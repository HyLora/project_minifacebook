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
      $sql = "SELECT Provincia FROM Citta WHERE Stato= '$stato' ORDER BY Provincia";
     
      $res = $cid->query($sql);
   	  if ($res==null)
	  {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella esecuzione della interrogazione " . $cid->error;
	  }
	  else
	  {	
       $provincia= array(); 
	   while($row=$res->fetch_row())
	   {
			$provincia[]=array("provincia"=>$row[0]);
	   }
	   $risultato["contenuto"]=$provincia;
     }
	}
	
	 echo json_encode($risultato);