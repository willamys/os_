<?php
ob_start();
require_once('common/banco.php');
require_once('common/mensagens.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
"http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en">
<head>
<title>Acesso</title>
<link href="captiveportal-favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon">
<style type="text/css">
body{ background:#f5f5f5; margin:0px; padding:0px; font-family:"Trebuchet MS"; font-size:10pt; color:#666666; }

#tudo{ background:#FFFFFF; margin:100px auto; padding:10px; width:500px; height: 350px;  }

#topo{ padding:10px; }

#menu{ width:200px; background:#000033; float: left; }
#menu ul{ width:140px; margin:0px; padding:0px; position:relative; height:auto; padding:10px; }
#menu li{ list-style:none; color:#FFFFFF; padding:10px; }
#menu li a{ color:#FFFFFF; text-decoration:none; }
#menu li a:hover{ text-decoration:underline; }
#menu li ul{ margin:0px; position:absolute; padding:0px; list-style:none; margin-top:-13px; left:100px; background:#666666; height:auto; display:none;  }
#menu li ul li{ list-style:none; width:140px; background:#666666; color:#999900; }
#menu li:hover ul{ display:list-item;  }

a{ color:#333333; }
a:hover{ text-decoration:overline; } 

#meio{ width:700px; float:left; padding:10px; }

#rodape{ clear:both; padding:10px; }

.titulopag{ font-size:22pt; color:#666666; }

.tituloi{ font-size:16pt; }
</style>
</head>
<body>
<div id="tudo">
     <form method="post">
          <div align="center"><p class="tituloi"><img src="common/icones/logoIFCE.png" height="100" width="250"/>
          	<br/>
          	<br/>
          	<br/>
          	<br/>  SISTEMA EM MANUTEN&Ccedil;&Atilde;O
          </p>
         </div>
         <div style="position: relative; left: 35%;">
        
          </div>
     </form> 
</div>
<div align="center" style="position: absolute; width: 100%; height:50px; top: 550px; background:#fff;">
<div id="rodape">
Copyright &copy; 2013 <br/>NTI <i>campus</i> Tiangu&aacute;<br/>
</div><!-- div grid rodape-->
</div>
</body>
</html>

