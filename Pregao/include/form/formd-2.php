<?php 
//Monta os Dados do Arquivo
$sql = 'SELECT nrLote, nrDocumentoLicitante, vlOferta, dsMarca FROM propostalicitante WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND flVencedor = 1 ORDER BY nrLote';
		$SelPropostas = mysqli_query($connect,$sql) or die (mysqli_error($connect));
		$Rows = mysqli_num_rows($SelPropostas);
		if($Rows > 0) {
			$Export = PHP_EOL;
			while($Propostas = mysqli_fetch_array($SelPropostas)){
				$Export .= '2|'.$_SESSION['Parametros']['nrPregao'].'|'.$_SESSION['Parametros']['dtAnoProcesso'].'|'.$Propostas['nrLote'].'|1|1|'.$Propostas['nrDocumentoLicitante'].'|'.$Propostas['vlOferta'].'|'.$Propostas['dsMarca'].'|1'.PHP_EOL;
			};
			
//Gera o Arquivo
			$nmArquivo = 'files/Pregao'.$_SESSION['Parametros']['dtAnoProcesso'].'nrProcesso.exp'; 
			$Arquivo = fopen($nmArquivo,'w');
			fwrite($Arquivo,$Export);

			fclose($Arquivo);

//força o donwload
	header("Content-Type: application/txt");
	header("Content-Length: ". filesize($nmArquivo));
	header("Content-Disposition: attachment; filename=".basename($nmArquivo));
	
	readfile($nmArquivo);

//exclui o arquivo
unlink($nmArquivo);
		};
?>