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
        <h1 class="cabecalho"> Ordem de Servicos </h1>

        <?php

            //recebe o codigo da OS passado pela pagina "cadastrarOS", via get
            //conecta a base de dados
           $conexao = conecta_banco();

            //captura do banco de dados os valores referentes aquela determinada OS
            // e os armazena em algumas variaveis
           $consulta = mysql_query("SELECT * FROM solicitante WHERE email='$_SESSION[usuario]'");
           $vetor = mysql_fetch_array($consulta);
		   $senha_atual = $vetor['senha'];
		   $cod_solicitante = $vetor['cod_solicitante'];
		   $email = $vetor['email'];
		   desconecta_banco();
           
        ?>

        <form action="editarSenha.php" method="post" id="validaFormulario">
            <fieldset>
                <legend>Alterar Senha</legend>

                <label>Solicitante:</label><?php echo $email; ?>
                <br>
                <br>
                <label>Senha Atual:</label>
				<input type="password" name="senha" id="senha"/>
				<br>
                <br>
				<label>Nova senha:</label>
				<input type="password" name="novasenha" id="novasenha"/>
				<br>
                <br>
				<label>Repetir senha:</label>
				<input type="password" name="novasenharepetir" id="novasenharepetir"/>
                <br>
                <br>
                <!--Campo oculto que serve para fins de validacao -->
                <input type="hidden" name="validador" value="1"/>
				
                <!--Volta para a pagina principal -->
                <input type="button" value="Voltar" onclick="window.location.href='index.php'" />

                <!--Limpa os campos -->
                <input type="reset" value="Limpar"/>

                <!--Envia os dados do formulario para tratamento -->
                <input type="submit" value="Ok"/>
            </fieldset>
        </form>
        <h5>Instituto Federal do Cear&aacute; - Campus Tiangu&aacute;</h5>
	</body> 
</html>
        <?php
            //verifica existÃªncia e valor do campo oculto 'validador'
            if(isset ($_POST['validador']) && ($_POST['validador'] == 1)){
				if($senha_atual == md5($_POST['senha'])){
					if(($_POST['novasenha'] == $_POST['novasenharepetir']) && ($_POST['novasenharepetir'] <> null) 
					&& ($_POST['novasenha'] <> null) ){
						//conecta a base de dados
						conecta_banco();
						//seta as variaveis com os valores do formulÃ¡rio
						$nova_senha = md5($_POST['novasenha']);
						$consulta = mysql_query("UPDATE solicitante SET senha='$nova_senha' WHERE cod_solicitante='$cod_solicitante'");
                 
						//verifica o sucesso da consulta e emite uma mensagem ao usuario
						if($consulta == 1){
							retornar("Atualiza&ccedil;&atilde;o realizada com sucesso!","editarSenha.php");
						}else{
							retornar("Erro ao tentar atualizar!","editarSenha.php");
						}
					}else{
						retornar("Nova Senha e Repetir Senha não conferem.Ou estão vazios.", "editarSenha.php");
					}	
				}else{
					retornar("Senha Atual não confere.", "editarSenha.php");
				}
					//retornar($mensagem, "index.php");
				 //fecha a conexao com o SGBD
                 $conexao = desconecta_banco();
            }?>

