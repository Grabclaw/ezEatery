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
	
	xmlhttp.open("POST", "status.php", true);
	xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlhttp.send("id="+id+"&qa="+$("#"+id+"_qa").val());
}