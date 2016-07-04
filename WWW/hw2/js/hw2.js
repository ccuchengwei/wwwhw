var maintext = "";
function parse_xml(datasrc)
{
	
	if(datasrc.value == "")
	{
		alert("Error, Please input XML url.") ;
			return 0;
	}
	
	
	var	newhttp = new XMLHttpRequest();
		newhttp.open("GET",datasrc.value,false);
		newhttp.send();
	var xmlDoc = newhttp.responseXML;
	if(xmlDoc == null){
			alert("Error in XML file.") ;
			return 0;
        }
	maintext = '<html xmlns="http://www.w3.org/1999/xhtml"><head></head><body>';
	maintext += '<div style="text-align:center;font-size:30;"><Strong>Menu</Strong><br /><br />';
	var food = xmlDoc.getElementsByTagName("food");
	
	if(food.length==0)
	{
		maintext += '<strong>No data.</strong>';
	}
	
	var foodname = xmlDoc.getElementsByTagName("foodname");
	var price = xmlDoc.getElementsByTagName("price");
	var calories = xmlDoc.getElementsByTagName("calories");
	var description = xmlDoc.getElementsByTagName("description");
	for (i = 0; i < food.length; i++)
	{
		 
        maintext += '<span><strong>'+foodname[i].childNodes[0].nodeValue;
		maintext += '</strong><br />'+ price[i].childNodes[0].nodeValue ;
		maintext += ' ('+calories[i].childNodes[0].nodeValue+')</span><br />';
		maintext += '<span>'+description[i].childNodes[0].nodeValue+'</span><br/><br/>';
	
	}
	maintext += '</div><br /><br />';    	
	maintext += '<div  style="text-align:center;font-size:30;"><Strong>Basketball</Strong><br /><br />';
	var basketball = xmlDoc.getElementsByTagName("basketball");
	
	if(food.length == 0 && basketball.length==0)

	{
			alert("Error in XML file.") ;
			return 0;
	}
	
	if(basketball.length==0)
	{
		maintext += '<strong>No data.</strong>';
		
	}
	
	var Team = xmlDoc.getElementsByTagName("Team");
	var City = xmlDoc.getElementsByTagName("City");
	var Color = xmlDoc.getElementsByTagName("Color");
	var BColor = xmlDoc.getElementsByTagName("BColor");
	var Image = xmlDoc.getElementsByTagName("Image");
	var name = xmlDoc.getElementsByTagName("name");
	var age = xmlDoc.getElementsByTagName("age");
	var position = xmlDoc.getElementsByTagName("position");
	var Coach = xmlDoc.getElementsByTagName("Coach");
	var Stadium = xmlDoc.getElementsByTagName("Stadium");
	var video = xmlDoc.getElementsByTagName("Video");
	
	for(i=0; i < basketball.length; i++)
	{
		Image = xmlDoc.getElementsByTagName("Image");
		maintext += "<a href=#table"+ i +"><img src="+Image[i].childNodes[0].nodeValue+" width=120 height=120 /></a>";
	}
	
	for(i=0; i < basketball.length; i++)
	{
		
		maintext +='<br/><br/><a name="table'+i+'"><table border="1" align="center" width="800" height="800"'
		+'style="text-align:center;color:'+Color[i].childNodes[0].nodeValue+'" bgcolor="'+BColor[i].childNodes[0].nodeValue+'">';
		maintext +='<tr><th colspan="4" style="font-size:20;">'
		+Team[i].childNodes[0].nodeValue+'</th></tr>'
		+'<tr><th rowspan="2"><img src ="'+Image[i].childNodes[0].nodeValue+'"width=50 height=50></th>'
		+'<th>All-star</th><th>Coach</th><th>Stadium</th></tr>'
		+'<tr><td><table border="1" width=100% height=100% style="text-align:center;color:'
		+Color[i].childNodes[0].nodeValue+'">'
		+'<tr><td>'+name[i].childNodes[0].nodeValue+'</td><td>'+age[i].childNodes[0].nodeValue+'</td><td>'+position[i].childNodes[0].nodeValue
		+'</td></tr></table>'
		+'<td>'+Coach[i].childNodes[0].nodeValue+'</td><td>'+Stadium[i].childNodes[0].nodeValue
		+'</td></tr><tr height="400"><td colspan="4"><iframe width="100%" height="100%"  src="'
		+video[i].childNodes[0].nodeValue+'"></iframe></td></tr></table></a><br/><br/>';	
		
	}
	
	
	newWindow = window.open('', 'popUpWindow','toolbar=yes,scrollbars=yes,resizable=yes,height=800,width=1000');
	newWindow.document.write(maintext);

}