<?php 
	//Verifica se há credenciados/proponentes
	$sql = 'SELECT * FROM licitanteedital WHERE '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' ORDER BY nmLicitante' ;
	$SelLicitantes = mysqli_query($connect,$sql) or die (mysqli_error($connect));

	$rows = mysqli_num_rows($SelLicitantes); 
	//Se houver proponentes, inicia $ToWord incluindo head e relaciona o credenciamentos do processo
if($rows>0){
	
	$ToWord='
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<style>
table {
	border-collapse: collapse;
	font-family: calibri; 
	font-size:12px;
	}
table, th, td{
	border: 1px solid black;
	text-align: center;
	}
.larg-lote{
	width:0.98cm;
}
.larg-3{
	width:2.33cm;
}
.larg-2{
	width:3.5cm;
}
.larg-1{
	width:7cm;
}
</style>
</head>
<body>
<table>
  <thead>
    <tr>
      <th width="403">RAZÃO SOCIAL</th>
      <th width="106">CNPJ</th>
      <th width="64">MPE</th>
      <th width="64">ÂMBITO</th>
      <th width="329">REPRESENTANTE</th>
    </tr>
  </thead>
  <tbody>';
  while($Licitantes=mysqli_fetch_array($SelLicitantes)){ 
    $ToWord .= '<tr>
      <td>'.strtoupper($Licitantes['nmLicitante']).'</td>
      <td>'.strtoupper($Licitantes['nrDocumentoLicitante']).'</td>
      <td>';if ($Licitantes['flMPE']==1) { $ToWord .= 'SIM';} else { $ToWord .= 'NÃO';}; $ToWord .='</td>
      <td>'; if ($Licitantes['tpAmbito']==1) { $ToWord .= 'LOCAL';} else {if ($Licitantes['tpAmbito']==2){ $ToWord .= 'REGIONAL';} else { $ToWord .=  'FORA';};}; $ToWord .='</td>
      <td>'.strtoupper($Licitantes['nmRepresentante']).'</td>
    </tr>';
	};
	$ToWord .='
   </tbody>
</table>
<br />

		';
		//Busca Relação de Lotes e Quantidades do processo
	$sql = 'SELECT nrLote, vlQuantidade FROM itemeditalentidade WHERE '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' ORDER BY nrLote' ;
	$SelItens = mysqli_query($connect,$sql) or die (mysqli_error($connect));
		//verifica se há mais do que 3 licitantes, para definir rotina de busca de propostas e lances a cada lote aos trios de licitantes
		//$i refere-se ao número de buscas a serem realizadas a cada três Licitantes
	$i = intdiv($rows, 3);
	$PosicaoLicitante = 0;
	while($i>0){//0
		$sql = 'SELECT * FROM licitanteedital WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' ORDER BY nmLicitante ASC LIMIT '.$PosicaoLicitante.', 3' ;
		$SelLicitantes = mysqli_query($connect,$sql) or die (mysqli_error($connect));
			//Retoma $ToWord iniciando a inclusão de nova tabela para cada 3 Licitantes
		$ToWord .='
<table >
  <thead>
    <tr>
      <th class="larg-lote" nowrap="nowrap" rowspan="2">LOTE</th>';
		while ($Licitantes=mysqli_fetch_array($SelLicitantes)){
			$ToWord .= '<th colspan="2">'.$Licitantes['nmLicitante'].'</th>';
		};
   $ToWord .=' </tr>
    <tr>
      <th class="larg-3" nowrap="nowrap">Proposta</th>
      <th class="larg-3" nowrap="nowrap">Lance</th>
      <th class="larg-3" nowrap="nowrap">Proposta</th>
      <th class="larg-3" nowrap="nowrap">Lance</th>
      <th class="larg-3" nowrap="nowrap">Proposta</th>
      <th class="larg-3" nowrap="nowrap">Lance</th>
    </tr>
  </thead>
  <tbody>';
			
			while($Itens=mysqli_fetch_array($SelItens)){
				$ToWord .= '<tr>
      		<td nowrap="nowrap"><strong>'.$Itens['nrLote'].'</strong></td>
				';
				mysqli_data_seek($SelLicitantes, 0); 
				while($Licitantes=mysqli_fetch_array($SelLicitantes)){
					$sql='SELECT vlProposta, vlOferta, flVencedor FROM propostalicitante WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrDocumentoLicitante = '.$Licitantes['nrDocumentoLicitante'].' AND nrLote = '.$Itens['nrLote'];
					
					$SelPropostas=mysqli_query($connect,$sql) or die (mysqli_error($connect));

					$row=mysqli_num_rows($SelPropostas);
					
					if ($row == 1){
						$Proposta=mysqli_fetch_array($SelPropostas);
						$ToWord .= '<td>R$ '.number_format($Proposta['vlProposta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</td>';
						if ($Proposta['flVencedor']==1){
								$ToWord .='<td>R$ <strong>'.number_format($Proposta['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</strong></td>';
						}else{
							if($Proposta['vlOferta']>0){
								$ToWord .='<td>R$ '.number_format($Proposta['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</td>';
							}else{
								$ToWord .='<td></td>';
							};
						};
					}else{
						$ToWord .= '<td></td><td></td>';
					};
				};
				
				$ToWord .='
						</tr>
				';
			};
    

    $ToWord .=' 
			</tbody>
			</table>
			<br />
		';
			
			$PosicaoLicitante += 3;
			$i--;
			mysqli_data_seek($SelItens, 0);
		};
		//havendo sobra na divisão acima, estabelece outra rotina para busca de dados
		$s = $rows % 3;
		if($s>0){
		$sql = 'SELECT * FROM licitanteedital WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' ORDER BY nmLicitante ASC LIMIT '.$PosicaoLicitante.', '.$s ;
		$SelLicitantes = mysqli_query($connect,$sql) or die (mysqli_error($connect));
			if ($s == 1){
			//Retoma $ToWord iniciando a inclusão de nova tabela para 1 Licitante que sobrou
			
				$ToWord .='
<table >
  <thead>
    <tr>
      <th class="larg-lote" nowrap="nowrap" rowspan="2">LOTE</th>';
				while ($Licitantes=mysqli_fetch_array($SelLicitantes)){
					$ToWord .= '<th colspan="2">'.$Licitantes['nmLicitante'].'</th>';
				};
   			$ToWord .=' </tr>
    <tr>
      <th class="larg-1" nowrap="nowrap">Proposta</th>
      <th class="larg-1" nowrap="nowrap">Lance</th>
    </tr>
  </thead>
  <tbody>';
			
			while($Itens=mysqli_fetch_array($SelItens)){
				$ToWord .= '<tr>
      		<td nowrap="nowrap"><strong>'.$Itens['nrLote'].'</strong></td>
				';
				mysqli_data_seek($SelLicitantes,0);
				while($Licitantes=mysqli_fetch_array($SelLicitantes)){
					$sql='SELECT vlProposta, vlOferta, flVencedor FROM propostalicitante WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrDocumentoLicitante = '.$Licitantes['nrDocumentoLicitante'].' AND nrLote = '.$Itens['nrLote'];
					
					$SelPropostas=mysqli_query($connect,$sql) or die (mysqli_error($connect));

					$row=mysqli_num_rows($SelPropostas);
					
					if ($row == 1){
						$Proposta=mysqli_fetch_array($SelPropostas);
						$ToWord .= '<td>R$ '.number_format($Proposta['vlProposta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</td>';
						if ($Proposta['flVencedor']==1){
								$ToWord .='<td>R$ <strong>'.number_format($Proposta['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</strong></td>';
						}else{
							if($Proposta['vlOferta']>0){
								$ToWord .='<td>R$ '.number_format($Proposta['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</td>';
							}else{
								$ToWord .='<td></td>';
							};
						};
					}else{
						$ToWord .= '<td></td><td></td>';
					};
				};
				
				$ToWord .='
						</tr>
				';
			};
    

    $ToWord .=' 
			</tbody>
			</table>
			<br />
		';
					
			};
			if ($s == 2){
			
			
				$ToWord .='
<table >
  <thead>
    <tr>
      <th class="larg-lote" nowrap="nowrap" rowspan="2">LOTE</th>';
				while ($Licitantes=mysqli_fetch_array($SelLicitantes)){
					$ToWord .= '<th colspan="2">'.$Licitantes['nmLicitante'].'</th>';
				};
   			$ToWord .=' </tr>
    <tr>
      <th class="larg-2" nowrap="nowrap">Proposta</th>
      <th class="larg-2" nowrap="nowrap">Lance</th>
			<th class="larg-2" nowrap="nowrap">Proposta</th>
      <th class="larg-2" nowrap="nowrap">Lance</th>
    </tr>
  </thead>
  <tbody>';
			
			while($Itens=mysqli_fetch_array($SelItens)){
				$ToWord .= '<tr>
      		<td nowrap="nowrap"><strong>'.$Itens['nrLote'].'</strong></td>
				';
				
				mysqli_data_seek($SelLicitantes, 0) ;
				while($Licitantes=mysqli_fetch_array($SelLicitantes)){
					$sql='SELECT vlProposta, vlOferta, flVencedor FROM propostalicitante WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrDocumentoLicitante = '.$Licitantes['nrDocumentoLicitante'].' AND nrLote = '.$Itens['nrLote'];
					
					$SelPropostas=mysqli_query($connect,$sql) or die (mysqli_error($connect));

					$row=mysqli_num_rows($SelPropostas);
					
					if ($row == 1){
						$Proposta=mysqli_fetch_array($SelPropostas);
						$ToWord .= '<td>R$ '.number_format($Proposta['vlProposta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</td>';
						if ($Proposta['flVencedor']==1){
								$ToWord .='<td>R$ <strong>'.number_format($Proposta['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</strong></td>';
						}else{
							if($Proposta['vlOferta']>0){
								$ToWord .='<td>R$ '.number_format($Proposta['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</td>';
							}else{
								$ToWord .='<td></td>';
							};
						};
					}else{
						$ToWord .= '<td></td><td></td>';
					};
				};
				
				$ToWord .='
						</tr>
				';
			};
    

    $ToWord .=' 
			</tbody>
			</table>
			<br />
			
		';
					
			};
		};

				$ToWord .= '
					<table style="width: 100%;">
					<tbody>
				';
		$sql = 'SELECT nmLicitante,nrDocumentoLicitante FROM licitanteedital WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' ORDER BY nmLicitante' ;
	$SelLicitantes = mysqli_query($connect,$sql) or die (mysqli_error($connect));
			while($Licitantes=mysqli_fetch_array($SelLicitantes)){
				$sql ='
				SELECT a.vlOferta, b.vlQuantidade FROM pregao.propostalicitante AS a 
				INNER JOIN itemeditalentidade AS b ON a.cdEntidade = b.cdEntidade AND a.dtAnoProcesso = b.dtAnoProcesso AND a.nrPregao = b.nrPregao AND a.nrLote = b.nrLote AND a.nrItem = b.nrItem
				WHERE a.cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND a.nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND a.dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' AND a.flVencedor = 1 AND a.nrDocumentoLicitante = '.$Licitantes['nrDocumentoLicitante'];
				$SelValores = mysqli_query($connect,$sql) or die (mysqli_error($connect));
				$Total =0;
					while($Valores=mysqli_fetch_array($SelValores)){
						$Total += $Valores['vlOferta']*$Valores['vlQuantidade'];
					};
				$ToWord .= '
						<tr>
							<td>'.$Licitantes['nmLicitante'].'</td>
							<td>R$ '.number_format($Total,$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</td>
						</tr>
					
				';
			};
			$ToWord .= '
				</tbody>
				</table>
			</body>
		</html>
			';
		header("Content-type: application/vnd.ms-word");
		header("Content-Disposition: attachment; Filename=Relatório.doc");
		header("Pragma: no-cache");
		header("Expires: 0");	
		echo $ToWord;
	};
?>