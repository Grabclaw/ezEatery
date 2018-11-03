function pressedUpdateButton(id)
{
	if(window.XMLHttpRequest)
	{
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	
	xmlhttp.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			document.getElementById(id).innerHTML = this.responseText;
		}
	};
	
	xmlhttp.open("GET", "status.php?id="+id+
	"&fn="+$("#"+id+"_fn").val()+
	"&pr="+$("#"+id+"_pr").val()+
	"&qa="+$("#"+id+"_qa").val()+
	"&ph="+$("#"+id+"_ph").val()+
	"&de="+$("#"+id+"_de").val()
	, true);
	xmlhttp.send();
}