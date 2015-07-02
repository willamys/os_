<?php
ob_start();
require_once('common/banco.php');
require_once('common/mensagens.php');
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<?php
require_once('cabecalho.php');
?>
<body>
<h1 class="cabecalho">Ordem de Servi&ccedil;os</h1>
<div style="position: relative; width: 180px; height: 200px; left: 535px;">
	<form action="login.php" method="POST"  id="validaFormulario">
			usuario : <br> <input type="text" value="@ifce.edu.br" name="usuario" id="usuario" size="30" class="validate[required,custom[email]]"/><br> 
			senha: <br>
			<input
			name="senha" id="senha" type="password" size="30" class="validate[required]"/> <br> 
			<input type="hidden" name="validador" value="1"/>
			<input name="enviar" type="submit"
			id="enviar" value="enviar">
	</form>
	
	</div>
	 <h5>Instituto Federal do Cear&aacute; - Campus Tiangu&aacute;</h5>
<?php	 

//ob_start();
//seta as variáveis com os valores do formulário
if (isset ($_POST['validador']) && ($_POST['validador'] == 1)){
		$usuario_post = $_POST['usuario'];
		$senha_post = $_POST['senha'];

		if(!($usuario_post == "" && $senha_post == "")){
		
			//$resultado = buscarPermissao($usuario_post,$senha_post);
                   
			if(validarUsuario($usuario_post)){
			//verifica o sucesso da consulta e emite uma mensagem ao usuário
                                        $resultado = buscarPermissao($usuario_post,$senha_post);
					while($vetor = mysql_fetch_array($resultado)){
						$usuario = $vetor['email'];
						$senha = $vetor['siape'];
						$usuarir_dir = $vetor['tipo_solic'];
						}	
					if($usuario == $usuario_post && $senha == $senha_post){
						$validacao = "1";
						$usuario = $usuario_post;
						session_start();
						$_SESSION[usuario] = $usuario;
						$_SESSION[funcionalidade] = $usuarir_dir;
// 							if($usuarir_dir == "1"){
// 								header("Location:usuario/");
// 							}
// 							if($usuarir_dir == "2"){
// 								header("Location:adm/");
// 							}
							header("Location: index.php");
					}else{
						$mensagem = 'Senha incorreta!';
                                                retornar($mensagem, 'login.php');
					     }
			}else {
                            $mensagem = 'Usu&aacute;rio n&atilde;o encontrado!';
                            retornar($mensagem, 'login.php');		
			      }
		}else{
                    $mensagem = 'Algum campo n&atilde; foi preenchido!';
                    retornar($mensagem, 'login.php');	
                     }
     }
	?>
</body>
</html>



