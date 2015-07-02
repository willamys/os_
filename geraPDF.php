<?php    

    // Caminho para o arquivo fpdf.php
    require('common/fpdf.php');    

    include ('common/banco.php');
	
	ob_start();
	session_start();
	
	if ($_SESSION['funcionalidade'] == "1" || $_SESSION['funcionalidade'] == "2" ){

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
    $data_cadastro = $vetor['data_cadastro'];
    $data_encerramento = $vetor['data_encerramento'];    
    
    //captura do banco de dados o nome e o cargo do solicitante da OS
    // e o armazena nas variaveis '$solicitante' e '$cargo'
    $consulta = mysql_query("SELECT s.cod_solicitante, s.nome,s.cargo
                               FROM solicitante s, os o
                                  WHERE (o.cod_os = '$codigoOS') AND (o.cod_solicitante = s.cod_solicitante)");
    $vetor = mysql_fetch_array($consulta);
    $solicitante = $vetor['nome'];
    $cargo = $vetor['cargo'];

    //pega o tombamento do equipamento cadastrado na OS
    $consulta = mysql_query("SELECT tombamento
                                         FROM os
                                         WHERE cod_os = '$codigoOS'");
    $vetor = mysql_fetch_array($consulta);
    $tombamento = $vetor['tombamento'];
	
    if($tombamento == 0 || $tombamento == NULL){ $tombamento = 'Não possui';}
                   

    //pega a marca e o modelo do equipamento daquela OS
    $consulta = mysql_query("SELECT e.marca, e.modelo
                                FROM equipamento e, os o
                                WHERE (e.descricao_equip = '$descricao_equip') AND
                                      (o.cod_os = '$codigoOS') AND (o.tombamento = e.tombamento)");
    $vetor = mysql_fetch_array($consulta);
    $marca = $vetor['marca'];
    $modelo = $vetor['modelo'];
	
	if($marca == "" ||$marca == NULL){ $marca = 'Não informado';}
	if($modelo == "" ||$modelo == NULL){ $modelo = 'Não informado';}

    //pega o cargo do tecnico responsavel pelo atendimento da OS
    $consulta = mysql_query("SELECT cargo
                                FROM solicitante
                                WHERE (nome = '$tecnico')");
    $vetor = mysql_fetch_array($consulta);
    $cargo_tec = $vetor['cargo'];

    //defininfo a localizacao das fonte
    define('FPDF_FONTPATH','common/fontes/');

    //Novo documento PDF com orientação P - Retrato (Picture) que pode ser também L - Paisagem (Landscape)
    $pdf = new FPDF('P');

    $pdf->AddPage();
    
    $pdf->SetFont('helvetica','',8);

    $pdf->Image('common/icones/logotipoIFCE.jpg', 10,15,40,15);
    
    $pdf->Ln(10);    
    $pdf->Cell(0,4,'MINISTERIO DA EDUCACAO',0,1,'R');
    $pdf->Cell(0,4,'INSTITUTO FEDERAL DE EDUCACAO, CIENCIA E TECNOLOGIA DO CEARA',0,1,'R');
    $pdf->Cell(0,4,'CAMPUS TIANGUA',0,1,'R');
    $pdf->Ln(2);
    $pdf->Cell(0,0,'',1,1,'L');

    $pdf->Ln(10);

    $pdf->SetFont('arial','B',18);
    $pdf->Cell(0,5,iconv('utf-8','iso-8859-1','Ordem de Serviço'),0,1,'C');
    $pdf->Ln(10);
    
    $pdf-> SetFont('times','B',12);    
    $pdf-> Cell(33,5,iconv('utf-8','iso-8859-1','Código da OS:'),0,0);
    $pdf-> SetFont('times','',12);
    $pdf->Cell(40,5, $codigoOS,0,1);
    
    $pdf-> SetFont('times','B',12);    
    $pdf-> Cell(33,5,iconv('utf-8','iso-8859-1','Local de Origem:'),0,0);
    $pdf-> SetFont('times','',12);
     $pdf->Cell(40,5, iconv('utf-8','iso-8859-1',$setor_origem),0,1);

    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(33,5,iconv('utf-8','iso-8859-1','Cadastrada em:'),0,0);
    $pdf-> SetFont('times','',12);
    $pdf->Cell(40,5, $data_cadastro,0,1);

    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(33,5,'Status:',0,0);
    $pdf-> SetFont('times','',12);
    $pdf->Cell(35, 5, $status,0,1);

    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(33,5,iconv('utf-8','iso-8859-1','Encerrada em:'),0,0);
    $pdf-> SetFont('times','',12);
    $pdf->Cell(40,5, $data_encerramento,0,1);

    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(33,5,'Solicitante:',0,0);
    $pdf-> SetFont('times','',12);
    $pdf->Cell(35,5, iconv('utf-8','iso-8859-1',$solicitante),0,1);

    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(33,5,iconv('utf-8','iso-8859-1','Atendida por:'),0,0);
    $pdf-> SetFont('times','',12);
    $pdf->Cell(35,5, iconv('utf-8','iso-8859-1',$tecnico),0,1);

    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(33,5,'Equipamento:',0,0);
    $pdf-> SetFont('times','',12);
    $pdf->Cell(35,5, iconv('utf-8','iso-8859-1',$descricao_equip),0,1);

    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(33,5,'Marca: ',0,0);
    $pdf-> SetFont('times','',12);
    $pdf->Cell(35,5, iconv('utf-8','iso-8859-1',$marca),0,1);

    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(33,5,'Modelo:',0,0);
    $pdf-> SetFont('times','',12);
    $pdf->Cell(35,5, iconv('utf-8','iso-8859-1',$modelo),0,1);
    
    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(33,5,'Tombamento:',0,0);
    $pdf-> SetFont('times','',12);
    $pdf->Cell(35,5, iconv('utf-8','iso-8859-1',$tombamento),0,1);

	if($institucional == "Nao"){ $institucional = "Não";} 
    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(33,5,'Institucional?',0,0);
    $pdf-> SetFont('times','',12);
     $pdf->Cell(35,5, iconv('utf-8','iso-8859-1',$institucional),0,1);
    $pdf->Ln(5);

    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(50,5,'Atendimento Requisitado:',0,0);
    $pdf-> SetFont('times','',12);
    $pdf->MultiCell(130, 5, iconv('utf-8','iso-8859-1',$serv_solicitado),0,1);
    $pdf->Ln(5);

    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(50,5,'Problemas Identificados:',0,0);
    $pdf-> SetFont('times','',12);
    $pdf->MultiCell(130, 5, iconv('utf-8','iso-8859-1',$problemas),0,1);
    $pdf->Ln(5);

    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(50,5,iconv('utf-8','iso-8859-1','Serviço Realizado:'),0,0);
    $pdf-> SetFont('times','',12);
    $pdf->MultiCell(130, 5, iconv('utf-8','iso-8859-1',$serv_realizado),0,1);
    $pdf->Ln(5);

    $pdf-> SetFont('times','B',12);
    $pdf-> Cell(35,7,iconv('utf-8','iso-8859-1','Grau de Satisfação do Solicitante:'),0,1);
    $pdf-> SetFont('times','',12);    
    $pdf->Cell(35, 7, '(  ) Insatisfeito',0,0);
    $pdf->Cell(35, 7, '(  ) Satisfeito',0,1);
    $pdf->Ln(1);
    $pdf->Cell(0,5,"Justifique: ___________________________________________________________________________",0,1,'L');
    $pdf->Ln(15);

    $pdf->Cell(0,5,"____________________________________",0,1,'C');
    $pdf->Cell(0,5,iconv('utf-8','iso-8859-1',$tecnico),0,1,'C');
    $pdf->Cell(0,5,iconv('utf-8','iso-8859-1',$cargo_tec),0,1,'C');

    $pdf->Ln(5);
    
    $pdf->Cell(0,5,"____________________________________",0,1,'C');
    $pdf->Cell(0,5,iconv('utf-8','iso-8859-1',$solicitante),0,1,'C');
    $pdf->Cell(0,5,iconv('utf-8','iso-8859-1',$cargo),0,1,'C');
    
    /*******definindo o rodapé*************************/
    $pdf-> SetFont('helvetica','',8);
    //posiciona verticalmente 270mm
    $pdf->SetY("265");
    //data atual
    $data=date("d/m/Y");
    $conteudo="Instituto Federal de Educação, Ciência e Tecnologia do Ceará - Campus Tianguá";
    $texto="Rodovia CE 187 - Aeroporto - CEP: 62320-000 - Tianguá - CE Fone: (88) 3671.2299 / (88) 3671.2310";

    //imprime uma celula... largura,altura, texto,borda,quebra de linha, alinhamento
    $pdf->Cell(0,0,'',1,1,'L');
    //imprime uma celula... largura,altura, texto,borda,quebra de linha, alinhamento
    $pdf->Cell(0,5,iconv('utf-8','iso-8859-1',$conteudo),0,1,'C');
    //imprime uma celula... largura,altura, texto,borda,quebra de linha, alinhamento
    $pdf->Cell(0,5,iconv('utf-8','iso-8859-1',$texto),0,0,'C');

    $pdf->Output();
					
	}else{header("Location: index.php");}
?>
