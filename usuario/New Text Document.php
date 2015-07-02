<?php
require_once('common/banco.php');
require_once('common/mensagens.php');
session_start();
if ( isset($_SESSION['validacao'] == "1") ){
?>
<!DOCTYPE html>
<html>
    <?php
        require_once('cabecalho.php');
    ?>
    
    <body>
        <h1 class="cabecalho">Ordem de Servi&ccedil;os</h1>

        <br />
        <h5>Instituto Federal do Cear&atilde; - Campus Tiangu&atilde; - 2012</h5>
    </body>
</html>
<?php header("Location:login.php");?>

