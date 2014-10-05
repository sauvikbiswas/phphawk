// Globals

function getHost() {
var url = window.location.href;
var nohttp = url.split('//')[1];
var hostPort = nohttp.split('/')[0]
return(hostPort)
}

var server = 'http://'+getHost()+'/';
var collapsecount = 0;
var collapseid = new Array();

function prepareImageSwap(elem,mouseOver,mouseOutRestore,mouseDown,mouseUpRestore,mouseOut,mouseUp) { 
//Do not delete these comments. 
//Non-Obtrusive Image Swap Script V1.1 by Hesido.com 
//Attribution required on all accounts 
    if (typeof(elem) == 'string') elem = document.getElementById(elem); 
    if (elem == null) return; 
    var regg = /(.*)(_orig\.)([^\.]{3,4})$/ 
    var prel = new Array(), img, imgList, imgsrc, mtchd; 
    imgList = elem.getElementsByTagName('img'); 
    for (var i=0; img = imgList[i]; i++) { 
        if (!img.rolloverSet && img.src.match(regg)) { 
            mtchd = img.src.match(regg); 
            img.hoverSRC = mtchd[1]+'_alt.'+ mtchd[3]; 
            img.outSRC = img.src; 
            if (typeof(mouseOver) != 'undefined') { 
                img.hoverSRC = (mouseOver) ? mtchd[1]+'_alt.'+ mtchd[3] : false; 
                img.outSRC = (mouseOut) ? mtchd[1]+'_ou.'+ mtchd[3] : (mouseOver && mouseOutRestore) ? img.src : false; 
                img.mdownSRC = (mouseDown) ? mtchd[1]+'_md.' + mtchd[3] : false; 
                img.mupSRC = (mouseUp) ? mtchd[1]+'_mu.' + mtchd[3] : (mouseOver && mouseDown && mouseUpRestore) ? img.hoverSRC : (mouseDown && mouseUpRestore) ? img.src : false; 
                } 
            if (img.hoverSRC) {preLoadImg(img.hoverSRC); img.onmouseover = imgHoverSwap;} 
            if (img.outSRC) {preLoadImg(img.outSRC); img.onmouseout = imgOutSwap;} 
            if (img.mdownSRC) {preLoadImg(img.mdownSRC); img.onmousedown = imgMouseDownSwap;} 
            if (img.mupSRC) {preLoadImg(img.mupSRC); img.onmouseup = imgMouseUpSwap;} 
            img.rolloverSet = true; 
        } 
    } 
    function preLoadImg(imgSrc) { 
        prel[prel.length] = new Image(); prel[prel.length-1].src = imgSrc; 
    } 
} 
function imgHoverSwap() {this.src = this.hoverSRC;} 
function imgOutSwap() {this.src = this.outSRC;} 
function imgMouseDownSwap() {this.src = this.mdownSRC;} 
function imgMouseUpSwap() {this.src = this.mupSRC;}

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
	
