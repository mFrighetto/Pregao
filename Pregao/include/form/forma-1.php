<?php 
//Verifica se alguma entidade foi selecionada no header, busca os dados no banco e grava variaveis de sessão
	if (isset($_GET['cdEntidade'])) {
		$sql = "SELECT * FROM entidade WHERE cdEntidade = ".$_GET['cdEntidade'];
		$DadosEntidade = mysqli_query($connect,$sql) or die (mysqli_error($connect));
		$_SESSION['Parametros'] = mysqli_fetch_array($DadosEntidade);
//Senão, verifica se foram enviados dados para cadastramento/atualização
		} else {
			if (isset($_POST['form'])){
				$_SESSION['Parametros'] = $_POST['Parametros'];
				$sql = "SELECT * FROM entidade WHERE cdEntidade = ".$_SESSION['Parametros']['cdEntidade'];
								
				//Busca se existe cadastro para o cdEntidade
				$DadosEntidade = mysqli_query($connect,$sql) or die (mysqli_error($connect));
				$rows = mysqli_num_rows($DadosEntidade);
								
				//Se cadastro inexistente, insere novo cadastro
				if ($rows == 0) {
					$sql = "INSERT INTO entidade (cdEntidade, nmEntidade, flAplicaBeneficios, flFormaBeneficios, vlPercentual, flLocalPrioridadeRegional) VALUES (".$_SESSION['Parametros']['cdEntidade'].", '".strtoupper($_SESSION['Parametros']['nmEntidade'])."', ".$_SESSION['Parametros']['flAplicaBeneficios'].", ".$_SESSION['Parametros']['flFormaBeneficios'].", ".$_SESSION['Parametros']['vlPercentual'].", ".$_SESSION['Parametros']['flLocalPrioridadeRegional'].")";	
			//Senão, atualiza cadastro existente
					}else{
						$sql = "UPDATE entidade SET nmEntidade = '".strtoupper($_SESSION['Parametros']['nmEntidade'])."', flAplicaBeneficios = ".$_SESSION['Parametros']['flAplicaBeneficios'].", flFormaBeneficios = ".$_SESSION['Parametros']['flFormaBeneficios'].", vlPercentual = ".$_SESSION['Parametros']['vlPercentual'].", flLocalPrioridadeRegional = ".$_SESSION['Parametros']['flLocalPrioridadeRegional']." WHERE cdEntidade = ".$_SESSION['Parametros']['cdEntidade'];
				};
		mysqli_query($connect,$sql) or die (mysqli_error($connect));
		//Ao se tratar solicitação de tela para inclusão de nova entidade, apaga variaveis de sessão
		}else {
			unset ($_SESSION['Parametros']);
		};
	};
	include ('header.php');	
	
?>

<div class="container">
  <form action="index.php" method="post">
    <legend>Cadastro e Parametrização de entidades</legend>
    <input type="hidden" name="form" value="a-1">
    <div class="row">
    <div class="col-lg-3">
    <div class="form-group">
      <label for="Parametros[cdEntidade]">Código da Entidade no TCE-PR</label>
      <input type="number" name="Parametros[cdEntidade]" class="form-control" <?php if ($_SESSION['Parametros']['cdEntidade'] <> ''){ print 'value="'.$_SESSION['Parametros']['cdEntidade'].'" disabled="disabled"';};?>  maxlength="6" required>
      <?php if ($_SESSION['Parametros']['cdEntidade'] <> ''){ print '<input type="hidden" name="Parametros[cdEntidade]" value="'.$_SESSION['Parametros']['cdEntidade'].'" >';};?>
    </div>
    </div>
    <div class="col-lg-9">
    <div class="form-group">
      <label for="Parametros[nmEntidade]">Nome da Entidade</label>
      <input type="text" name="Parametros[nmEntidade]" class="form-control" <?php if ($_SESSION['Parametros']['nmEntidade'] <> ''){print 'value="'.strtoupper($_SESSION['Parametros']['nmEntidade']).'"';};?> maxlength="200" required>
    </div>
    </div>
    </div>
    <div class="form-group"> <fieldset>
      <label for="Parametros[flAplicaBeneficios]">1. A Entidade aplica benefício da prioridade de contratação para as MPE Locais e Regionais em seus editais?</label>
      <br />
      <input type="radio" name="Parametros[flAplicaBeneficios]" <?php if ($_SESSION['Parametros']['flAplicaBeneficios'] == 1){print 'checked="checked"';}  ?> value="1" />
      Sim
      </label>
      <input type="radio" name="Parametros[flAplicaBeneficios]" <?php if ($_SESSION['Parametros']['flAplicaBeneficios'] == 0){print 'checked="checked"';};?> value="0" />
      Não
      </fieldset>
    </div>
    <div class="form-group"> <fieldset">
      <label for="Parametros[flFormaBeneficios]">2. Se sim para parametro "1", de que forma a Entidade aplica os benefícios?</label>
      <br />
      <input type="radio" name="Parametros[flFormaBeneficios]" <?php if ($_SESSION['Parametros']['flFormaBeneficios'] == 1){print 'checked="checked"';}; ?> value="1" />
      A Administração permite que a MPE Local/Regional apresente nova oferta<br />
      <input type="radio" name="Parametros[flFormaBeneficios]" <?php if ($_SESSION['Parametros']['flFormaBeneficios'] == 0){print 'checked="checked"';};?> value="0" />
      A Administração paga até 10% mais caro para contratar MPE Local/Regional
      </fieldset>
    </div>
    <div class="form-group">
      <label for="Parametros[vlPercentual]">3. Qual o percentual considerado para aplicação dos benefícios?</label>
      <input type="number" step="0.01" max="10" name="Parametros[vlPercentual]" class="form-control" <?php print 'value="'.$_SESSION['Parametros']['vlPercentual'].'"';?> placeholder="Valor em percentual" />
    </div>
    <div class="form-group"> <fieldset">
      <label for="Parametros[flLocalPrioridadeRegional]">4. MPE Locais têm prioridade sobre Regionais? </label>
      <br />
      <label class="radio-inline">
        <input type="radio" name="Parametros[flLocalPrioridadeRegional]" <?php if ($_SESSION['Parametros']['flLocalPrioridadeRegional'] == 1){print 'checked="checked"';}; ?> value="1" />
        Sim </label>
      <label class="radio-inline">
        <input type="radio" name="Parametros[flLocalPrioridadeRegional]" <?php if ($_SESSION['Parametros']['flLocalPrioridadeRegional'] == 0){print 'checked="checked"';}; ?> value="0" />
        Não </label>
      </fieldset>
    </div>
    <input type="submit" value="Cadastrar/Atualizar" class="btn btn-success">
    <input type="reset" value="Limpar" class="btn btn-default">
  </form>
</div>
