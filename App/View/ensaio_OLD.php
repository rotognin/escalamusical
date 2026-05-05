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

if (empty($arquivos)) {
    $html_play = '<p>Não existem arquivos para este ensaio</p>';
} else {
    $html_play = '';

    $html_play = <<<TEXTO
        <br>
        <button id="tocar" class="w3-button w3-blue">Tocar</button>
        <button id="parar" class="w3-button w3-red" disabled>Parar</button>
        <br><br>
        <div id="controles"></div>

        <script>
            let audioCtx;
            let buffers = [];
            let sourcesAtivas = [];
            const urls = [
    TEXTO;

    foreach ($arquivos as $arq) {
        $html_play .= '"' . $arq . '",';
    }

    $html_play .= '];';

    $html_play .= <<<TEXTO
        audioCtx = new (window.AudioContext || window.webkitAudioContext)();

        // Carrega todos os áudios em paralelo
        const promessas = urls.map(async (url, i) => {
            const res = await fetch(url);
            const arrayBuffer = await res.arrayBuffer();
            buffers[i] = await audioCtx.decodeAudioData(arrayBuffer);

            // Cria slider de volume pra cada faixa
            criarControleVolume(i, url);
        });

        Promise.all(promessas);

        document.getElementById('tocar').onclick = () => {
            pararTodos(); // garante que não sobreponha

            const agora = audioCtx.currentTime + 0.1; // pequeno delay pra agendar

            buffers.forEach((buffer, i) => {
                const source = audioCtx.createBufferSource();
                const gainNode = audioCtx.createGain();

                source.buffer = buffer;
                gainNode.gain.value = document.getElementById('vol' + i).value;

                source.connect(gainNode).connect(audioCtx.destination);
                source.start(agora); // todos começam no mesmo timestamp

                sourcesAtivas.push({ source, gainNode, index: i });
            });

            document.getElementById('parar').disabled = false;
        };

        // 3. Para tudo
        function pararTodos() {
            sourcesAtivas.forEach(obj => {
                try { obj.source.stop(); } catch (e) { }
            });
            sourcesAtivas = [];
        }

        document.getElementById('parar').onclick = () => {
            pararTodos();
            document.getElementById('parar').disabled = true;
        };

        // Cria sliders de volume individuais
        function criarControleVolume(i, nome) {

            var nome_faixa = ajustarNome(nome);
            const div = document.createElement('div');
            var i_mais = i + 1;
            div.innerHTML = '<label>Faixa ' + i_mais + ': ' + nome_faixa + '&nbsp;&nbsp;&nbsp;&nbsp;' +
                '<input type="range" id="vol' + i + '" min="0" max="1" step="0.01" value="0.8">' +
                '</label>';
            document.getElementById('controles').appendChild(div);

            // Atualiza volume em tempo real
            document.getElementById('vol' + i).oninput = (e) => {
                const sourceObj = sourcesAtivas.find(s => s.index === i);
                if (sourceObj) sourceObj.gainNode.gain.value = e.target.value;
            };
        }

        function ajustarNome(nome){
            var aNome = nome.split('/');
            var arquivo = aNome[aNome.length - 1];
            var aArq = arquivo.split('.');
            return aArq[0];
        }

        </script>
    TEXTO;
}

?>

<!DOCTYPE html>
<html>
<?php include 'html' . DIRECTORY_SEPARATOR . 'head.php'; ?>

<body>
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