<?php
session_start();

include_once("../common/connection.php");
require_once "../common/funzioni.php";

	if (isset($_SESSION["logged"]))
	{	 		  
		$ris= richiediAmicizia($cid, $_SESSION["email"], $_GET["nuovo_amico"], null);

		if ($ris["status"]=='ok')
		{
			header("Location:../frontend/friends.php?status=ok&msg=". urlencode($ris["msg"]));
			stampaRichieste($ris["contenuto"]);
		}
		else
			header("Location:../frontend/friends.php?status=ko&msg=". urlencode($ris["msg"]));
	}
	else
	{
		header("Location:../index.php?status=ko&msg=". urlencode("Operazione riservata ad utenti registrati. Procedi con la login"));
	}	



?>