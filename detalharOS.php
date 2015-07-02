<?php
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
        <?php

            //recebe o código da OS passado pela página "index.php", via get
            $codigoOS = $_GET['cod_os'];

            //conecta a base de dados
            $conexao = conecta_banco();

            //captura do banco de dados os valores referentes àquela determinada OS
            // e os armazena em algumas variáveis
            $consulta = mysql_query("SELECT * FROM os WHERE cod_os = '$codigoOS'");
            $vetor = mysql_fetch_array($consulta);
            $descricao_equip = $vetor['descricao_equip'];
            $institucional = $vetor['institucional'];
            $setor_origem = $vetor['setor_origem'];
            $tombamento = $vetor['tombamento'];            
            $serv_solicitado = $vetor['serv_solicitado'];
            $problemas = $vetor['prob_identificado'];
            $serv_realizado = $vetor['serv_realizado'];
            $tecnico = $vetor['tecnico_resp'];
            $status = $vetor['status'];

            //captura do banco de dados o nome do solicitante da OS
            // e o armazena na variavel '$solicitante'
            $consulta = mysql_query("SELECT s.cod_solicitante, s.nome
                                       FROM solicitante s, os o
                                          WHERE (o.cod_os = '$codigoOS') AND (o.cod_solicitante = s.cod_solicitante)");
            $vetor = mysql_fetch_array($consulta);
            $solicitante = $vetor['nome'];

            //pega o tombamento do equipamento cadastrado na OS
            $consulta = mysql_query("SELECT tombamento
                                                 FROM os
                                                 WHERE cod_os = '$codigoOS'");
            $vetor = mysql_fetch_array($consulta);
            $tombamento = $vetor['tombamento'];

            //pega a marca e o modelo do equipamento daquela OS
            $consulta = mysql_query("SELECT e.marca, e.modelo
                                        FROM equipamento e, os o
                                        WHERE (e.descricao_equip = '$descricao_equip') AND
                                              (o.cod_os = '$codigoOS') AND (o.tombamento = e.tombamento)");
            $vetor = mysql_fetch_array($consulta);
            $marca = $vetor['marca'];
            $modelo = $vetor['modelo'];
            
        ?>

        <form action="detalharOS.php" method="get">
            <fieldset>
                <legend>Detalhes da Ordem de Serviço</legend>             
                
                <!--Escreve o tecnico que atendeu a OS, contido na varavel $codigoOS -->
                <label>C&oacute;digo:</label> <?php echo $codigoOS;?>
                <br /> <br />

                <!--Escreve o tecnico que atendeu a OS, contido na varavel $status -->
                <label>Status:</label> <?php echo '&nbsp;'.$status;?>
                <br /> <br />
                
                <!--Escreve o setor que originou a OS, contido na varavel $setor_origem -->
                <label>Local do Atendimento:</label> <?php echo '&nbsp;'.$setor_origem;?>
                <br /> <br /> <br />
                
                <label>Solicitante:</label> <?php echo $solicitante;?>
                <br /> <br />

                 <!--Escreve o tecnico que atendeu a OS, contido na varavel $tecnico -->
                <label>Atendida por:</label> <?php echo $tecnico;?>
                <br /> <br /> <br />

                <label>Equipamento:</label> <?php echo $descricao_equip;?>
                <br /> <br />

                <!--Escreve a marca do equipamento contido na variável $marca -->
                <label>Marca:</label> <?php echo '&nbsp;'.$marca;?>
                <br />  <br />

                <!--Escreve o modelo do equipamento contido na variável $modelo -->
                <label>Modelo:</label> <?php echo '&nbsp;'.$modelo;?>
                <br /> <br />

                <label>Tombamento:</label> 
                    <?php
                        if($tombamento == 0 || $tombamento == NULL){ $tombamento = 'Nao possui';}
                        echo '&nbsp;'.$tombamento;
                    ?>
                <br /> <br />

                <label>Institucional?</label> <?php echo '&nbsp;'.$institucional;?>
                <br /> <br />

                <!--Escreve o serviço solicitado para equipamento, contido na variável $servico está somente leitura porque foi o usuário que assim digitou -->
                <label>Atendimento Requisitado:</label> <?php echo '&nbsp;'.$serv_solicitado;?>
                <br /> <br /> <br />

                <!--Escreve os problemas identificados contidos na variável $problemas -->
                <label>Problemas Identificados:</label>
                <textarea name="problemas" cols="60" rows="5" disabled><?php echo $problemas;?></textarea>
                <br /> <br />

                <!--Escreve o serviço realizado no equipamento, contido na variável $serv_realizado -->
                <label>Servi&ccedil;o Realizado:</label>
                <textarea name="serv_realizado" cols="60" rows="5" disabled><?php echo $serv_realizado;?></textarea>
                <br /> 
                
                <?php
                    
                     //fecha a conexão com o SGBD
                     $conexao = desconecta_banco();                     

                     $data = date("d/m/Y");
                     $hora = date("H:i");
                     echo "<br /> ";
                
                     echo "Consulta realizada com sucesso em $data às $hora hs." ;
                     echo "<br /> <br /> ";
                 ?> 

                <!--Volta para a página principal -->
                <input type="button" value="Voltar" onclick="window.location.href='index.php'" />
                 

            </fieldset>
        </form>
       <h5>Instituto Federal do Cear&aacute; - Campus Tiangu&aacute;</h5>
    </body>
</html>
