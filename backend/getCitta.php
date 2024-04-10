<?php

require "../common/connection.php";
$risultato= array("msg"=>"","status"=>"ok", "contenuto"=>"");

if($cid->connect_errno)
	{
	  	$risultato["status"]="ko";
		$risultato["msg"]="errore nella esecuzione della interrogazione " . 
		$cid->connect_error;	
	}
    else
	{	
	  $stato=$_GET["stato"];
      $provincia=$_GET["provincia"];
      $sql = "SELECT Nome FROM Citta WHERE Stato= '$stato' and Provincia = '$provincia' ORDER BY Nome";
     
      $res = $cid->query($sql);
   	  if ($res==null)
	  {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella esecuzione della interrogazione " . $cid->error;
	  }
	  else
	  {	
       $citta = array(); 
	   while($row=$res->fetch_row())
	   {
			$citta[]=array("nome"=>$row[0]);
	   }
	   $risultato["contenuto"]=$citta;
     }
	}
	
	 echo json_encode($risultato);