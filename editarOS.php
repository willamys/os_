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
        <h1 class="cabecalho"> Ordem de Servicos </h1>

        <?php

            //recebe o codigo da OS passado pela pagina "cadastrarOS", via get
            $codigoOS = $_GET['cod_os'];

            //conecta a base de dados
            $conexao = conecta_banco();

            //captura do banco de dados os valores referentes aquela determinada OS
            // e os armazena em algumas variaveis
            $consulta = mysql_query("SELECT * FROM os WHERE cod_os = '$codigoOS'");
            $vetor = mysql_fetch_array($consulta);

            $tipo_equipamento = $vetor['descricao_equip'];
            $setor_origem = $vetor['setor_origem'];
            $tombamento = $vetor['tombamento'];
            $institucional = $vetor['institucional'];
            $serv_solicitado = $vetor['serv_solicitado'];
            $problemas = $vetor['prob_identificado'];
            $serv_realizado = $vetor['serv_realizado'];
            $tecnico = $vetor['tecnico_resp'];
            $status = $vetor['status'];

        ?>

        <form action="editarOS.php" method="get" id="validaFormulario">
            <fieldset>
                <legend>Editar Ordem de Servi&ccedil;o</legend>

                <label for="solicitante">Solicitante:</label>
                <select name="solicitante">

                      <?php
                         //busca o solicitante da OS na base de dados e o exibe
                         $consulta = mysql_query("SELECT s.cod_solicitante, s.nome
                                       FROM solicitante s, os o
                                          WHERE (o.cod_os = '$codigoOS') AND (o.cod_solicitante = s.cod_solicitante)");
                         while($resultado = mysql_fetch_array($consulta)){
                             echo '<option value="'.$resultado['cod_solicitante'].'">'.$resultado['nome'].'</option>';
                         }
                      ?>
                </select>
                <br>
                <br>
                <label for="tipo_equipamento">Equipamento:</label>
                <select name="tipo_equipamento">
                      <?php
                        //busca o tipo do equipamento da OS na base de dados e o exibe
                         $consulta = mysql_query("SELECT e.descricao_equip
                                                  FROM tipoequipamento e, os o
                                                  WHERE (cod_os = '$codigoOS') AND (o.descricao_equip = e.descricao_equip)");
                         while($result = mysql_fetch_array($consulta)){
                             echo '<option value="'.$result['descricao_equip'].'">'.$result['descricao_equip'].'</option>';
                         }

                      ?>
                </select>
                <br /> <br />

                <!-- Seta a marcacao referente ao tipo de equipamento: se pertence ao IFCE ou nao -->
                <label for="institucional">Equipamento pertence ao IFCE?</label>
                <br />
                <?php
                        if ($institucional == NULL){
                            echo "<input type='radio' name='institucional' value='Sim'> Sim";
                            echo "  ";
                            echo "<input type='radio' name='institucional' value='Nao'> Nao";
                             echo "<br /> <br /> <br />";
                        }
                        if ($institucional == "Sim"){
                            echo "<input type='radio' name='institucional' value='Sim' checked> Sim";
                            echo "  ";
                            echo "<input type='radio' name='institucional' value='Nao'> Nao";
                             echo "<br /> <br /> <br />";
                        }
                        if ($institucional == "Nao"){
                            echo "<input type='radio' name='institucional' value='Sim'> Sim";
                            echo "  ";
                            echo "<input type='radio' name='institucional' value='Nao' checked> Nao";
                            echo "<br /> <br /> <br />";
                        }
                      ?>
                
                <!--Escreve o setor de origem do equipamento contido na variavel $setor_origem -->
                <label for ="setor_origem">Local do Atendimento:</label>
                <input type="text" name="setor_origem" id="setor_origem" size="30" maxlength="30" value="<?php echo $setor_origem;?>"/>
                <br /> <br /> <br />

                <label for="tombamento">Tombamento:</label>
                <select name="tombamento" id ="tombamento" class="validate[required]">
                    <option value="" selected></option>
                      <?php
                            if ($tombamento == NULL){
                                $consulta = mysql_query("SELECT e.tombamento
                                                 FROM equipamento e, tipoequipamento t, os o
                                                 WHERE (o.cod_os = '$codigoOS') AND
                                                       ('$tipo_equipamento' = t.descricao_equip) AND
                                                        (t.descricao_equip = e.descricao_equip)
                                                ORDER BY e.tombamento");
                            }else{
                                $consulta = mysql_query("SELECT tombamento
                                                 FROM os
                                                 WHERE cod_os = '$codigoOS'");
                            }
                         while($result = mysql_fetch_array($consulta)){
                             echo '<option value="'.$result['tombamento'].'">'.$result['tombamento'].'</option>';
                         }
                      ?>
                </select>
                &nbsp; <i>Se n&atilde;o estiver aqui, voc&ecirc; pode &nbsp;</i><a href="cadastrarTombamento.php">Incluir Tombamento</a>
                <br /> <br />

                <!--Escreve o servico solicitado contido na variavel $serv_solicitado -->
                <label for ="serv_solicitado">Atendimento Requisitado:</label>
                <input type="text" name="serv_solicitado" id="serv_solicitado" size="60" maxlength="60" value="<?php echo $serv_solicitado;?>" readonly ="readonly"/>
                <br /> <br /> <br />

                <!--Escreve os problemas identificados contidos na variavel $problemas -->
                <label for ="problemas">Problemas Identificados:</label>
                <!--<input type="text" name="problemas" id="problemas" size="100" maxlength="100" value="<?php //echo $problemas;?>"/>-->
                <textarea name="problemas" cols="60" rows="5"><?php echo $problemas;?></textarea>
                <br /> <br />

                <!--Escreve o servico realizado no equipamento, contido na variavel $serv_realizado -->
                <label for ="serv_realizado">Servi&ccedil;o Realizado:</label>
                <textarea name="serv_realizado" cols="60" rows="5"><?php echo $serv_realizado;?></textarea>
                <!--<input type="text" name="serv_realizado" id="serv_realizado" size="100" maxlength="100" value="<?php //echo $serv_realizado;?>"/>-->
                <br /> <br />

                <label for="statusOS">Status:</label>
                <br>
                <?php
                    //atualiza a marcacao do status da OS conforme o banco de dados

                    if ($status == "Aberta"){
                        echo "<input type='radio' name='statusOS' value='Aberta' checked>Aberta<br>";
                        echo "<input type='radio' name='statusOS' value='Em andamento'>Em andamento<br>";
                        echo "<input type='radio' name='statusOS' value='Finalizada'>Finalizada<br>";
                        echo "<br />";
                    }
                    if($status == "Em andamento"){
                        echo "<input type='radio' name='statusOS' value='Aberta'>Aberta<br>";
                        echo "<input type='radio' name='statusOS' value='Em andamento' checked>Em andamento<br>";
                        echo "<input type='radio' name='statusOS' value='Finalizada'>Finalizada<br>";
                        echo "<br />";
                    }
                    if ($status == "Finalizada"){
                        echo "<input type='radio' name='statusOS' value='Aberta'>Aberta<br>";
                        echo "<input type='radio' name='statusOS' value='Em andamento'>Em andamento<br>";
                        echo "<input type='radio' name='statusOS' value='Finalizada' checked>Finalizada<br>";
                        echo "<br />";
                    }
                ?>

                <label for="tecnico">Atendida por:</label>
                <br /> <br />
                      <?php
                        if ($tecnico == NULL){
                            echo "<input type='radio' name='tecnico' value='Fabio Arruda Magalhaes'>Fabio Arruda Magalhaes<br>";
                            echo "<input type='radio' name='tecnico' value='Flavio Alexandre R. Barbosa Lima'>Flavio Alexandre R. Barbosa Lima<br>";
                            echo "<input type='radio' name='tecnico' value='Francisco Douglas Ferreira da Silva'>Francisco Douglas Ferreira da Silva<br>";
                            echo "<input type='radio' name='tecnico' value='Willamys Gomes Fonseca Araujo'>Willamys Gomes Fonseca Araujo<br>";
                            echo "<br />";
                        }
                        if ($tecnico == "Fabio Arruda Magalhaes"){
                            echo "<input type='radio' name='tecnico' value='Fabio Arruda Magalhaes' checked>Fabio Arruda Magalhaes<br>";
                            echo "<input type='radio' name='tecnico' value='Flavio Alexandre R. Barbosa Lima'>Flavio Alexandre R. Barbosa Lima<br>";
                            echo "<input type='radio' name='tecnico' value='Francisco Douglas Ferreira da Silva'>Francisco Douglas Ferreira da Silva<br>";
                            echo "<input type='radio' name='tecnico' value='Willamys Araujo'>Willamys Araujo<br>";
                            echo "<br />";
                        }
                        if ($tecnico == "Flavio Alexandre R. Barbosa Lima"){
                            echo "<input type='radio' name='tecnico' value='Fabio Arruda Magalhaes'>Fabio Arruda Magalhaes<br>";
                            echo "<input type='radio' name='tecnico' value='Flavio Alexandre R. Barbosa Lima' checked>Flavio Alexandre R. Barbosa Lima<br>";
                            echo "<input type='radio' name='tecnico' value='Francisco Douglas Ferreira da Silva'>Francisco Douglas Ferreira da Silva<br>";
                            echo "<input type='radio' name='tecnico' value='Willamys Gomes Fonseca Araujo'>Willamys Gomes Fonseca Araujo<br>";
                            echo "<br />";
                        }
                        if ($tecnico == "Francisco Douglas Ferreira da Silva"){
                            echo "<input type='radio' name='tecnico' value='Fabio Arruda Magalhaes'>Fabio Arruda Magalhaes<br>";
                            echo "<input type='radio' name='tecnico' value='Flavio Alexandre R. Barbosa Lima'>Flavio Alexandre R. Barbosa Lima<br>";
                            echo "<input type='radio' name='tecnico' value='Francisco Douglas Ferreira da Silva' checked>Francisco Douglas Ferreira da Silva<br>";
                            echo "<input type='radio' name='tecnico' value='Willamys Gomes Fonseca Araujo'>Willamys Gomes Fonseca Araujo<br>";
                            echo "<br />";
                        }
                        if ($tecnico == "Willamys Gomes Fonseca Araujo"){
                            echo "<input type='radio' name='tecnico' value='Fabio Arruda Magalhaes'>Fabio Arruda Magalhaes<br>";
                            echo "<input type='radio' name='tecnico' value='Flavio Alexandre R. Barbosa Lima'>Flavio Alexandre R. Barbosa Lima<br>";
                            echo "<input type='radio' name='tecnico' value='Francisco Douglas Ferreira da Silva'>Francisco Douglas Ferreira da Silva<br>";
                            echo "<input type='radio' name='tecnico' value='Willamys Gomes Fonseca Araujo' checked>Willamys Gomes Fonseca Araujo<br>";
                            echo "<br />";
                        }

                         //fecha a conexao com o SGBD
                         $conexao = desconecta_banco();
                      ?>


                <!--Campo oculto que serve para fins de validaÃ§Ã£o -->
                <input type="hidden" name="validador" value="1"/>

                <!--Campo oculto que passa o id para a propria pagina a fim de sabermos qual sera a linha a ser alterada -->
                <input type="hidden" name="cod_os" value="<?php echo $codigoOS; ?>"/>

                <!--Volta para a pagina principal -->
                <input type="button" value="Voltar" onclick="window.location.href='index.php'" />

                <!--Limpa os campos -->
                <input type="reset" value="Limpar"/>

                <!--Envia os dados do formulario para tratamento -->
                <input type="submit" value="Ok"/>
            </fieldset>
        </form>
        <h5>Instituto Federal do Cear&aacute; - Campus Tiangu&aacute;</h5>

        <?php
            //verifica existÃªncia e valor do campo oculto 'validador'
            if (isset ($_GET['validador']) && ($_GET['validador'] == 1)){

                //conecta a base de dados
                 $conexao = conecta_banco();

                 //seta as variaveis com os valores do formulÃ¡rio
                 $codigoOS = $_GET['cod_os'];
                 $solicitante = $_GET['solicitante'];
                 $tipo_equipamento = $_GET['tipo_equipamento'];
                 $institucional = $_GET['institucional'];
                 $setor_origem = $_GET['setor_origem'];
                 $tombamento = $_GET['tombamento'];
                 $serv_solicitado = $_GET['serv_solicitado'];
                 $problemas = $_GET['problemas'];
                 $serv_realizado = $_GET['serv_realizado'];
                 $status = $_GET['statusOS'];
                 $tecnico = $_GET['tecnico'];
                 $hora_encerramento = date("H:i:s");
                 $data_encerramento = date("d/m/Y");


                 //verifica o status da OS, e a partir dai, ajusta o comando SQL
                 if ($status == "Em andamento"){
                     $consulta = mysql_query("UPDATE os
                                                SET cod_solicitante = '$solicitante', descricao_equip = '$tipo_equipamento',
                                                    institucional = '$institucional', setor_origem = '$setor_origem', tombamento = '$tombamento',
                                                    serv_solicitado = '$serv_solicitado',
                                                    prob_identificado = '$problemas', serv_realizado = '$serv_realizado',
                                                    tecnico_resp = '$tecnico', status ='$status'
                                                WHERE cod_os = '$codigoOS'");
                 }else if ($status == "Finalizada"){
                     $consulta = mysql_query("UPDATE os
                                                SET cod_solicitante = '$solicitante', descricao_equip = '$tipo_equipamento',
                                                    institucional = '$institucional', setor_origem = '$setor_origem', tombamento = '$tombamento',
                                                    serv_solicitado = '$serv_solicitado',
                                                    prob_identificado = '$problemas', serv_realizado = '$serv_realizado',
                                                    tecnico_resp = '$tecnico', status ='$status',
                                                    hora_encerramento = '$hora_encerramento', data_encerramento = '$data_encerramento'
                                                WHERE cod_os = '$codigoOS'");
                 }

                 //verifica o sucesso da consulta e emite uma mensagem ao usuario
                 if($consulta){
                     $mensagem = "Atualiza&ccedil;&atilde;o realizada com sucesso!";
                 }else{
                     $mensagem = "Erro ao tentar atualizar!";
                 }

                 retornar($mensagem, "index.php");

                 //fecha a conexao com o SGBD
                 $conexao = desconecta_banco();
            }
        ?>
<?php }else{
				$mensagem = "Acesso restrito e exclusivo ao usu&aacuterio administrador.";
				retornar($mensagem,"index.php");
		}
	?>
    </body>
</html>
