<?php
require_once('../common/banco.php');
require_once('../common/mensagens.php');
ob_start();
session_start();
if ( $_SESSION['funcionalidade'] == "2" ){
	?>
<!DOCTYPE html>
<html lang="en">
    <?php
        require_once('../cabecalho.php');
    ?>
    
    <body>
        <h1 class="cabecalho">Ordem de Servi&ccedil;os</h1>
	Seja bem vindo <strong><?php echo $_SESSION['usuario']?></strong>
	<a href="../deslogar.php">Sair</a>
        <br />
        <h5>Instituto Federal do Cear&atilde; - Campus Tiangu&atilde; - 2012</h5>
    </body>
</html>
<?php }else{header("Location:../login.php");}?>
