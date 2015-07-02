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
	if ($_SESSION['funcionalidade'] == "1" || $_SESSION['funcionalidade'] == "2" ){
	?>

        <h1 class="cabecalho">Ordem de Servi&ccedil;os</h1>

        <form action="buscarOS.php" method="get" id="validaFormulario">
            <fieldset>
                <legend>Pesquisar Ordem de Servi&ccedil;o</legend>
                
                <!--Campo que recebe a expressao a ser pesquisada -->
                <label for="busca">Pesuisar por:</label>                
                <input type="text" name="busca" id="busca" class="validate[required]">

                <br />
                <!--Campo que mostra opcoes personalizadas de pesquisa -->
                <label for="coluna">Em:</label>
                <select name="coluna" id="coluna">
                    <option value="todas">Todos os campos</option>
                    <option value="s.nome">Solicitante</option>
                    <option value="t.descricao_equip">Equipamento</option>
                    <option value="o.serv_solicitado">Atendimento Requisitado</option>
                    <option value="o.status">Status</option>
                    <option value="o.data_cadastro">Data</option>
                </select>
                <br /> <br />

                <!--Campo oculto que serve para fins de validação -->
                <input type="hidden" name="validador" value="1"/>             

                <!--Volta para a página principal -->
                <input type="button" value="Voltar" onclick="window.location.href='index.php'" />

                <!--Limpa os campos -->
                <input type="reset" value="Limpar"/>

                <!--Envia os dados do formulário para tratamento -->
                <input type="submit" value="Buscar"/>                
            </fieldset>
        </form>
        <br />

        <?php            

            //verifica existência e valor do campo oculto 'validador'
            if(isset($_GET['validador']) && ($_GET['validador'] == 1))
            {
        ?>
            <!-- Exibe a tabela com os resultados da pesquisa, pois a condição acima foi satisfeita  -->
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
                <tbody>
                    <?php

                        //recebe o valor a ser pesquisado, que foi passado via get
                        $busca = $_GET['busca'];
                        $coluna = $_GET['coluna'];
                     
                    //armazena o resultado da consulta em um vetor
                    //enquanto o vetor possuir valores ele exbibe, conforme os campos do select
                    //caso nao possua resultados, notifica o usuario
                    
                    $resultado = buscarDadosOS($busca, $coluna);
                    
                    if (mysql_num_rows($resultado)== 0){
                        notificar("Nenhum dado foi encontrado!");
                    }
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
            </table>
            <br />
            <?php
            }
            ?>

        <h5>Instituto Federal do Cear&aacute; - Campus Tiangu&aacute;</h5>
		<?php }else{
		?>
							<script type="text/javascript">
							jAlert("Acesso restrito e exclusivo ao usu&aacuterio administrador.");
							window.location.href = "index.php";
							</script>
	<?}
	?>
    </body>
</html>
