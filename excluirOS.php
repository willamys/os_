<?php
    require_once('common/banco.php');
    require_once('common/mensagens.php');
	ob_start();
	session_start();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
    <?php
        require_once('cabecalho.php');
    ?>
    <body>
	<?php 
	if ($_SESSION['funcionalidade'] == "1" ){
	?>

        <h1 class="cabecalho">Ordem de Servi&ccedil;os</h1>

        <?php

             //recebe o código da OS passado pela página "index.php", via get
             $codigoOS = $_GET['cod_os'];

            $resultado = excluirOS($codigoOS);            

            //verifica o sucesso da consulta e emite uma mensagem ao usuário
                 if($resultado){
                     $mensagem = "Ordem de Servi&ccedil;o removida com sucesso!";
                 }else{
                     $mensagem = "Erro ao tentar remover!";
                 }
                 retornar($mensagem, "index.php");
        ?>
        <h5>Instituto Federal do Cear&aacute; - Campus Tiangu&aacute;</h5>
		<?php }else{
$mensagem = "Acesso restrito e exclusivo ao usu&aacuterio administrador.";
	retornar($mensagem,"index.php");}?>    </body>
</html>
