<?php
session_start();
	include ('connect.php');
	//verifica se um cadastro ou consulta foi preenchido
	if (isset($_POST['form'])){
		include ("include/form/form".$_POST['form'].".php");
		
		} else {
		//se nenhum formulário de cadastro ou consutal foi preenchido, verifica se alguma das opções principais foram selecionadas
		if (isset($_GET['form'])) {
			include ("include/form/form".$_GET['form'].".php");

			} else {
				//Caso negativo reseta variaveisde sessão e apresenta tela de boas vindas
				unset ($_SESSION['Parametros']);
				include ('header.php');
				include ('include/welcome.php');
		};
		
	};
	

	include ("footer.php");
?>