function grabFromEngine(header,param1,param2)
{
	xmlHttp=GetXmlHttpObject();
	if (xmlHttp==null) {
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url=server+"engine.php?subdir="+param1+"&parse="+param2+".txt";
	document.getElementById("header").src="images/"+param2+".gif";
	document.getElementById("content").innerHTML="<div style=\"padding:20px;\"><img style=\"float: left; padding-right: 20px;\" src=\"images/ajax-loader.gif\"> Loading...</div>";
	xmlHttp.onreadystatechange=stateChanged;
	xmlHttp.open("GET",url,true);
	xmlHttp.send(null);
	
}

function stateChanged() 
{ 
	if (xmlHttp.readyState==4) {
	document.getElementById("content").innerHTML=xmlHttp.responseText;
	}
}

function collapse(id)
{
	document.getElementById(id).innerHTML="";
}

function inload(enginecmd,id)
{
	vars = getUrlVars();
	for(i=0;i<collapsecount;i++) collapse(collapseid[i]);
	collapseid[collapsecount]=id;
	collapsecount++;
	xmlHttp3=GetXmlHttpObject();
	if (xmlHttp3==null) {
		alert ("Your browser does not support AJAX!");
		return;
	}
	var url=server+"engine.php?"+enginecmd;
	document.getElementById(id).innerHTML="<div style=\"padding:20px;\"><img style=\"float: left; padding-right: 20px;\" src=\"images/ajax-loader.gif\"> Loading...</div>";
	xmlHttp3.onreadystatechange=function() { 
		if (xmlHttp3.readyState==4) if (xmlHttp3.status==200) {
			document.getElementById(id).innerHTML="[ <small><a href=\"#"+vars['page']+"\" onclick=\"collapse('"+id+"');\">Collapse</a></small> ]<br>"+xmlHttp3.responseText;
		}
	}
	xmlHttp3.open("GET",url,true);
	xmlHttp3.send(null);
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

function clearemail()
{
	document.getElementById('dpeform').email.value = "";
}

function hidead()
{
	document.getElementById("adspace").innerHTML='<img src="images/overlay_bottom.gif" height="60" width="261">';
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
			grabFromEngine('News','content','news');
			break;
		case 'band':
			grabFromEngine('Band','content','band');
			break;
		case 'music':
			grabFromEngine('Music','content','music');
			break;
		case 'gallery':
			grabFromEngine('Gallery','content','gallery');
			break;
		case 'live':
			grabFromEngine('Live','content','live');
			break;
		case 'contact':
			grabFromEngine('Contact','content','contact');
			break;
		case 'DPezine':
			grabFromEngine('DPezine','content','DPezine');
			break;
		case 'dpezine':
			grabFromEngine('DPezine','content','DPezine');
			break;
		case 'store':
			grabFromEngine('store','content','store');
			hidead();
			break;
		case 'vppbooking':
			grabFromEngine('store','content','vppbooking');
			hidead();
			break;
		default:
			grabFromEngine('News','content','news');
	}
}

function dpeadd()
{
	enginecmd="subdir=content&page=dpereg.php&type=p&regemail="+document.getElementById('dpeform').email.value;
	inloadx(enginecmd,'newsletter');
}

function swapimg(imghref,title,pubdate,href2)
{
	document.getElementById('photo').src = imghref;
	document.getElementById('imgtitle').innerHTML = title;
	document.getElementById('imgpubdate').innerHTML = pubdate;
	document.getElementById('permalink').innerHTML = "<small><a target=\"_blank\" href=\""+href2+"\">Permalink /Comments</a></small>";
}

function guestbooksubmit()
{
	enginecmd="subdir=content&page=guestbook.php&type=p&name="+document.getElementById('guestbook').name.value+"&email="+document.getElementById('guestbook').email.value+"&url="+document.getElementById('guestbook').url.value+"&comments="+document.getElementById('guestbook').comments.value+"&submit="+document.getElementById('guestbook').submit.value;
	inloadx(enginecmd,'content');
}

function twitterhead()
{
	enginecmd="subdir=content&page=twitterhead.php&type=p";
	inloadx(enginecmd,'twitterhead');
}

function booking()
{
	enginecmd="subdir=content&page=store.php&type=p&name="+document.getElementById('booking').name.value+"&copies="+document.getElementById('booking').copies.value;
	enginecmd=enginecmd+"&email="+document.getElementById('booking').email.value;
	enginecmd=enginecmd+"&address="+document.getElementById('booking').address.value.replace(/\n/g, '<br>')+"&city="+document.getElementById('booking').city.value;
	enginecmd=enginecmd+"&state="+document.getElementById('booking').state.value+"&pin="+document.getElementById('booking').pin.value;
	enginecmd=enginecmd+"&code="+document.getElementById('booking').code.value+"&bookingstatus="+document.getElementById('booking').bookingstatus.value;
	inloadx(enginecmd,'content');
}

function booking_re()
{
	enginecmd="subdir=content&page=store.php&type=p&name="+document.getElementById('booking').name.value+"&copies="+document.getElementById('booking').copies.value;
	enginecmd=enginecmd+"&email="+document.getElementById('booking').email.value;
	enginecmd=enginecmd+"&address="+document.getElementById('booking').address.value.replace(/\n/g, '<br>')+"&city="+document.getElementById('booking').city.value;
	enginecmd=enginecmd+"&state="+document.getElementById('booking').state.value+"&pin="+document.getElementById('booking').pin.value;
	enginecmd=enginecmd+"&code="+document.getElementById('booking').code.value+"&bookingstatus=0";
	inloadx(enginecmd,'content');
}						