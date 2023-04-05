<?php 
	if (@$_POST['Operacao'] == 2){
		$nrLote = $_POST['nrLote'];
		$nrItem = $_POST['nrItem'];
		$Lances = $_POST['Lance'];
		foreach ($Lances as $Lance){
			$sql = 'UPDATE propostalicitante SET vlOferta = ';
			if ($Lance['vlOferta']==''){$sql .= number_format($Lance['vlProposta'],$_SESSION['Parametros']['nrCasasDecimais']);}else{$sql .= number_format($Lance['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais']);};
			$sql .=' WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'].' and nrDocumentoLicitante = '.$Lance['nrDocumentoLicitante'];
			mysqli_query($connect,$sql) or die (mysqli_error($connect));
		};
	};
	if(@$_POST['Operacao']==3){
		$nrLote = $_POST['nrLote'];
		$nrItem = $_POST['nrItem'];
		$sql = 'UPDATE propostalicitante SET flVencedor = 0 WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'];
		mysqli_query($connect,$sql) or die (mysqli_error($connect));
		$sql = 'UPDATE propostalicitante SET vlOferta = '.number_format($_POST['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais']).', flVencedor = 1 WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'].' AND nrDocumentoLicitante = '.$_POST['nrDocumentoLicitante'];
		mysqli_query($connect,$sql) or die (mysqli_error($connect));
		$sql = 'UPDATE itemeditalentidade SET flSituacao = 1 WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'];
		mysqli_query($connect,$sql) or die (mysqli_error($connect));
		};
		if(@$_POST['Operacao']==4){
			$nrLote = $_POST['nrLote'];
			$nrItem = $_POST['nrItem'];
			$sql = 'UPDATE itemeditalentidade SET flSituacao = 2 WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'];
		mysqli_query($connect,$sql) or die (mysqli_error($connect));
		};
		if(@$_POST['Operacao']==5){
			$nrLote = $_POST['nrLote'];
			$nrItem = $_POST['nrItem'];
			$sql = 'UPDATE itemeditalentidade SET flSituacao = 3 WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'];
		mysqli_query($connect,$sql) or die (mysqli_error($connect));
		};
		if(@$_POST['Operacao']==6){
			$nrLote = $_POST['nrLote'];
			$nrItem = $_POST['nrItem'];
			$sql = 'UPDATE itemeditalentidade SET flSituacao = 4 WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'];
		mysqli_query($connect,$sql) or die (mysqli_error($connect));
		};
		if(@$_POST['Operacao']==8){
			$nrLote = $_POST['nrLote'];
			$nrItem = $_POST['nrItem'];
			$sql = 'UPDATE itemeditalentidade SET flSituacao = 0 WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'];
		mysqli_query($connect,$sql) or die (mysqli_error($connect));
		};
		if(@$_POST['Operacao']==7){
			$nrLote = $_POST['nrLote'];
			$nrItem = $_POST['nrItem'];
			$sql = 'UPDATE itemeditalentidade SET flSituacao = 0 WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'];
			mysqli_query($connect,$sql) or die (mysqli_error($connect));
			$sql = 'UPDATE propostalicitante SET flVencedor = 0, vlOferta = null WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'];
			mysqli_query($connect,$sql) or die (mysqli_error($connect));
		};
	include ('header.php'); 
?>

<div>
  <legend class="text-uppercase"><?php print '<strong>'.strtoupper($_SESSION['Parametros']['nmEntidade']).' - Pregão nº '.$_SESSION['Parametros']['nrPregao'].'/'.$_SESSION['Parametros']['dtAnoProcesso'].'</strong><br />'.strtoupper($_SESSION['Parametros']['dsObjeto']); ?></legend>
  <form action="index.php" method="post" >
    <input type="hidden" name="form" value="c-4" />
    <legend>Disputa por Lances</legend>
    <div class="row">
      <div class="form-group">
        <div class="col-lg-9">
          <select name="nrLoteItem" class="form-control">
            <?php 
						for ($i=0; $i<=4; $i++ ){
							switch ($i){
								case 0: print '<optgroup label="Não Disputados">'; break;
								case 1: print '<optgroup label="Disputados">'; break;
								case 2: print '<optgroup label="Frustrados">'; break;
								case 3: print '<optgroup label="Desertos">'; break;
								case 4: print '<optgroup label="Cancelados">'; break;						
							};
							$sql = 'SELECT nrLote,nrItem, LEFT(dsItem,60) AS dsItem FROM itemeditalentidade WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND flSituacao = '.$i.' ORDER BY nrLote,nrItem';
							$SelLotes=mysqli_query($connect,$sql) or die (mysqli_error($connect));
							while ($Lotes=mysqli_fetch_array($SelLotes)){
								print '<option value="'.$Lotes['nrLote'].'.'.$Lotes['nrItem'].'" ';
								if ((@$_POST['nrLoteItem']==($Lotes['nrLote'].'.'.$Lotes['nrItem']))or(@$_POST['nrLote'].'.'.@$_POST['nrItem']==($Lotes['nrLote'].'.'.$Lotes['nrItem']))){
									print ' selected="selected" ';
								};
								print' >Lote '.$Lotes['nrLote'].' - Item '.$Lotes['nrItem'].' - '.strtoupper($Lotes['dsItem']).'</option>';
							};
							print '</optgroup>';
						};
