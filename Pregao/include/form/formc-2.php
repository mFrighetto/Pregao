<?php 
if (@$_POST['Operacao']==1){
	$sql='DELETE FROM propostalicitante WHERE nrDocumentoLicitante = '.$_POST['nrDocumentoLicitante'].' AND cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'];
	
	mysqli_query($connect,$sql) or die (mysqli_error($connect));
	$sql = 'INSERT INTO propostalicitante (cdEntidade, dtAnoProcesso, nrPregao, nrLote, nrItem, nrDocumentoLicitante, vlProposta, dsMarca) VALUES ';
	$Propostas = $_POST['Proposta'];
	foreach ($Propostas as $Proposta ) {
		if($Proposta['vlProposta']!=''){
			$sql.='('.$_SESSION['Parametros']['cdEntidade'].','.$_SESSION['Parametros']['dtAnoProcesso'].','.$_SESSION['Parametros']['nrPregao'].','.$Proposta['nrLote'].','.$Proposta['nrItem'].','.$_POST['nrDocumentoLicitante'].','.$Proposta['vlProposta'].',UPPER("'.strtoupper($Proposta['dsMarca']).'")),';
		};
	};
	$sql = trim($sql,',');
	mysqli_query($connect,$sql) or die (mysqli_error($connect));
}else{
	if (@$_POST['Operacao']==2){
		$sql='UPDATE propostalicitante SET vlProposta = '.$_POST['vlProposta'].', dsMarca = UPPER("'.strtoupper($_POST['dsMarca']).'") WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrDocumentoLicitante = '.$_POST['nrDocumentoLicitante'].' AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'];
		mysqli_query($connect,$sql) or die (mysqli_error($connect));
	}else{
		if (@$_POST['Operacao']==3){
			$sql = 'DELETE FROM propostalicitante WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrDocumentoLicitante = '.$_POST['nrDocumentoLicitante'].' AND nrLote = '.$_POST['nrLote'].' AND nrItem = '.$_POST['nrItem'];
			mysqli_query($connect,$sql) or die (mysqli_error($connect));
		}else{
			if (@$_POST['Operacao']==4){
				$sql = 'DELETE FROM propostalicitante WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrDocumentoLicitante = '.$_POST['nrDocumentoLicitante'];
				mysqli_query($connect,$sql) or die (mysqli_error($connect));
			};
		};
	};
}; 
include ('header.php'); 

?>

<legend class="text-uppercase"><?php print '<strong>'.$_SESSION['Parametros']['nmEntidade'].' - Pregão nº '.$_SESSION['Parametros']['nrPregao'].'/'.$_SESSION['Parametros']['dtAnoProcesso'].'</strong><br />'.$_SESSION['Parametros']['dsObjeto']; ?></legend>
<legend>Cadastramento de Propostas</legend>
<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="headingNova"> <strong>
      <h4 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseNova" aria-expanded="false" aria-controls="collapseNova"> <span class="glyphicon glyphicon-plus"></span> INCLUIR NOVA PROPOSTA </a> </h4>
      </strong> </div>
    <div id="collapseNova" class="panel-collapse collapse <?php if ($_POST['Operacao']==5){print 'in';}; ?>" role="tabpanel" aria-labelledby="headingNova">
      <div class="panel-body">
        <?php 
	$sql = 'SELECT * FROM licitanteedital WHERE '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' ORDER BY nmLicitante' ;
