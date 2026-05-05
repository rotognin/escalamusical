const arquivos = [
    '01_bateria.mp3',
    '02_baixo.mp3',
    '03_violao.mp3',
    '04_voz.mp3',
    '05_backing.mp3'
];

const audioCtx = new AudioContext();
let elements = [];
let gainNodes = [];
let volumes = [1, 1, 1, 1, 1];
let playing = false;
let duration = 0;
let driftCheckInterval = null;
let isSeeking = false;

const seekbar = document.getElementById('seekbar');
const tempoEl = document.getElementById('tempo');
const statusEl = document.getElementById('status');
const btnPlay = document.getElementById('btnPlay');

// 1. Monta o player com <audio> pra streaming
async function montarPlayer() {
    statusEl.textContent = 'Carregando metadata...';
    btnPlay.disabled = true;

    elements = arquivos.map((url, i) => {
        const audio = new Audio();
        audio.src = url;
        audio.preload = 'auto'; // Baixa em background pra evitar stutter
        audio.crossOrigin = 'anonymous';

        const source = audioCtx.createMediaElementSource(audio);
        gainNodes[i] = audioCtx.createGain();
        gainNodes[i].gain.value = volumes[i];
        source.connect(gainNodes[i]);
        gainNodes[i].connect(audioCtx.destination);

        // Detecta quando uma faixa termina sozinha = dessincronizou feio
        audio.addEventListener('ended', () => {
            if (playing) {
                console.warn('Faixa ' + i + ' terminou antes das outras');
                stop();
            }
        });

        return audio;
    });

    // Espera metadata de todas
    await Promise.all(elements.map(el => new Promise((resolve, reject) => {
        el.addEventListener('loadedmetadata', resolve, { once: true });
        el.addEventListener('error', () => reject('Erro ao carregar ' + el.src), { once: true });
    })));

    duration = elements[0].duration;
    seekbar.max = duration;
    btnPlay.disabled = false;
    statusEl.textContent = 'Pronto';
    atualizaTempo();

    // Atualiza seekbar pelo elemento master = faixa 0
    elements[0].addEventListener('timeupdate', () => {
        if (!isSeeking) {
            seekbar.value = elements[0].currentTime;
            atualizaTempo();
        }
    });
}

// 2. Play sincronizado
async function play() {
    if (audioCtx.state === 'suspended') await audioCtx.resume();

    statusEl.textContent = 'Tocando...';
    const currentTime = elements[0].currentTime;

    // Seta o tempo em todas antes de dar play pra garantir sync inicial
    elements.forEach(el => el.currentTime = currentTime);

    // Dá play em todas. Promise.all espera todas começarem
    try {
        await Promise.all(elements.map(el => el.play()));
        playing = true;
        btnPlay.textContent = 'Pause';
        iniciarChecagemDrift();
    } catch (e) {
        console.error('Erro ao dar play:', e);
        statusEl.textContent = 'Erro: clique novamente';
    }
}

// 3. Pause
function pause() {
    elements.forEach(el => el.pause());
    playing = false;
    btnPlay.textContent = 'Play';
    statusEl.textContent = 'Pausado';
    pararChecagemDrift();
}

// 4. Stop = pause + volta pro início
function stop() {
    pause();
    elements.forEach(el => el.currentTime = 0);
    seekbar.value = 0;
    atualizaTempo();
}

// 5. Seek - pula pra posição específica
function seek(tempo) {
    isSeeking = true;
    const novoTempo = Math.max(0, Math.min(duration, tempo));
    elements.forEach(el => el.currentTime = novoTempo);
    setTimeout(() => isSeeking = false, 100); // Evita conflito com timeupdate
}

// 6. Skip - avança/volta X segundos
function skip(segundos) {
    seek(elements[0].currentTime + segundos);
}

// 7. Correção de drift: checa a cada 2s se alguma faixa desgarrou
function iniciarChecagemDrift() {
    pararChecagemDrift();
    driftCheckInterval = setInterval(() => {
        if (!playing || isSeeking) return;

        const masterTime = elements[0].currentTime;
        let maxDiff = 0;

        elements.forEach((el, i) => {
            const diff = Math.abs(el.currentTime - masterTime);
            maxDiff = Math.max(maxDiff, diff);

            // Tolerância de 100ms. Acima disso, corrige
            if (diff > 0.1) {
                el.currentTime = masterTime;
                console.log('Corrigindo drift faixa ' + i + ': ' + diff.toFixed(3) + 's');
            }
        });

        // Mostra drift máximo no status
        if (maxDiff > 0.05) {
            statusEl.textContent = 'Sync: ' + maxDiff.toFixed(3) + 's';
        }
    }, 2000);
}

function pararChecagemDrift() {
    if (driftCheckInterval) {
        clearInterval(driftCheckInterval);
        driftCheckInterval = null;
    }
}

// 8. Utilitários
function atualizaTempo() {
    tempoEl.textContent = formataTempo(elements[0].currentTime) + ' / ' + formataTempo(duration);
}

function formataTempo(s) {
    s = Math.floor(s);
    const h = Math.floor(s / 3600);
    const m = Math.floor((s % 3600) / 60);
    const sec = s % 60;
    if (h > 0) return h + ':' + String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
    return m + ':' + String(sec).padStart(2, '0');
}

// Eventos de transporte
btnPlay.onclick = () => playing ? pause() : play();
document.getElementById('btnStop').onclick = stop;
document.getElementById('retro1m').onclick = () => skip(-60);
document.getElementById('retro15s').onclick = () => skip(-15);
document.getElementById('avanca15s').onclick = () => skip(15);
document.getElementById('avanca1m').onclick = () => skip(60);

seekbar.addEventListener('input', () => {
    isSeeking = true;
    seek(parseFloat(seekbar.value));
});
seekbar.addEventListener('change', () => {
    isSeeking = false;
});

// Volume e Mute
document.querySelectorAll('.mute').forEach(chk => {
    chk.addEventListener('change', (e) => {
        const idx = parseInt(e.target.dataset.track);
        const vol = e.target.checked ? volumes[idx] : 0;
        gainNodes[idx].gain.setTargetAtTime(vol * vol, audioCtx.currentTime, 0.01);
    });
});

document.querySelectorAll('.volume').forEach(slider => {
    slider.addEventListener('input', (e) => {
        const idx = parseInt(e.target.dataset.track);
        const vol = parseFloat(e.target.value);
        volumes[idx] = vol;

        const chk = document.querySelector('.mute[data-track="' + idx + '"]');
        if (chk.checked) {
            gainNodes[idx].gain.setTargetAtTime(vol * vol, audioCtx.currentTime, 0.01);
        }

        // Atualiza label
        e.target.nextElementSibling.textContent = Math.round(vol * 100) + '%';
    });
});

// Inicia
montarPlayer();