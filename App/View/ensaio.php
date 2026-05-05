<?php

/**
 * Listar as faixas do ensaio gravado
 */

namespace App\View;

use App\Model\Grupo;

$addGet = $_SESSION['addGet'];
$aGet = explode('&', $addGet);
$aGrupoGet = explode('=', $aGet[0]);
$gruID = $aGrupoGet[1];

$aGrupo = Grupo::carregar($gruID);

// Checar se existem arquivos na pasta do ensaio
$data = $aGrupo['gruDataEnsaio'];
$dataBR = implode('/', array_reverse(explode('-', $data)));

$pasta = 'ensaios/' . $data . '/';
$arquivos = glob($pasta . '*');

$css_player = <<<ESTILO
    <style>
        #player {
            font-family: sans-serif;
            padding: 20px;
        }

        .faixa {
            margin: 10px 0;
        }

        .faixa label {
            display: inline-block;
            width: 80px;
        }

        .volume {
            width: 200px;
            vertical-align: middle;
        }

        .vol-label {
            margin-left: 10px;
            font-size: 12px;
            color: #666;
        }

        button {
            margin: 2px;
            padding: 8px 12px;
        }

        #seekbar {
            margin: 10px 0;
        }
    </style>
ESTILO;

if (empty($arquivos)) {
    $html_play = '<p>Não existem arquivos para este ensaio</p>';
} else {
    $html_play = '';
    $html_play = <<<HTML
        <div id="player">
            <button id="btnPlay">Play</button>
            <button id="btnStop">Stop</button>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <button id="retro1m">-1 min</button>
            <button id="retro15s">-15s</button>
            &nbsp;&nbsp;&nbsp;
            <button id="avanca15s">+15s</button>
            <button id="avanca1m">+1 min</button>

            <br><br>
            <input type="range" id="seekbar" value="0" step="0.1" style="width: 500px;">
            <div id="tempo">0:00 / 0:00</div>
            <div id="status">Carregando...</div>

            <br>
    HTML;

    $nro_faixa = 0;
    $add_audios = 'const arquivos = [';

    foreach ($arquivos as $arq) {
        $nome_arquivo = pathinfo($arq, PATHINFO_FILENAME);

        $html_play .= <<<HTML
            <div class="faixa">
                <label>{$nome_arquivo}</label>
                <input type="checkbox" class="mute" data-track="{$nro_faixa}" checked>
                <input type="range" class="volume" data-track="{$nro_faixa}" min="0" max="1" step="0.01" value="1">
                <span class="vol-label">100%</span>
            </div>

        HTML;

        // Adicionar o áudio
        $add_audios .= '"' . $arq . '",';

        $nro_faixa++;
    }

    $add_audios .= '];';

    $html_play .= '</div>';
    $html_play .= '<script>' . $add_audios;
    $html_play .= <<<SCRIPT
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

        // 7. Correção de drift: checa a cada 3s se alguma faixa desgarrou
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
            }, 3000);
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

    SCRIPT;

    $html_play .= '</script>';
}

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>

<body>
    <?php echo $css_player; ?>
    <div class="w3-container w3-card-4">
        <h3>Áudios do Ensaio <?php echo $dataBR; ?></h3>
        <a class="w3-button w3-blue" href="principal.php?action=home">Início</a>
        <br><br>
    </div>
    <div class="w3-container w3-card-4 w3-padding">
        <?php include_once 'lib/mensagem.php'; ?>
        <h3>Faixas:</h3>

        <?php echo $html_play; ?>
        <br>
    </div>
</body>

</html>