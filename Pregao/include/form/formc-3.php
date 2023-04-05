<?php 
if (isset($_POST['form'])){
	if ($_POST['Operacao']==1){
		$sql= 'UPDATE licitanteedital SET flClassificado = '.$_POST['flClassificado'].', dsMotivoDesclassificado = "'.strtoupper($_POST['dsMotivoDesclassificado']).'" WHERE cdEntidade ='.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrDocumentoLicitante = "'.$_POST['nrDocumentoLicitante'].'"';
		mysqli_query($connect,$sql) or die (mysqli_error($connect));
		$sql= 'UPDATE propostalicitante SET flClassificado = '.$_POST['flClassificado'].', dsMotivoDesclassificado = "'.strtoupper($_POST['dsMotivoDesclassificado']).'" ';
		if ($_POST['flClassificado']==0){$sql.=', flVencedor = 0 ';};
		$sql.=' WHERE cdEntidade ='.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrDocumentoLicitante = "'.$_POST['nrDocumentoLicitante'].'"';
		mysqli_query($connect,$sql) or die (mysqli_error($connect));
	}else{
		if ($_POST['Operacao']==2){
			$sql= 'UPDATE licitanteedital SET flHabilitado = '.$_POST['flHabilitado'].', dsMotivoInabilitado = "'.strtoupper($_POST['dsMotivoInabilitado']).'" WHERE cdEntidade ='.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrDocumentoLicitante = "'.$_POST['nrDocumentoLicitante'].'"';
			mysqli_query($connect,$sql) or die (mysqli_error($connect));
			$sql= 'UPDATE propostalicitante SET flHabilitado = '.$_POST['flHabilitado'].', dsMotivoInabilitado = "'.strtoupper($_POST['dsMotivoInabilitado']).'" ';
			if ($_POST['flHabilitado']==0){$sql.=', flVencedor = 0 ';};
			$sql.=' WHERE cdEntidade ='.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrDocumentoLicitante = "'.$_POST['nrDocumentoLicitante'].'"';
			mysqli_query($connect,$sql) or die (mysqli_error($connect));
		}else{
			if ($_POST['Operacao']==3){
				$sql= 'UPDATE propostalicitante SET flClassificado = '.$_POST['flClassificado'].', dsMotivoDesclassificado = "'.strtoupper($_POST['dsMotivoDesclassificado']).'" ';
		if ($_POST['flClassificado']==0){$sql.=', flVencedor = 0 ';};
		$sql.=' WHERE cdEntidade ='.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrDocumentoLicitante = "'.$_POST['nrDocumentoLicitante'].'" AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'];
				mysqli_query($connect,$sql) or die (mysqli_error($connect));
			}else{
				if ($_POST['Operacao']==4){
					$sql= 'UPDATE propostalicitante SET flHabilitado = '.$_POST['flHabilitado'].', dsMotivoInabilitado = "'.strtoupper($_POST['dsMotivoInabilitado']).'" ';
		if ($_POST['flHabilitado']==0){$sql.=', flVencedor = 0 ';};
		$sql.=' WHERE cdEntidade ='.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrDocumentoLicitante = "'.$_POST['nrDocumentoLicitante'].'" AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'];
					mysqli_query($connect,$sql) or die (mysqli_error($connect));
				};
			};
		};
	};
};
include ('header.php'); 

?>

<legend class="text-uppercase"><?php print '<strong>'.strtoupper($_SESSION['Parametros']['nmEntidade']).' - Pregão nº '.$_SESSION['Parametros']['nrPregao'].'/'.$_SESSION['Parametros']['dtAnoProcesso'].'</strong><br />'.strtoupper($_SESSION['Parametros']['dsObjeto']); ?></legend>
<legend>Classificação e Habilitação</legend>
<?php 
	$sql = 'SELECT * FROM licitanteedital WHERE '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' ORDER BY nmLicitante' ;
