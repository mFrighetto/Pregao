<?php 
if (isset($_GET['form'])and isset($_GET['nrPregao'])){//0
	$sql = "SELECT * FROM editalentidade WHERE cdEntidade = ".$_SESSION['Parametros']['cdEntidade']." AND dtAnoProcesso = ".$_GET['dtAnoProcesso']." AND nrPregao = ".$_GET['nrPregao'];
	$DadosEdital = mysqli_query($connect,$sql) or die (mysqli_error($connect));
	$DadosEdital = mysqli_fetch_array($DadosEdital);
	$_SESSION['Parametros']['nrPregao'] = $DadosEdital['nrPregao'];
	$_SESSION['Parametros']['dtAnoProcesso'] = $DadosEdital['dtAnoProcesso'];
	$_SESSION['Parametros']['nrCasasDecimais'] = $DadosEdital['nrCasasDecimais'];
	$_SESSION['Parametros']['dsObjeto'] = strtoupper($DadosEdital['dsObjeto']);
	}else{
if (isset($_GET['form'])) { //1
	unset ($_SESSION['Parametros']['nrPregao']);
	unset ($_SESSION['Parametros']['dtAnoProcesso']);
	unset ($_SESSION['Parametros']['nrCasasDecimais']);
	unset ($_SESSION['Parametros']['dsObjeto']);
	}else{
		
	if (isset($_POST['form'])) { //2
		if ($_POST['Parametros']['nrPregao'] <> ''){ //3
			$_SESSION['Parametros']['nrPregao']=$_POST['Parametros']['nrPregao'];
			$_SESSION['Parametros']['dtAnoProcesso']=$_POST['Parametros']['dtAnoProcesso'];
			$_SESSION['Parametros']['nrCasasDecimais']=$_POST['Parametros']['nrCasasDecimais'];
			$_SESSION['Parametros']['dsObjeto']=strtoupper($_POST['Parametros']['dsObjeto']);
		
			$sql = "SELECT * FROM editalentidade WHERE cdEntidade = ".$_SESSION['Parametros']['cdEntidade']." AND dtAnoProcesso = ".$_SESSION['Parametros']['dtAnoProcesso']." AND nrPregao = ".$_SESSION['Parametros']['nrPregao'];
			
				//Busca se existe cadastro para o cdEntidade
			$DadosEdital = mysqli_query($connect,$sql) or die (mysqli_error($connect));
			$rows = mysqli_num_rows($DadosEdital);
				
				//Se cadastro inexistente, insere novo cadastro
				if ($rows == 0) { //4
					$sql = "INSERT INTO editalentidade (cdEntidade, dtAnoProcesso, nrPregao, dsObjeto, nrCasasDecimais) VALUES (".$_SESSION['Parametros']['cdEntidade'].", ".$_SESSION['Parametros']['dtAnoProcesso'].", ".$_SESSION['Parametros']['nrPregao'].", '".strtoupper($_SESSION['Parametros']['dsObjeto'])."', ".$_SESSION['Parametros']['nrCasasDecimais'].")";	
			//Senão, atualiza cadastro existente
					}else{
						$sql = "UPDATE editalentidade SET dsObjeto = '".strtoupper($_SESSION['Parametros']['dsObjeto'])."',  nrCasasDecimais = ".$_SESSION['Parametros']['nrCasasDecimais']." WHERE cdEntidade = ".$_SESSION['Parametros']['cdEntidade']." AND dtAnoProcesso = ".$_SESSION['Parametros']['dtAnoProcesso']." AND nrPregao = ".$_SESSION['Parametros']['nrPregao'];
				}; //4
				mysqli_query($connect,$sql) or die (mysqli_error($connect));
		}; //3
		if (isset($_POST['ItemEditalEntidade'])){ //5
			$sql="DELETE FROM itemeditalentidade WHERE cdEntidade = ".$_SESSION['Parametros']['cdEntidade']." AND dtAnoProcesso = ".$_SESSION['Parametros']['dtAnoProcesso']." AND nrPregao = ".$_SESSION['Parametros']['nrPregao'];
			mysqli_query($connect,$sql) or die (mysqli_error($connect));
			$sql="INSERT INTO itemeditalentidade (cdEntidade, dtAnoProcesso, nrPregao, nrLote, nrItem, vlQuantidade, dsUnidade, dsItem, vlUnitario, tpLote, nrLoteCotaPrincipal, flPrioridade) VALUES ".$_POST['ItemEditalEntidade'];
			mysqli_query($connect,$sql) or die (mysqli_error($connect));
		}; //5
	}; //2
}; //1
	};//0
include ('header.php');	?>

