<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<?php
    ob_start();
    session_start();
    require_once('common/banco.php');
    require_once('common/mensagens.php');
	//ob_start();
	//session_start();
?>
    <?php
        require_once('cabecalho.php');
    ?>
    <body>
	<?php 
	if ( $_SESSION['funcionalidade'] == "2" ){
	?>
        <h1 class="cabecalho">Ordem de Servi&ccedil;os</h1>

        <form action="cadastrarEquipamento.php" method="get" id="validaFormulario">
            <fieldset>
                <legend>Cadastrar Equipamento</legend>
                <br />
                <label for="descricao_equip">Equipamento:</label>
                <input type="text" name="descricao_equip" id="descricao_equip" class="validate[required,custom[onlyLetterSp]]" size="20" maxlength="20"/> <i>(Descreva o tipo gen&eacute;rico do equipamento. Ex: Notebook, Impressora, Monitor, etc..)</i>
                <br /> <br />        
                          
                <!--Campo oculto que serve para fins de validação -->
                <input type="hidden" name="validador" value="1"/>

                <!--Volta para a página principal -->
                <input type="button" value="Voltar" onclick="window.location.href='index.php'" />

                <!--Limpa os campos -->
                <input type="reset" value="Limpar"/>

                <!--Envia os dados do formulário para tratamento -->
                <input type="submit" value="Ok"/>

            </fieldset>
        </form>

            <?php
            //verifica existência e valor do campo oculto 'validador'
            if (isset ($_GET['validador']) && ($_GET['validador'] == 1)){                

                 //seta as variáveis com os valores do formulário
                 $descricao_equip = $_GET['descricao_equip'];
                 
                 $resultado = inserirTipoEquipamento($descricao_equip);

                 //verifica o sucesso da consulta e emite uma mensagem ao usuário
                 if($resultado){
                     $mensagem = "Equipamento inserido com sucesso!";
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
