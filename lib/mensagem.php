<?php

$html = '';

if (isset($mensagem) && ($mensagem) != ''){
    $html = <<<TEXTO
<div class="w3-panel w3-red w3-display-container">
<span onclick="this.parentElement.style.display='none'" class="w3-button w3-display-topright">X</span>
<p>{$mensagem}</p>
</div>
TEXTO;
}

echo $html;