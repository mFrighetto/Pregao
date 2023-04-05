<?php 
if (isset($_POST['Parametros'])){
	$sql = 'SELECT a.cdEntidade,b.nmEntidade,a.dtAnoProcesso,a.nrPregao,a.dsObjeto,a.nrCasasDecimais FROM editalentidade AS a INNER JOIN entidade AS b ON a.cdEntidade = b.cdEntidade WHERE a.cdEntidade = '.$_POST['Parametros']['cdEntidade'].' AND a.nrPregao = '.$_POST['Parametros']['cdEntidade'].' AND dtAnoProcesso = '.$_POST['Parametros']['dtAnoProcesso'];
	$DadosProcesso=mysqli_query($connect,$sql) or die (mysqli_error($connect));
	$rows=mysqli_num_rows($DadosProcesso);
	if($rows==1){
	$_SESSION['Parametros']=mysqli_fetch_array($DadosProcesso);
	};
};
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta charset="utf-8">
<title>PREGÃO WEB - GERADOR DE PROPOSTAS
<?php if(isset($_SESSION['Parametros']['nmEntidade'])) { print ' - '.strtoupper($_SESSION['Parametros']['nmEntidade']);}; if (isset($_SESSION['Parametros']['nrPregao'])){print ' - Pregão'.$_SESSION['Parametros']['nrPregao'].'/'.$_SESSION['Parametros']['dtAnoProcesso'];}; ?>
</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="img/index.ico" type="image/x-icon" />
<link rel="shortcut icon" href="img/index.ico" type="image/x-icon" />
<link href="../../css/bootstrap.min.css" rel="stylesheet" type="text/css">
</head>
<body class="container">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<script src="js/inputmask-plugin.js"></script> 
<script src="js/bootstrap.min.js"></script>
<header class="alert-success">
  <div class="text-center"> <img src="img/brasao.png" width="160px" style="float:left">
    <h1>PREGÃO WEB
      <?php if(isset($_SESSION['Parametros']['nmEntidade'])) { print ' - '.strtoupper($_SESSION['Parametros']['nmEntidade']);}; ?>
    </h1>
    <h2>
      <?php if (isset($_SESSION['Parametros']['nrPregao'])){print 'Pregão'.$_SESSION['Parametros']['nrPregao'].'/'.$_SESSION['Parametros']['dtAnoProcesso'];}; ?>
    </h2>
    <h3><strong>Gerador de Propostas</strong></h3>
  </div>
