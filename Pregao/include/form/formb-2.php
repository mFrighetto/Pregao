<?php
if (isset($_GET['form'])) {//1
	unset ($_SESSION['Parametros']['nrPregao']);
	unset ($_SESSION['Parametros']['dtAnoProcesso']);
	unset ($_SESSION['Parametros']['nrCasasDecimais']);
	unset ($_SESSION['Parametros']['dsObjeto']);
	};//1
	
	include ('header.php');
?>

<div>
  <legend class="text-uppercase"><?php print '<strong>'.strtoupper($_SESSION['Parametros']['nmEntidade']).'</strong>'; ?></legend>
  <form action="index.php" method="post">
    <legend>Cadastramento e Atualização de Editais</legend>
    <input type="hidden" name="form" value="b-2"  />
    <div class="form-group">
      <div class="row">
        <div class="col-lg-3">
          <label for="nrPregao">Número do Pregão</label>
          <input type="number" name="nrPregao" class="form-control" <?php if ($_POST['nrPregao'] <> ''){ print 'value="'.$_POST['nrPregao'].'" ';};?>/>
        </div>
        <div class="col-lg-3">
          <label for="dtAnoProcesso">Ano do processo</label>
          <input type="number" name="dtAnoProcesso" class="form-control" <?php if ($_POST['dtAnoProcesso'] <> ''){ print ' value="'.$_POST['dtAnoProcesso'].'" ';};?> />
        </div>
        <div class="col-lg-4">
          <label for="Termo">Palavras Chave para busca por Objeto</label>
          <input type="text" name="Termo" class="form-control text-uppercase" <?php if ($_POST['Termo']<>''){ print ' value="'.$_POST['Termo'].'" ';}; ?> />
        </div>
        <div class="col-lg-2">
          <label><br />
          </label>
          <input type="submit" class="btn btn-info btn-block" value="Buscar" />
        </div>
      </div>
    </div>
  </form>
</div>
<div>
  <?php 
	if (isset($_POST['form'])){//2
		$Criterios = ' cdEntidade = '.$_SESSION['Parametros']['cdEntidade'];
		if($_POST['nrPregao']<>''){$Criterios .= ' AND nrPregao = '.$_POST['nrPregao'];};
		if($_POST['dtAnoProcesso']<>''){$Criterios .= ' AND dtAnoProcesso = '.$_POST['dtAnoProcesso'];};
		if($_POST['Termo']<>'') {
				$Criterios .= " AND (";
				$expTermo = explode(' ',$_POST['Termo']);
				foreach ($expTermo as $Termos) {
					$Criterios .= " dsObjeto LIKE '%".$Termos."%' OR ";
				};
				$Criterios = trim($Criterios,"AND ");
				$Criterios .= ") ";
		};
		$sql = 'SELECT * FROM editalentidade WHERE '.$Criterios.' ORDER BY dtAnoProcesso, nrPregao';
		$SelEditais= mysqli_query($connect,$sql) or die (mysqli_error($connect));
		print'

<table>
<table class=" table table-bordered table-responsive table-striped table-condensed" align="center" width="100%">
  <thead>
    <tr>
      <th class="text-center" width="30px">NÚMERO</th>
      <th class="text-center" width="30px">ANO</th>
      <th colspan="2" class="text-center">OBJETO</th>
    </tr>
  </thead>
  <tbody>';
    	while($Editais=mysqli_fetch_array($SelEditais)){
			print'
				<tr>
					
						<td class="text-center">'.$Editais['nrPregao'].'</td> 
						<td class="text-center">'.$Editais['dtAnoProcesso'].'</td>
						<td class="text-justify">'.strtoupper($Editais['dsObjeto']).'</td>
						<td class="text-center" width="50px"><a href="?form=b-1&nrPregao='.$Editais['nrPregao'].'&dtAnoProcesso='.$Editais['dtAnoProcesso'].'"><span class="glyphicon  glyphicon-ok""></span></a></td>
					
				</tr>';
			};
		print '
  </tbody>
</table>';
	};
?>
</div>
