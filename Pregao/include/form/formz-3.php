<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<title>PREGÃO WEB - GERADOR DE PROPOSTAS
<?php if(isset($_SESSION['Parametros']['nmEntidade'])) { print ' - '.strtoupper($_SESSION['Parametros']['nmEntidade']);}; if (isset($_SESSION['Parametros']['nrPregao'])){print ' - Pregão'.$_SESSION['Parametros']['nrPregao'].'/'.$_SESSION['Parametros']['dtAnoProcesso'];}; ?>
</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="img/index.ico" type="image/x-icon" />
<link rel="shortcut icon" href="img/index.ico" type="image/x-icon" />
</head>
<body class="container">
<legend class="text-center">CARTA PROPOSTA</legend>
<p class="text-justify">Ao Pregoeiro e equipe de apoio da Prefeitura  Municipal de Guarapuava<br>
  <strong>PROPOSTA  DE PREÇOS – PREGÃO PRESENCIAL <?php print $_SESSION['Parametros']['nrPregao'].'/'.$_SESSION['Parametros']['dtAnoProcesso']; ?></strong><br>
  <strong>Objeto:</strong><?php print strtoupper($_SESSION['Parametros']['dsObjeto']); ?></p>
<p class="text-justify"> Apresentamos nossa proposta para  fornecimento dos Itens abaixo discriminados, conforme ANEXO I, que integra o  instrumento convocatório da licitação em epígrafe.</p>
<p><strong>IDENTIFICAÇÃO DO PROPONENTE:</strong><br>
  Razão social: <strong><?php print strtoupper($_POST['nmLicitante']); ?></strong> <br>
  CNPJ: <strong><?php print($_POST['nrDocumentoLicitante']); ?></strong><br>
  Endereço:<strong><?php print strtoupper($_POST['dsEnderecoLicitante']); ?></strong><br>
  Telefone: <strong><?php print ($_POST['nrTelefone']); ?></strong> Endereço  eletrônico (e-mail): <strong><?php print ($_POST['dsEmail']); ?></strong><br>
  Banco: <strong><?php print strtoupper($_POST['dsBanco']); ?></strong> Agência: <strong><?php print ($_POST['nrAgencia']); ?></strong> Conta Corrente:<strong><?php print ($_POST['nrContaCorrente']); ?></strong><br>
  <strong>Representante Legal</strong><br>
  Nome: <strong><?php print strtoupper($_POST['nmRepresentante']); ?></strong><br>
  CPF: <strong><?php print($_POST['nrDocumentoRepresentante']); ?></strong> RG: <strong><?php print ($_POST['nrRGRepresentante']); ?></strong><br>
</p>
<p> <strong>PROPOSTA</strong></p>
<table class="table table-bordered table-condensed text-center" >
  <thead>
    <tr>
      <th width="30px" valign="top">Lote</th>
      <th width="30px" valign="top">Item</th>
      <th width="30px" valign="top">Qtd</th>
      <th width="30px" valign="top">Und</th>
      <th valign="top">Descrição</th>
      <th width="30px" valign="top">Marca</th>
      <th width="30px" valign="top">Unitário.</th>
      <th width="30px" valign="top">Total</th>
    </tr>
  </thead>
  <tbody>
    <?php 
	$Soma=0;
	foreach ($_POST['Proposta'] as $Proposta) {
		if($Proposta['vlProposta']!=''){
?>
    <tr>
      <td><?php print $Proposta['nrLote']; ?></td>
      <td><?php print $Proposta['nrItem']; ?></td>
      <td><?php print number_format($Proposta['vlQuantidade'],3,',','.'); ?></td>
      <td><?php print strtoupper($Proposta['dsUnidade']); ?></td>
      <td class="text-justify"><?php print strtoupper($Proposta['dsItem']); ?></td>
      <td><?php print strtoupper($Proposta['dsMarca']); ?></td>
      <td><?php print number_format($Proposta['vlProposta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.'); ?></td>
      <td><?php print number_format($Proposta['vlProposta']*$Proposta['vlQuantidade'],$_SESSION['Parametros']['nrCasasDecimais'],',','.'); $Soma += ($Proposta['vlProposta']*$Proposta['vlQuantidade']);  ?></td>
    </tr>
    <?php 
		};
	}; 
?>
    <tr>
      <th colspan="8" class="text-right" >Valor Total da Proposta: R$ <?php print number_format($Soma,$_SESSION['Parametros']['nrCasasDecimais'],',','.'); ?> </th>
    </tr>
  </tbody>
</table>
<p class="text-justify"><strong>DECLARAÇÕES:</strong><br>
  Tomamos  conhecimento de todas as informações e das condições locais para o cumprimento  das obrigações, e execução do objeto da licitação e na concordância com todos  os termos deste edital, inclusive no seguinte:<br>
  Que a  proposta de preços terá validade de no mínimo 60 dias corridos contados da data  de sua apresentação.<br>
  Que atende os  requisitos de qualidade mínima exigidos do(s) produto(s) ou serviço(s) bem como  seus prazos e condições de entrega.<br>
  Que os preços  apresentados na proposta incluem todos os custos e despesas, tais como: custos  diretos e indiretos, tributos incidentes, taxa de administração, serviços,  encargos sociais, trabalhistas, seguros, treinamento, lucro e outros  necessários ao cumprimento integral do objeto deste edital e seus Anexos.
  <?php 
	if ($_POST['flMPE']==1){ print '
  <br><strong>Declaramos  que, na presenta data, esta empresa é considerada MICRO EMPRESA ou EMPRESA DE  PEQUENO PORTE, nos termos do art. 3º da Lei Complementar 123/2006 e ainda, que  está excluída das vedações constantes do seu § 4º.</strong>';
	};
?>
</p>
<p align="center">
  <?php 
	$data = date("d").' de ';
	switch (date("m")){
		case 1: $data .= 'Janeiro de ';break;
		case 2: $data .= 'Fevereiro de ';break;
		case 3: $data .= 'Março de ';break;
		case 4: $data .= 'Abril de ';break;
		case 5: $data .= 'Maio de ';break;
		case 6: $data .= 'Junho de ';break;
		case 7: $data .= 'Julho de ';break;
		case 8: $data .= 'Agosto de ';break;
		case 9: $data .= 'Setembro de ';break;
		case 10: $data .= 'Outubro de ';break;
		case 11: $data .= 'Novembro de ';break;
		case 12: $data .= 'Dezembro de ';break;
	};
	$data .= date("Y");
	print $data; 
?>
  .<br>
  <br>
  <br>
</p>
<p align="center">_______________________________________<br>
  <strong><?php print strtoupper($_POST['nmLicitante']); ?></strong><br>
  <strong><?php print strtoupper($_POST['nmRepresentante']); ?></strong></p>