?>
          </select>
        </div>
        <div class="col-lg-3">
          <button type="submit" name="Operacao" value="1"  class="form-control btn btn-primary">Carregar Lote para Disputa</button>
        </div>
      </div>
    </div>
  </form>
</div><br />
<div>
  <?php
	if (isset($_POST['Operacao'])){
		if($_POST['Operacao']==1){
			$nrLoteItem=explode(".", $_POST['nrLoteItem']);
			$nrLote = $nrLoteItem[0];
			$nrItem = $nrLoteItem[1];
		};
		
		$sql = 'SELECT * FROM itemeditalentidade WHERE  cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$nrLote.' AND nrItem = '.$nrItem;
		$SelLote=mysqli_query($connect,$sql) or die (mysqli_error($connect));
		$Lote=mysqli_fetch_array($SelLote);
		?>
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th class="text-center">Lote</th>
        <th class="text-center">Item</th>
        <th class="text-center">Quantidade</th>
        <th class="text-center">Unidade</th>
        <th class="text-center">Valor de Referência</th>
        <th class="text-center">Tipo</th>
        <th class="text-center">Prioridade</th>
        <th class="text-center">Status</th>
      </tr>
    </thead>
    <tbody>
      <tr class="text-center">
        <td class="text-center"><?php print $Lote['nrLote']; ?></td>
        <td class="text-center"><?php print $Lote['nrItem']; ?></td>
        <td class="text-center"><?php print number_format($Lote['vlQuantidade'],3,',','.'); ?></td>
        <td class="text-center"><?php print strtoupper($Lote['dsUnidade']); ?></td>
        <td class="text-center"><?php print number_format($Lote['vlUnitario'],$_SESSION['Parametros']['nrCasasDecimais'],',','.'); ?></td>
        <td class="text-center"><?php switch ($Lote['tpLote']){case 1: print 'AC'; break; case 2: print 'CP'; break; case 3: print 'CR'; break; case 4: print 'EX'; break; };?></td>
        <td class="text-center"><?php switch ($Lote['flPrioridade']){case 0: print 'NÃO'; break; case 1: print 'SIM'; break; };?></td>
        <td class="text-center"><?php switch ($Lote['flSituacao']){case 0: print 'NÃO DISPUTADO'; break; case 1: print 'DISPUTADO'; break; case 2: print 'FRUSTRADO'; break; case 3: print 'DESERTO'; break; case 4: print 'CANCELADO'; break; }; ?></td>
      </tr>
      <tr >
        <td class="text-justify" colspan="7"><strong>Descrição:</strong> <?php print strtoupper($Lote['dsItem']); ?></td>
        <td class="text-center" ><form action="index.php" method="post">
            <input type="hidden" name="form" value="c-4" />
            <input type="hidden" name="nrLote" value="<?php print $Lote['nrLote']; ?>" />
            <input type="hidden" name="nrItem" value="<?php print $Lote['nrItem']; ?>" />
            <button class="btn btn-warning" type="submit" name="Operacao" value="6" >Cancelar</button>
            <button class="btn btn-default" type="submit" name="Operacao" value="8" >Resetar Lote</button>
          </form></td>
        
      </tr>
    </tbody>
  </table>
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th class="text-center">Licitante</th>
        <th class="text-center">MPE</th>
        <th class="text-center">Âmbito</th>
        <th class="text-center">%</th>
        <th class="text-center">Proposta</th>
        <th colspan="2" class="text-center">Oferta</th>
      </tr>
    </thead>
    <?php 
			$sql = 'SELECT vlProposta FROM propostalicitante WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$Lote['nrLote'].' AND nrItem = '.$Lote['nrItem'].' AND flClassificado = 1 AND flHabilitado <> 0 ORDER BY vlProposta ASC LIMIT 1';
			$Menor = mysqli_query($connect,$sql) or die (mysqli_error($connect));
			$Menor = mysqli_fetch_array($Menor);
			
			$sql = 'SELECT a.nrDocumentoLicitante, a.vlProposta, a.vlOferta, b.nmLicitante, b.flMPE, b.tpAmbito, b.nmRepresentante FROM propostalicitante AS a INNER JOIN licitanteedital AS b ON a.cdEntidade = b.cdEntidade AND a.dtAnoProcesso = b.dtAnoProcesso AND a.nrPregao = b.nrPregao AND a.nrDocumentoLicitante = b.nrDocumentoLicitante WHERE a.cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND a.dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND a.nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND a.nrLote = '.$Lote['nrLote'].' AND a.nrItem = '.$Lote['nrItem'].' AND a.flClassificado = 1 AND a.flHabilitado <> 0 ORDER BY vlProposta DESC';
			$SelPropostas = mysqli_query($connect,$sql) or die (mysqli_error($connect));
			$rows = mysqli_num_rows($SelPropostas);
			if($rows>0) {
				?>
    <tbody>
    <form action="index.php" method="post">
      <input type="hidden" name="form" value="c-4" />
      <input type="hidden" name="nrLote" value="<?php print $Lote['nrLote']; ?>" />
      <input type="hidden" name="nrItem" value="<?php print $Lote['nrItem']; ?>" />
      <?php
				$i=0;
				while ($Propostas = mysqli_fetch_array($SelPropostas)){
		?>
      <tr <?php if(($rows>3)and(((($Propostas['vlProposta']/$Menor['vlProposta'])-1)*100)>10)){print ' class="dangero" ';}else{if($Propostas['nmRepresentante']==''){print ' class="warning" ';};}; ?>>
        <td><input type="hidden" name="Lance[<?php print $i; ?>][nrDocumentoLicitante]" value="<?php print $Propostas['nrDocumentoLicitante']; ?>" />
          <?php print strtoupper($Propostas['nmLicitante']); ?></td>
        <td width="30px" class="text-center"><?php switch ($Propostas['flMPE']){case 0: print 'Não'; break; case 1: print 'Sim'; break;}; ?></td>
        <td width="30px" class="text-center"><?php switch ($Propostas['tpAmbito']){case 1: print 'Local'; break; case 2: print 'Regional'; break; case 3: print 'Fora'; break;}; ?></td>
        <td width="30px" class="text-center"><?php print number_format(((($Propostas['vlProposta']/$Menor['vlProposta'])-1)*100),2,',','.'); ?></td>
        <td width="30px" class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][vlProposta]" value="<?php print number_format($Propostas['vlProposta'],$_SESSION['Parametros']['nrCasasDecimais']); ?>" />
          <?php print number_format($Propostas['vlProposta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.'); ?></td>
        <td width="30px" class="text-center"><input type="number" name="Lance[<?php print $i; ?>][vlOferta]" value="<?php if($Propostas['vlOferta']<>''){print number_format($Propostas['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais']);}; ?>" style="width:80px;" step="<?php print pow(10, -$_SESSION['Parametros']['nrCasasDecimais']); ?>" /></td>
        <td width="30px" class="text-center"><button class="btn btn-default form-control" style="padding-top: 0px; padding-bottom: 0px; height: 26px;">Declinar</button></td>
      </tr>
      <?php
					$i++;
					$rows--;
				};
?>
      <tr>
        <td class="text-center"><button type="submit" name="Operacao" value="7" class="btn btn-default">Reiniciar Lances</button></td>
        <td colspan="6" class="text-right"><button type="submit" name="Operacao" value="2" class="btn btn-success">Gravar Lances</button></td>
      </tr>
    </form>
      </tbody>
    
    <?php 
			}else{
				$sql = 'SELECT a.nrDocumentoLicitante, a.vlProposta, a.vlOferta, b.nmLicitante, b.flMPE, b.tpAmbito FROM propostalicitante AS a INNER JOIN licitanteedital AS b ON a.cdEntidade = b.cdEntidade AND a.dtAnoProcesso = b.dtAnoProcesso AND a.nrPregao = b.nrPregao AND a.nrDocumentoLicitante = b.nrDocumentoLicitante WHERE a.cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND a.dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND a.nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND a.nrLote = '.$Lote['nrLote'].' AND a.nrItem = '.$Lote['nrItem'].' ORDER BY vlProposta DESC';
				$SelPropostas = mysqli_query($connect,$sql) or die (mysqli_error($connect));
				$rows = mysqli_num_rows($SelPropostas);
				if($rows>0){
					print '<tbody><tr><td colspan="4"><p class="alert alert-warning">Não há propostas classificadas para a disputa!!!</p></td><td  class="text-center" colspan="3"><form action="index.php" method="post">
  <input type="hidden" name="form" value="c-4" />
  <input type="hidden" name="nrLote" value="'.$Lote['nrLote'].'" />
  <input type="hidden" name="nrItem" value="'.$Lote['nrItem'].'" />
<button class="btn btn-warning" type="submit" name="Operacao" value="4" >Declarar Frustrado</button>
</form></td></tr></tbody>';
				}else{
					print '<tbody><tr><td colspan="4"><p class="alert alert-warning">Não há propostas cadastradas para a disputa!!!</p></td><td class="text-center" colspan="3"><form action="index.php" method="post">
  <input type="hidden" name="form" value="c-4" />
  <input type="hidden" name="nrLote" value="'.$Lote['nrLote'].'" />
  <input type="hidden" name="nrItem" value="'.$Lote['nrItem'].'" />
<button class="btn btn-warning" type="submit" name="Operacao" value="5" class="text-center" >Declarar Deserto</button>
</form></td></tr></tbody>';
				};
			};
			?>
  </table>
</div>
<div>
  <?php
	if (($_POST['Operacao']==2)or($_POST['Operacao']==3)){
		$sql = 'SELECT a.vlOferta,a.nrDocumentoLicitante,b.nmLicitante,b.flMPE,b.tpAmbito,a.flVencedor FROM propostalicitante AS a INNER JOIN licitanteedital AS b ON a.cdEntidade = b.cdEntidade AND a.dtAnoProcesso = b.dtAnoProcesso AND a.nrPregao = b.nrPregao AND a.nrDocumentoLicitante = b.nrDocumentoLicitante WHERE a.cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND a.dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND a.nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND a.nrLote = '.$Lote['nrLote'].' AND a.nrItem = '.$Lote['nrItem'].' AND a.flClassificado = 1 AND a.flHabilitado <> 0 ORDER BY vlOferta ASC LIMIT 1';
		$SelMenor = mysqli_query($connect,$sql) or die (mysqli_error($connect));
		$Menor = mysqli_fetch_array($SelMenor);
?>
  <table class="table table-bordered table-condensed">
    <thead>
      <tr>
        <th class="text-center">Licitante</th>
        <th class="text-center">MPE</th>
        <th class="text-center">Âmbito</th>
        <th class="text-center">%</th>
        <th class="text-center">Oferta</th>
        <th class="text-center">Vencedor?</th>
      </tr>
    </thead>
    <tbody>
      <tr <?php if ($Menor['flVencedor']==1){print ' class="successo" ';};?>>
        <form action="index.php" method="post">
          <input type="hidden" name="form" value="c-4" />
          <input type="hidden" name="nrLote" value="<?php print $Lote['nrLote']; ?>" />
          <input type="hidden" name="nrItem" value="<?php print $Lote['nrItem']; ?>" />
          <input type="hidden" name="nrDocumentoLicitante" value="<?php print $Menor['nrDocumentoLicitante']; ?>" />
          <td><?php print strtoupper($Menor['nmLicitante']); ?></td>
          <td class="text-center" width="30px"><?php switch ($Menor['flMPE']){case 0: print 'Não'; break; case 1: print 'Sim'; break;}; ?></td>
          <td class="text-center" width="30px"><?php switch ($Menor['tpAmbito']){case 1: print 'Local'; break; case 2: print 'Regional'; break; case 3: print 'Fora'; break;}; ?></td>
          <td class="text-center" width="30px">-</td>
          <td class="text-center" width="30px"><input type="hidden" name="vlOferta" value="<?php print number_format($Menor['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais']); ?>" />
            <?php print number_format($Menor['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.'); ?></td>
          <td width="30px"><button class="btn btn-success form-control" type="submit" name="Operacao" value="3" >Vencedor</button></td>
        </form>
      </tr>
      <?php 
		
			switch ($Lote['tpLote']){
				case 1:
				case 2: 
					include ("include/form/formc-4.1.php"); 
					break;
				case 3:
				case 4:	
					if($Lote['flPrioridade']==1){
						include ("include/form/formc-4.2.php"); 
					};
					break;	
			};
?>
    </tbody>
  </table>
  <?php
	};
?>
</div>
<?php
	};
?>
