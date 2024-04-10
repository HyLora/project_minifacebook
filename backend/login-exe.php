<?php
session_start();
include_once "../common/connection.php";
include_once "../common/funzioni.php";
	$login = $_POST["email"];
	$pwd = $_POST["password"];

	$ris = isUser($cid,$login,$pwd); //la funzione isUser si connette con il database e 
									 //controlla se l'utente esiste nel db

	if ($ris["status"]=='ko')	
	{
		session_destroy();
		header('location: ../frontend/loginmodificato.php?status=ko&msg='. urlencode($ris["msg"]));
	}
	else
	{
		$_SESSION["email"]=$login;
		$_SESSION["logged"]=true;
		header("location: ../frontend/homepage.php?status=ok&msg=". urlencode($ris["msg"]));
	}
	$_SESSION["tipo"] = $ris["tipo"];