</header>
<?php 
	if (isset($_SESSION['Parametros']['nrPregao'])){
	?>
	
<div class="container" style="clear:both;">
  <form action="index.php" method="post" target="_blank" >
    <div class="form-group">
      <legend>Dados do Licitante</legend>
      <div class="row">
        <div class="col-lg-6">
          <label for="nmLicitante">Razão Social</label>
          <input type="text" name="nmLicitante" class="form-control" required >
        </div>
        <div class="col-lg-2">
          <label for="nrDocumentoLicitante">CNPJ</label>
          <input type="text" name="nrDocumentoLicitante" class="form-control" data-mask="99.999.999/9999-99" required >
        </div>
        <div class="col-lg-4">
          <label for="flMPE">Enquadrado como Micro ou Pequena Empresa?</label>
          <select name="flMPE" class="form-control">
            <option value="1">SIM</option>
            <option value="0" selected="selected">NÃO</option>
          </select>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-6">
          <label for="dsEnderecoLicitante">Endereço Completo (Rua, nº, Bairro, Município - UF, CEP)</label>
          <input type="text" name="dsEnderecoLicitante" class="form-control" required >
        </div>
        <div class="col-lg-2">
          <label for="nrTelefone">Telefone</label>
          <input type="tel" name="nrTelefone" class="form-control" required >
        </div>
        <div class="col-lg-4">
          <label for="dsEmail">e-Mail</label>
          <input type="email" name="dsEmail" class="form-control" required >
        </div>
      </div>
      <div class="row">
        <div class="col-lg-4">
          <label for="dsBanco">Banco para pagamento</label>
          <input type="text" name="dsBanco" class="form-control" required >
        </div>
        <div class="col-lg-4">
          <label for="nrAgencia">Nº Agência</label>
          <input type="text" name="nrAgencia" class="form-control" required >
        </div>
        <div class="col-lg-4">
          <label for="nrContaCorrente">Nº Conta Corrente</label>
          <input type="text" name="nrContaCorrente" class="form-control" required >
        </div>
      </div>
      <fieldset>
        <label for="tpAmbito">Para efeito de aplicação de benefícios previstos no Decreto Municipal nº 6320/2017, dentre as opções a baixo, aonde a licitante possui sede?</label>
        <br />
        <input type="radio" name="tpAmbito" value="1" />
        Sediada em ÂMBITO LOCAL (Guarapuava - PR);<br />
        <input type="radio" name="tpAmbito" value="2" />
        Sediada em ÂMBITO REGIONAL (Campina do Simão, Candói, Cantagalo, Goioxim, Inácio Martins, Irati, Pinhão, Prudentópolis ou Turvo);<br />
        <input type="radio" name="tpAmbito" value="3" />
        Outros Municípios.<br />
      </fieldset>
      <br />
      <legend>Dados do Representante Legal</legend>
      <div class="row">
        <div class="col-lg-8">
          <label for="nmRepresentante">Nome Completo do Representante Legal (assinante da proposta)</label>
          <input type="text" name="nmRepresentante" class="form-control" required >
        </div>
        <div class="col-lg-2">
          <label for="nrDocumentoRepresentante">CPF</label>
          <input type="text" name="nrDocumentoRepresentante" class="form-control" required data-mask="999.999.999-99" >
        </div>
        <div class="col-lg-2">
          <label for="nrRGRepresentante">RG</label>
          <input type="text" name="nrRGRepresentante" class="form-control" required >
        </div>
      </div>
    </div>
    <div>
      <legend>Proposta de preços</legend>
      <p class="alert alert-warning"> <strong><span class="glyphicon glyphicon-warning-sing"></span> Atenção às seguintes Observações:</strong><br/>
        <br/>
        <strong>Legenda Tipo do Lote:</strong><br/>
        <strong>AC</strong> - Lote de Ampla Concorrência; <br/>
        <strong>CP</strong> - Lote de Cota Principal (destinado à Ampla Concorrência;<br/>
        <strong>CR</strong> - Lote de Cota Reservada (destinado à Contratação de Micro e Pequenas Empresas;<br/>
        <strong>EX</strong> - Lote Exclusivo para Micro e Pequenas Empresas;<br/>
        <br/>
        <strong>Em caso de prestação de serviços, a informação do campo marca não é obrigatória!!</strong> </p>
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
		$i=1;
		while ($Itens=mysqli_fetch_array($SelItens)){ 
			if($Itens['tpLote']==1){print '<tr class="success"><td class="text-center">AC</td>';};
			if($Itens['tpLote']==2){print '<tr class="info"><td class="text-center">CP</td>';};
			if($Itens['tpLote']==3){print '<tr class="warning"><td class="text-center">CR</td>';};
			if($Itens['tpLote']==4){print '<tr class="danger"><td class="text-center">EX</td>';};
			print '
				<td class="text-center"><input type="hidden" name="Proposta['.$i.'][nrLote]" value="'.$Itens['nrLote'].'"/>'.$Itens['nrLote'].'</td>
				<td class="text-center"><input type="hidden" name="Proposta['.$i.'][nrItem]" value="'.$Itens['nrItem'].'"/>'.$Itens['nrItem'].'</td>
				<td class="text-center"><input type="hidden" name="Proposta['.$i.'][vlQuantidade]" value="'.number_format($Itens['vlQuantidade'],3).'"/>'.number_format($Itens['vlQuantidade'],3,',','.').'</td>
				<td class="text-center text-uppercase"><input type="hidden" name="Proposta['.$i.'][dsUnidade]" value="'.strtoupper($Itens['dsUnidade']).'"/>'.strtoupper($Itens['dsUnidade']).'</td>
				<td class="text-justify text-uppercase"><textarea name="Proposta['.$i.'][dsItem]" style="display:none;">'.strtoupper(str_replace("'", '', str_replace('"', '', $Itens['dsItem']))).'</textarea>'.strtoupper(str_replace("'", '', str_replace('"', '', $Itens['dsItem']))).'</td>
				<td class="text-center">'.number_format($Itens['vlUnitario'],$_SESSION['Parametros']['nrCasasDecimais'],',','.').'</td>
				<td class="text-center"><input type="number" min="'.pow(10, -$_SESSION['Parametros']['nrCasasDecimais']).'" name="Proposta['.$i.'][vlProposta]" step="'.pow(10, -$_SESSION['Parametros']['nrCasasDecimais']).'" style="width:100px;" /></td>
				<td class="text-center"><input type="text" name="Proposta['.$i.'][dsMarca]" style="width:125px" /></td>
				</tr>';
			$i++;
		};
?>
        </tbody>
      </table>
      <div class="form-group">
        <div class="row">
          <div class="col-lg-4">
            <button type="submit" name="form" value="z-2" class="btn btn-success form-control"><span class="glyphicon glyphicon-save"></span> Gerar Proposta Digital</button>
          </div>
          <div class="col-lg-4">
            <button type="submit" name="form" value="z-3" class="btn btn-success form-control"><span class="glyphicon glyphicon-print"></span> Gerar Proposta para Impressão</button>
          </div>
          <div class="col-lg-4">
            <input type="reset" value="Limpar Formulário" class="btn btn-default form-control">
          </div>
        </div>
      </div>
    </div>
  </form>
</div>
<?php 
}else{ 
?>
<div>
<p class="alert alert-warning">O Processo <strong>Pregão <?php print $_POST['Parametros']['nrPregao'].'/'.$_POST['Parametros']['dtAnoProcesso'];?></strong> selecionado não está disponível para geração de proposta!!!</p>
</div>
<?php
};
?>