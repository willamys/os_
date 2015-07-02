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
	if ( $_SESSION['funcionalidade'] == "1" || $_SESSION['funcionalidade'] == "2" ){
	?>
        <h1 class="cabecalho">Ordem de Servi&ccedil;os</h1>

        <form action="cadastrarOS.php" method="get" id="validaFormulario">
            <fieldset>
                <legend>Cadastrar Ordem de Serviço</legend>

				
                <label for="solicitante">Solicitante:</label>
                <select name="solicitante" id ="solicitante" class="validate[required]">
                      <?php
						
                        //concecta ao SGBD
                         $conexao = conecta_banco();
                         //exibe a relação de solicitantes cadastrados na base de dados
                         $consulta = mysql_query("SELECT cod_solicitante, nome
                                                  FROM solicitante WHERE email = '$_SESSION[usuario]'");
                         while($resultado = mysql_fetch_array($consulta)){                             
                             echo '<option value="'.$resultado['cod_solicitante'].'">'.$resultado['nome'].'</option>';
                         }
                      ?>                    
                </select>                
                <br /> <br />
                <label for="equipamento">Equipamento:</label>
                <select name="equipamento" id ="equipamento" class="validate[required]">
                    <option value="" selected>Selecione uma op&ccedil;&atilde;o</option>
                      <?php                        
                         //seleciona a relação de equipamentos cadastrados na base de dados
                         $consulta = mysql_query("SELECT descricao_equip
                                                  FROM tipoequipamento ORDER BY descricao_equip");
                         while($result = mysql_fetch_array($consulta)){
                             echo '<option value="'.$result['descricao_equip'].'">'.$result['descricao_equip'].'</option>';
                         }
                         //fecha a conexão com o SGBD
                         $conexao = desconecta_banco();
                      ?>
                </select>                
                <br /> <br />
                

                <!--Campo que recebe o serviço solicitado -->
                <label for ="servico_sol">Atendimento que necessito:</label>
                <input type="text" name="servico_sol" id="servico_sol" size="60" maxlength="60" class="validate[required]"/>
                <i>Breve descri&ccedil;&atilde;o. <b>Ex</b>: Instala&ccedil;&atilde;o de Programa, Repara&ccedil;&atilde;o de Defeito, Substitui&ccedil;&atilde;o de Pe&ccedil;a</i>
                <br /> <br /> <br />
                
                <!--Campo que recebe o local do atendimento -->
                <label for ="setor_origem">Local do Atendimento:</label>
                <input type="text" name="setor_origem" id="setor_origem" size="30" maxlength="30" class="validate[required]"/>
                <i>Breve descri&ccedil;&atilde;o. <b>Ex</b>: Sala dos Professores, Biblioteca, etc...</i>
                <br /> <br />

                <!--Campo que exibe a data do sistema por meio da variável $data -->
                <label for ="data_entrada">Data:</label>
                <input type="text" name="data_entrada" value="<?php echo $data = date("d/m/Y"); ?>" readonly/>
                <br /> <br />

                <!--Campo que exibe a hora do sistema por meio da variável $hora -->
                <label for ="hora_entrada">Hora de Entrada:</label>
                <input type="text" name="hora_entrada" value="<?php echo $hora = date("H:i"); ?>" readonly/>
                <br /> <br /> <br />

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
        <h5>Instituto Federal do Cear&aacute; - Campus Tiangu&aacute;</h5>

        <?php
            //verifica existência e valor do campo oculto 'validador'
            if (isset ($_GET['validador']) && ($_GET['validador'] == 1)){                

                 //seta as variáveis com os valores do formulário
                 $solicitante = $_GET['solicitante'];
                 $equipamento = $_GET['equipamento'];
                 $setor_origem = $_GET['setor_origem'];
                 //$tombamento = 'Não informado';
                 $servico_sol = $_GET['servico_sol'];
                 $status = 'Aberta';
                 $hora_entrada = $_GET['hora_entrada'];
                 $data_entrada = $_GET['data_entrada'];                                           

                 
                 $resultado = inserirOS($solicitante, $equipamento, $servico_sol, $setor_origem, $status, $hora_entrada, $data_entrada);

                 //verifica o sucesso da consulta e emite uma mensagem ao usuário
                 if($resultado){
                     $mensagem = "Ordem de Servi&ccedil;o inserida com sucesso!";
                 }else{
                     $mensagem = "Erro ao tentar inserir!";
                 }
                 retornar($mensagem, "index.php");
            }
        ?>
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