$SelLicitantes = mysqli_query($connect,$sql) or die (mysqli_error($connect));
$rows = mysqli_num_rows($SelLicitantes);
if ($rows==0){
	print '<p class="alert-warning"> Não existe nenhum licitante cadastrado/credenciado para o Processo </p>';
}else{
	
?>
        <form action="index.php" method="post">
          <input type="hidden" name="form" value="c-2" />
          <input type="hidden" name="Operacao" value="1" />
          <div class="row">
            <div class="col-lg-8">
              <label for="nrDocumentoLicitante">Licitante</label>
              <select name="nrDocumentoLicitante" class="form-control" >
                <option></option>
                <?php 
				while ($Licitantes=mysqli_fetch_array($SelLicitantes)){ 
           print 
					'<option value="'.$Licitantes['nrDocumentoLicitante'].'" ';
					if ((@$_POST['Operacao']==5)and(@$_POST['nrDocumentoLicitante']==$Licitantes['nrDocumentoLicitante'])){print ' selected="selected" ';};
					print '" >'.strtoupper($Licitantes['nmLicitante']).'</option>';
				}; 
				?>
              </select>
            </div>
            <div class="col-lg-2"> <br />
              <button type="submit" class="bnt btn-success form-control"><span class="glyphicon glyphicon-ok"></span> Gravar Proposta</button>
            </div>
            <div class="col-lg-2"> <br />
              <button type="reset" class="bnt btn-warning form-control"><span class="glyphicon glyphicon-erase"></span> Limpar Formulário</button>
            </div>
          </div>
          <br />
          <table class="table table-bordered table-striped table-responsive table-condensed uppercase" align="center">
            <thead>
              <tr>
                <th class="text-center" width="30px" >TIPO</th>
                <th class="text-center" width="30px" >LOTE</th>
                <th class="text-center" width="30px" >ITEM</th>
                <th class="text-center" width="30px" >QUANTIDADE</th>
                <th class="text-center" width="30px" >UN</th>
                <th class="text-center" >DESCRITIVO</th>
                <th class="text-center" width="30px" >UNITÁRIO EDITAL</th>
                <th class="text-center" width="30px" >UNITÁRIO PROPOSTA</th>
                <th class="text-center" width="30px" >MARCA</th>
              </tr>
            </thead>
            <tbody>
              <?php 
		$sql = 'SELECT * FROM itemeditalentidade WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' ORDER BY nrLote,nrItem';
		$SelItens = mysqli_query($connect,$sql) or die (mysqli_error($connect));
		$i=0;
		while ($Itens=mysqli_fetch_array($SelItens)){ 
			if($Itens['tpLote']==1){print '<tr class="success"><td class="text-center">AC</td>';};
			if($Itens['tpLote']==2){print '<tr class="info"><td class="text-center">CP</td>';};
			if($Itens['tpLote']==3){print '<tr class="warning"><td class="text-center">CR</td>';};
			if($Itens['tpLote']==4){print '<tr class="danger"><td class="text-center">EX</td>';};
			print '
				<td class="text-center"><input type="hidden" name="Proposta['.$i.'][nrLote]" value="'.$Itens['nrLote'].'"/>'.$Itens['nrLote'].'</td>
				<td class="text-center"><input type="hidden" name="Proposta['.$i.'][nrItem]" value="'.$Itens['nrItem'].'"/>'.$Itens['nrItem'].'</td>
				<td class="text-center">'.number_format($Itens['vlQuantidade'],3,',','.').'</td>
				<td class="text-center text-uppercase">'.strtoupper($Itens['dsUnidade']).'</td>
				<td class="text-justify text-uppercase">'.strtoupper($Itens['dsItem']).'</td>
				<td class="text-center">'.number_format($Itens['vlUnitario'],$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</td>
				<td class="text-center"><input type="number" min="'.pow(10, -$_SESSION['Parametros']['nrCasasDecimais']).'" name="Proposta['.$i.'][vlProposta]" step="'.pow(10, -$_SESSION['Parametros']['nrCasasDecimais']).'" style="width:80px;" ';
			if (@$_POST['Operacao']==5){
				$sql='SELECT vlProposta,dsMarca FROM propostalicitante WHERE nrDocumentoLicitante = '.$_POST['nrDocumentoLicitante'].' AND cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND dtAnoProcesso ='.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrLote = '.$Itens['nrLote'].' AND nrItem = '.$Itens['nrItem'];
				$SelProp = mysqli_query($connect,$sql) or die (mysqli_error($connect));
				$rows=mysqli_num_rows($SelProp);
				if($rows==0){
						print '/></td>
				<td class="text-center"><input type="text" name="Proposta['.$i.'][dsMarca]" style="width:125px" /></td>';
						}else{
						$Prop = mysqli_fetch_array($SelProp);
						print ' value="'.number_format($Prop['vlProposta'],$_SESSION['Parametros']['nrCasasDecimais']).'" /></td>
				<td class="text-center"><input type="text" name="Proposta['.$i.'][dsMarca]" value="'.strtoupper($Prop['dsMarca']).'" style="width:125px" /></td>';
					};
				}else{ print '/></td>
				<td class="text-center"><input type="text"" name="Proposta['.$i.'][dsMarca]" style="width:125px" /></td>';
			};
			print '
		</tr>';
		$i++;
		};
    ?>
            </tbody>
          </table>
        </form>
      </div>
    </div>
  </div>
  <?php
	$sql='SELECT DISTINCT a.nrDocumentoLicitante,b.nmLicitante FROM propostalicitante AS a INNER JOIN licitanteedital AS b ON a.nrDocumentoLicitante = b.nrDocumentoLicitante WHERE a.cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND a.dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND a.nrPregao = '.$_SESSION['Parametros']['nrPregao'].' ORDER BY nmLicitante';
	$Proponentes = mysqli_query($connect,$sql) or die (mysqli_error($connect));
	//while de busca de licitantes com proposta cadastrada
	while ($Proponente=mysqli_fetch_array($Proponentes)){
 ?>
  <div class="panel panel-default">
    <div class="panel-heading" role="tab" id="heading<?php print $Proponente['nrDocumentoLicitante']; ?>">
      <h2 class="panel-title"> <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php print $Proponente['nrDocumentoLicitante']; ?>" aria-expanded="false" aria-controls="collapse<?php print $Proponente['nrDocumentoLicitante']; ?>"> <?php print strtoupper($Proponente['nmLicitante']); ?> </a> </h2>
    </div>
    <div id="collapse<?php print $Proponente['nrDocumentoLicitante']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php print $Proponente['nrDocumentoLicitante']; ?>">
      <div class="panel-body">
        <table class="table table-condensed table-bordered uppercase">
          <thead>
            <tr class="text-center">
              <th width="30px" >LOTE </th>
              <th width="30px" >ITEM </th>
              <th width="30px" >QNT </th>
              <th width="30px" >UND </th>
              <th>DESCRITIVO </th>
              <th width="30px" >MARCA </th>
              <th width="30px" >UNITÁRIO </th>
              <th width="30px" >TOTAL </th>
              <th colspan="2">OPERAÇÕES </th>
            </tr>
          </thead>
          <tbody>
            <?php 
			$sql = 'SELECT a.nrLote,a.nrItem,b.vlQuantidade,b.dsUnidade,b.dsItem,a.vlProposta,a.dsMarca FROM propostalicitante AS a INNER JOIN itemeditalentidade AS b ON a.cdEntidade = b.cdEntidade AND a.dtAnoProcesso = b.dtAnoProcesso AND a.nrPregao = b.nrPregao AND a.nrLote = b.nrLote AND a.nrItem = b.nrItem WHERE a.cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND a.dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND a.nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND a.nrDocumentoLicitante = '.$Proponente['nrDocumentoLicitante'].' ORDER BY nrLote,nrItem';
			$Soma = 0;
			$Propostas = mysqli_query($connect,$sql) or die (mysqli_error($connect));
			while ($Proposta=mysqli_fetch_array($Propostas)){ //busca propostas do licitante
			?>
            <tr class="text-center" >
              <form action="index.php" method="post">
                <input type="hidden" name="form" value="c-2" />
                <input type="hidden" name="nrDocumentoLicitante" value="<?php print $Proponente['nrDocumentoLicitante']; ?>" />
                <td><input type="hidden" name="nrLote" value="<?php print $Proposta['nrLote']; ?>" />
                  <?php print $Proposta['nrLote']; ?></td>
                <td><input type="hidden" name="nrItem" value="<?php print $Proposta['nrItem']; ?>" />
                  <?php print $Proposta['nrItem']; ?></td>
                <td><?php print number_format($Proposta['vlQuantidade'],3,',','.'); ?></td>
                <td><?php print strtoupper($Proposta['dsUnidade']); ?></td>
                <td class="text-justify"><?php print strtoupper($Proposta['dsItem']); ?></td>
                <td><input type="text" name="dsMarca" value="<?php print strtoupper($Proposta['dsMarca']); ?>" style="width:125px"/></td>
                <td><input type="number" name="vlProposta" value="<?php print number_format($Proposta['vlProposta'],$_SESSION['Parametros']['nrCasasDecimais']); ?>" step="<?php print pow(10, -$_SESSION['Parametros']['nrCasasDecimais']); ?>" style="width:80px;"/></td>
                <td><?php print number_format($Proposta['vlProposta']*$Proposta['vlQuantidade'],$_SESSION['Parametros']['nrCasasDecimais'],',','.'); ?></td>
                <td width="30px"><button type="submit" name="Operacao" value="2"><span class="glyphicon glyphicon-ok"></span></button></td>
                <td width="30px"><button type="submit" name="Operacao" value="3"><span class="glyphicon glyphicon-trash"></span></button></td>
              </form>
              <?php
              	$Soma += $Proposta['vlProposta']*$Proposta['vlQuantidade'];
							?>
            </tr>
            <?php 
			};//fecha while das propostas
			?>
          </tbody>
          <tfoot>
            <tr>
              <th class="text-right" colspan="6">VALOR TOTAL: R$ <?php print number_format($Soma,$_SESSION['Parametros']['nrCasasDecimais'],',','.'); ?></th>
              <th class="text-center" colspan="2"><form action="index.php" method="post">
                  <input type="hidden" name="form" value="c-2" />
                  <input type="hidden" name="Operacao" value="5"/>
                  <input type="hidden" name="nrDocumentoLicitante" value="<?php print $Proponente['nrDocumentoLicitante']; ?>" />
                  <button type="submit" class="btn btn-primary" style="width:100px;"><span class="glyphicon glyphicon-pencil"></span> Editar</button>
                </form></th>
              <th colspan="2"><form action="index.php" method="post">
                  <input type="hidden" name="form" value="c-2" />
                  <input type="hidden" name="Operacao" value="4" />
                  <input type="hidden" name="nrDocumentoLicitante" value="<?php print $Proponente['nrDocumentoLicitante']; ?>" />
                  <button type="submit" class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span> Remover</button>
                </form></th>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
  <?php
	};//encerra while busca por licitantes com proposta

?>
</div>
<?php
};//encerra o if da count rows


?>
