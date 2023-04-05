<?php
//fazer updates do Operacao = 1
if(@$_POST['Operacao']==1){
	$Lances=$_POST['Lance'];
	foreach ($Lances as $Lance){
		if($Lance['flAjuste']==1){//Proceder ajuste de cota
			if($Lance['vlOfertaReservada']>$Lance['vlOfertaPrincipal']){//atualiza preço da cota reservada
				$sql='UPDATE propostalicitante SET vlOferta = '.number_format($Lance['vlOfertaPrincipal'],$_SESSION['Parametros']['nrCasasDecimais']).' WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrDocumentoLicitante = '.$Lance['nrDocumentoLicitante'].' AND nrLote = '.$Lance['nrLoteReservada'].' AND nrItem = '.$Lance['nrItemReservada'] ;
			}else{//atualiza preço da cota principal
				$sql='UPDATE propostalicitante SET vlOferta = '.number_format($Lance['vlOfertaReservada'],$_SESSION['Parametros']['nrCasasDecimais']).' WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrDocumentoLicitante = '.$Lance['nrDocumentoLicitante'].' AND nrLote = '.$Lance['nrLotePrincipal'].' AND nrItem = '.$Lance['nrItemPrincipal'] ;
			};
		}else{
			if($Lance['flAjuste']==0){ //Descassificar empresa de ambas as cotas
				$sql='UPDATE propostalicitante SET flClassificado = 0, dsMotivoDesclassificado = "RECUSOU-SE A IGUALAR OS PREÇOS OFERTADOS PARA COTAS DO PRODUTO, DAS QUAIS FOI VENCEDOR COM PREÇOS DIVERGENTES", flVencedor = 0 WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrDocumentoLicitante = '.$Lance['nrDocumentoLicitante'].' AND ((nrLote = '.$Lance['nrLotePrincipal'].' AND nrItem = '.$Lance['nrItemPrincipal'].') OR (nrLote = '.$Lance['nrLoteReservada'].' AND nrItem = '.$Lance['nrItemReservada'].'))';
			}else{
				if($Lance['flAjuste']==2){//PRINCIPAL AO VENCEDOR DA RESERVADA
					$sql='INSERT INTO propostalicitante (cdEntidade, dtAnoProcesso, nrPregao, nrLote, nrItem, nrDocumentoLicitante, vlProposta, vlOferta, dsMarca, 					 flClassificado, dsMotivoDesclassificado, flHabilitado, dsMotivoInabilitado, flVencedor) VALUES ('.$_SESSION['Parametros']['cdEntidade'].', '.$_SESSION['Parametros']['dtAnoProcesso'].', '.$_SESSION['Parametros']['nrPregao'].', '.$Lance['nrLotePrincipal'].', '.$Lance['nrItemPrincipal'].', '.$Lance['nrDocumentoLicitante'].', '.$Lance['vlOfertaPrincipal'].', '.$Lance['vlOfertaPrincipal'].', "'.$Lance['dsMarca'].'", 1, "ADJUDICADO AO VENCEDOR DA COTA RESERVADA", 1, NULL, 1)';
					mysqli_query($connect,$sql) or die (mysqli_error($connect));
					$sql='UPDATE itemeditalentidade SET flSituacao = 1 WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$Lance['nrLotePrincipal'].' AND nrItem = '.$Lance['nrItemPrincipal'];
				}else{
					if($Lance['flAjuste']==3){//RESERVADA AO VENCEDOR DA COTA PRINCIPAL
						$sql='INSERT INTO propostalicitante (cdEntidade, dtAnoProcesso, nrPregao, nrLote, nrItem, nrDocumentoLicitante, vlProposta, vlOferta, dsMarca, 					 flClassificado, dsMotivoDesclassificado, flHabilitado, dsMotivoInabilitado, flVencedor) VALUES ('.$_SESSION['Parametros']['cdEntidade'].', '.$_SESSION['Parametros']['dtAnoProcesso'].', '.$_SESSION['Parametros']['nrPregao'].', '.$Lance['nrLoteReservada'].', '.$Lance['nrItemReservada'].', '.$Lance['nrDocumentoLicitante'].', '.$Lance['vlOfertaReservada'].', '.$Lance['vlOfertaReservada'].', "'.$Lance['dsMarca'].'", 1, "ADJUDICADO AO VENCEDOR DA COTA PRINCIPAL", 1, NULL, 1)';
					mysqli_query($connect,$sql) or die (mysqli_error($connect));
					$sql='UPDATE itemeditalentidade SET flSituacao = 1 WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$Lance['nrLoteReservada'].' AND nrItem = '.$Lance['nrItemReservada'];
					};
				};
			};
		};
		mysqli_query($connect,$sql) or die (mysqli_error($connect));
	};
};

