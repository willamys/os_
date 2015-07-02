<?php 
ob_start();
//INICIALIZA A SESSÃO 
session_start();
//DESTRÓI AS SESSOES
unset($_SESSION[usuario]); 
unset($_SESSION[funcionalidade]);
session_destroy(); 
//REDIRECIONA PARA A TELA DE LOGIN 
Header("Location: login.php"); 
?>