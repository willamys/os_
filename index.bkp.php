<?php
    require_once('common/banco.php');
    require_once('common/mensagens.php');
	ob_start();
	session_start();
if ( $_SESSION['funcionalidade'] == "1" || $_SESSION['funcionalidade'] == "2" ){
?>

<!DOCTYPE html>
<html>
    <?php
        require_once('cabecalho.php');
    ?>
    
    <body>
        <h1 class="cabecalho">Ordem de Servi&ccedil;os</h1>
Seja bem vindo <b><?php echo $_SESSION['usuario'];?>  </b><a href="deslogar.php">[Sair]</a><br/>
        <!-- Formulario que realiza uma busca rapida, ou vai para a pagina de busca avancada, a partir da pagina principal-->
        <?php if($_SESSION['funcionalidade'] == '2'){?>
		<form action="buscarOS.php" method="get" id="validaFormulario">
            <a href="buscarOS.php"><img src="common/icones/busca.png" title="Ir para Busca Avançada" width="40" height="40" alt="Ir para Busca Avançada"/></a>
            <input type="text" name="busca" id ="busca" class="validate[required]">
            <input type="submit" value="Buscar">

            <!--Campo oculto que serve para fins de validação -->
            <input type="hidden" name="validador" value="1"/>

            <!--Campo oculto que serve para fins de validação -->
            <input type="hidden" name="coluna" value="todas"/>
        </form>
		<?php }?>
        <br />
        <table id="myTable" class="tablesorter">
            <!-- Cabecalho da tabela -->
            <thead>
                <th>C&oacute;digo</th>
                <th>Equipamento</th>
                <th>Atendimento Requisitado</th>
                <th>Solicitante</th>
                <th>Status</th>
                <th>Data de Cadastro</th>
                <th>Op&ccedil;&otilde;es</th>
            </thead>
            <!-- Corpo da tabela -->
            <tbody>

                <?php
                
                 //referencia a funcao contida em 'banco.php'
                //que mostra os dados da tela principal do sistema sobre as OS's
                 $resultado = listarDadosOS($_SESSION['usuario'],$_SESSION['funcionalidade'] );

                 //armazena o resultado da funcao em um vetor
                 //e enquanto o vetor possuir valores, ele exbibe 
                 while ($vetor = mysql_fetch_array($resultado)){

                     $codigoOS = $vetor['cod_os'];
                     $equipamento = $vetor['descricao_equip'];
                     $serv_solicitado = $vetor['serv_solicitado'];
                     $nome = $vetor['nome'];
                     $status = $vetor['status'];
                     $data_cadastro = $vetor['data_cadastro'];
                     ?>
                     <tr>
                        <td><?php echo $codigoOS; ?></td>
                        <td><?php echo $equipamento; ?></td>
                        <td><?php echo $serv_solicitado; ?></td>
                        <td><?php echo $nome; ?></td>
                        <td><?php echo $status; ?></td>
                        <td><?php echo $data_cadastro; ?></td>
                        <td>

                            <!--Link que gera o PDF da OS-->
                            <a href="geraPDF.php?cod_os=<?php echo $codigoOS; ?>"><img src="common/icones/pdf-icon.png" title="Gerar PDF" width="22" height="22" alt="Visualizar"/></a>&nbsp;&nbsp;

                            <!--Link que leva a pagina de visualizacao dos detalhes da OS-->
                            <a href="detalharOS.php?cod_os=<?php echo $codigoOS; ?>"><img src="common/icones/visualizar.png" title="Visualizar" width="20" height="20" alt="Visualizar"/></a>&nbsp;
                                                        
                            <!--Link que leva a pagina de alteracao da OS-->
                            <a href="editarOS.php?cod_os=<?php echo $codigoOS; ?>"><img src="common/icones/editar.png" title="Editar" width="20" height="20" alt="Editar"/></a>&nbsp;
                            
                            <!--Link que leva a pagina de exclusao da OS-->
                            <a href="#" onclick="return jConfirm('Deseja realmente excluir essa ordem de servi&ccedil;o?', 'Confirma&ccedil;&atilde;o',
                                function (valor){
                                    if (valor){
                                        window.location.href='excluirOS.php?cod_os=<?php echo $codigoOS; ?>';
                                }
                               });"><img src="common/icones/deletar.png" title="Excluir" width="20" height="20" alt="Excluir"/></a>
                        </td>
                     </tr>
                     <?php                   
                 }                 
                ?>

            </tbody>
            <!-- Rodape da tabela -->
            <tfoot>
                <tr>
                    <th colspan="7">
                        <a class="botao_cadastrar" href="cadastrarOS.php"><img class="imagem_botao_cadastrar" src="common/icones/cadastrar.png" title="Nova OS" width="50" height="50"/>Nova OS</a> &nbsp; &nbsp;
                        <a class="botao_cadastrar" href="cadastrarSolicitante.php"><img class="imagem_botao_cadastrar" src="common/icones/solicitante.gif" title="Novo Solicitante" width="40" height="40"/>Novo Solicitante</a> &nbsp; &nbsp;
                        <a class="botao_cadastrar" href="cadastrarEquipamento.php"><img class="imagem_botao_cadastrar" src="common/icones/equipamento.gif" title="Novo Equipamento" width="40" height="40"/>Novo Equipamento</a> &nbsp; &nbsp;
                        <!--<a class="botao_cadastrar" href="cadastrarTombamento.php"><img class="imagem_botao_cadastrar" src="common/icones/tombamento.png" title="Novo Tombamento" width="35" height="35"/>Novo Tombamento</a>-->
                    </th>
                </tr>
            </tfoot>

        </table>        
        <br />
        <h5>Instituto Federal do Cear&aacute; - Campus Tiangu&aacute;</h5>
    </body>
</html><?php  
		}else{header("Location:login.php");}?>


