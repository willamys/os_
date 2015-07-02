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
	if ($_SESSION['funcionalidade'] == "2" ){
	?>
        <h1 class="cabecalho">Ordem de Servi&ccedil;os</h1>

        <form action="cadastrarTombamento.php" method="get" id="validaFormulario">
            <fieldset>
                <legend>Cadastrar Tombamento</legend>
                <br />
                <label for="descricao_equip">Equipamento:</label>
                <select name="descricao_equip" id="descricao_equip" class="validate[required]">
                    <option value="" selected>Selecione uma op&ccedil;&atilde;o...</option>
                      <?php
                         //conecta ao Banco de Dados
                         $conexao = conecta_banco();

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

                <!-- Campo que recebe o numero de tombamento, caso o equipamento seja do IFCE, e possua tal tombamento -->
                <label for ="tombamento">Tombamento:</label>
                <input type="text" name="tombamento" id="tombamento" size="20" maxlength="6" class="validate[required,custom[onlyNumberSp]]"/> <i>(Localize a placa de metal colada ao equipamento. Ex: 174538. Caso n&atilde;o possua, digite <b>0</b>)</i>
                <br /> <br />
                
                <!-- Campo que recebe a marca do equipamento -->
                <label for ="marca">Marca:</label>
                <input type="text" name="marca" id="marca" size="20" maxlength="20" /><i> Deixar <b>em branco</b> caso tombamento seja <b>0</b></i>
                <br /> <br />

                <!-- Campo que recebe o modelo do equipamento -->
                <label for ="modelo">Modelo:</label>
                <input type="text" name="modelo" id="modelo" size="20" maxlength="20"/><i> Deixar <b>em branco</b> caso tombamento seja <b>0</b></i>
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
                 $tombamento = $_GET['tombamento'];
                 $marca = $_GET['marca'];
                 $modelo = $_GET['modelo'];

                 $resultado = inserirTombamento($tombamento, $descricao_equip, $marca, $modelo);

                 //verifica o sucesso da consulta e emite uma mensagem ao usuário
                 if($resultado){
                     $mensagem = "Tombamento inserido com sucesso!";
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
