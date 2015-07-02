<?php
require_once('common/banco.php');
require_once('common/mensagens.php');

ob_start();
//seta as variáveis com os valores do formulário
$usuario_post = $_POST['usuario'];
$senha_post = $_POST['senha'];

if(!($usuario_post == "" && $senha_post == "")){

	$resultado = buscarPermissao($usuario_post,$senha_post);

	//verifica o sucesso da consulta e emite uma mensagem ao usuário
	while($vetor = mysql_fetch_array($resultado)){
		$usuario = $vetor['usuario'];
		$senha = $vetor['senha'];
		$usuarir_dir = $vetor['cod_funcionalidade'];
	}
		if($usuario == $usuario_post && $senha == $senha_post){
			$validacao = "1";
			$usuario = $usuario_post;
			session_start();
			$_SESSION[usuario] = $usuario;
			$_SESSION[validacao] = $validacao;
			if($usuarir_dir == "1"){
				header("Location:usuarios/");
			}
			if($usuarir_dir == "2"){
				header("Location:adm/");
			}
		}else{
			?>
			<script type="text/javascript">
			alert("Login ou senha incorreta!");
			</script>
			<?
			//header("Location:login.php");
		}
	}else{
		?>
			<script type="text/javascript">
			alert("Login ou senha incorreta!");
			</script>
		<?		
	}