include ('header.php');
?>

<div>
  <legend class="text-uppercase"><?php print '<strong>'.$_SESSION['Parametros']['nmEntidade'].' - Pregão nº '.$_SESSION['Parametros']['nrPregao'].'/'.$_SESSION['Parametros']['dtAnoProcesso'].'</strong><br />'.$_SESSION['Parametros']['dsObjeto']; ?></legend>
  <legend><strong>Verificações de consistência de dados</strong></legend>
  <legend>Lotes disputados sem vencedor</legend>
  <?php 
//Recoloca em disputa lotes que o vencedor foi inabilitado/desclassificado
	$sql='SELECT * FROM itemeditalentidade WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND flSituacao = 1 ORDER BY nrLote,nrItem';
	$SelItens= mysqli_query($connect,$sql) or die (mysqli_error($connect));
	$rows=mysqli_num_rows($SelItens);
	if ($rows>0){
		$i=0;
		while($Itens=mysqli_fetch_array($SelItens)){
			$sql='SELECT * FROM propostalicitante WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$Itens['nrLote'].' AND nrItem = '.$Itens['nrItem'].' AND flVencedor = 1 ORDER BY nrLote,nrItem';
			$SelVencedor= mysqli_query($connect,$sql) or die (mysqli_error($connect));
			$rows=mysqli_num_rows($SelVencedor);
			if ($rows==0){
				$sql='UPDATE itemeditalentidade SET flSituacao = 0 WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$Itens['nrLote'].' AND nrItem = '.$Itens['nrItem'];
				mysqli_query($connect,$sql) or die (mysqli_error($connect));
				$i++;
			};
		};
	};
	if($i==0){
		print '<p class="alert alert-success">Não existem itens com situação "DISPUTADO" sem definição de vencedor!!!</p>';
	}else{
		print '<p class="alert alert-warning">Existem '.$i.' itens que precisam ter sua disputa revisada!!! Verifique na opção "NEGOCIAÇÃO E DISPUTA" da guia "SESSÃO" os lotes que constam relacionados como "Não Disputados"!!!</p>';
	};
	?>
</div>
<div>
  <legend>Rotinas relacionadas aos lotes de cota</legend>
  <form action="index.php" method="post">
  <input type="hidden" name="form" value="c-5" />
  <table class="table table-condensed table-bordered">
    <thead>
      <tr>
        <th width="30px" class="text-center">COTA</th>
        <th width="30px" class="text-center">PRINCIPAL</th>
        <th width="30px" class="text-center">RESERVADA</th>
        <th class="text-center">DESCRIÇÃO </th>
        <th class="text-center">VENCEDOR </th>
      </tr>
    </thead>
    <tbody>
    
      <?php