$SelLicitantes = mysqli_query($connect,$sql) or die (mysqli_error($connect));
$rows = mysqli_num_rows($SelLicitantes);
if ($rows==0){print '<p class="alert-warning"> Não existe nenhum licitante cadastrado/credenciado para o Processo </p>';}else
{
?>
<table class="table table-bordered table-striped table-responsive uppercase" align="center">
  <thead>
    <tr>
      <th class="text-left" >NOME/RAZÃO SOCIAL</th>
      <th class="text-left" >MPE?</th>
      <th class="text-left" colspan="3">CLASSIFICADO?</th>
      <th class="text-left" colspan="4">HABILITADO?</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($Licitantes=mysqli_fetch_array($SelLicitantes)){ ?>
    <tr <?php if (($Licitantes['flClassificado']==0)or($Licitantes['flHabilitado']==0)){print 'class="dangero"';}else{if(($Licitantes['flClassificado']==1)and($Licitantes['flHabilitado']==1)){print 'class="successo"';}else{print 'class="default"';};}; ?> >
      <form action="index.php" method="post">
        <input type="hidden" name="form" value="c-3" />
        <input type="hidden" name="nrDocumentoLicitante" value="<?php print $Licitantes['nrDocumentoLicitante']; ?>" />
        <td><?php print '<strong>'.strtoupper($Licitantes['nmLicitante']).'</strong>'; ?></td>
        <td class="text-center"><?php if ($Licitantes['flMPE']==0){print "<strong>NÃO</strong>";}else{print "<strong>SIM</strong>";}; ?></td>
        <td class="text-center" ><select name="flClassificado" class="form-control" style="width:77px;" >
            <option value="2" <?php if ($Licitantes['flClassificado']==2) { print ' selected="selected" ';};?>></option>
            <option value="1" <?php if ($Licitantes['flClassificado']==1) { print ' selected="selected" ';};?> >SIM</option>
            <option value="0" <?php if ($Licitantes['flClassificado']==0) { print ' selected="selected" ';};?>>NÃO</option>
          </select></td>
        <td ><input type="text" name="dsMotivoDesclassificado" value="<?php print strtoupper($Licitantes['dsMotivoDesclassificado']); ?>" class="form-control" style="width:250px;"/></td>
        <td class="text-center" ><button type="submit" class="bnt btn-success form-control" name="Operacao" value="1" ><span class="glyphicon glyphicon-ok"></span></button></td>
        <td class="text-center" ><select name="flHabilitado" class="form-control" style="width:77px;" >
            <option value="2" <?php if ($Licitantes['flHabilitado']==2) { print ' selected="selected" ';};?>></option>
            <option value="1" <?php if ($Licitantes['flHabilitado']==1) { print ' selected="selected" ';};?>>SIM</option>
            <option value="0" <?php if ($Licitantes['flHabilitado']==0) { print ' selected="selected" ';};?>>NÃO</option>
          </select></td>
        <td ><input type="text" name="dsMotivoInabilitado" value="<?php print strtoupper($Licitantes['dsMotivoInabilitado']); ?>" class="form-control" style="width:250px;" /></td>
        <td class="text-center" ><button type="submit" class="bnt btn-success form-control" name="Operacao" value="2" ><span class="glyphicon glyphicon-ok"></span></button></td>
        <td><a class="btn btn-warning" role="button" data-toggle="collapse" data-target="#Col<?php print $Licitantes['nrDocumentoLicitante'];?>" aria-expanded="false" aria-controls="Col<?php print $Licitantes['nrDocumentoLicitante'];?>"><span class="glyphicon glyphicon-option-vertical"></span></a></td>
      </form>
    </tr>
    <tr>
      <td colspan="9"><div class="collapse<?php if (@$_POST['nrDocumentoLicitante']==$Licitantes['nrDocumentoLicitante']){print ' in';}; ?>" id="Col<?php print $Licitantes['nrDocumentoLicitante'];?>">
          <div class="well">
            <table class="table table-bordered table-condensed">
              <thead>
                <tr>
                  <th width="30px">TIPO</th>
                  <th width="30px">LOTE</th>
                  <th width="30px">ITEM</th>
                  <th width="30px">EDITAL</th>
                  <th width="30px">PROPOSTA</th>
                  <th width="30px">OFERTA</th>
                  <th colspan="3">CLASSIFICADO?</th>
                  <th colspan="3">HABILITADO?</th>
                </tr>
              </thead>
              <tbody>
<?php
						$sql='SELECT b.tpLote, a.nrLote, a.nrItem, b.vlUnitario, a.vlProposta, a.vlOferta, a.flClassificado, a.dsMotivoDesclassificado, a.flHabilitado, a.dsMotivoInabilitado FROM propostalicitante AS a INNER JOIN itemeditalentidade AS b ON a.cdEntidade = b.cdEntidade AND a.dtAnoProcesso = b.dtAnoProcesso AND a.nrPregao = b.nrPregao AND a.nrLote = b.nrLote AND a.nrItem = b.nrItem WHERE a.cdEntidade ='.$_SESSION['Parametros']['cdEntidade'].' AND a.nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND a.dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND a.nrDocumentoLicitante = "'.$Licitantes['nrDocumentoLicitante'].'" ORDER BY nrLote,nrItem';
						$SelPropostas = mysqli_query($connect,$sql) or die (mysqli_error($connect));
						while ($Propostas=mysqli_fetch_array($SelPropostas)){
?>
              
              	<tr <?php 
								if (($Propostas['flClassificado']==0)or($Propostas['flHabilitado']==0)){
									print 'class="dangero"';
								}else{
									if(($Propostas['flClassificado']==1)and($Propostas['flHabilitado']==1)){
										print 'class="successo"';
									}else{
										if (($Propostas['flClassificado']<>0) and ($Licitantes['flMPE']==0) and (($Propostas['tpLote']==3)or($Propostas['tpLote']==4))){
											print 'class="warning"';
										}else{
											print 'class="default"';
										};
									};
								};?>>
                	<form action="index.php" method="post">
                  <input type="hidden" name="form" value="c-3" />
                  <input type="hidden" name="nrDocumentoLicitante" value="<?php print $Licitantes['nrDocumentoLicitante']; ?>" />
                	<td class="text-center" ><?php switch ($Propostas['tpLote']){case 1: print 'AC'; break; case 2: print 'CP'; break; case 3: print 'CR'; break; case 4: print 'EX'; break; };?></td>
                  <td class="text-center" ><input type="hidden" name="nrLote" value="<?php print $Propostas['nrLote']; ?>" /><?php print $Propostas['nrLote']; ?></td>
                  <td class="text-center" ><input type="hidden" name="nrItem" value="<?php print $Propostas['nrItem']; ?>" /><?php print $Propostas['nrItem']; ?></td>
                  <td class="text-center" ><?php print number_format($Propostas['vlUnitario'],$_SESSION['Parametros']['nrCasasDecimais'],',','.'); ?></td>
                  <td  class="text-center <?php if ($Propostas['vlProposta']>$Propostas['vlUnitario']){print ' dangero';};?>" ><?php print number_format($Propostas['vlProposta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.'); ?></td>
                  <td class="text-center"><?php print number_format($Propostas['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.'); ?></td>
                  <td><select name="flClassificado">
            <option value="2" <?php if ($Propostas['flClassificado']==2) { print ' selected="selected" ';};?>></option>
            <option value="1" <?php if ($Propostas['flClassificado']==1) { print ' selected="selected" ';};?> >SIM</option>
            <option value="0" <?php if ($Propostas['flClassificado']==0) { print ' selected="selected" ';};?>>NÃO</option>
          </select></td>
                  <td><input type="text" name="dsMotivoDesclassificado" value="<?php print strtoupper($Propostas['dsMotivoDesclassificado']); ?>" style="width:200px;"/></td>
                  <td><button type="submit" class="bnt btn-success form-control" name="Operacao" value="3" style=" height: 26px;padding-top:0px; padding-bottom: 0px;"><span class="glyphicon glyphicon-ok"></span></button></td>
                  <td><select name="flHabilitado" >
            <option value="2" <?php if ($Propostas['flHabilitado']==2) { print ' selected="selected" ';};?>></option>
            <option value="1" <?php if ($Propostas['flHabilitado']==1) { print ' selected="selected" ';};?>>SIM</option>
            <option value="0" <?php if ($Propostas['flHabilitado']==0) { print ' selected="selected" ';};?>>NÃO</option>
          </select></td>
                  <td><input type="text" name="dsMotivoInabilitado" value="<?php print strtoupper($Propostas['dsMotivoInabilitado']); ?>" style="width:200px;" /></td>
                  <td><button type="submit" class="bnt btn-success form-control" name="Operacao" value="4" style=" height: 26px;padding-top:0px; padding-bottom: 0px;" ><span class="glyphicon glyphicon-ok"></span></button></td>
                  </form>
                </tr>
<?php
		};
?>
              </tbody>
            </table>
          </div>
        </div></td>
    </tr>
    <?php }; ?>
  </tbody>
</table>
<?php }; ?>
