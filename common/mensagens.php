<?php
    //Arquivo que contem as funcoes responsaveis por criar as caixas de dialogo

//funcao que emite uma mensagem de aviso, contida na variavel '$mensagem'
function notificar($mensagem){
    echo "<script language='javascript'>jAlert('$mensagem', 'Aviso');</script>";
}

//funcao que emite uma mensagem de aviso, contida na variavel '$mensagem' e retorna a uma pagina especificada pela variavel '$pagina'
function retornar($mensagem, $pagina){
    echo "<script language='javascript'>jAlert('$mensagem', 'Informação', function(){ window.location.href = '$pagina'}); </script>";    
    // o exit serve para parar de executar o restante do codigo de javascript, pois pode continuar a carregar a pagina desnecessariamente
    exit;
}

?>
