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
      $sql = "SELECT DISTINCT Stato FROM Citta ORDER BY Stato";
     
      $res = $cid->query($sql);
   	  if ($res==null)
	  {
		$risultato["status"]="ko";
		$risultato["msg"]="errore nella esecuzione della interrogazione " . $cid->error;
	  }
	  else
	  {	
       $stato= array(); 
	   while($row=$res->fetch_row())
	   {
			$stato[]=$row[0];
	   }
	   $risultato["contenuto"]=$stato;
     }
	}
	
	 echo json_encode($risultato);