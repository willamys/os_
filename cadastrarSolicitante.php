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
	if ( $_SESSION['funcionalidade'] == "2" ){
	?>
        <h1 class="cabecalho">Ordem de Servi&ccedil;os</h1>

        <form action="cadastrarSolicitante.php" method="get" id="validaFormulario">
            <fieldset>
                <legend>Cadastrar Solicitante</legend>

                <!--Recebe o valor correspondente ao tipo de solicitante -->
                <label for="tipo_solic">Voc&ecirc; &eacute; servidor do IFCE?</label>
                <br />
                <input type="radio" name="tipo_solic" value="1">Sim 
                &nbsp;  &nbsp;
                <input type="radio" name="tipo_solic" value="2">Sim, e administrador do sistema.
		  &nbsp;  &nbsp;
                <input type="radio" name="tipo_solic" value="3">N&atilde;o<br>
		 

                <br /> <br />

                <!--Recebe o nome do solicitante -->
                <label for ="nome">Nome:</label>
                <input type="text" id="nome" name="nome" size="50" maxlength="80" class="validate[required,custom[onlyLetterSp]]"/>
                <br /> <br />

                <!--Recebe o cargo do solicitante, caso seja servidor do IFCE -->
                <label for ="cargo">Cargo:</label>
                <input type="text" name="cargo" id="cargo" size="50" maxlength="50"/><i>(Somente se for servidor do IFCE)</i>
                <br /> <br />

                <!--Recebe o e-mail do solicitante-->
                <label for ="email">E-mail:</label>
                <input type="text" name="email" value="@ifce.edu.br" id="email" size="50" maxlength="50" class="validate[required,custom[email]]"/>
                <br /> <br />

                <!--Recebe o SIAPE do solicitante, caso seja servidor do IFCE -->
                <label for ="siape">SIAPE:</label>
                <input type="text" name="siape" id="siape" size="20" maxlength="20"/><i>(Somente se for servidor do IFCE)</i>
                <br /> <br />

                <input type="hidden" name="validador" value="1"/>
                <input type="button" value="Voltar" onclick="window.location.href='index.php'" />
                <input type="reset" value="Limpar"/>
                <input type="submit" value="Ok"/>

            </fieldset>
        </form>

            <?php
            if (isset ($_GET['validador']) && ($_GET['validador'] == 1)){                

                 $tipoSolicitante = $_GET['tipo_solic'];
                 $nome = $_GET['nome'];
                 $cargo = $_GET['cargo'];
                 $siape = $_GET['siape'];
                 $email = $_GET['email'];

                 $resultado = inserirSolicitante($nome, $cargo, $siape, $email, $tipoSolicitante);

                 if($resultado){
                     $mensagem = "Solicitante inserido com sucesso!";
                 }else{
                     $mensagem = "Erro ao tentar inserir!";
                 }
                 retornar($mensagem, "index.php");
            }
        ?>
        <h5>Instituto Federal do Cear&aacute; - Campus Tiangu&aacute;</h5>
		<?php }else{
				$mensagem = "Acesso restrito e exclusivo ao usu&aacuterio administrador.";
				retornar($mensagem,"index.php");
				}
	?>
    </body>
</html>
