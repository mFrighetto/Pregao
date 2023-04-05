<?php
if (isset($_POST['form'])and($_POST['Operacao']!=6)){
	if($_POST['Operacao']==1){
		$sql='INSERT INTO  licitanteedital (cdEntidade,dtAnoProcesso,nrPregao,nrDocumentoLicitante,nmLicitante,flMPE,tpAmbito,nrDocumentoRepresentante,  nmRepresentante) VALUES ('.$_SESSION['Parametros']['cdEntidade'].', '.$_SESSION['Parametros']['dtAnoProcesso'].', '.$_SESSION['Parametros']['nrPregao'].','.$_POST['nrDocumentoLicitante'].', UPPER("'.strtoupper($_POST['nmLicitante']).'"), '.$_POST['flMPE'].', '.$_POST['tpAmbito'].', '.$_POST['nrDocumentoRepresentante'].', UPPER("'.strtoupper($_POST['nmRepresentante']).'"))';
	}else{
		if($_POST['Operacao']==2){
		$sql='UPDATE licitanteedital SET nmLicitante = UPPER("'.strtoupper($_POST['nmLicitante']).'"), flMPE ='.$_POST['flMPE'].', tpAmbito ='.$_POST['tpAmbito'].', nrDocumentoRepresentante ="'.$_POST['nrDocumentoRepresentante'].'", nmRepresentante = UPPER("'.strtoupper($_POST['nmRepresentante']).'") WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrDocumentoLicitante = "'.$_POST['nrDocumentoLicitante'].'"';
		}else{
			if($_POST['Operacao']==3) {
				$sql='DELETE FROM propostalicitante WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrDocumentoLicitante = "'.$_POST['nrDocumentoLicitante'].'"';
				mysqli_query($connect,$sql) or die (mysqli_error($connect));
				$sql='DELETE FROM licitanteedital WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrDocumentoLicitante = "'.$_POST['nrDocumentoLicitante'].'"';
			};
		};
	};
	mysqli_query($connect,$sql) or die (mysqli_error($connect));
}else{
	if (isset($_POST['form'])and($_POST['Operacao']==6)){
			$Dados=$_FILES['importacao']['tmp_name'];
			$Linhas = file($Dados);
			$sqlP = 'INSERT INTO propostalicitante (cdEntidade, dtAnoProcesso, nrPregao, nrLote, nrItem, nrDocumentoLicitante, vlProposta, dsMarca) VALUES ';
			foreach ($Linhas as $Linha){
				$Linha=trim($Linha);
				$Valor=explode('|',$Linha);
				if ($Valor[0]=='1'){
					if (($Valor[1]==$_SESSION['Parametros']['cdEntidade'])and($Valor[2]==$_SESSION['Parametros']['dtAnoProcesso'])and($Valor[3]==$_SESSION['Parametros']['nrPregao'])){
					$sql='DELETE FROM propostalicitante WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrDocumentoLicitante = '.$Valor[4];
					mysqli_query($connect,$sql) or die (mysqli_error($connect));
					$sql='DELETE FROM licitanteedital WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrDocumentoLicitante = '.$Valor[4];
					mysqli_query($connect,$sql) or die (mysqli_error($connect));
					$sql='INSERT INTO licitanteedital (cdEntidade, dtAnoProcesso, nrPregao, nrDocumentoLicitante, nmLicitante, flMPE, tpAmbito, nrDocumentoRepresentante, nmRepresentante) VALUES ('.$_SESSION['Parametros']['cdEntidade'].', '.$_SESSION['Parametros']['dtAnoProcesso'].', '.$_SESSION['Parametros']['nrPregao'].','.$Valor[4].', UPPER("'.strtoupper($Valor[5]).'"), '.$Valor[6].', '.$Valor[7].', '.$Valor[8].', UPPER("'.strtoupper($Valor[9]).'"))';
					mysqli_query($connect,$sql) or die (mysqli_error($connect));
					}else{
						exit;
					};
				}else{
					if($Valor[0]=='2'){
						$sqlP.='('.$Valor[1].','.$Valor[2].','.$Valor[3].','.$Valor[4].','.$Valor[5].','.$Valor[6].','.$Valor[7].',UPPER("'.$Valor[8].'")),';
					};
				};
			};
			$sqlP = trim($sqlP,',');
			mysqli_query($connect,$sqlP) or die (mysqli_error($connect));
	};
};

include ('header.php');

?>

