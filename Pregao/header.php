<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>PREGÃO WEB
<?php if(isset($_SESSION['Parametros']['nmEntidade'])) { print ' - '.$_SESSION['Parametros']['nmEntidade'];}; if (isset($_SESSION['Parametros']['nrPregao'])){print ' - Pregão'.$_SESSION['Parametros']['nrPregao'].'/'.$_SESSION['Parametros']['dtAnoProcesso'];}; ?>
</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="img/index.ico" type="image/x-icon" />
<link rel="shortcut icon" href="img/index.ico" type="image/x-icon" />
</head>
<body class="container">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script> 
<script src="js/bootstrap.min.js"></script>
<header>
  <nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
      <div class="navbar-header"> <a class="navbar-brand" href="index.php" style="padding: 0px;"><img src="img/brasao.png" height="100%"></a>
        <ul class="nav navbar-nav">
          <!-- Relaciona entidades -->
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <strong>ENTIDADE </strong><span class="glyphicon glyphicon-menu-down"></span></a>
            <ul class="dropdown-menu">
              <li> <a href="?form=a-1"><span class="glyphicon glyphicon-plus"></span> NOVA ENTIDADE </a></li>
              <li role="separator" class="divider"></li>
              <?php 
$sql = "SELECT cdEntidade,nmEntidade FROM entidade order by nmEntidade";
$SelEntidade = mysqli_query($connect,$sql) or die (mysqli_error($connect));
while ($Entidades = mysqli_fetch_array ($SelEntidade)) {
?>
              <li> <a href="?form=a-1&cdEntidade=<?php print $Entidades['cdEntidade']; ?>"><span class="glyphicon glyphicon-menu-right"></span> <?php print $Entidades['nmEntidade'];}; ?> </a></li>
            </ul>
          </li>
          
          <!-- Se entidade estiver selecionada, relaciona processos -->
          <?php if ((isset($_SESSION['Parametros']['cdEntidade']))or (isset($_GET['cdEntidade']))) { ?>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <strong>PROCESSO </strong><span class="glyphicon glyphicon-menu-down"></span></a>
            <ul class="dropdown-menu">
              <li> <a href="?form=b-1"><span class="glyphicon glyphicon-plus"></span> NOVO PROCESSO </a></li>
              <li> <a href="?form=b-2"><span class="glyphicon glyphicon-search"></span> BUSCA DETALHADA </a></li>
              <li role="separator" class="divider"></li>
              <?php 
$sql = "SELECT nrPregao,dtAnoProcesso FROM editalentidade WHERE cdEntidade = ".$_SESSION['Parametros']['cdEntidade']." ORDER BY dtAnoProcesso,nrPregao DESC LIMIT 10";
$SelProcesso = mysqli_query($connect,$sql) or die (mysqli_error($connect));
while ($Processos = mysqli_fetch_array ($SelProcesso)) {
?>
              <li> <a href="?form=b-1&nrPregao=<?php print $Processos['nrPregao']; ?>&dtAnoProcesso=<?php print $Processos['dtAnoProcesso']; ?>"><span class="glyphicon glyphicon-menu-right"></span> Pregão <?php print $Processos['nrPregao'].'/'.$Processos['dtAnoProcesso'];}; ?> </a></li>
            </ul>
          </li>
          <?php }; ?>
          <!-- Se processo estiver selecionado, relaciona Formulários do Processo -->
          <?php if (isset($_SESSION['Parametros']['nrPregao']) and isset($_SESSION['Parametros']['cdEntidade'])) { ?>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <strong>SESSÃO</strong> <span class="glyphicon glyphicon-menu-down"></span></a>
            <ul class="dropdown-menu">
              <li> <a href="?form=c-1"><span class="glyphicon glyphicon-menu-right"></span> CREDENCIAMENTO </a></li>
              <li> <a href="?form=c-2"><span class="glyphicon glyphicon-menu-right"></span> PROPOSTAS </a></li>
              <li> <a href="?form=c-3"><span class="glyphicon glyphicon-menu-right"></span> CLASSIFICAÇÃO E HABILITAÇÃO </a></li>
              <li> <a href="?form=c-4"><span class="glyphicon glyphicon-menu-right"></span> NEGOCIAÇÃO E DISPUTA </a></li>
              <li> <a href="?form=c-5"><span class="glyphicon glyphicon-menu-right"></span> CONSISTÊNCIAS </a></li>
            </ul>
          </li>
          <li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"> <strong>RELATÓRIOS</strong> <span class="glyphicon glyphicon-menu-down"></span></a>
            <ul class="dropdown-menu">
              <li class="dropdown-header" > <span class="glyphicon glyphicon-triangle-right"></span> PREGÃO <?php print $_SESSION['Parametros']['nrPregao'].'/'.$_SESSION['Parametros']['dtAnoProcesso']; ?> </li>
              <li> <a href="?form=d-1" target="_blank" ><span class="glyphicon glyphicon-menu-file"></span> TABELAS PARA ATA </a></li>
              <li> <a href="?form=d-2" target="_blank" ><span class="glyphicon glyphicon-menu-save"></span> EXPORTAÇÃO </a></li>
            </ul>
          </li>
          <?php }; ?>
        </ul>
      </div>
    </div>
  </nav>
  <br>
  <br>
  <br>
</header>
