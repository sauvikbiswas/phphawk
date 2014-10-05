flagPlaylist = false;

function getHost() {
var url = window.location.href;
var nohttp = url.split('//')[1];
var hostPort = nohttp.split('/')[0]
return(hostPort)
}
var server = 'http://'+getHost()+'/';

function masterLoad(){
	setYoutubeHeight();
}

function masterResize() {
	setYoutubeHeight();
}

function toggleCollapsePlaylist() {
	if (!flagPlaylist) {
		document.getElementById("playlist-more").innerHTML="Collapse";
		document.getElementById("page-header").style.height = 270;
		menuSwitcher();
		flagPlaylist = true;
	} else {
		document.getElementById("playlist-more").innerHTML="More";
		document.getElementById("page-header").style.height = 85;
		menuSwitcher();
		flagPlaylist = false;
	}
}

function menuSwitcher() {
	var top = document.body.scrollTop;
	if (top > 170) {
		if(!flagPlaylist) document.getElementById("head-version").style.display = 'none';
	} else {
		document.getElementById("head-version").style.display = 'block';
	}
}

function setYoutubeHeight() {
	youtubeWidth = document.getElementById("youtube").offsetWidth;
	document.getElementById("youtube").height = (youtubeWidth*9)/16;
}

function GetXmlHttpObject()
{
	var xmlHttp;
	try {
		// Firefox, Opera 8.0+, Safari
		xmlHttp=new XMLHttpRequest();
	}
	catch (e) {
		// Internet Explorer
		try {
			xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
		}
		catch (e) {
			try {
				xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
			catch (e) {
				return false;
			}
		}
	}
	return xmlHttp;
}

function getUrlVars()
{
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	for(var i = 0; i < hashes.length; i++)
	{
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	if(window.location.href.indexOf('?')==-1) {
		hashes = window.location.href.slice(window.location.href.indexOf('#') + 1);
		vars['page']=hashes;
	}
	return vars;
}

function inloadx(enginecmd,id)
{
	xmlHttp4=GetXmlHttpObject();
	if (xmlHttp4==null) {
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url=server+"engine.php?"+enginecmd;
	document.getElementById(id).innerHTML="<div style=\"padding:20px;\"><img style=\"float: left; padding-right: 20px;\" src=\"images/ajax-loader.gif\"> Loading...</div>";
	xmlHttp4.onreadystatechange=function() { 
		if (xmlHttp4.readyState==4) if (xmlHttp4.status==200) {
			document.getElementById(id).innerHTML=xmlHttp4.responseText;
		}
	}
	xmlHttp4.open("GET",url,true);
	xmlHttp4.send(null);
}

function loadpage(page)
{
	var vars;
	if (page=="default") {
		vars = getUrlVars();
		if (vars.length==0) grabFromEngine('News','content','news');
		page = vars['page'];
	}
	switch (page) {
		case 'news':
			// grabFromEngine('News','content','news');
			inloadx("subdir=content&parse=news.txt","main-content");
			break;
		case 'band':
			// grabFromEngine('Band','content','band');
			inloadx("subdir=content&parse=band.txt","main-content");
			break;
		default:
			grabFromEngine('News','content','news');
	}
}