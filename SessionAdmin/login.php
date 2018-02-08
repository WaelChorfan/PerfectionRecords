<?php

$login_valide = "admin";
$pwd_valide = "admin";


if (isset($_POST['login']) && isset($_POST['pwd'])) {


	if ($login_valide == $_POST['login'] && $pwd_valide == $_POST['pwd']) {

		session_start ();

		$_SESSION['login'] = $_POST['login'];
		$_SESSION['pwd'] = $_POST['pwd'];

		header ('location:gestion.php');
	}
	else {

		echo '<body onLoad="alert(\'Membre non reconnu...\')">';
		// puis on le redirige vers la page d'accueil
		echo '<meta http-equiv="refresh" content="0;URL=index.php">';
	}
}
else {
	echo 'Verifier les champs.';
}
?>