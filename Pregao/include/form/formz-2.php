<?php 
//gera o arquivo
$DadosProposta = '1|'.$_SESSION['Parametros']['cdEntidade'].'|'.$_SESSION['Parametros']['dtAnoProcesso'].'|'.$_SESSION['Parametros']['nrPregao'].'|'.str_replace('-', '', str_replace('/', '', str_replace('.', '', $_POST['nrDocumentoLicitante']))).'|'.strtoupper($_POST['nmLicitante']).'|'.$_POST['flMPE'].'|'.$_POST['tpAmbito'].'|'.str_replace('-', '', str_replace('.', '', $_POST['nrDocumentoRepresentante'])).'|'.strtoupper($_POST['nmRepresentante']).PHP_EOL;

$Propostas = $_POST['Proposta'];
foreach ($Propostas as $Proposta ) {
	if($Proposta['vlProposta']!=''){
	$DadosProposta.='2|'.$_SESSION['Parametros']['cdEntidade'].'|'.$_SESSION['Parametros']['dtAnoProcesso'].'|'.$_SESSION['Parametros']['nrPregao'].'|'.$Proposta['nrLote'].'|'.$Proposta['nrItem'].'|'.str_replace('-', '', str_replace('/', '', str_replace('.', '', $_POST['nrDocumentoLicitante']))).'|'.number_format($Proposta['vlProposta'],$_SESSION['Parametros']['nrCasasDecimais']).'|'.strtoupper($Proposta['dsMarca']).PHP_EOL;
	};
};
$DadosProposta = trim($DadosProposta,'\r\n');
$nmArquivo = 'files/PropostaDigital'.$_SESSION['Parametros']['nrPregao'].'_'.$_SESSION['Parametros']['dtAnoProcesso'].'_'.str_replace('-', '', str_replace('/', '', str_replace('.', '', $_POST['nrDocumentoLicitante']))).'.txt';
$PropostaDigital = fopen($nmArquivo,'w');
fwrite($PropostaDigital,$DadosProposta);

fclose($PropostaDigital);

//força o donwload
	header("Content-Type: application/txt");
	header("Content-Length: ". filesize($nmArquivo));
	header("Content-Disposition: attachment; filename=".basename($nmArquivo));
	
	readfile($nmArquivo);

//exclui o arquivo
unlink($nmArquivo);
?>