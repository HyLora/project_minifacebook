
var setTimer;

function ajaxRequest()
{var request=false;
  //Prova a creare un oggetto XMLHttpRequest
  try { request = new XMLHttpRequest()}catch(e1){
	//Prova a creare un oggetto ActiveXObject per le versioni recenti di Internet Explorer
	try{request = new ActiveXObject("Msxml2.XMLHTTP")}catch(e2){
		//Prova a creare un oggetto ActiveXObject per le versioni più vecchie di Internet Explorer
		try{ request = new ActiveXObject("Microsoft.XMLHTTP")
		}catch(e3){request = false}
	}
  }
  //restituito oggetto XMLHttpRequest creato (se è stato possibile crearlo) o false se non è stato possibile creare l'oggetto
  return request
}


function caricaStati()
{	
	var xttp = new ajaxRequest();
	xttp.onreadystatechange  = function()
	{
		// console.log(this.readyState + ' ' + this.status);
      if (this.readyState == 4 && this.status == 200)
	  {
		  // console.log(this.response);
		  risposta = JSON.parse(this.response);
		  
          if (risposta.status == "ok")		  
		  {
           stati = risposta.contenuto;
           menu = document.getElementById('stato');		   
		   for (i=0; i < stati.length; i++)
		   {
			   var item = document.createElement('option');
			   item.setAttribute("value",stati[i]);
			   item. innerText=stati[i];
			   menu.appendChild(item);
		   }
		  }
		  else
		  {
			  alert(risposta.msg);
		  }
		    
	  }		  
    };
	xttp.open("GET","../backend/getStato.php",true);
	xttp.send();
}


function caricaProvince()
{	
	statoMenu=  document.getElementById('stato');
	stato = statoMenu.options[statoMenu.selectedIndex].value;
	console.log('il valore della stato: '+stato);
	var xttp = new ajaxRequest();
	xttp.onreadystatechange  = function()
	{
		console.log(this.readyState + ' ' + this.status);
      if (this.readyState == 4 && this.status == 200)
	  {
		  console.log(this.response);
		  risposta = JSON.parse(this.response);
		  
          if (risposta.status == "ok")		  
		  {
           province = risposta.contenuto;
           menu = document.getElementById('prov');	
           menu.innerHTML="";		   
		   for (i=0; i < province.length; i++)
		   {
			   var item = document.createElement('option');
			   item.setAttribute("value",province[i].provincia);
			   item. innerText=province[i].provincia;
			   menu.appendChild(item);
		   }
		  }
		  else
		  {
			  alert(risposta.msg);
		  }
		    
	  }		  
    };
	xttp.open("GET","../backend/getProvincia.php?stato="+stato,true);
	xttp.send();
}

function caricaCitta() {
    statoMenu = document.getElementById('stato');
    stato = statoMenu.options[statoMenu.selectedIndex].value;
    console.log('il valore della stato: ' + stato);

    provMenu = document.getElementById('prov');
    prov = provMenu.options[provMenu.selectedIndex].value;
    console.log('il valore della provincia: ' + prov);

    var xttp = new ajaxRequest();
    xttp.onreadystatechange = function () {
        if (this.readyState == 4) {
            console.log(this.status);
            if (this.status == 200) {
                risposta = JSON.parse(this.response);

                if (risposta.status == "ok") {
                    citta = risposta.contenuto;
                    menu = document.getElementById('citt');
                    menu.innerHTML = "";
                    for (i = 0; i < citta.length; i++) {
                        var item = document.createElement('option');

                        item.setAttribute("value", citta[i].nome);
                        item.innerText = citta[i].nome;
                        menu.appendChild(item);
                    }
                } else {
                    alert(risposta.msg);
                }
            } else {
                console.error("Error: " + this.status);
            }
        }
    };
    xttp.open("GET", "../backend/getCitta.php?stato=" + stato + "&provincia=" + prov, true);
    xttp.send();
}