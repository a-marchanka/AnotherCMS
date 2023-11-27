/* COPYRIGHTS ©Another CMS */
function rMsg() {
	/* clear warning message after N sec */
	var elemErr = document.getElementById('errMsg');
	var elemWrn = document.getElementById('warnMsg');
	var cls_f = 0;
	if (elemErr) if (elemErr.innerHTML) cls_f = 1;
	if (elemWrn) if (elemWrn.innerHTML) cls_f = 1;
	if (cls_f == 1) setTimeout(clrMsg, 6000);
}
function clrMsg() {
	/* clear warning message after 5 sec */
	var elemErr = document.getElementById('errMsg');
	var elemWrn = document.getElementById('warnMsg');
	if (elemErr) elemErr.style.display="none";
	if (elemWrn) elemWrn.style.display="none";
	clearTimeout(clrMsg);
}
function toggle(elementId, state) {
	/* state: 0 - disable, 1 - enable, -1 - change */
	var elem = document.getElementById(elementId);
	if (elem) {
		var visibility = elem.style.display;
		if (state == 1 && visibility == "none")
			visibility = "block";
		if (state == 0 && visibility == "block")
			visibility = "none";
		if (state == -1)
			visibility = (visibility == "none") ? ("block") : ("none");
		elem.style.display = visibility;
	}
}
/* display drop down */
function drawOptions(targetId, prefixVal, ind, selId) {
	target_obj = document.getElementById(targetId);
	if (!ind) ind_str = '';
	else ind_str = '[' + ind +']';
	element_len = eval(prefixVal + "_param" + ind_str + ".length");
	target_obj.length = element_len;
	selected_ind = 0;
	for(i = 0; i < element_len; i ++) {
		current_value = eval(prefixVal + "_value" + ind_str + "[" + i + "]");
		target_obj[i].text = eval(prefixVal + "_param" + ind_str + "[" + i + "]");
		target_obj[i].value = current_value;
		if (selId == current_value)
			selected_ind = i;
	}
	target_obj.selectedIndex = selected_ind;
	return true;
}
/* order drop down */
function orderOptions(objId, targetId, prefixId, selId) {
	parent_name = objId + prefixId;
	target_name = targetId + prefixId;
	parent_obj = document.getElementById(parent_name);
	target_obj = document.getElementById(target_name);
	current_ind = parent_obj.selectedIndex + 1;
	element_len = eval(targetId + "_param[" + current_ind + "].length");
	target_obj.length = element_len;
	selected_ind = 0;
	for(i = 0; i < element_len; i ++) {
		current_value = eval(targetId + "_value[" + current_ind + "][" + i + "]");
		target_obj[i].text = eval(targetId + "_param[" + current_ind + "][" + i + "]");
		target_obj[i].value = current_value;
		if (selId == current_value)
			selected_ind = i;
	}
	target_obj.selectedIndex = selected_ind;
	return true;
}
/* window functions */
function rScr(action, subaction) {
	request = "?" + "action=" + action + "&entry_id=" + var_entry_id + "&" + var_sid + ((subaction) ? ("&subaction=" + subaction) : (""));
	url = this.location.pathname;
	this.location.href = url + request;
}
function rOpnr(sid, id, action, param) {
	request = "?" + "action=" + action + "&entry_id=" + id + "&" + sid + ((param) ? ("&" + param) : (""));
	url = opener.location.pathname + request;
	opener.location.href = url;
	opener.focus();
	window.close();
}
function closeWindow() {
	this.close();
}
function oDtl(subaction, uid) {
	if (window.innerWidth < 600) {
		var bw = 380; var bl = 10; var bt = 10;
	} else {
		var bw = 800; var bl = 100; var bt = 50;
	}
	var bh = Math.round(0.9*window.innerHeight);
	url = this.location.pathname;
	newWindow = open(url + "?" + "action=details&entry_id=" + var_entry_id + "&" + var_sid + "&subaction=" + subaction + "&details_id=" + uid, "window_details_" + uid, "width=" + bw + ", height=" + bh + ", status=yes, toolbar=no, menubar=no, scrollbars=yes, resizable=yes, left=" + bl + ", top=" + bt);
}
function oLog(action, subaction, uid) {
	if (window.innerWidth < 600) {
		var bw = 380; var bl = 10; var bt = 10;
	} else {
		var bw = 800; var bl = 100; var bt = 50;
	}
	var bh = Math.round(0.9*window.innerHeight);
	url = this.location.pathname;
	newWindow = open(url + "?" + "action=" + action + "&entry_id=" + var_entry_id + "&" + var_sid + "&subaction=" + subaction + "&details_id=" + uid, "window_log_" + uid, "width=" + bw + ", height=" + bh + ", status=yes, toolbar=no, menubar=yes, scrollbars=yes, resizable=yes, left=" + bl + ", top=" + bt);
}
function oCnfr(action, subaction, uid, msg) {
	url = this.location.pathname;
	if (confirm(msg))
		this.location.href = url + "?" + "action=" + action + "&entry_id=" + var_entry_id + "&" + var_sid + "&subaction=" + subaction + "&details_id=" + uid;
}
function oModul(id, action, subaction) {
	url = this.location.pathname;
	this.location.href = url + "?entry_id=" + id + "&" + var_sid + "&action=" + action + "&subaction=" + subaction;
}
/* File Manager */
function oFmDtl(subaction, dir, name, ext) {
	url = this.location.pathname;
	newWindow = open(url + "?" + var_sid + "&entry_id=" + var_entry_id + "&action=details&subaction=" + subaction + "&dir=" + dir + "&name=" + name + "&ext=" + ext, "window_details", "width=650, height=600, status=yes, toolbar=no, menubar=no, scrollbars=yes, resizable=yes, left=250, top=150");
}
function oFmDir(id, action, subaction, dir) {
	url = this.location.pathname;
	this.location.href = url + "?" + var_sid + "&entry_id=" + id + "&action=" + action + "&subaction=" + subaction + "&dir=" + dir;
}
function oFmCnfr(action, subaction, dir, name, ext, msg) {
	url = this.location.pathname;
	if (confirm(msg))
		this.location.href = url + "?" + var_sid + "&entry_id=" + var_entry_id + "&action=" + action + "&subaction=" + subaction + "&dir=" + dir + "&name=" + name + "&ext=" + ext;
}
function rFmScr(action, subaction, dir, name, ext) {
	url = this.location.pathname;
	this.location.href = url + "?" + var_sid + "&entry_id=" + var_entry_id + "&action=" + action + "&subaction=" + subaction + "&dir=" + dir + "&name=" + name + "&ext=" + ext;
}
/* PAGER */
function pagerGo(targetId, action, subaction){
	if (!subaction) var subaction = 'search';
	target_obj=document.getElementById(targetId);
	page_obj=document.getElementById('page');
	var ind=0;
	switch(action){
	case 'first':ind=0;break;
	case 'prev':ind=page_obj.selectedIndex-1;break;
	case 'next':ind=page_obj.selectedIndex+1;break;
	case 'last':ind=page_obj.length-1;break;
	default:ind=page_obj.selectedIndex;break};
	page_obj.selectedIndex=ind;
	target_obj.subaction.value=subaction;
	target_obj.submit();
}
/* PASSWORD GENERATOR */
function genPass(targetId, plength) {
	var keylist="aAbBcCdDeEfFgGhHijJkKLmMnNoOpPqQrRsStTuUvVwWxXyYzZ123456789";
	var temp='';
	for (i=0;i<plength;i++)
		temp+=keylist.charAt(Math.floor(Math.random()*keylist.length));
	target_obj = document.getElementById(targetId);
	target_obj.value = temp;
}
/* Search replace */
function searchReplaceTxt(textId) {
	var e_sql = document.getElementById(textId);
	var var_sql = e_sql.value;
	var from_obj = document.getElementById('var_s');
	var var_from = from_obj.value;
	var to_obj = document.getElementById('var_r');
	var var_to = to_obj.value;
	if(var_from && var_to){
		var_sql = var_sql.replace(new RegExp(var_from, 'g'), var_to);
		e_sql.value=var_sql;
	}
}
/* dtree links */
function goTree(entry_id) {
	request = "?" + "action=list&entry_id=" + entry_id + "&" + var_sid;
	url = this.location.pathname;
	this.location.href = url + request;
}
/* w3 sidebar */
function dtreeSidebar() {
	var x = document.getElementById("dtreeSidebar");
	if (x.className.indexOf("w3-show") == -1) x.className += " w3-show";
	else x.className = x.className.replace(" w3-show", "");
}
/* Lytebox */
function Lytebox(e,t){this.label=new Object;
this.label["close"]="Close (Esc)";
this.label["prev"]="Previous (\u2190)";
this.label["next"]="Next (\u2192)";
this.label["play"]="Play (spacebar)";
this.label["pause"]="Pause (spacebar)";
this.label["print"]="Print";
this.label["image"]="Image %1 of %2";
this.label["page"]="Page %1 of %2";
this.theme=typeof lyteboxTheme!=="undefined"&&/^(black|grey|red|green|blue|gold|orange)$/i.test(lyteboxTheme)?lyteboxTheme:"grey";
this.roundedBorder=true;
this.innerBorder=false;
this.outerBorder=false;
this.resizeSpeed=10;
this.maxOpacity=80;
this.borderSize=10;
this.appendQS=false;
this.fixedPosition=this.isMobile()?false:true;
this.inherit=true;
this.__hideObjects=true;
this.__autoResize=true;
this.__doAnimations=false;
this.__animateOverlay=false;
this.__forceCloseClick=false;
this.__refreshPage=false;
this.__showPrint=false;
this.__navType=3;
this.__navTop=this.isMobile()?false:false;
this.__titleTop=this.isMobile()?true:false;
this.__width="96%";
this.__height="96%";
this.__scrolling="auto";
this.__loopPlayback=false;
this.__autoPlay=true;
this.__autoEmbed=true;
this.__slideInterval=3e3;
this.__showNavigation=false;
this.__showClose=true;
this.__showDetails=true;
this.__showPlayPause=true;
this.__autoEnd=true;
this.__pauseOnNextClick=false;
this.__pauseOnPrevClick=true;
this.__loopSlideshow=false;
this.__beforeStart="";
this.__afterStart="";
this.__beforeEnd="";
this.__afterEnd="";
this.__changeTipCursor=true;
this.__tipDecoration="dotted";
this.__tipStyle="classic";
this.__tipRelative=true;
this.navTypeHash=new Object;
this.navTypeHash["Hover_by_type_1"]=true;
this.navTypeHash["Display_by_type_1"]=false;
this.navTypeHash["Hover_by_type_2"]=false;
this.navTypeHash["Display_by_type_2"]=true;
this.navTypeHash["Hover_by_type_3"]=true;
this.navTypeHash["Display_by_type_3"]=true;
this.resizeWTimerArray=new Array;
this.resizeWTimerCount=0;
this.resizeHTimerArray=new Array;
this.resizeHTimerCount=0;
this.changeContentTimerArray=new Array;
this.changeContentTimerCount=0;
this.overlayTimerArray=new Array;
this.overlayTimerCount=0;
this.imageTimerArray=new Array;
this.imageTimerCount=0;
this.timerIDArray=new Array;
this.timerIDCount=0;
this.slideshowIDArray=new Array;
this.slideshowIDCount=0;
this.imageArray=new Array;
this.slideArray=new Array;
this.frameArray=new Array;
this.contentNum=null;
this.aPageSize=new Array;
this.overlayLoaded=false;
this.checkFrame();
this.isSlideshow=false;
this.isLyteframe=false;
this.tipSet=false;
this.ieVersion=this.ffVersion=this.chromeVersion=this.operaVersion=this.safariVersion=-1;
this.ie=this.ff=this.chrome=this.opera=this.safari=false;
this.setBrowserInfo();
this.classAttribute=this.ie&&this.doc.compatMode=="BackCompat"||this.ie&&this.ieVersion<=7?"className":"class";
this.classAttribute=this.ie&&(document.documentMode==8||document.documentMode==9)?"class":this.classAttribute;
this.isReady=false;if(e){this.http=t;
this.bodyOnscroll=document.body.onscroll;if(this.resizeSpeed>10){this.resizeSpeed=10}if(this.resizeSpeed<1){this.resizeSpeed=1}var n=2; var r=navigator.userAgent.match(/windows nt 5.1/i)||navigator.userAgent.match(/windows nt 5.2/i)?true:false;
this.resizeDuration=(11-this.resizeSpeed)*(this.ie?this.ieVersion>=9?6:this.ieVersion==8?this.doc.compatMode=="BackCompat"?n:n-1:3:7);
this.resizeDuration=this.ff?(11-this.resizeSpeed)*(this.ffVersion<6?3:r?6:12):this.resizeDuration;
this.resizeDuration=this.chrome?(11-this.resizeSpeed)*5:this.resizeDuration;
this.resizeDuration=this.safari?(11-this.resizeSpeed)*20:this.resizeDuration;
this.resizeDuration=this.isMobile()?(11-this.resizeSpeed)*2:this.resizeDuration;if(window.name!="lbIframe"){this.initialize()}}else{this.http=new Array;if(typeof $=="undefined"){$=function(e){if($.cache[e]===undefined){$.cache[e]=document.getElementById(e)||false}return $.cache[e]};$.cache={}}}};
function initLytebox(){myLytebox=$lb=new Lytebox(true,$lb.http)}
Lytebox.prototype.setBrowserInfo=function(){var e=navigator.userAgent.toLowerCase();
this.chrome=e.indexOf("chrome")>-1;
this.ff=e.indexOf("firefox")>-1;
this.safari=!this.chrome&&e.indexOf("safari")>-1;
this.opera=e.indexOf("opera")>-1;
this.ie=false;if(this.chrome){var t=new RegExp("chrome/([0-9]{1,}[.0-9]{0,})");if(t.exec(e)!=null){this.chromeVersion=parseInt(RegExp.$1)}}if(this.ff){var t=new RegExp("firefox/([0-9]{1,}[.0-9]{0,})");if(t.exec(e)!=null){this.ffVersion=parseInt(RegExp.$1)}}if(this.ie){var t=new RegExp("msie ([0-9]{1,}[.0-9]{0,})");if(t.exec(e)!=null){this.ieVersion=parseInt(RegExp.$1)}}if(this.opera){var t=new RegExp("opera/([0-9]{1,}[.0-9]{0,})");if(t.exec(e)!=null){this.operaVersion=parseInt(RegExp.$1)}}if(this.safari){var t=new RegExp("version/([0-9]{1,}[.0-9]{0,})");if(t.exec(e)!=null){this.safariVersion=parseInt(RegExp.$1)}}};
Lytebox.prototype.initialize=function(){this.updateLyteboxItems(); var e=this.doc.getElementsByTagName("body").item(0);if(this.doc.$("lbOverlay")){e.removeChild(this.doc.$("lbOverlay"))}if(this.doc.$("lbMain")){e.removeChild(this.doc.$("lbMain"))}if(this.doc.$("lbLauncher")){e.removeChild(this.doc.$("lbLauncher"))}var t=this.doc.createElement("a");t.setAttribute("id","lbLauncher");t.setAttribute(this.classAttribute,"lytebox");t.style.display="none";e.appendChild(t); var n=this.doc.createElement("div");n.setAttribute("id","lbOverlay");n.setAttribute(this.classAttribute,this.theme);if(this.ie&&(this.ieVersion<=6||this.ieVersion<=9&&this.doc.compatMode=="BackCompat")){n.style.position="absolute"}n.style.display="none";e.appendChild(n); var r=this.doc.createElement("div");r.setAttribute("id","lbMain");r.style.display="none";e.appendChild(r); var i=this.doc.createElement("div");i.setAttribute("id","lbOuterContainer");i.setAttribute(this.classAttribute,this.theme);if(this.roundedBorder){i.style.MozBorderRadius="8px";i.style.borderRadius="8px"}r.appendChild(i); var s=this.doc.createElement("div");s.setAttribute("id","lbTopContainer");s.setAttribute(this.classAttribute,this.theme);if(this.roundedBorder){s.style.MozBorderRadius="8px";s.style.borderRadius="8px"}i.appendChild(s); var o=this.doc.createElement("div");o.setAttribute("id","lbTopData");o.setAttribute(this.classAttribute,this.theme);s.appendChild(o); var u=this.doc.createElement("span");u.setAttribute("id","lbTitleTop");o.appendChild(u); var a=this.doc.createElement("span");a.setAttribute("id","lbNumTop");o.appendChild(a); var f=this.doc.createElement("div");f.setAttribute("id","lbTopNav");s.appendChild(f); var l=this.doc.createElement("a");l.setAttribute("id","lbCloseTop");l.setAttribute("title",this.label["close"]);l.setAttribute(this.classAttribute,this.theme);l.setAttribute("href","javascript:void(0)");
f.appendChild(l); var c=this.doc.createElement("a");c.setAttribute("id","lbPrintTop");c.setAttribute("title",this.label["print"]);c.setAttribute(this.classAttribute,this.theme);c.setAttribute("href","javascript:void(0)");
f.appendChild(c); var h=this.doc.createElement("a");h.setAttribute("id","lbNextTop");h.setAttribute("title",this.label["next"]);h.setAttribute(this.classAttribute,this.theme);h.setAttribute("href","javascript:void(0)");
f.appendChild(h); var p=this.doc.createElement("a");p.setAttribute("id","lbPauseTop");p.setAttribute("title",this.label["pause"]);p.setAttribute(this.classAttribute,this.theme);p.setAttribute("href","javascript:void(0)");
p.style.display="none";f.appendChild(p); var d=this.doc.createElement("a");d.setAttribute("id","lbPlayTop");d.setAttribute("title",this.label["play"]);d.setAttribute(this.classAttribute,this.theme);d.setAttribute("href","javascript:void(0)");
d.style.display="none";f.appendChild(d); var v=this.doc.createElement("a");v.setAttribute("id","lbPrevTop");v.setAttribute("title",this.label["prev"]);v.setAttribute(this.classAttribute,this.theme);v.setAttribute("href","javascript:void(0)");
f.appendChild(v); var m=this.doc.createElement("div");m.setAttribute("id","lbIframeContainer");m.style.display="none";i.appendChild(m); var g=this.doc.createElement("iframe");g.setAttribute("id","lbIframe");g.setAttribute("name","lbIframe");g.setAttribute("frameBorder","0");if(this.innerBorder){g.setAttribute(this.classAttribute,this.theme)}g.style.display="none";m.appendChild(g); var y=this.doc.createElement("div");y.setAttribute("id","lbImageContainer");i.appendChild(y); var b=this.doc.createElement("img");b.setAttribute("id","lbImage");if(this.innerBorder){b.setAttribute(this.classAttribute,this.theme)}y.appendChild(b); var w=this.doc.createElement("div");w.setAttribute("id","lbLoading");w.setAttribute(this.classAttribute,this.theme);i.appendChild(w); var E=this.doc.createElement("div");E.setAttribute("id","lbBottomContainer");E.setAttribute(this.classAttribute,this.theme);if(this.roundedBorder){E.style.MozBorderRadius="8px";E.style.borderRadius="8px"}i.appendChild(E); var S=this.doc.createElement("div");S.setAttribute("id","lbBottomData");S.setAttribute(this.classAttribute,this.theme);E.appendChild(S); var x=this.doc.createElement("span");x.setAttribute("id","lbTitleBottom");S.appendChild(x); var T=this.doc.createElement("span");T.setAttribute("id","lbNumBottom");S.appendChild(T); var N=this.doc.createElement("span");N.setAttribute("id","lbDescBottom");S.appendChild(N); var C=this.doc.createElement("div");C.setAttribute("id","lbHoverNav");y.appendChild(C); var k=this.doc.createElement("div");k.setAttribute("id","lbBottomNav");E.appendChild(k); var L=this.doc.createElement("a");L.setAttribute("id","lbPrevHov");L.setAttribute("title",this.label["prev"]);L.setAttribute(this.classAttribute,this.theme);L.setAttribute("href","javascript:void(0)");
C.appendChild(L); var A=this.doc.createElement("a");A.setAttribute("id","lbNextHov");A.setAttribute("title",this.label["next"]);A.setAttribute(this.classAttribute,this.theme);A.setAttribute("href","javascript:void(0)");
C.appendChild(A); var O=this.doc.createElement("a");O.setAttribute("id","lbClose");O.setAttribute("title",this.label["close"]);O.setAttribute(this.classAttribute,this.theme);O.setAttribute("href","javascript:void(0)");
k.appendChild(O); var M=this.doc.createElement("a");M.setAttribute("id","lbPrint");M.setAttribute("title",this.label["print"]);M.setAttribute(this.classAttribute,this.theme);M.setAttribute("href","javascript:void(0)");
M.style.display="none";k.appendChild(M); var _=this.doc.createElement("a");_.setAttribute("id","lbNext");_.setAttribute("title",this.label["next"]);_.setAttribute(this.classAttribute,this.theme);_.setAttribute("href","javascript:void(0)");
k.appendChild(_); var D=this.doc.createElement("a");D.setAttribute("id","lbPause");D.setAttribute("title",this.label["pause"]);D.setAttribute(this.classAttribute,this.theme);D.setAttribute("href","javascript:void(0)");
D.style.display="none";k.appendChild(D); var P=this.doc.createElement("a");P.setAttribute("id","lbPlay");P.setAttribute("title",this.label["play"]);P.setAttribute(this.classAttribute,this.theme);P.setAttribute("href","javascript:void(0)");
P.style.display="none";k.appendChild(P); var H=this.doc.createElement("a");H.setAttribute("id","lbPrev");H.setAttribute("title",this.label["prev"]);H.setAttribute(this.classAttribute,this.theme);H.setAttribute("href","javascript:void(0)");
k.appendChild(H); var B=this.isFrame&&window.parent.frames[window.name].document?window.parent.frames[window.name].document.getElementsByTagName("iframe"):document.getElementsByTagName("iframe");for(var j=0;j<B.length;j++){if(/youtube/i.test(B[j].src)){B[j].src+=(/\?/.test(B[j].src)?"&":"?")+"wmode=transparent"}}this.isReady=true};
Lytebox.prototype.updateLyteboxItems=function(){var e=this.isFrame&&window.parent.frames[window.name].document?window.parent.frames[window.name].document.getElementsByTagName("a"):document.getElementsByTagName("a");e=this.isFrame?e:document.getElementsByTagName("a"); var t=this.isFrame&&window.parent.frames[window.name].document?window.parent.frames[window.name].document.getElementsByTagName("area"):document.getElementsByTagName("area"); var n=this.combine(e,t); var r=relAttribute=revAttribute=classAttribute=dataOptions=dataTip=tipDecoration=tipStyle=tipImage=tipHtml=aSetting=sName=sValue=sExt=aUrl=null; var i=bRelative=false;for(var s=0;s<n.length;s++){r=n[s];relAttribute=String(r.getAttribute("rel"));classAttribute=String(r.getAttribute(this.classAttribute));if(r.getAttribute("href")){sType=classAttribute.match(/lytebox|lyteshow|lyteframe/i);sType=this.isEmpty(sType)?relAttribute.match(/lytebox|lyteshow|lyteframe/i):sType;dataOptions=String(r.getAttribute("data-lyte-options"));dataOptions=this.isEmpty(dataOptions)?String(r.getAttribute("rev")):dataOptions;aUrl=r.getAttribute("href").split("?");sExt=aUrl[0].split(".").pop().toLowerCase();i=sExt=="png"||sExt=="jpg"||sExt=="jpeg"||sExt=="gif"||sExt=="bmp";if(sType&&sType.length>=1){if(this.isMobile()&&/youtube/i.test(r.getAttribute("href"))){r.target="_blank"}else if(i&&(dataOptions.match(/slide:true/i)||sType[0].toLowerCase()=="lyteshow")){r.onclick=function(){$lb.start(this,true,false);return false}}else if(i){r.onclick=function(){$lb.start(this,false,false);return false}}else{r.onclick=function(){$lb.start(this,false,true);return false}}}dataTip=String(r.getAttribute("data-tip"));dataTip=this.isEmpty(dataTip)?r.getAttribute("title"):dataTip;if(classAttribute.toLowerCase().match("lytetip")&&!this.isEmpty(dataTip)&&!this.tipsSet){if(this.__changeTipCursor){r.style.cursor="help"}tipDecoration=this.__tipDecoration;tipStyle=this.__tipStyle;bRelative=this.__tipRelative;if(!this.isEmpty(dataOptions)){aOptions=dataOptions.split(" ");for(var o=0;o<aOptions.length;o++){aSetting=aOptions[o].split(":");sName=aSetting.length>1?this.trim(aSetting[0]).toLowerCase():"";sValue=aSetting.length>1?this.trim(aSetting[1]):"";switch(sName){case"tipstyle":tipStyle=/classic|info|help|warning|error/.test(sValue)?sValue:tipStyle;break;case"changetipcursor":r.style.cursor=/true|false/.test(sValue)?sValue=="true"?"help":"":r.style.cursor;break;case"tiprelative":bRelative=/true|false/.test(sValue)?sValue=="true":bRelative;break;case"tipdecoration":tipDecoration=/dotted|solid|none/.test(sValue)?sValue:tipDecoration;break}}}if(tipDecoration!="dotted"){r.style.borderBottom=tipDecoration=="solid"?"1px solid":"none"}switch(tipStyle){case"info":tipStyle="lbCustom lbInfo";tipImage="lbTipImg lbInfoImg";break;case"help":tipStyle="lbCustom lbHelp";tipImage="lbTipImg lbHelpImg";break;case"warning":tipStyle="lbCustom lbWarning";tipImage="lbTipImg lbWarningImg";break;case"error":tipStyle="lbCustom lbError";tipImage="lbTipImg lbErrorImg";break;case"classic":tipStyle="lbClassic";tipImage="";break;default:tipStyle="lbClassic";tipImage=""}if(this.ie&&this.ieVersion<=7||this.ieVersion==8&&this.doc.compatMode=="BackCompat"){tipImage="";if(tipStyle!="lbClassic"&&!this.isEmpty(tipStyle)){tipStyle+=" lbIEFix"}}var u=this.findPos(r);if(this.ie&&(this.ieVersion<=6||this.doc.compatMode=="BackCompat")||bRelative){r.style.position="relative"}tipHtml=r.innerHTML;r.innerHTML="";if(this.ie&&this.ieVersion<=6&&this.doc.compatMode!="BackCompat"||bRelative){r.innerHTML=tipHtml+'<span class="'+tipStyle+'">'+(tipImage?'<div class="'+tipImage+'"></div>':"")+dataTip+"</span>"}else{r.innerHTML=tipHtml+'<span class="'+tipStyle+'" style="left:'+u[0]+"px;top:"+(u[1]+u[2])+'px;">'+(tipImage?'<div class="'+tipImage+'"></div>':"")+dataTip+"</span>"}if(classAttribute.match(/lytebox|lyteshow|lyteframe/i)==null){r.setAttribute("title","")}}}}this.tipsSet=true};
Lytebox.prototype.launch=function(e){var t=this.isEmpty(e.url)?"":String(e.url); var n=this.isEmpty(e.options)?"":String(e.options); var r=this.isEmpty(e.title)?"":e.title; var i=this.isEmpty(e.description)?"":e.description; var s=/slide:true/i.test(n);if(this.isEmpty(t)){return false}if(!this.isReady){this.timerIDArray[this.timerIDCount++]=setTimeout("$lb.launch({ url: '"+t+"', options: '"+n+"', title: '"+r+"', description: '"+i+"' })",100);return}else{for(var o=0;o<this.timerIDCount;o++){window.clearTimeout(this.timerIDArray[o])}}var u=t.split("?"); var a=u[0].split(".").pop().toLowerCase(); var f=a=="png"||a=="jpg"||a=="jpeg"||a=="gif"||a=="bmp"; var l=this.doc.$("lbLauncher");l.setAttribute("href",t);l.setAttribute("data-lyte-options",n);l.setAttribute("data-title",r);l.setAttribute("data-description",i);
this.updateLyteboxItems();
this.start(l,s,f?false:true)};
Lytebox.prototype.start=function(e,t,n){var r=String(e.getAttribute("data-lyte-options"));r=this.isEmpty(r)?String(e.getAttribute("rev")):r;
this.setOptions(r);
this.isSlideshow=t?true:false;
this.isLyteframe=n?true:false;if(!this.isEmpty(this.beforeStart)){var i=window[this.beforeStart];if(typeof i==="function"){if(!i(this.args)){return}}}if(this.ie&&this.ieVersion<=6){this.toggleSelects("hide")}if(this.hideObjects){this.toggleObjects("hide")}if(this.isFrame&&window.parent.frames[window.name].document){window.parent.$lb.printId=this.isLyteframe?"lbIframe":"lbImage"}else{this.printId=this.isLyteframe?"lbIframe":"lbImage"}this.aPageSize=this.getPageSize(); var s=this.doc.$("lbOverlay"); var o=this.doc.getElementsByTagName("body").item(0);s.style.height=this.aPageSize[1]+"px";s.style.display="";
this.fadeIn({id:"lbOverlay",opacity:this.doAnimations&&this.animateOverlay&&(!this.ie||this.ieVersion>=9)?0:this.maxOpacity}); var u=this.isFrame&&window.parent.frames[window.name].document?window.parent.frames[window.name].document.getElementsByTagName("a"):document.getElementsByTagName("a");u=this.isFrame?u:document.getElementsByTagName("a"); var a=this.isFrame&&window.parent.frames[window.name].document?window.parent.frames[window.name].document.getElementsByTagName("area"):document.getElementsByTagName("area"); var f=this.combine(u,a); var l=sExt=aUrl=null;
this.frameArray=[];
this.frameNum=0;
this.imageArray=[];
this.imageNum=0;
this.slideArray=[];
this.slideNum=0;if(this.isEmpty(this.group)){r=String(e.getAttribute("data-lyte-options"));r=this.isEmpty(r)?String(e.getAttribute("rev")):r;if(this.isLyteframe){this.frameArray.push(new Array(e.getAttribute("href"),!this.isEmpty(e.getAttribute("data-title"))?e.getAttribute("data-title"):e.getAttribute("title"),e.getAttribute("data-description"),r))}else{this.imageArray.push(new Array(e.getAttribute("href"),!this.isEmpty(e.getAttribute("data-title"))?e.getAttribute("data-title"):e.getAttribute("title"),e.getAttribute("data-description"),r))}}else{for(var c=0;c<f.length;c++){var h=f[c];r=String(h.getAttribute("data-lyte-options"));r=this.isEmpty(r)?String(h.getAttribute("rev")):r;if(h.getAttribute("href")&&r.toLowerCase().match("group:"+this.group)){l=String(h.getAttribute(this.classAttribute)).match(/lytebox|lyteshow|lyteframe/i);l=this.isEmpty(l)?h.getAttribute("rel").match(/lytebox|lyteshow|lyteframe/i):l;aUrl=h.getAttribute("href").split("?");sExt=aUrl[0].split(".").pop().toLowerCase();bImage=sExt=="png"||sExt=="jpg"||sExt=="jpeg"||sExt=="gif"||sExt=="bmp";if(l&&l.length>=1){if(bImage&&(r.match(/slide:true/i)||l[0].toLowerCase()=="lyteshow")){this.slideArray.push(new Array(h.getAttribute("href"),!this.isEmpty(h.getAttribute("data-title"))?h.getAttribute("data-title"):h.getAttribute("title"),h.getAttribute("data-description"),r))}else if(bImage){this.imageArray.push(new Array(h.getAttribute("href"),!this.isEmpty(h.getAttribute("data-title"))?h.getAttribute("data-title"):h.getAttribute("title"),h.getAttribute("data-description"),r))}else{this.frameArray.push(new Array(h.getAttribute("href"),!this.isEmpty(h.getAttribute("data-title"))?h.getAttribute("data-title"):h.getAttribute("title"),h.getAttribute("data-description"),r))}}}}if(this.isLyteframe){this.frameArray=this.removeDuplicates(this.frameArray);while(this.frameArray[this.frameNum][0]!=e.getAttribute("href")){this.frameNum++}}else if(t){this.slideArray=this.removeDuplicates(this.slideArray);try{while(this.slideArray[this.slideNum][0]!=e.getAttribute("href")){this.slideNum++}}catch(p){}}else{this.imageArray=this.removeDuplicates(this.imageArray);while(this.imageArray[this.imageNum][0]!=e.getAttribute("href")){this.imageNum++}}}this.changeContent(this.isLyteframe?this.frameNum:this.isSlideshow?this.slideNum:this.imageNum)};
Lytebox.prototype.changeContent=function(e){this.contentNum=e;if(!this.overlayLoaded){this.changeContentTimerArray[this.changeContentTimerCount++]=setTimeout("$lb.changeContent("+this.contentNum+")",250);return}else{for(var t=0;t<this.changeContentTimerCount;t++){window.clearTimeout(this.changeContentTimerArray[t])}}var n=this.isLyteframe?this.frameArray[this.contentNum][3]:this.isSlideshow?this.slideArray[this.contentNum][3]:this.imageArray[this.contentNum][3];if(!this.inherit||/inherit:false/i.test(n)){this.setOptions(String(n))}else{var r=String(this.isLyteframe?this.frameArray[0][3]:this.isSlideshow?this.slideArray[0][3]:this.imageArray[0][3]);if(this.isLyteframe){var i=sHeight=null;try{i=n.match(/width:\d+(%|px|)/i)[0]}catch(s){}try{sHeight=n.match(/height:\d+(%|px|)/i)[0]}catch(s){}if(!this.isEmpty(i)){r=r.replace(/width:\d+(%|px|)/i,i)}if(!this.isEmpty(sHeight)){r=r.replace(/height:\d+(%|px|)/i,sHeight)}}this.setOptions(r)}var o=this.doc.$("lbMain");o.style.display=""; var u=40;if(this.autoResize&&this.fixedPosition){if(this.ie&&(this.ieVersion<=7||this.doc.compatMode=="BackCompat")){o.style.top=this.getPageScroll()+this.aPageSize[3]/u+"px"; var a=this.aPageSize[3]/u;
this.scrollHandler=function(){$lb.doc.$("lbMain").style.top=$lb.getPageScroll()+a+"px"};
this.bodyOnscroll=document.body.onscroll;if(window.addEventListener){window.addEventListener("scroll",this.scrollHandler)}else if(window.attachEvent){window.attachEvent("onscroll",this.scrollHandler)}o.style.position="absolute"}else{o.style.top=this.aPageSize[3]/u+"px";o.style.position="fixed"}}else{o.style.position="absolute";o.style.top=this.getPageScroll()+this.aPageSize[3]/u+"px"}this.doc.$("lbOuterContainer").style.paddingBottom="0";if(!this.outerBorder){this.doc.$("lbOuterContainer").style.border="none"}else{this.doc.$("lbOuterContainer").setAttribute(this.classAttribute,this.theme)}if(this.forceCloseClick){this.doc.$("lbOverlay").onclick=""}else{this.doc.$("lbOverlay").onclick=function(){$lb.end();return false}}this.doc.$("lbMain").onclick=function(e){var e=e;if(!e){if(window.parent.frames[window.name]&&parent.document.getElementsByTagName("frameset").length<=0){e=window.parent.window.event}else{e=window.event}}var t=e.target?e.target.id:e.srcElement.id;if(t=="lbMain"&&!$lb.forceCloseClick){$lb.end();return false}};
this.doc.$("lbPrintTop").onclick=this.doc.$("lbPrint").onclick=function(){$lb.printWindow();return false};
this.doc.$("lbCloseTop").onclick=this.doc.$("lbClose").onclick=function(){$lb.end();return false};
this.doc.$("lbPauseTop").onclick=function(){$lb.togglePlayPause("lbPauseTop","lbPlayTop");return false};
this.doc.$("lbPause").onclick=function(){$lb.togglePlayPause("lbPause","lbPlay");return false};
this.doc.$("lbPlayTop").onclick=function(){$lb.togglePlayPause("lbPlayTop","lbPauseTop");return false};
this.doc.$("lbPlay").onclick=function(){$lb.togglePlayPause("lbPlay","lbPause");return false};if(this.isSlideshow&&this.showPlayPause&&this.isPaused){this.doc.$("lbPlay").style.display="";
this.doc.$("lbPause").style.display="none"}if(this.isSlideshow){for(var t=0;t<this.slideshowIDCount;t++){window.clearTimeout(this.slideshowIDArray[t])}}if(!this.outerBorder){this.doc.$("lbOuterContainer").style.border="none"}else{this.doc.$("lbOuterContainer").setAttribute(this.classAttribute,this.theme)}var f=10;if(this.titleTop||this.navTop){this.doc.$("lbTopContainer").style.visibility="hidden";f+=this.doc.$("lbTopContainer").offsetHeight}else{this.doc.$("lbTopContainer").style.display="none"}this.doc.$("lbBottomContainer").style.display="none";
this.doc.$("lbImage").style.display="none";
this.doc.$("lbIframe").style.display="none";
this.doc.$("lbPrevHov").style.display="none";
this.doc.$("lbNextHov").style.display="none";
this.doc.$("lbIframeContainer").style.display="none";
this.doc.$("lbLoading").style.marginTop="-"+f+"px";
this.doc.$("lbLoading").style.display="";if(this.isLyteframe){var l=$lb.doc.$("lbIframe");l.src="about:blank"; var c=this.trim(this.width); var h=this.trim(this.height);if(/\%/.test(c)){var p=parseInt(c);c=parseInt((this.aPageSize[2]-50)*p/100);c=c+"px"}if(/\%/.test(h)){var p=parseInt(h);h=parseInt((this.aPageSize[3]-150)*p/100);h=h+"px"}if(this.autoResize){var d=this.aPageSize[2]-50; var v=this.aPageSize[3]-150;c=(parseInt(c)>d?d:c)+"";h=(parseInt(h)>v?v:h)+""}l.height=this.height=h;l.width=this.width=c;l.scrolling=this.scrolling; var m=l.contentWindow||l.contentDocument;try{if(m.document){m=m.document}m.body.style.margin=0;m.body.style.padding=0;if(this.ie&&this.ieVersion<=8){m.body.scroll=this.scrolling;m.body.overflow=this.scrolling="no"?"hidden":"auto"}}catch(s){}this.resizeContainer(parseInt(this.width),parseInt(this.height))}else{this.imgPreloader=new Image;
this.imgPreloader.onload=function(){var e=$lb.imgPreloader.width; var t=$lb.imgPreloader.height;if($lb.autoResize){var n=$lb.aPageSize[2]-50; var r=$lb.aPageSize[3]-150;if(e>n){t=Math.round(t*(n/e));e=n;if(t>r){e=Math.round(e*(r/t));t=r}}else if(t>r){e=Math.round(e*(r/t));t=r;if(e>n){t=Math.round(t*(n/e));e=n}}}var i=$lb.doc.$("lbImage");i.src=$lb.imgPreloader.src;i.width=e;i.height=t;$lb.resizeContainer(e,t);$lb.imgPreloader.onload=function(){}};
this.imgPreloader.src=this.isSlideshow?this.slideArray[this.contentNum][0]:this.imageArray[this.contentNum][0]}};
Lytebox.prototype.resizeContainer=function(e,t){this.resizeWidth=e;
this.resizeHeight=t;
this.wCur=this.doc.$("lbOuterContainer").offsetWidth;
this.hCur=this.doc.$("lbOuterContainer").offsetHeight;
this.xScale=(this.resizeWidth+this.borderSize*2)/this.wCur*100;
this.yScale=(this.resizeHeight+this.borderSize*2)/this.hCur*100; var n=this.wCur-this.borderSize*2-this.resizeWidth; var r=this.hCur-this.borderSize*2-this.resizeHeight;
this.wDone=n==0;if(!(r==0)){this.hDone=false;
this.resizeH("lbOuterContainer",this.hCur,this.resizeHeight+this.borderSize*2,this.getPixelRate(this.hCur,this.resizeHeight))}else{this.hDone=true;if(!this.wDone){this.resizeW("lbOuterContainer",this.wCur,this.resizeWidth+this.borderSize*2,this.getPixelRate(this.wCur,this.resizeWidth))}}if(r==0&&n==0){if(this.ie){this.pause(250)}else{this.pause(100)}}this.doc.$("lbPrevHov").style.height=this.resizeHeight+"px";
this.doc.$("lbNextHov").style.height=this.resizeHeight+"px";if(this.hDone&&this.wDone){if(this.isLyteframe){this.loadContent()}else{this.showContent()}}};
Lytebox.prototype.loadContent=function(){try{var e=this.doc.$("lbIframe"); var t=this.frameArray[this.contentNum][0];if(!this.inline&&this.appendQS){t+=(/\?/.test(t)?"&":"?")+"request_from=lytebox"}if(this.autoPlay&&/youtube/i.test(t)){t+=(/\?/.test(t)?"&":"?")+"autoplay=1"}if(!this.autoEmbed||this.ff&&t.match(/.pdf|.mov|.wmv/i)){this.frameSource=t;
this.showContent();return}if(this.ie){e.onreadystatechange=function(){if($lb.doc.$("lbIframe").readyState=="complete"){$lb.showContent();$lb.doc.$("lbIframe").onreadystatechange=null}}}else{e.onload=function(){$lb.showContent();$lb.doc.$("lbIframe").onload=null}}if(this.inline||t.match(/.mov|.mp4|.mpg|.webm|.wav|.mp3|.m4a/i)){e.src="about:blank";
this.frameSource=""; var n=this.inline?this.doc.$(t.substr(t.indexOf("#")+1,t.length)).innerHTML:this.buildObject(parseInt(this.width),parseInt(this.height),t); var r=e.contentWindow||e.contentDocument;if(r.document){r=r.document}r.open();r.write(n);r.close();r.body.style.margin=0;r.body.style.padding=0;if(!this.inline){r.body.style.backgroundColor="#fff";r.body.style.fontFamily="Verdana, Helvetica, sans-serif";r.body.style.fontSize="0.9em"}this.frameSource=""}else{this.frameSource=t;e.src=t}}catch(i){}};
Lytebox.prototype.showContent=function(){if(this.isSlideshow){if(this.contentNum==this.slideArray.length-1){if(this.loopSlideshow){this.slideshowIDArray[this.slideshowIDCount++]=setTimeout("$lb.changeContent(0)",this.slideInterval)}else if(this.autoEnd){this.slideshowIDArray[this.slideshowIDCount++]=setTimeout("$lb.end('slideshow')",this.slideInterval)}}else{if(!this.isPaused){this.slideshowIDArray[this.slideshowIDCount++]=setTimeout("$lb.changeContent("+(this.contentNum+1)+")",this.slideInterval)}}this.doc.$("lbHoverNav").style.display=this.ieVersion!=6&&this.showNavigation&&this.navTypeHash["Hover_by_type_"+this.navType]?"":"none";
this.doc.$("lbCloseTop").style.display=this.showClose&&this.navTop?"":"none";
this.doc.$("lbClose").style.display=this.showClose&&!this.navTop?"":"none";
this.doc.$("lbBottomData").style.display=this.showDetails?"":"none";
this.doc.$("lbPauseTop").style.display=this.showPlayPause&&this.navTop?!this.isPaused?"":"none":"none";
this.doc.$("lbPause").style.display=this.showPlayPause&&!this.navTop?!this.isPaused?"":"none":"none";
this.doc.$("lbPlayTop").style.display=this.showPlayPause&&this.navTop?!this.isPaused?"none":"":"none";
this.doc.$("lbPlay").style.display=this.showPlayPause&&!this.navTop?!this.isPaused?"none":"":"none";
this.doc.$("lbPrevTop").style.display=this.navTop&&this.showNavigation&&this.navTypeHash["Display_by_type_"+this.navType]?"":"none";
this.doc.$("lbPrev").style.display=!this.navTop&&this.showNavigation&&this.navTypeHash["Display_by_type_"+this.navType]?"":"none";
this.doc.$("lbNextTop").style.display=this.navTop&&this.showNavigation&&this.navTypeHash["Display_by_type_"+this.navType]?"":"none";
this.doc.$("lbNext").style.display=!this.navTop&&this.showNavigation&&this.navTypeHash["Display_by_type_"+this.navType]?"":"none"}else{this.doc.$("lbHoverNav").style.display=this.ieVersion!=6&&this.navTypeHash["Hover_by_type_"+this.navType]&&!this.isLyteframe?"":"none";if(this.navTypeHash["Display_by_type_"+this.navType]&&!this.isLyteframe&&this.imageArray.length>1||this.frameArray.length>1&&this.isLyteframe){this.doc.$("lbPrevTop").style.display=this.navTop?"":"none";
this.doc.$("lbPrev").style.display=!this.navTop?"":"none";
this.doc.$("lbNextTop").style.display=this.navTop?"":"none";
this.doc.$("lbNext").style.display=!this.navTop?"":"none"}else{this.doc.$("lbPrevTop").style.display="none";
this.doc.$("lbPrev").style.display="none";
this.doc.$("lbNextTop").style.display="none";
this.doc.$("lbNext").style.display="none"}this.doc.$("lbCloseTop").style.display=this.navTop?"":"none";
this.doc.$("lbClose").style.display=!this.navTop?"":"none";
this.doc.$("lbBottomData").style.display="";
this.doc.$("lbPauseTop").style.display="none";
this.doc.$("lbPause").style.display="none";
this.doc.$("lbPlayTop").style.display="none";
this.doc.$("lbPlay").style.display="none"}this.doc.$("lbPrintTop").style.display=this.showPrint&&this.navTop?"":"none";
this.doc.$("lbPrint").style.display=this.showPrint&&!this.navTop?"":"none";
this.updateDetails();
this.doc.$("lbLoading").style.display="none";
this.doc.$("lbImageContainer").style.display=this.isLyteframe?"none":"";
this.doc.$("lbIframeContainer").style.display=this.isLyteframe?"":"none";if(this.isLyteframe){if(!this.isEmpty(this.frameSource)){this.doc.$("lbIframe").src=this.frameSource}this.doc.$("lbIframe").style.display="";
this.fadeIn({id:"lbIframe",opacity:this.doAnimations&&(!this.ie||this.ieVersion>=9)?0:100})}else{this.doc.$("lbImage").style.display="";
this.fadeIn({id:"lbImage",opacity:this.doAnimations&&(!this.ie||this.ieVersion>=9)?0:100});
this.preloadNeighborImages()}if(!this.isEmpty(this.afterStart)){var e=window[this.afterStart];if(typeof e==="function"){e(this.args)}}};
Lytebox.prototype.updateDetails=function(){var e=this.isSlideshow?this.slideArray[this.contentNum][1]:this.isLyteframe?this.frameArray[this.contentNum][1]:this.imageArray[this.contentNum][1]; var t=this.isSlideshow?this.slideArray[this.contentNum][2]:this.isLyteframe?this.frameArray[this.contentNum][2]:this.imageArray[this.contentNum][2];if(this.ie&&this.ieVersion<=7||this.ieVersion>=8&&this.doc.compatMode=="BackCompat"){this.doc.$(this.titleTop?"lbTitleBottom":"lbTitleTop").style.display="none";
this.doc.$(this.titleTop?"lbTitleTop":"lbTitleBottom").style.display=this.isEmpty(e)?"none":"block"}this.doc.$("lbDescBottom").style.display=this.isEmpty(t)?"none":"";
this.doc.$(this.titleTop?"lbTitleTop":"lbTitleBottom").innerHTML=this.isEmpty(e)?"":e;
this.doc.$(this.titleTop?"lbTitleBottom":"lbTitleTop").innerHTML="";
this.doc.$(this.titleTop?"lbNumBottom":"lbNumTop").innerHTML="";
this.updateNav();if(this.titleTop||this.navTop){this.doc.$("lbTopContainer").style.display="block";
this.doc.$("lbTopContainer").style.visibility="visible"}else{this.doc.$("lbTopContainer").style.display="none"}var n=this.titleTop?this.doc.$("lbNumTop"):this.doc.$("lbNumBottom");if(this.isSlideshow&&this.slideArray.length>1){n.innerHTML=this.label["image"].replace("%1",this.contentNum+1).replace("%2",this.slideArray.length)}else if(this.imageArray.length>1&&!this.isLyteframe){n.innerHTML=this.label["image"].replace("%1",this.contentNum+1).replace("%2",this.imageArray.length)}else if(this.frameArray.length>1&&this.isLyteframe){n.innerHTML=this.label["page"].replace("%1",this.contentNum+1).replace("%2",this.frameArray.length)}else{n.innerHTML=""}var r=!(this.titleTop||this.isEmpty(e)&&this.isEmpty(n.innerHTML));
this.doc.$("lbDescBottom").innerHTML=this.isEmpty(t)?"":(r?'<br style="line-height:0.6em;" />':"")+t; var i=0;if(this.ie&&this.ieVersion<=7||this.ieVersion>=8&&this.doc.compatMode=="BackCompat"){i=39+(this.showPrint?39:0)+(this.isSlideshow&&this.showPlayPause?39:0);if(this.isSlideshow&&this.slideArray.length>1&&this.showNavigation&&this.navType!=1||this.frameArray.length>1&&this.isLyteframe||this.imageArray.length>1&&!this.isLyteframe&&this.navType!=1){i+=39*2}}this.doc.$("lbBottomContainer").style.display=!(this.titleTop&&this.navTop)||!this.isEmpty(t)?"block":"none";if(this.titleTop&&this.navTop){if(i>0){this.doc.$("lbTopNav").style.width=i+"px"}this.doc.$("lbTopData").style.width=this.doc.$("lbTopContainer").offsetWidth-this.doc.$("lbTopNav").offsetWidth-15+"px";if(!this.isEmpty(t)){this.doc.$("lbDescBottom").style.width=this.doc.$("lbBottomContainer").offsetWidth-15+"px"}}else if((!this.titleTop||!this.isEmpty(t))&&!this.navTop){if(i>0){this.doc.$("lbBottomNav").style.width=i+"px"}this.doc.$("lbBottomData").style.width=this.doc.$("lbBottomContainer").offsetWidth-this.doc.$("lbBottomNav").offsetWidth-15+"px";
this.doc.$("lbDescBottom").style.width=this.doc.$("lbBottomData").style.width}this.fixBottomPadding();
this.aPageSize=this.getPageSize(); var s=parseInt(this.doc.$("lbMain").style.top);if(this.ie&&this.ieVersion<=7||this.ieVersion>=8&&this.doc.compatMode=="BackCompat"){s=this.ie?parseInt(this.doc.$("lbMain").style.top)-this.getPageScroll():parseInt(this.doc.$("lbMain").style.top)}var o=this.doc.$("lbOuterContainer").offsetHeight+s-this.aPageSize[3]; var u=40;if(o>0&&this.autoResize&&this.fixedPosition){if(this.ie&&(this.ieVersion<=7||this.doc.compatMode=="BackCompat")){document.body.onscroll=this.bodyOnscroll;if(window.removeEventListener){window.removeEventListener("scroll",this.scrollHandler)}else if(window.detachEvent){window.detachEvent("onscroll",this.scrollHandler)}}this.doc.$("lbMain").style.position="absolute";
this.doc.$("lbMain").style.top=this.getPageScroll()+this.aPageSize[3]/u+"px"}};
Lytebox.prototype.updateNav=function(){if(this.isSlideshow){if(this.contentNum!=0){if(this.navTypeHash["Display_by_type_"+this.navType]&&this.showNavigation){this.doc.$(this.navTop?"lbPrevTop":"lbPrev").setAttribute(this.classAttribute,this.theme);
this.doc.$(this.navTop?"lbPrevTop":"lbPrev").style.display="";
this.doc.$(this.navTop?"lbPrevTop":"lbPrev").onclick=function(){if($lb.pauseOnPrevClick){$lb.togglePlayPause($lb.navTop?"lbPauseTop":"lbPause",$lb.navTop?"lbPlayTop":"lbPlay")}$lb.changeContent($lb.contentNum-1);return false}}if(this.navTypeHash["Hover_by_type_"+this.navType]){var e=this.doc.$("lbPrevHov");e.style.display="";e.onclick=function(){if($lb.pauseOnPrevClick){$lb.togglePlayPause($lb.navTop?"lbPauseTop":"lbPause",$lb.navTop?"lbPlayTop":"lbPlay")}$lb.changeContent($lb.contentNum-1);return false}}}else{if(this.navTypeHash["Display_by_type_"+this.navType]){this.doc.$(this.navTop?"lbPrevTop":"lbPrev").setAttribute(this.classAttribute,this.theme+"Off");
this.doc.$(this.navTop?"lbPrevTop":"lbPrev").onclick=function(){return false}}}if(this.contentNum!=this.slideArray.length-1&&this.showNavigation){if(this.navTypeHash["Display_by_type_"+this.navType]){this.doc.$(this.navTop?"lbNextTop":"lbNext").setAttribute(this.classAttribute,this.theme);
this.doc.$(this.navTop?"lbNextTop":"lbNext").style.display="";
this.doc.$(this.navTop?"lbNextTop":"lbNext").onclick=function(){if($lb.pauseOnNextClick){$lb.togglePlayPause($lb.navTop?"lbPauseTop":"lbPause",$lb.navTop?"lbPlayTop":"lbPlay")}$lb.changeContent($lb.contentNum+1);return false}}if(this.navTypeHash["Hover_by_type_"+this.navType]){var e=this.doc.$("lbNextHov");e.style.display="";e.onclick=function(){if($lb.pauseOnNextClick){$lb.togglePlayPause($lb.navTop?"lbPauseTop":"lbPause",$lb.navTop?"lbPlayTop":"lbPlay")}$lb.changeContent($lb.contentNum+1);return false}}}else{if(this.navTypeHash["Display_by_type_"+this.navType]){this.doc.$(this.navTop?"lbNextTop":"lbNext").setAttribute(this.classAttribute,this.theme+"Off");
this.doc.$(this.navTop?"lbNextTop":"lbNext").onclick=function(){return false}}}}else if(this.isLyteframe){if(this.contentNum!=0){this.doc.$(this.navTop?"lbPrevTop":"lbPrev").setAttribute(this.classAttribute,this.theme);
this.doc.$(this.navTop?"lbPrevTop":"lbPrev").style.display="";
this.doc.$(this.navTop?"lbPrevTop":"lbPrev").onclick=function(){$lb.changeContent($lb.contentNum-1);return false}}else{this.doc.$(this.navTop?"lbPrevTop":"lbPrev").setAttribute(this.classAttribute,this.theme+"Off");
this.doc.$(this.navTop?"lbPrevTop":"lbPrev").onclick=function(){return false}}if(this.contentNum!=this.frameArray.length-1){this.doc.$(this.navTop?"lbNextTop":"lbNext").setAttribute(this.classAttribute,this.theme);
this.doc.$(this.navTop?"lbNextTop":"lbNext").style.display="";
this.doc.$(this.navTop?"lbNextTop":"lbNext").onclick=function(){$lb.changeContent($lb.contentNum+1);return false}}else{this.doc.$(this.navTop?"lbNextTop":"lbNext").setAttribute(this.classAttribute,this.theme+"Off");
this.doc.$(this.navTop?"lbNextTop":"lbNext").onclick=function(){return false}}}else{if(this.contentNum!=0){if(this.navTypeHash["Display_by_type_"+this.navType]){this.doc.$(this.navTop?"lbPrevTop":"lbPrev").setAttribute(this.classAttribute,this.theme);
this.doc.$(this.navTop?"lbPrevTop":"lbPrev").style.display="";
this.doc.$(this.navTop?"lbPrevTop":"lbPrev").onclick=function(){$lb.changeContent($lb.contentNum-1);return false}}if(this.navTypeHash["Hover_by_type_"+this.navType]){var t=this.doc.$("lbPrevHov");t.style.display="";t.onclick=function(){$lb.changeContent($lb.contentNum-1);return false}}}else{if(this.navTypeHash["Display_by_type_"+this.navType]){this.doc.$(this.navTop?"lbPrevTop":"lbPrev").setAttribute(this.classAttribute,this.theme+"Off");
this.doc.$(this.navTop?"lbPrevTop":"lbPrev").onclick=function(){return false}}}if(this.contentNum!=this.imageArray.length-1){if(this.navTypeHash["Display_by_type_"+this.navType]){this.doc.$(this.navTop?"lbNextTop":"lbNext").setAttribute(this.classAttribute,this.theme);
this.doc.$(this.navTop?"lbNextTop":"lbNext").style.display="";
this.doc.$(this.navTop?"lbNextTop":"lbNext").onclick=function(){$lb.changeContent($lb.contentNum+1);return false}}if(this.navTypeHash["Hover_by_type_"+this.navType]){var t=this.doc.$("lbNextHov");t.style.display="";t.onclick=function(){$lb.changeContent($lb.contentNum+1);return false}}}else{if(this.navTypeHash["Display_by_type_"+this.navType]){this.doc.$(this.navTop?"lbNextTop":"lbNext").setAttribute(this.classAttribute,this.theme+"Off");
this.doc.$(this.navTop?"lbNextTop":"lbNext").onclick=function(){return false}}}}this.enableKeyboardNav()};
Lytebox.prototype.fixBottomPadding=function(){if(!((this.ieVersion==7||this.ieVersion==8||this.ieVersion==9)&&this.doc.compatMode=="BackCompat")&&this.ieVersion!=6){var e=this.doc.$("lbTopContainer").offsetHeight+5; var t=(e==5?0:e)+this.doc.$("lbBottomContainer").offsetHeight;
this.doc.$("lbOuterContainer").style.paddingBottom=t+5+"px"}};
Lytebox.prototype.enableKeyboardNav=function(){document.onkeydown=this.keyboardAction};
Lytebox.prototype.disableKeyboardNav=function(){document.onkeydown=""};
Lytebox.prototype.keyboardAction=function(e){var t=key=escape=null;t=e==null?event.keyCode:e.which;key=String.fromCharCode(t).toLowerCase();escape=e==null?27:e.DOM_VK_ESCAPE;if(key=="x"||key=="c"||t==escape||t==27){parent.$lb.end()}else if(t==32&&$lb.isSlideshow&&$lb.showPlayPause){if($lb.isPaused){$lb.togglePlayPause($lb.navTop?"lbPlayTop":"lbPlay",$lb.navTop?"lbPauseTop":"lbPause")}else{$lb.togglePlayPause($lb.navTop?"lbPauseTop":"lbPause",$lb.navTop?"lbPlayTop":"lbPlay")}return false}else if(key=="p"||t==37){if($lb.isSlideshow){if($lb.contentNum!=0){$lb.disableKeyboardNav();$lb.changeContent($lb.contentNum-1)}}else if($lb.isLyteframe){if($lb.contentNum!=0){$lb.disableKeyboardNav();$lb.changeContent($lb.contentNum-1)}}else{if($lb.contentNum!=0){$lb.disableKeyboardNav();$lb.changeContent($lb.contentNum-1)}}}else if(key=="n"||t==39){if($lb.isSlideshow){if($lb.contentNum!=$lb.slideArray.length-1){$lb.disableKeyboardNav();$lb.changeContent($lb.contentNum+1)}}else if($lb.isLyteframe){if($lb.contentNum!=$lb.frameArray.length-1){$lb.disableKeyboardNav();$lb.changeContent($lb.contentNum+1)}}else{if($lb.contentNum!=$lb.imageArray.length-1){$lb.disableKeyboardNav();$lb.changeContent($lb.contentNum+1)}}}};
Lytebox.prototype.preloadNeighborImages=function(){if(this.isSlideshow){if(this.slideArray.length-1>this.contentNum){var e=new Image;e.src=this.slideArray[this.contentNum+1][0]}if(this.contentNum>0){var t=new Image;t.src=this.slideArray[this.contentNum-1][0]}}else{if(this.imageArray.length-1>this.contentNum){var e=new Image;e.src=this.imageArray[this.contentNum+1][0]}if(this.contentNum>0){var t=new Image;t.src=this.imageArray[this.contentNum-1][0]}}};
Lytebox.prototype.togglePlayPause=function(e,t){if(this.isSlideshow&&(e=="lbPauseTop"||e=="lbPause")){for(var n=0;n<this.slideshowIDCount;n++){window.clearTimeout(this.slideshowIDArray[n])}}this.doc.$(e).style.display="none";
this.doc.$(t).style.display="";if(e=="lbPlayTop"||e=="lbPlay"){this.isPaused=false;if(this.contentNum==this.slideArray.length-1){if(this.loopSlideshow){this.changeContent(0)}else if(this.autoEnd){this.end()}}else{this.changeContent(this.contentNum+1)}}else{this.isPaused=true}};
Lytebox.prototype.end=function(e){var t=e=="slideshow"?false:true;if(this.isSlideshow&&this.isPaused&&!t){return}if(!this.isEmpty(this.beforeEnd)){var n=window[this.beforeEnd];if(typeof n==="function"){if(!n(this.args)){return}}}this.disableKeyboardNav();document.body.onscroll=this.bodyOnscroll;if(this.refreshPage){var r=top.location.href; var i=/\#.*$/g;r=r.replace(i,"");top.location.href=r;return}this.doc.$("lbMain").style.display="none";
this.fadeOut({id:"lbOverlay",opacity:this.doAnimations&&this.animateOverlay&&(!this.ie||this.ieVersion>=9)?this.maxOpacity:0,speed:5,display:"none"});
this.toggleSelects("visible");if(this.hideObjects){this.toggleObjects("visible")}this.doc.$("lbOuterContainer").style.width="200px";
this.doc.$("lbOuterContainer").style.height="200px";if(this.inline&&this.safari){var s=this.doc.$("lbIframe"); var o=s.contentWindow||s.contentDocument;if(o.document){o=o.document}o.open();o.write("<html><head></head><body></body></html>");o.close()}if(this.isSlideshow){for(var u=0;u<this.slideshowIDCount;u++){window.clearTimeout(this.slideshowIDArray[u])}this.isPaused=false}if(!this.isEmpty(this.afterEnd)){var n=window[this.afterEnd];if(typeof n==="function"){n(this.args)}}};
Lytebox.prototype.checkFrame=function(){if(window.parent.frames[window.name]&&parent.document.getElementsByTagName("frameset").length<=0&&window.name!="lbIframe"){this.isFrame=true;
this.doc=parent.document}else{this.isFrame=false;
this.doc=document}this.doc.$=this.doc.getElementById};
Lytebox.prototype.getPixelRate=function(e,t){var n=t>e?t-e:e-t;if(n>=0&&n<=100){return 100/this.resizeDuration}if(n>100&&n<=200){return 150/this.resizeDuration}if(n>200&&n<=300){return 200/this.resizeDuration}if(n>300&&n<=400){return 250/this.resizeDuration}if(n>400&&n<=500){return 300/this.resizeDuration}if(n>500&&n<=600){return 350/this.resizeDuration}if(n>600&&n<=700){return 400/this.resizeDuration}if(n>700){return 450/this.resizeDuration}};
Lytebox.prototype.fadeIn=function(e){var t=this.isEmpty(e.id)?"":e.id; var n=this.isEmpty(e.speed)?5:parseInt(e.speed)>5?5:parseInt(e.speed);n=isNaN(n)?5:n; var r=this.isEmpty(e.opacity)?0:parseInt(e.opacity);r=isNaN(r)?0:r; var i=this.isEmpty(e.display)?"":e.display; var s=this.isEmpty(e.visibility)?"":e.visibility; var o=this.doc.$(t); var u=n;if(/lbImage|lbIframe|lbOverlay|lbBottomContainer|lbTopContainer/.test(t)){u=this.ff?this.ffVersion>=6?2:5:this.safari?3:this.ieVersion<=8?10:5;u=this.isMobile()?20:u;u=t=="lbOverlay"?u*2:u;u=t=="lbIframe"?100:u}else if(this.ieVersion==7||this.ieVersion==8){u=10}o.style.opacity=r/100;o.style.filter="alpha(opacity="+r+")";if(r>=100&&(t=="lbImage"||t=="lbIframe")){try{o.style.removeAttribute("filter")}catch(a){}this.fixBottomPadding()}else if(r>=this.maxOpacity&&t=="lbOverlay"){for(var f=0;f<this.overlayTimerCount;f++){window.clearTimeout(this.overlayTimerArray[f])}this.overlayLoaded=true;return}else if(r>=100&&(t=="lbBottomContainer"||t=="lbTopContainer")){try{o.style.removeAttribute("filter")}catch(a){}for(var f=0;f<this.imageTimerCount;f++){window.clearTimeout(this.imageTimerArray[f])}this.doc.$("lbOverlay").style.height=this.aPageSize[1]+"px"}else if(r>=100){for(var f=0;f<this.imageTimerCount;f++){window.clearTimeout(this.imageTimerArray[f])}}else{if(t=="lbOverlay"){this.overlayTimerArray[this.overlayTimerCount++]=setTimeout("$lb.fadeIn({ id: '"+t+"', opacity: "+(r+u)+", speed: "+n+" })",1)}else{this.imageTimerArray[this.imageTimerCount++]=setTimeout("$lb.fadeIn({ id: '"+t+"', opacity: "+(r+u)+", speed: "+n+" })",1)}}};
Lytebox.prototype.fadeOut=function(e){var t=this.isEmpty(e.id)?"":e.id; var n=this.isEmpty(e.speed)?5:parseInt(e.speed)>5?5:parseInt(e.speed);n=isNaN(n)?5:n; var r=this.isEmpty(e.opacity)?100:parseInt(e.opacity);r=isNaN(r)?100:r; var i=this.isEmpty(e.display)?"":e.display; var s=this.isEmpty(e.visibility)?"":e.visibility; var o=this.doc.$(t);if(this.ieVersion==7||this.ieVersion==8){n*=2}o.style.opacity=r/100;o.style.filter="alpha(opacity="+r+")";if(r<=0){try{if(!this.isEmpty(i)){o.style.display=i}if(!this.isEmpty(s)){o.style.visibility=s}}catch(u){}if(t=="lbOverlay"){this.overlayLoaded=false;if(this.isLyteframe){this.doc.$("lbIframe").src="about:blank";
this.initialize()}}else{for(var a=0;a<this.timerIDCount;a++){window.clearTimeout(this.timerIDArray[a])}}}else if(t=="lbOverlay"){this.overlayTimerArray[this.overlayTimerCount++]=setTimeout("$lb.fadeOut({ id: '"+t+"', opacity: "+(r-n*2)+", speed: "+n+", display: '"+i+"', visibility: '"+s+"' })",1)}else{this.timerIDArray[this.timerIDCount++]=setTimeout("$lb.fadeOut({ id: '"+t+"', opacity: "+(r-n)+", speed: "+n+", display: '"+i+"', visibility: '"+s+"' })",1)}};
Lytebox.prototype.resizeW=function(e,t,n,r,i){var s=this.doc.$(e); var o=this.doAnimations?t:n;s.style.width=o+"px";if(o<n){o+=o+r>=n?n-o:r}else if(o>n){o-=o-r<=n?o-n:r}this.resizeWTimerArray[this.resizeWTimerCount++]=setTimeout("$lb.resizeW('"+e+"', "+o+", "+n+", "+r+", "+i+")",i);if(parseInt(s.style.width)==n){this.wDone=true;for(var u=0;u<this.resizeWTimerCount;u++){window.clearTimeout(this.resizeWTimerArray[u])}if(this.isLyteframe){this.loadContent()}else{this.showContent()}}};
Lytebox.prototype.resizeH=function(e,t,n,r,i){var s=this.doc.$(e); var o=this.doAnimations?t:n;s.style.height=o+"px";if(o<n){o+=o+r>=n?n-o:r}else if(o>n){o-=o-r<=n?o-n:r}this.resizeHTimerArray[this.resizeHTimerCount++]=setTimeout("$lb.resizeH('"+e+"', "+o+", "+n+", "+r+", "+(i+.02)+")",i+.02);if(parseInt(s.style.height)==n){this.hDone=true;for(var u=0;u<this.resizeHTimerCount;u++){window.clearTimeout(this.resizeHTimerArray[u])}this.resizeW("lbOuterContainer",this.wCur,this.resizeWidth+this.borderSize*2,this.getPixelRate(this.wCur,this.resizeWidth))}};
Lytebox.prototype.getPageScroll=function(){if(self.pageYOffset){return this.isFrame?parent.pageYOffset:self.pageYOffset}else if(this.doc.documentElement&&this.doc.documentElement.scrollTop){return this.doc.documentElement.scrollTop}else if(document.body){return this.doc.body.scrollTop}};
Lytebox.prototype.getPageSize=function(){var e,t,n,r;if(window.innerHeight&&window.scrollMaxY){e=this.doc.scrollWidth;t=(this.isFrame?parent.innerHeight:self.innerHeight)+(this.isFrame?parent.scrollMaxY:self.scrollMaxY)}else if(this.doc.body.scrollHeight>this.doc.body.offsetHeight){e=this.doc.body.scrollWidth;t=this.doc.body.scrollHeight}else{e=this.doc.getElementsByTagName("html").item(0).offsetWidth;t=this.doc.getElementsByTagName("html").item(0).offsetHeight;e=e<this.doc.body.offsetWidth?this.doc.body.offsetWidth:e;t=t<this.doc.body.offsetHeight?this.doc.body.offsetHeight:t}if(self.innerHeight){n=this.isFrame?parent.innerWidth:self.innerWidth;r=this.isFrame?parent.innerHeight:self.innerHeight}else if(document.documentElement&&document.documentElement.clientHeight){n=this.doc.documentElement.clientWidth;r=this.doc.documentElement.clientHeight;n=n==0?this.doc.body.clientWidth:n;r=r==0?this.doc.body.clientHeight:r}else if(document.body){n=this.doc.getElementsByTagName("html").item(0).clientWidth;r=this.doc.getElementsByTagName("html").item(0).clientHeight;n=n==0?this.doc.body.clientWidth:n;r=r==0?this.doc.body.clientHeight:r}var i=t<r?r:t; var s=e<n?n:e;return new Array(s,i,n,r)};
Lytebox.prototype.toggleObjects=function(e){var t=this.doc.getElementsByTagName("object");for(var n=0;n<t.length;n++){t[n].style.visibility=e=="hide"?"hidden":"visible"}var r=this.doc.getElementsByTagName("embed");for(var n=0;n<r.length;n++){r[n].style.visibility=e=="hide"?"hidden":"visible"}if(this.isFrame){for(var n=0;n<parent.frames.length;n++){try{t=parent.frames[n].window.document.getElementsByTagName("object");for(var i=0;i<t.length;i++){t[i].style.visibility=e=="hide"?"hidden":"visible"}}catch(s){}try{r=parent.frames[n].window.document.getElementsByTagName("embed");for(var i=0;i<r.length;i++){r[i].style.visibility=e=="hide"?"hidden":"visible"}}catch(s){}}}};
Lytebox.prototype.toggleSelects=function(e){var t=this.doc.getElementsByTagName("select");for(var n=0;n<t.length;n++){t[n].style.visibility=e=="hide"?"hidden":"visible"}if(this.isFrame){for(var n=0;n<parent.frames.length;n++){try{t=parent.frames[n].window.document.getElementsByTagName("select");for(var r=0;r<t.length;r++){t[r].style.visibility=e=="hide"?"hidden":"visible"}}catch(i){}}}};
Lytebox.prototype.pause=function(e){var t=new Date; var n=t.getTime()+e;while(true){t=new Date;if(t.getTime()>n){return}}};
Lytebox.prototype.combine=function(e,t){var n=[];for(var r=0;r<e.length;r++){n.push(e[r])}for(var r=0;r<t.length;r++){n.push(t[r])}return n};
Lytebox.prototype.removeDuplicates=function(e){var t=new Array;e:for(var n=0,r=e.length;n<r;n++){for(var i=0,s=t.length;i<s;i++){if(t[i][0].toLowerCase()==e[n][0].toLowerCase()){continue e}}t[t.length]=e[n]}return t};
Lytebox.prototype.printWindow=function(){var e=this.isLyteframe?800:this.imgPreloader.width+20; var t=this.isLyteframe?600:this.imgPreloader.height+20; var n=parseInt(screen.availWidth/2-e/2); var r=parseInt(screen.availHeight/2-t/2); var i="width="+e+",height="+t+",left="+n+",top="+r+"screenX="+n+",screenY="+r+"directories=0,location=0,menubar=0,resizable=0,scrollbars=0,status=0,titlebar=0,toolbar=0"; var s=new Date; var o="Print"+s.getTime(); var u=document.getElementById(this.printId).src;
this.wContent=window.open(u,o,i);
this.wContent.focus(); var a=setTimeout("$lb.printContent()",1e3)};
Lytebox.prototype.printContent=function(){try{if(this.wContent.document.readyState=="complete"){this.wContent.print();
this.wContent.close();
this.wContent=null}else{var e=setTimeout("$lb.printContent()",1e3)}}catch(t){}};
Lytebox.prototype.setOptions=function(e){this.args="";
this.group="";
this.inline=false;
this.hideObjects=this.__hideObjects;
this.autoResize=this.__autoResize;
this.doAnimations=this.__doAnimations;
this.animateOverlay=this.__animateOverlay;
this.forceCloseClick=this.__forceCloseClick;
this.refreshPage=this.__refreshPage;
this.showPrint=this.__showPrint;
this.navType=this.__navType;
this.titleTop=this.__titleTop;
this.navTop=this.__navTop;
this.beforeStart=this.__beforeStart;
this.afterStart=this.__afterStart;
this.beforeEnd=this.__beforeEnd;
this.afterEnd=this.__afterEnd;
this.scrolling=this.__scrolling;
this.width=this.__width;
this.height=this.__height;
this.loopPlayback=this.__loopPlayback;
this.autoPlay=this.__autoPlay;
this.autoEmbed=this.__autoEmbed;
this.slideInterval=this.__slideInterval;
this.showNavigation=this.__showNavigation;
this.showClose=this.__showClose;
this.showDetails=this.__showDetails;
this.showPlayPause=this.__showPlayPause;
this.autoEnd=this.__autoEnd;
this.pauseOnNextClick=this.__pauseOnNextClick;
this.pauseOnPrevClick=this.__pauseOnPrevClick;
this.loopSlideshow=this.__loopSlideshow;
var t=sValue=""; var n=null; var r=e.split(" ");for(var i=0;i<r.length;i++){n=r[i].split(":");t=n.length>1?this.trim(n[0]).toLowerCase():"";sValue=n.length>1?this.trim(n[1]):"";switch(t){case"group":this.group=t=="group"?!this.isEmpty(sValue)?sValue.toLowerCase():"":"";break;case"hideobjects":this.hideObjects=/true|false/.test(sValue)?sValue=="true":this.__hideObjects;break;case"autoresize":this.autoResize=/true|false/.test(sValue)?sValue=="true":this.__autoResize;break;case"doanimations":this.doAnimations=/true|false/.test(sValue)?sValue=="true":this.__doAnimations;break;case"animateoverlay":this.animateOverlay=/true|false/.test(sValue)?sValue=="true":this.__animateOverlay;break;case"forcecloseclick":this.forceCloseClick=/true|false/.test(sValue)?sValue=="true":this.__forceCloseClick;break;case"refreshpage":this.refreshPage=/true|false/.test(sValue)?sValue=="true":this.__refreshPage;break;case"showprint":this.showPrint=/true|false/.test(sValue)?sValue=="true":this.__showPrint;break;case"navtype":this.navType=/[1-3]{1}/.test(sValue)?parseInt(sValue):this.__navType;break;case"titletop":this.titleTop=/true|false/.test(sValue)?sValue=="true":this.__titleTop;break;case"navtop":this.navTop=/true|false/.test(sValue)?sValue=="true":this.__navTop;break;case"beforestart":this.beforeStart=!this.isEmpty(sValue)?sValue:this.__beforeStart;break;case"afterstart":this.afterStart=!this.isEmpty(sValue)?sValue:this.__afterStart;break;case"beforeend":this.beforeEnd=!this.isEmpty(sValue)?sValue:this.__beforeEnd;break;case"afterend":this.afterEnd=!this.isEmpty(sValue)?sValue:this.__afterEnd;break;case"args":this.args=!this.isEmpty(sValue)?sValue:"";break;case"scrollbars":this.scrolling=/auto|yes|no/.test(sValue)?sValue:this.__scrolling;break;case"scrolling":this.scrolling=/auto|yes|no/.test(sValue)?sValue:this.__scrolling;break;case"width":this.width=/\d(%|px|)/.test(sValue)?sValue:this.__width;break;case"height":this.height=/\d(%|px|)/.test(sValue)?sValue:this.__height;break;case"loopplayback":this.loopPlayback=/true|false/.test(sValue)?sValue=="true":this.__loopPlayback;break;case"autoplay":this.autoPlay=/true|false/.test(sValue)?sValue=="true":this.__autoPlay;break;case"autoembed":this.autoEmbed=/true|false/.test(sValue)?sValue=="true":this.__autoEmbed;break;case"inline":this.inline=/true|false/.test(sValue)?sValue=="true":false;case"slideinterval":this.slideInterval=/\d/.test(sValue)?parseInt(sValue):this.__slideInterval;break;case"shownavigation":this.showNavigation=/true|false/.test(sValue)?sValue=="true":this.__showNavigation;break;case"showclose":this.showClose=/true|false/.test(sValue)?sValue=="true":this.__showClose;break;case"showdetails":this.showDetails=/true|false/.test(sValue)?sValue=="true":this.__showDetails;break;case"showplaypause":this.showPlayPause=/true|false/.test(sValue)?sValue=="true":this.__showPlayPause;break;case"autoend":this.autoEnd=/true|false/.test(sValue)?sValue=="true":this.__autoEnd;break;case"pauseonnextclick":this.pauseOnNextClick=/true|false/.test(sValue)?sValue=="true":this.__pauseOnNextClick;break;case"pauseonprevclick":this.pauseOnPrevClick=/true|false/.test(sValue)?sValue=="true":this.__pauseOnPrevClick;break;case"loopslideshow":this.loopSlideshow=/true|false/.test(sValue)?sValue=="true":this.__loopSlideshow;break}}};
Lytebox.prototype.buildObject=function(e,t,n){var r=""; var i=""; var s=""; var o=""; var u=this.autoPlay?"true":"false"; var a=this.loopPlayback?"true":"false";
var f=n.match(/.mov|.mp4|.mpg|.webm|.wav|.mp3|.m4a/i);
switch(f[0]) {
case '.mov':
case '.mp4':
case '.mpg':
	r = '<video style="width:' + e + 'px; height:' + t + 'px;" controls>'
		+ '<source src="' + n + '" type="video/mp4" />'
		+ 'Media element is not supported'
		+ '</video>';
	break;
case '.webm':
	r = '<video style="width:' + e + 'px; height:' + t + 'px;" controls>'
		+ '<source src="' + n + '" type="video/webm" />'
		+ 'Media element is not supported'
		+ '</video>';
	break;
case '.mp3':
case '.m4a':
	r = '<audio style="width:' + e + 'px; height:' + t + 'px;" controls>'
		+ '<source src="' + n + '" type="audio/mpeg" />'
		+ 'Media element is not supported'
		+ '</audio>';
	break;
case '.wav':
	r = '<audio style="width:' + e + 'px; height:' + t + 'px;" controls>'
		+ '<source src="' + n + '" type="audio/wav" />'
		+ 'Media element is not supported'
		+ '</audio>';
	break;
}
return r};
Lytebox.prototype.findPos=function(e){if(this.ie&&this.doc.compatMode=="BackCompat"){return[0,16,12]}var t=0; var n=0; var r=0;r=e.offsetHeight+6;if(e.offsetParent){do{t+=e.offsetLeft;n+=e.offsetTop}while(e=e.offsetParent)}return[t,n,r]};
Lytebox.prototype.isMobile=function(){var e=navigator.userAgent;return e.match(/ipad/i)!=null||e.match(/ipod/i)!=null||e.match(/iphone/i)!=null||e.match(/android/i)!=null||e.match(/opera mini/i)!=null||e.match(/blackberry/i)!=null||e.match(/(pre\/|palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i)!=null||e.match(/(iris|3g_t|windows ce|opera mobi|windows ce; smartphone;|windows ce; iemobile)/i)!=null||e.match(/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|m881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|s800|8325rc|ac831|mw200|brew |d88|htc\/|htc_touch|355x|m50|km100|d736|p-9521|telco|sl74|ktouch|m4u\/|me702|8325rc|kddi|phone|lg |sonyericsson|samsung|240x|x320|vx10|nokia|sony cmd|motorola|up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|psp|treo)/i)!=null};
Lytebox.prototype.validate=function(e){var t=sName=""; var n=false; var r=this.isEmpty(e.id)?this.isEmpty(e.element)?null:e.element:document.getElementById(e.id); var i=this.isEmpty(e.value)?"":String(e.value); var s=this.isEmpty(e.type)?"":String(e.type).toLowerCase(); var o=this.isEmpty(e.regex)?"":e.regex; var u=/visa|mc|amex|diners|discover|jcb/.test(e.ccType)?e.ccType:""; var a=this.isEmpty(e.imageType)?"":String(e.imageType.toLowerCase()); var f=/^\d+$/.test(e.min)?parseInt(e.min):0; var l=/^\d+$/.test(e.max)?parseInt(e.max):0; var c=e.inclusive?true:/true|false/.test(e.inclusive)?e.inclusive=="true":true; var h=e.allowComma?true:/true|false/.test(e.allowComma)?e.allowComma=="true":true; var p=e.allowWhiteSpace?true:/true|false/.test(e.allowWhiteSpace)?e.allowWhiteSpace=="true":true;if(this.isEmpty(i)&&this.isEmpty(r)||this.isEmpty(s)&&this.isEmpty(o)){return false} var i=this.isEmpty(i)?r.value:i;if(!this.isEmpty(o)){n=o.test(i)} else {switch(s){case"alnum":n=p?/^[a-z0-9\s]+$/i.test(i):/^[a-z0-9]+$/i.test(i);break;case"alpha":n=p?/^[a-z\s]+$/i.test(i):/^[a-z]+$/i.test(i);break;case"between":var d=h?parseInt(i.replace(/\,/g,"")):parseInt(i);n=c?d>=f&&d<=l:d>f&&d<l;break;case"ccnum":if(this.isEmpty(u)){n=/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6(?:011|5[0-9][0-9])[0-9]{12}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|(?:2131|1800|35\d{3})\d{11})$/.test(i);break}else{switch(u){case"visa":n=/^4[0-9]{12}(?:[0-9]{3})?$/.test(i);break;case"mc":n=/^5[1-5][0-9]{14}$/.test(i);break;case"amex":n=/^3[47][0-9]{13}$/.test(i);break;case"diners":n=/^3(?:0[0-5]|[68][0-9])[0-9]{11}$/.test(i);break;case"discover":n=/^6(?:011|5[0-9]{2})[0-9]{12}$/.test(i);break;case"jcb":n=/^(?:2131|1800|35\d{3})\d{11}$/.test(i);break;default:n=false}};case"date":var v=new Date(i);n=!(v.toString()=="NaN"||v.toString()=="Invalid Date");break;case"digits":n=/^\d+$/.test(i);break;case"email":n=/^([a-z0-9_\.\-])+\@(([a-z0-9\-])+\.)+([a-z0-9]{2,4})+$/i.test(i);break;case"float":n=/^[-+]?[0-9]*\.?[0-9]+$/.test(h?i.replace(/\,/g,""):i);break;case"image":if(this.isEmpty(a)){n=/^(png|jpg|jpeg|gif)$/i.test(i.split(".").pop());break}else{n=i.split(".").pop().toLowerCase().match(a)?true:false;break};case"int":case"integer":n=/^[-+]?\d+$/.test(i.replace(/\,/g,""));break;case"len":case"length":n=f==l?i.length==f:i.length>=f&&i.length<=l;break;case"phone":n=/^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/.test(i);break;case"notempty":n=!this.isEmpty(i);break;case"ssn":n=/^[0-9]{3}\-?[0-9]{2}\-?[0-9]{4}$/.test(i);break;case"url":n=/\b((?:[a-z][\w-]+:(?:\/{1,3}|[a-z0-9%])|www\d{0,3}[.]|[a-z0-9.\-]+[.][a-z]{2,4}\/)(?:[^\s()<>]+|\(([^\s()<>]+|(\([^\s()<>]+\)))*\))+(?:\(([^\s()<>]+|(\([^\s()<>]+\)))*\)|[^\s`!()\[\]{};:'".,<>?«»""'']))/i.test(i); break; case"zip":n=/^\d{5}$|^\d{5}-\d{4}$/.test(i); break}} return n};
Lytebox.prototype.ajax=function(e){var t=this.http.length; var n=this.getRequestObject();
this.http[t]=n; var r=e;r.index=t;r.method=!/get|post/i.test(r.method)?"get":r.method;r.cache=!/true|false/.test(r.cache)?true:r.cache=="true"||r.cache;if(!this.isEmpty(r.timeout)&&/^\d+$/.test(r.timeout)){r.timerId=setTimeout("$lb.http["+t+"].abort()",r.timeout)}n.onreadystatechange=function(){return function(){if(n.readyState==4&&n.status==200){if(document.getElementById(r.updateId)){try{document.getElementById(r.updateId).innerHTML=n.responseText}catch(e){alert(e.description)}}if(typeof r.success==="function"){r.success(n)}window.clearTimeout(r.timerId);$lb.http[r.index]=null}else if(n.readyState==4&&n.status!=200){if(typeof r.fail==="function"){r.fail(n)}window.clearTimeout(r.timerId);$lb.http[r.index]=null}}(n,r)};if(r.method.toLowerCase()=="post"){var i=document.getElementById(r.form); var s=!/true|false/.test(e.stripTags)?false:e.stripTags=="true"||e.stripTags; var o=i==null?this.serialize({name:r.form,stripTags:s}):this.serialize({element:i,stripTags:s}); var u=!r.cache?(/\&/.test(o)?"&":"")+(new Date).getTime():"";n.open("post",r.url,true);n.setRequestHeader("Content-type","application/x-www-form-urlencoded");n.send(o+u)}else{var u=!r.cache?(/\?/.test(r.url)?"&":"?")+(new Date).getTime():"";n.open("get",r.url+u,true);n.send()}};
Lytebox.prototype.serialize=function(e){var t=sValue=""; var n=!/true|false/.test(e.stripTags)?false:e.stripTags=="true"||e.stripTags; var r=this.isEmpty(e.id)?this.isEmpty(e.element)?null:e.element:document.getElementById(e.id);if(r==null){for(var i=0;i<document.forms.length;i++){if(document.forms[i].name==e.name){r=document.forms[i].elements}}}for(var i=0;i<r.length;i++){if(r[i].type=="checkbox"&&!r[i].checked||r[i].type=="radio"&&!r[i].checked||r[i].disabled||r[i].name==""||r[i].type=="reset"){continue}if(r[i].type=="select-multiple"){for(var s=0;s<r[i].options.length;s++){if(r[i].options[s].selected==true){t+=(t==""?"":"&")+r[i].name+"="+encodeURIComponent(r[i].options[s].value)}}}else{sValue=n?this.stripTags({value:r[i].value}):r[i].value;t+=(t==""?"":"&")+r[i].name+"="+encodeURIComponent(sValue)}}return t};
Lytebox.prototype.getRequestObject=function(){var e=null;if(window.XMLHttpRequest){try{e=new XMLHttpRequest}catch(t){}}else if(typeof ActiveXObject!="undefined"){try{e=new ActiveXObject("Msxml2.XMLHTTP")}catch(t){try{e=new ActiveXObject("Microsoft.XMLHTTP")}catch(t){}}}return e};
Lytebox.prototype.isEmpty=function(e){var t="";try{t=this.isEmpty(e.value)?e:e.value}catch(n){t=e}return this.trim(t)==""||t=="null"||t==null||typeof t=="undefined"};
Lytebox.prototype.stripTags=function(e){var t=this.isEmpty(e.id)?this.isEmpty(e.element)?null:e.element:document.getElementById(e.id);if(!this.isEmpty(t)){t.value=String(t.value).replace(/(<([^>]+)>)/ig,"")}else{var n="";try{n=this.isEmpty(e.value)?e:e.value}catch(r){n=e}return this.trim(n)=="[object Object]"?"":String(n).replace(/(<([^>]+)>)/ig,"")}};
Lytebox.prototype.trim=function(e){var t="";try{t=this.isEmpty(e.value)?e:e.value}catch(n){t=e}return String(t).replace(/^\s+|\s+$/g,"")};
Lytebox.prototype.capitalize=function(e){return String(e.value?e.value:e).replace(/(^|\s)([a-z])/g,function(e,t,n){return t+n.toUpperCase()})};
Lytebox.prototype.hasClass=function(e){var t=this.isEmpty(e.name)?"":e.name; var n=this.isEmpty(e.id)?this.isEmpty(e.element)?null:e.element:document.getElementById(e.id);return(new RegExp("(\\s|^)"+t+"(\\s|$)")).test(n.className)};
Lytebox.prototype.addClass=function(e){var t=this.isEmpty(e.name)?"":e.name; var n=this.isEmpty(e.id)?this.isEmpty(e.element)?null:e.element:document.getElementById(e.id); var r=t.split(" ");for(var i=0;i<r.length;i++){if(!this.hasClass({element:n,name:r[i]})){n.className+=" "+r[i]}}};
Lytebox.prototype.removeClass=function(e){var t=this.isEmpty(e.name)?"":e.name; var n=this.isEmpty(e.id)?this.isEmpty(e.element)?null:e.element:document.getElementById(e.id); var r=t.split(" ");for(var i=0;i<r.length;i++){if(this.hasClass({element:n,name:r[i]})){n.className=n.className.replace(new RegExp("(\\s|^)"+r[i]+"(\\s|$)")," ").replace(/\s+/g," ").replace(/^\s|\s$/,"")}}};if(window.addEventListener){window.addEventListener("load",initLytebox,false)}else if(window.attachEvent){window.attachEvent("onload",initLytebox)}else{window.onload=function(){initLytebox()}}myLytebox=$lb=new Lytebox(false);