<div>
  <legend class="text-uppercase"><?php print '<strong>'.$_SESSION['Parametros']['nmEntidade'].' - Pregão nº '.$_SESSION['Parametros']['nrPregao'].'/'.$_SESSION['Parametros']['dtAnoProcesso'].'</strong><br />'.$_SESSION['Parametros']['dsObjeto']; ?></legend>
  <form action="index.php" method="post">
    <legend><strong>Inclusão de Licitantes</strong></legend>
    <input type="hidden" name="form" value="c-1" />
    <div class="row">
      <div class="col-lg-12">
        <div class="form-group>">
          <label for="nmLicitante">Nome / Razão Social</label>
          <input type="text" name="nmLicitante" required="required"  class="form-control" />
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="form-group>">
          <label for="nrDocumentoLicitante">Número do Documento</label>
          <input type="text" name="nrDocumentoLicitante" required="required"  class="form-control" />
        </div>
      </div>
      <div class="col-lg-3">
        <div class="form-group>">
          <label for="flMPE">MPE?</label>
          <select name="flMPE" class="form-control">
            <option value="1" selected="selected">SIM</option>
            <option value="0" >NÃO</option>
          </select>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="form-group>">
          <label for="tpAmbito">Âmbito</label>
          <select name="tpAmbito" class="form-control">
            <option value="1" selected="selected">LOCAL</option>
            <option value="2" >REGIONAL</option>
            <option value="3" >FORA</option>
          </select>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-lg-6">
        <div class="form-group>">
          <label for="nmRepresentante">Nome do Representante</label>
          <input type="text" name="nmRepresentante"  class="form-control"/>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group>">
          <label for="nrDocumentoRepresentante">CPF do Representante</label>
          <input type="text" name="nrDocumentoRepresentante" class="form-control" />
        </div>
      </div>
      <div class="col-lg-2">
        <div class="form-group>">
          <label for="Operacao"><br />
          </label>
          <button type="submit" name="Operacao" value="1" class="btn btn-success form-control" >Incluir</button>
        </div>
      </div>
    </div>
  </form>
</div>
<div class="alert-success">
  <div class="row">
    <form action="index.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="form" value="c-1" />
      <div class="col-lg-8">
        <div class="form-group" style="padding-right: 10px; padding-left: 10px;">
          <label for="importacao" >Importação de Dados</label>
          <input type="file" name="importacao" required="required" />
        </div>
      </div>
      <div class="col-lg-4">
        <div class="form-group" style="padding-right: 10px; padding-left: 10px;"> <br />
          <button type="submit" name="Operacao" value="6" class="btn btn-primary form-control"><span class="glyphicon glyphicon-import"></span> Importar</button>
        </div>
      </div>
    </form>
  </div>
</div>
<div><br />
<?php 
$sql = 'SELECT * FROM licitanteedital WHERE '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' ORDER BY nmLicitante' ;
$SelLicitantes = mysqli_query($connect,$sql) or die (mysqli_error($connect));
$rows = mysqli_num_rows($SelLicitantes);
if ($rows>0){
?>
  <br />
  <legend>Licitantes Credenciados</legend>
  <table class="table table-bordered table-striped table-responsive uppercase" align="center">
    <thead>
      <tr>
        <th class="text-left" >NOME/RAZÃO SOCIAL</th>
        <th class="text-left" >DOCUMENTO</th>
        <th class="text-left" >MPE?</th>
        <th class="text-left" >ÂMBITO</th>
        <th class="text-left" >REPRESENTANTE LEGAL</th>
        <th class="text-left" >CPF</th>
        <th class="text-left" colspan="2">OPERAÇÕES</th>
      </tr>
    </thead>
    <tbody>
      <?php while($Licitantes=mysqli_fetch_array($SelLicitantes)){ ?>
      <tr>
        <form action="index.php" method="post">
          <input type="hidden" name="form" value="c-1" />
          <td><input type="text" name="nmLicitante" class="form-control" value="<?php print strtoupper($Licitantes['nmLicitante']); ?>"  /></td>
          <td class="text-center"><input type="text" name="nrDocumentoLicitante" value="<?php print $Licitantes['nrDocumentoLicitante']; ?>" class="form-control" style="width:149px;" /></td>
          <td class="text-center"><select name="flMPE" class="form-control" style="width:78px;" >
              <option value="1" <?php if ($Licitantes['flMPE']==1) { print ' selected="selected" ';};?> >SIM</option>
              <option value="0" <?php if ($Licitantes['flMPE']==0) { print ' selected="selected" ';};?> >NÃO</option>
            </select></td>
          <td class="text-center"><select name="tpAmbito" class="form-control" style="width:100px;" >
              <option value="1" <?php if ($Licitantes['tpAmbito']==1) { print ' selected="selected" ';};?>>LOCAL</option>
              <option value="2" <?php if ($Licitantes['tpAmbito']==2) { print ' selected="selected" ';};?>>REGIONAL</option>
              <option value="3" <?php if ($Licitantes['tpAmbito']==3) { print ' selected="selected" ';};?>>FORA</option>
            </select></td>
          <td><input type="text" name="nmRepresentante" value="<?php print strtoupper($Licitantes['nmRepresentante']); ?>" class="form-control" /></td>
          <td class="text-center"><input type="text" name="nrDocumentoRepresentante" value="<?php print $Licitantes['nrDocumentoRepresentante']; ?>" class="form-control" style="width:125px;" /></td>
          <td class="text-center" ><button type="submit" name="Operacao" value="2" class="bnt btn-success form-control"><span class="glyphicon glyphicon-ok"></span></button></td>
          <td class="text-center" ><button type="submit" name="Operacao" value="3" class="bnt btn-danger form-control"><span class="glyphicon glyphicon-trash"></span></button></td>
        </form>
      </tr>
      <?php 
};// Fecha While
?>
    </tbody>
  </table>
</div>
<?php 
};//Fecha if da consulta do número de linhas
?>
