<?php
	if($Menor['tpAmbito']==3){
		$sql = 'SELECT a.vlOferta,a.nrDocumentoLicitante,b.nmLicitante,b.flMPE,b.tpAmbito,a.flVencedor FROM propostalicitante AS a INNER JOIN licitanteedital AS b ON a.cdEntidade = b.cdEntidade AND a.dtAnoProcesso = b.dtAnoProcesso AND a.nrPregao = b.nrPregao AND a.nrDocumentoLicitante = b.nrDocumentoLicitante WHERE a.cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND a.dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND a.nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND a.nrLote = '.$Lote['nrLote'].' AND a.nrItem = '.$Lote['nrItem'].' AND a.flClassificado = 1 AND b.flMPE = 1 AND b.tpAmbito <> 3 AND a.vlOferta <= '.($Menor['vlOferta']*(1+($_SESSION['Parametros']['vlPercentual'])/100)).' ORDER BY ';
		if ($_SESSION['Parametros']['flLocalPrioridadeRegional']==1){
			$sql.=' tpAmbito,';
		};
		$sql.=' vlOferta ASC';
		$SelDemais = mysqli_query($connect,$sql) or die (mysqli_error($connect));
		while($Demais = mysqli_fetch_array($SelDemais)){
?>
<tr <?php if ($Demais['flVencedor']==1){print ' class="successo" ';};?>>
  <form action="index.php" method="post">
    <input type="hidden" name="form" value="c-4" />
    <input type="hidden" name="nrLote" value="<?php print $Lote['nrLote']; ?>" />
    <input type="hidden" name="nrItem" value="<?php print $Lote['nrItem']; ?>" />
    <input type="hidden" name="nrDocumentoLicitante" value="<?php print $Demais['nrDocumentoLicitante']; ?>" />
    <td ><?php print $Demais['nmLicitante']; ?></td>
    <td class="text-center"  width="30px"><?php switch ($Demais['flMPE']){case 0: print 'Não'; break; case 1: print 'Sim'; break;}; ?></td>
    <td class="text-center"  width="30px"><?php switch ($Demais['tpAmbito']){case 1: print 'Local'; break; case 2: print 'Regional'; break; case 3: print 'Fora'; break;}; ?></td>
    <td class="text-center"  width="30px"><?php print number_format(((($Demais['vlOferta']/$Menor['vlOferta'])-1)*100),2,',','.').'%'; ?></td>
    <td class="text-center"  width="30px"><?php 
		if ($_SESSION['Parametros']['flFormaBeneficios']==1){
			print '<input type="number" name="vlOferta" max="'.number_format($Menor['vlOferta']-pow(10, -$_SESSION['Parametros']['nrCasasDecimais']),$_SESSION['Parametros']['nrCasasDecimais']).'" value="'.number_format($Demais['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais']).'" step="'.pow(10, -$_SESSION['Parametros']['nrCasasDecimais']).'" style="width:80px;" /> ';
		}else{ 
			print '<input type="hidden" name="vlOferta" value="'.number_format($Demais['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais']).'" />'.number_format($Demais['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.');
		};?></td>
    <td  width="30px"><button type="submit" name="Operacao" value="3" class="btn btn-success form-control">Vencedor</button></td>
  </form>
</tr>
<?php
    };
	};
?>