<div>
<legend class="text-uppercase"><?php print '<strong>'.$_SESSION['Parametros']['nmEntidade'].'</strong>'; ?></legend>
  <form action="index.php" method="post">
    <legend>Cadastramento e Atualização de Editais</legend>
    <input type="hidden" name="form" value="b-1"  />
    <div class="row">
      <div class="col-lg-3">
        <div class="form-group">
          <label for="Parametros[nrPregao]">Número do Pregão</label>
          <input type="number" name="Parametros[nrPregao]" <?php if ($_SESSION['Parametros']['nrPregao'] <> ''){ print 'value="'.$_SESSION['Parametros']['nrPregao'].'" disabled="disabled"';};?> class="form-control" />
          <?php if ($_SESSION['Parametros']['nrPregao'] <> ''){ print '<input type="hidden" name="Parametros[nrPregao]" value="'.$_SESSION['Parametros']['nrPregao'].'" >';};?>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="form-group">
          <label for="Parametros[dtAnoProcesso]">Ano do processo</label>
          <input type="number" <?php if ($_SESSION['Parametros']['dtAnoProcesso'] <> ''){ print ' value="'.$_SESSION['Parametros']['dtAnoProcesso'].'" disabled="disabled"';}else{print ' value="'.date("Y").'" ';};?> name="Parametros[dtAnoProcesso]" class="form-control" />
          <?php if ($_SESSION['Parametros']['dtAnoProcesso'] <> ''){ print '<input type="hidden" name="Parametros[dtAnoProcesso]" value="'.$_SESSION['Parametros']['dtAnoProcesso'].'" >';};?>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="form-group">
          <label for="Parametros[nrCasasDecimais]">Número de Casas Decimais</label>
          <input type="number" value="<?php if ($_SESSION['Parametros']['nrCasasDecimais'] <> ''){ print $_SESSION['Parametros']['nrCasasDecimais'];}else{ print '2';}; ?>" name="Parametros[nrCasasDecimais]" class="form-control" />
        </div>
      </div>
      <div class="col-lg-3">
        <div class="form-group">
          <label><br />
          </label>
          <input type="submit" class="btn btn-success btn-block" value="Cadastrar/Atualizar" />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-12">
        <div class="form-group">
          <label for="Parametros[dsObjeto]">Descrição do Objeto</label>
          <textarea name="Parametros[dsObjeto]" class="form-control text-uppercase"><?php if ($_SESSION['Parametros']['dsObjeto'] <> ''){ print strtoupper($_SESSION['Parametros']['dsObjeto']);}; ?>
</textarea>
        </div>
      </div>
    </div>
  </form>
</div>
<?php 
if (isset($_SESSION['Parametros']['nrPregao'])) {
	$sql="SELECT * FROM itemeditalentidade WHERE cdEntidade = ".$_SESSION['Parametros']['cdEntidade']." AND dtAnoProcesso = ".$_SESSION['Parametros']['dtAnoProcesso']." AND nrPregao = ".$_SESSION['Parametros']['nrPregao']. " ORDER BY nrLote,nrItem";
	$SelItens = mysqli_query($connect,$sql) or die (mysqli_error($connect));
?>
<div>
<br />
  <form action="index.php" method="post">
    <input type="hidden" name="form" value="b-1" />
    <legend>Inclusão de lotes/itens ao edital</legend>
    <div class="row">
      <div class="col-lg-10">
        <div class="form-group">
          <label for="ItemEditalEntidade">Colar dados para importação</label>
          <textarea name="ItemEditalEntidade" class="form-control">
  </textarea>
        </div>
      </div>
      <div class="col-lg-2">
        <div class="form-group">
          <label><br />
          </label>
          <input type="submit" class="btn btn-success bts-block form-control" value="Enviar Itens" style="height: 54px;" />
        </div>
      </div>
    </div>
  </form>
</div>
<div>
<br />
<table class=" table table-bordered table-responsive table-striped table-condensed" align="center" width="100%">
  <thead>
    <tr>
      <th class="text-center" width="30px">LOTE</th>
      <th class="text-center" width="30px">ITEM</th>
      <th class="text-center" width="30px">QNT</th>
      <th class="text-center" width="30px">UN</th>
      <th class="text-center">DESCRIÇÃO</th>
      <th class="text-center" width="30px">UNITÁRIO</th>
      <th class="text-center" width="30px">TOTAL</th>
      <th class="text-center" width="30px">TIPO</th>
      <th class="text-center" width="30px">PRIORIDADE</th>
    </tr>
  </thead>
  <tbody>
    <?php
		while ($Itens = mysqli_fetch_array($SelItens)) {
			print '
		<tr>
      <td class="text-center">'.$Itens['nrLote'].'</td> 
      <td class="text-center">'.$Itens['nrItem'].'</td>
      <td class="text-center">'.number_format($Itens['vlQuantidade'],3,',','.').'</td>
      <td class="text-center text-uppercase">'.strtoupper($Itens['dsUnidade']).'</td>
      <td class="text-justify text-uppercase">'.strtoupper($Itens['dsItem']).'</td>
      <td class="text-center">'.number_format($Itens['vlUnitario'],$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</td>
      <td class="text-center">'.number_format($Itens['vlUnitario']*$Itens['vlQuantidade'],$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</td>';
			if($Itens['tpLote']==1){print '<td class="text-center">AC</td>';};
			if($Itens['tpLote']==2){print '<td class="text-center">CP</td>';};
			if($Itens['tpLote']==3){print '<td class="text-center">CR</td>';};
			if($Itens['tpLote']==4){print '<td class="text-center">EX</td>';};
			if($Itens['flPrioridade']==1){print '<td class="text-center">SIM</td>';}else{print '<td class="text-center">NÃO</td>';};
			print '
		</tr>';	
	}; ?>
  </tbody>
</table>
</div>
<?php 
	
	}; 
?>