//Vencedor de cotas do mesmo produto com valores diferentes
	$i=0;
	$sql='
		SELECT a.nrLote, a.nrItem, a.dsItem, a.nrLoteCotaPrincipal, b.nrDocumentoLicitante, b.dsMarca, c.nmLicitante, b.vlOferta, a.nrLoteCotaPrincipal
		FROM itemeditalentidade AS a 
		INNER JOIN propostalicitante AS b ON a.cdEntidade = b.cdEntidade AND a.dtAnoProcesso = b.dtAnoProcesso AND a.nrPregao = b.nrPregao AND a.nrLote = b.nrLote AND a.nrItem = b.nrItem 
		INNER JOIN licitanteedital AS c ON b.cdEntidade = c.cdEntidade AND b.dtAnoProcesso = c.dtAnoProcesso AND b.nrPregao = c.nrPregao AND b.nrDocumentoLicitante = c.nrDocumentoLicitante 
		WHERE a.cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND a.dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND a.nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND a.tpLote = 3 AND b.flVencedor = 1 ORDER BY nrLote,nrItem
	';
	$SelReservada=mysqli_query($connect,$sql) or die (mysqli_error($connect));
	while($Reservada=mysqli_fetch_array($SelReservada)){
		$sql='SELECT vlOferta FROM propostalicitante WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$Reservada['nrLoteCotaPrincipal'].' AND nrDocumentoLicitante = '.$Reservada['nrDocumentoLicitante'].' AND flVencedor = 1';
		$SelPrincipal=mysqli_query($connect,$sql) or die (mysqli_error($connect));
		$rows=mysqli_num_rows($SelPrincipal);
		$Principal=mysqli_fetch_array($SelPrincipal);
		if(($Reservada['vlOferta']!=$Principal['vlOferta'])and($rows==1)){
?>		<tr>
				<th colspan="5"> VENCEDOR DE COTAS DE UM MESMO PRODUTO, COM PREÇOS DIVERGENTES</th>
			</tr>
      <tr>
        <th class="text-center">LOTE</th>
        <td class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][nrLotePrincipal]" value="<?php print $Reservada['nrLoteCotaPrincipal']; ?>" /><?php print $Reservada['nrLoteCotaPrincipal']; ?></td>
        <td class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][nrLoteReservada]" value="<?php print $Reservada['nrLote']; ?>" /><?php print $Reservada['nrLote']; ?></td>
        <td rowspan="2" class="text-justify"><?php print strtoupper($Reservada['dsItem']); ?><input type="hidden" name="Lance[<?php print $i; ?>][dsMarca]" value="<?php print strtoupper($Reservada['dsMarca']); ?>" /></td>
        <td rowspan="2" class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][nrDocumentoLicitante]" value="<?php print $Reservada['nrDocumentoLicitante']; ?>" /><?php print strtoupper($Reservada['nmLicitante']); ?></td>
      </tr>
      <tr>
        <th class="text-center">ITEM</th>
        <td class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][nrItemPrincipal]" value="<?php print $Reservada['nrItem']; ?>" /><?php print $Reservada['nrItem']; ?></td>
        <td class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][nrItemReservada]" value="<?php print $Reservada['nrItem']; ?>" /><?php print $Reservada['nrItem']; ?></td>
      </tr>
      <tr>
        <th class="text-center">VALOR</th>
        <td class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][vlOfertaPrincipal]" value="<?php print number_format($Principal['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais']); ?>" /><?php print number_format($Principal['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.'); ?></td>
        <td class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][vlOfertaReservada]" value="<?php print number_format($Reservada['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais']); ?>" /><?php print number_format($Reservada['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.'); ?></td>
        <td colspan="2" class="text-center"><label><input type="radio" name="Lance[<?php print $i; ?>][flAjuste]" value="1" checked="checked" />Proceder Ajuste</label> <label style="padding-left: 50px;"><input type="radio" name="Lance[<?php print $i; ?>][flAjuste]" value="0" />Desclassificar de ambas as cotas</label></td>
      </tr>
      <tr class="warning"><td colspan="5"></td></tr>
      <?php 
      $i++;
		};
	};
	//busca todos os lotes de cota reservada
	$sql = 'SELECT * FROM itemeditalentidade  WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND tpLote = 3 ';
	$SelItens = mysqli_query($connect,$sql) or die (mysqli_error($connect));
	$rows=mysqli_num_rows($SelItens);
	if ($rows>0){
		while($Itens = mysqli_fetch_array($SelItens)){
			//busca proposta vencedora de cota reservada
			$sql = 'SELECT a.nrDocumentoLicitante, b.nmLicitante, a.vlOferta, a.dsMarca FROM propostalicitante AS a 
			INNER JOIN licitanteedital AS b ON a.cdEntidade = b.cdEntidade AND a.dtAnoProcesso = b.dtAnoProcesso AND a.nrPregao = b.nrPregao AND a.nrDocumentoLicitante = b.nrDocumentoLicitante 
			WHERE a.cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND a.dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND a.nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$Itens['nrLote'].' AND a.nrItem = '.$Itens['nrItem'].' AND a.flVencedor = 1';
			$SelReservada = mysqli_query($connect,$sql) or die (mysqli_error($connect));
			$rowsReservada=mysqli_num_rows($SelReservada);
			//busca proposta vencedora de cota principal
			$sql = 'SELECT a.nrDocumentoLicitante, b.nmLicitante, a.vlOferta, a.dsMarca FROM propostalicitante AS a 
			INNER JOIN licitanteedital AS b ON a.cdEntidade = b.cdEntidade AND a.dtAnoProcesso = b.dtAnoProcesso AND a.nrPregao = b.nrPregao AND a.nrDocumentoLicitante = b.nrDocumentoLicitante 
			WHERE a.cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND a.dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND a.nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND a.nrLote = '.$Itens['nrLoteCotaPrincipal'].' AND a.nrItem = '.$Itens['nrItem'].' AND a.flVencedor = 1';
			$SelPrincipal = mysqli_query($connect,$sql) or die (mysqli_error($connect));
			$rowsPrincipal=mysqli_num_rows($SelPrincipal);
			if(($rowsReservada == 1 and $rowsPrincipal == 0)or($rowsReservada == 0 and $rowsPrincipal == 1)){
				if($rowsReservada == 1){
					$PropReservada=mysqli_fetch_array($SelReservada);
					$sql = 'SELECT * FROM propostalicitante WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$Itens['nrLoteCotaPrincipal'].' AND nrItem = '.$Itens['nrItem'].' AND nrDocumentoLicitante = '.$PropReservada['nrDocumentoLicitante'];
					$Rowd=mysqli_query($connect,$sql) or die (mysqli_error($connect));
					$Rowd=mysqli_num_rows($Rowd);
					if($Rowd==0){
						$Proposta = $PropReservada;
					};
				}else{
					$PropPrincipal=mysqli_fetch_array($SelPrincipal);
					$sql = 'SELECT * FROM propostalicitante WHERE cdEntidade = '.$_SESSION['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_SESSION['Parametros']['dtAnoProcesso'].' AND nrPregao = '.$_SESSION['Parametros']['nrPregao'].' AND nrLote = '.$Itens['nrLote'].' AND nrItem = '.$Itens['nrItem'].' AND nrDocumentoLicitante = '.$PropPrincipal['nrDocumentoLicitante'];
					$Rowd=mysqli_query($connect,$sql) or die (mysqli_error($connect));
					$Rowd=mysqli_num_rows($Rowd);
					if($Rowd==0){
						$Proposta = $PropPrincipal;
					};
				};
				
				?>
      <tr>
				<th colspan="5"> COTA SEM VENCEDOR </th>
			</tr>
      <tr>
        <th class="text-center">LOTE</th>
        <td class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][nrLotePrincipal]" value="<?php print $Itens['nrLoteCotaPrincipal']; ?>" /><?php print $Itens['nrLoteCotaPrincipal']; ?></td>
        <td class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][nrLoteReservada]" value="<?php print $Itens['nrLote']; ?>" /><?php print $Itens['nrLote']; ?></td>
        <td rowspan="2" class="text-justify"><?php print strtoupper($Itens['dsItem']); ?><input type="hidden" name="Lance[<?php print $i; ?>][dsMarca]" value="<?php print strtoupper($Proposta['dsMarca']); ?>" /></td>
        <td rowspan="2" class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][nrDocumentoLicitante]" value="<?php print $Proposta['nrDocumentoLicitante']; ?>" /><?php print strtoupper($Proposta['nmLicitante']); ?></td>
      </tr>
      <tr>
        <th class="text-center">ITEM</th>
        <td class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][nrItemPrincipal]" value="<?php print $Itens['nrItem']; ?>" /><?php print $Itens['nrItem']; ?></td>
        <td class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][nrItemReservada]" value="<?php print $Itens['nrItem']; ?>" /><?php print $Itens['nrItem']; ?></td>
      </tr>
      <tr>
        <th class="text-center">VALOR</th>
        <td class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][vlOfertaPrincipal]" value="<?php print number_format($Proposta['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais']); ?>" /><?php if($rowsReservada==0){print number_format($Proposta['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.');}; ?></td>
        <td class="text-center"><input type="hidden" name="Lance[<?php print $i; ?>][vlOfertaReservada]" value="<?php print number_format($Proposta['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais']); ?>" /><?php if($rowsReservada==1){print number_format($Proposta['vlOferta'],$_SESSION['Parametros']['nrCasasDecimais'],',','.');}; ?></td>
        <td colspan="2" class="text-center"><label><input type="radio" name="Lance[<?php print $i; ?>][flAjuste]" value="<?php if($rowsReservada==1){print 2;}else{print 3;}; ?>" checked="checked" />Adjudicar ao Vencedor da Cota <?php if($rowsReservada==1){print 'Reservada';}else{print 'Principal';}; ?></label> <label style="padding-left: 50px;"><input type="radio" name="Lance[<?php print $i; ?>][flAjuste]" value="4" />Nada a fazer</label></td>
      </tr>
      <tr class="warning"><td colspan="5"></td></tr>
        <?php
				$i++;
			};
		};
	};
?>

    </tbody>
  </table>
  <?php 
	if($i>0){
		print '<button type="submit" name="Operacao" value="1" class="btn btn-primary form-control">Executar rotina</button>';
	}else{
		print '<p class="alert alert-success">Não existem lotes de cota passíveis de ajustes!!!</p>';
	}; ?>
  </form>
</div>
