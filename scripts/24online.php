<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 



























<html>
<head>

		<TITLE>24Online Client</TITLE>		


<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">


	<meta http-equiv="cache-control" content="max-age=0, must-revalidate, no-cache, no-store, private">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="expires" content="-1">
 
<STYLE>.mystyle1 { FONT-FAMILY:Arial;FONT-SIZE:10;}.text1 {  font-family: Arial; font-size: 11px}
</STYLE>
<style type="text/css">
   <!--
     body {
     height: 100%;
     margin: 0;
     padding: 0;
    }
   //-->
  </style>

	<link rel="stylesheet" href="/css/cyberoam.css">
	<link rel="stylesheet" href="/css/fck_editorarea.css">

<script language="JavaScript" src="/javascript/cyberoam.js"></script>
</head>

<script language="JavaScript" src="/javascript/utilities.js"></script>
<!-- script language="JavaScript" src="/javascript/usagecounter.js"></script-->
<SCRIPT LANGUAGE="JavaScript" SRC="/javascript/ajax.js"></SCRIPT>
<script language="JavaScript"> 
	re = /\w{1,}/;
	rew=/\W{1,}/;
	usernamere=/^[a-zA-Z0-9_\.]{1,30}$/;
	
	var hotelUserWin = null;
	var dt=new Date();
	dt.setHours("19");
	dt.setMinutes("59");
	dt.setSeconds("29");	
	dt.setDate("23");
	dt.setMonth("10");	
	dt.setYear("2013");	
	var d=new Date();	
	
	function openMyAccountWindow(){
		window.open("/myaccount.html",'_person')
	}
	
	function changeBandwidth(){
		var scrw = window.screen.availWidth;
		var scrh = window.screen.availHeight;
		var w =scrw-120;
		var h =scrh-150;
		var left = (scrw-w)/2;
		var top = 5;
		window.open('/24online/webpages/redirectclientgui.jsp?key=ChangeBWOnDemandURL&username=cyberpoision_sky','_blank','screenX=0,screenY=0,left='+left+',top='+top+',width=' + w + ',height=' + h +  ',titlebar=0,scrollbars=1');
	}
	
	function doNothing(){
		
	}


	/* call to ajax */
	function showAlert(){
			var funToCall=popup;
			var er=doNothing;
			var url = "/24online/servlet/AjaxManager?mode=754&username=cyberpoision_sky"
			AJAXRequest_async(url,funToCall,er);
		
	}
	
	/* this function get the message from XML document  */
	function popup(){
		
		var xmlDoc = req.responseXML.documentElement;
		var message = xmlDoc.getElementsByTagName("message");
		message = message[0].firstChild.data;
		var dtold = new Date();
		alert(message);
		var dtnew = new Date();
		var timeGap=dtnew.getTime()-dtold.getTime();
		timeGap=parseInt(timeGap/1000);
		document.forms[0].popupalert.value="0";
		document.forms[0].sessionTimeout.value=document.forms[0].sessionTimeout.value-timeGap;
	}
	
/* this get the Data related to usage from XML */
function getData(){
		
	//alert("get Data");
	var xmlDoc = req.responseXML.documentElement;

	var input = xmlDoc.getElementsByTagName("input");
	input = input[0].firstChild.data;

	var output = xmlDoc.getElementsByTagName("output");
	output = output[0].firstChild.data;

	var total = xmlDoc.getElementsByTagName("total");
	total = total[0].firstChild.data;

	var timeout = xmlDoc.getElementsByTagName("timeout");
	timeout = timeout[0].firstChild.data;
	
	var logout=xmlDoc.getElementsByTagName("logout");
	logout = logout[0].firstChild.data;

	var useddatatransfer = xmlDoc.getElementsByTagName("useddatatransfer");
	useddatatransfer = useddatatransfer[0].firstChild.data;		
	document.getElementById('useddatatransfer').innerHTML =ByteConversion( useddatatransfer);		

	var expiredate = xmlDoc.getElementsByTagName("expiredate");
	expiredate = expiredate[0].firstChild.data;		
	document.getElementById('expiredate').innerHTML = expiredate;

	var packageamount = xmlDoc.getElementsByTagName("packageamount");
	packageamount = packageamount[0].firstChild.data;
	document.getElementById('packageamount').innerHTML = packageamount;
	
	if(logout==1){
		logoutUser();
		return;
	}

	
	/* unlimited usage for unlimited time */	
	if(input==-1 && output==-1 && total==-1 && timeout==-1){

		document.getElementById("inOctets").innerHTML="Not Applicable";
		document.getElementById("outOctets").innerHTML="Not Applicable";
		document.getElementById("totalOctets").innerHTML="Not Applicable";
		document.getElementById("outOctets").innerHTML="Not Applicable";
	}

	/* only total is availabe*/
	if(total > 0){
		var str=ByteConversion(total);
		document.getElementById("totalOctets").innerHTML=str;
		document.getElementById("inOctets").innerHTML="Not Applicable";
		document.getElementById("outOctets").innerHTML="Not Applicable";
					
	}else{
		
		document.getElementById("totalOctets").innerHTML="Not Applicable";
	
		if(input > 0){
			var str=ByteConversion(input);
			document.getElementById("inOctets").innerHTML=str;
		}else{
			document.getElementById("inOctets").innerHTML="Unlimited";
		}
		
		if(output > 0){
			var str=ByteConversion(output);
			document.getElementById("outOctets").innerHTML=str;
			
		}else{
			document.getElementById("outOctets").innerHTML="Unlimited";	
		}
	}

	if(timeout > 0 ){
		getTime(timeout);
	}else if(timeout==-1){
	
		document.getElementById("sessionTime").innerHTML="Not Applicable";
		document.forms[0].sessionTimeout.value="Not Applicable";
		
	}
}
		
	
	/* this function get the time from XML document  */
	function getTime(timeout){
		var newSessiontime=timeout;
		var orgSessiontime = parseInt(document.forms[0].orgSessionTimeout.value);
		var Sessiontime=parseInt(document.forms[0].sessionTimeout.value);
		var diffSessiontime = orgSessiontime - Sessiontime;
		newSessiontime=newSessiontime-diffSessiontime;
		document.forms[0].sessionTimeout.value = newSessiontime;
		document.forms[0].orgSessionTimeout.value = timeout;
	}

	function err(){

	}

	/* detect touch in iPad and other touch sensitive device */
	try{
	document.addEventListener('touchstart', function(event) {
	//    alert(event.touches.length);
	
			if(document.forms[0].chrome.value==0 && true){
				byteReducer();
				document.forms[0].chrome.value=1;
			}	
		}, false);
	}catch(err){

	}
	
	/* This function call when body has focus and set the value */
	function gotFocus(){
		if(document.forms[0].chrome.value==0 && true){
			byteReducer();
			document.forms[0].chrome.value=1;
		}		
	}

	/* This function call when body has focus */
	function lostFocus(){

		/*if(isChrome()){
			document.forms[0].chrome.value=0;
		}*/	
	}

	
	/* this function call the ajax for byte reducer */
	function startByteReducer(){
		document.forms[0].chrome.value=0;		
		setTimeout("startByteReducer()",600000);
	}

	
	/* call to ajax */
	function  byteReducer(){
		//alert("byte reducer start");
		
	}
	
	function setCurrentTimeDate(){
		dt.setMinutes(dt.getMinutes()+1);
		var date= getDayOfWeek(dt.getDay())+" , "+dt.getDate()+" "+getMonth(dt.getMonth())+" , "+dt.getFullYear();
		var time=dt.getHours()+" : "+dt.getMinutes()+" hours";
		var lblTime=document.getElementById('time');
		var lblDate=document.getElementById('date');
		if(lblTime!=null){
			lblTime.innerHTML = time;
		}
		if(lblDate!=null){
			lblDate.innerHTML = date;
		}
		setTimeout("setCurrentTimeDate()",60000);	
	}
	function refreshLiveRequest(liveRequestTime,isfirsttime){
		
		setTimeout("refreshLiveRequest("+liveRequestTime+",false)",liveRequestTime);
		window.open('/24online/webpages/liverequest.jsp?isfirsttime='+isfirsttime,'livebar');
	}
	// SEND LIVE UPDATE REQ TO A PORT WHERE NO PROCESSING OCCURS SO THAT LOAD ON APACHE IS REDUCED
	// AND THIS ALSO KEEPS THE USER LIVE TO AVOID IDLE-TIMEOUT.
	function sendLiveUpdate(isfirsttime){
		if(isfirsttime == '1'){
			isfirsttime = '0';
		}else{
			iframeliveupd.location.href='http://10.10.0.1:9090/';
		}
		setTimeout("sendLiveUpdate("+isfirsttime+")",180000);
	}
	
	function validateLogout(){
		document.forms[0].mode.value='193';	
		document.forms[0].checkClose.value='1';
	}
	function validateLogin(){
		
			
				if (!(re.test(document.forms[0].username.value))){
						alert('Please enter the User Name');
						document.forms[0].username.focus();
						return false;
					}
				
					
				if(document.forms[0].password.value==''){
					alert('please enter password');
					document.forms[0].password.focus();
					return false;
				}
				
		
		targ=document.getElementsByName('chkcond')[0];
		if(targ != null && !document.forms[0].chkcond.checked){
			alert('Please Read and Agree Terms and Conditions.');
			document.forms[0].chkcond.focus();
			return false;
		}
		
					
		
			document.forms[0].mode.value='191';
		
		document.forms[0].checkClose.value='1';
	}
	function validateLoginAndSubmit(){
		if (!(re.test(document.forms[0].username.value))){
			alert('Please enter the Coupon Id');
			document.forms[0].username.focus();
			return false;
		}		
	
		if(document.forms[0].password.value==''){
			alert('please enter password');
			document.forms[0].password.focus();
			return false;
		}
		
		document.forms[0].mode.value='191';
		document.forms[0].checkClose.value='1';
		document.forms[0].method='post';			
		return true;
	}
	function buycouponnow(){
	        location.href="/24online/webpages/paymentgateway/onlinepinpurchase.jsp"
	}
	
	function logoutUser(){
		document.forms[0].mode.value='193';	
		document.forms[0].checkClose.value='1';
		document.forms[0].method='post';
		document.forms[0].submit();	
	}
	
	var message="© Cyberoam-Client";
	function click(e){
		if (document.all) {
			if (event.button == 1 || event.button == 2) {
				alert(message);
				return false;
			}
		}
		if (document.layers) {
			if (e.which == 3) {
				alert(message);
				return false;
			}
		}
	}
	if (document.layers) {
		document.enableExternalCapture();
		document.captureEvents(Event.MOUSEDOWN);
	}
	//document.onmousedown=click;
	function blurobj(obj){ 
		obj.style.backgroundColor="lightgrey";
		obj.disabled = true ;
	}
	function callAdministrator(){
		window.open("/24online/webpages/calladmin.jsp","CallAdmin","dialogHeight=5;dialogWidth=35;center=1;status=0;resizable=0;help=0");
		
	}
	
	function openBuyNewPackage(){
			
		
			var scrw = window.screen.availWidth;
			var scrh = window.screen.availHeight;
		
			var w = scrw-120;
			var h = scrh-150;
			var left = (scrw-w)/2;
			var top = 5;
			
			window.open('/24online/buypkgusing_pgway.html','_blank','screenX=0,screenY=0,left='+left+',top='+top+',width=' + w + ',height=' + h +  ',resizable=1,status=1,titlebar=0,menubar=1,toolbar=1,location=1,scrollbars=1');
		
				
	}
	
	function openMyAccountLogin(){
		
			var scrw = window.screen.availWidth;
			var scrh = window.screen.availHeight; 
		
			var w = scrw-120;
			var h = scrh-150;
			var left = (scrw-w)/2;
			var top = 5;
			window.open('/24online/myaccount.html','_blank','screenX=0,screenY=0,left='+left+',top='+top+',width=' + w + ',height=' + h +  ',resizable=1,status=1,titlebar=0,menubar=1,toolbar=1,location=1,scrollbars=1');
				
	}
	
	function openRenewPackageByPaymentGateway(){
	
		var scrw = window.screen.availWidth;
		var scrh = window.screen.availHeight;
		
		var w =scrw-120;
		var h =scrh-150;
		
		var left = (scrw-w)/2;
		var top = 5;	
				
		window.open('/24online/renewusing_pgway.html','_blank','screenX=0,screenY=0,left='+left+',top='+top+',width=' + w + ',height=' + h +  ',resizable=1,status=1,titlebar=0,menubar=1,toolbar=1,location=1,scrollbars=1');
	}
	
	function openHotelUserRegistration(){
	
		var scrw = window.screen.availWidth;
		var scrh = window.screen.availHeight;
		
		var w =scrw-120;
		var h =scrh-150;
		
		var left = (scrw-w)/2;
		var top = 5;
				
		if(hotelUserWin == null || hotelUserWin.closed){
			hotelUserWin = window.open('/24online/webpages/hoteluserregistration.jsp','_blank','screenX=0,screenY=0,left='+left+',top='+top+',width=' + w + ',height=' + h +  ',resizable=1,status=1,titlebar=0,menubar=1,toolbar=1,location=1,scrollbars=1');
		}else{	
			hotelUserWin.focus();
		}	
		
	}
	
	function accessHotelUserWindowParam(){
				
	
	}
	function sendGuestMsgRequest(){
		alert("Your request for Guest Messages has been sent.\nMessage(s) will be displayed in a short while.");
		var scrw = window.screen.availWidth;
		var w =scrw-180;
		window.open('/24online/webpages/myaccount/guestmessages.jsp?username=cyberpoision_sky','guestmsg','resizable=1,status=1,width='+w);
		/*document.clientloginform.mode.value="";
		document.clientloginform.guestmsgreq.value="true";
		document.clientloginform.method="post";
		document.clientloginform.submit();*/
	}
	function sendGuestBillReq(){
		var scrw = window.screen.availWidth;
		var scrh = window.screen.availHeight;
		var w =scrw-120;
		var h =scrh-150;
		var left = (scrw-w)/2;
		var top = 5;	
		window.open('/24online/webpages/hoteluserregistration.jsp?pwdmode=514','_blank','screenX=0,screenY=0,left='+left+',top='+top+',width=' + w + ',height=' + h +  ',titlebar=yes,scrollbars=yes');
	}

	// functions for loading Package Details
	
	function loadPackageDetails() {	   
		// Sending AJAX Request with user name and respective mode	
		
	} //Return from AJAX
	
	function parsePackageDetails(){		
		var xmlDoc = req.responseXML.documentElement;		
		
		var allottedtime = xmlDoc.getElementsByTagName("allottedtime");
		allottedtime = allottedtime[0].firstChild.data;		
		document.getElementById('allottedtime').innerHTML = allottedtime;
		
		var packageamount = xmlDoc.getElementsByTagName("packageamount");
		packageamount = packageamount[0].firstChild.data;
		document.getElementById('packageamount').innerHTML = packageamount;
		
		var expiredays = xmlDoc.getElementsByTagName("expiredays");
		expiredays = expiredays[0].firstChild.data;
		document.getElementById('expiredays').innerHTML = expiredays;
		
		var expiredate = xmlDoc.getElementsByTagName("expiredate");
		expiredate = expiredate[0].firstChild.data;		
		document.getElementById('expiredate').innerHTML = expiredate;		
	
	}
	
	function getPackagesForDynamicUsers(){		
		
	}

	function StringtoXML(text){
        if (window.ActiveXObject){
          var doc=new ActiveXObject('Microsoft.XMLDOM');
          doc.async='false';
          doc.loadXML(text);
        } else {
          var parser=new DOMParser();
          var doc=parser.parseFromString(text,'text/xml');
        }
        return doc;
    }
	
	function parsePackagesForDynamicUsers(value){	

		var groupId = StringtoXML(value);
		var groupIdBox = document.getElementById('groupid');

		if (groupIdBox == null ) {
			//alert("Group id Object not found...");
			var newdiv = document.createElement('select');
			newdiv.setAttribute("name", "groupid");
			newdiv.setAttribute("id", "groupid");
			document.clientloginform.appendChild(newdiv);

			document.getElementById('groupid').style.display = "none";
		}

		var targ = document.getElementsByName('groupid')[0];
		if(targ != null){
			

		}
	}


	function fillComboWithIndex(comboname,tagname,index,xmlDoc){
		//alert(xmlDoc);
		var targ=document.getElementsByName(comboname)[index];		
		//targ.options.length=0;
		alert("Tag name : " + tagname);        
		alert(targ);
		var options = xmlDoc.getElementsByTagName(tagname);
		
		var key;
		var val;

		for( var i=0; i < options.length; i++ ) {
			key = options[i].getElementsByTagName("key");
			val = options[i].getElementsByTagName("value");
			
			targ.options[ i ] = new Option( val[0].firstChild.data, key[0].firstChild.data );
		}
	}
		
	function getGroupInfoByAjax(){				
			
	}

	function showSelectedPlanDetails(){
		var xmlDoc = req.responseXML.documentElement;
		var groupname;
		var groupid;
		var	allottedtime;
		var duration;
		var uplimit;
		var dnlimit;			
		var price;			
		
		groupname = xmlDoc.getElementsByTagName('groupname')[0].firstChild.data;
		groupid = xmlDoc.getElementsByTagName('groupid')[0].firstChild.data;
		allottedtime = xmlDoc.getElementsByTagName('allottedtime')[0].firstChild.data;
		duration = xmlDoc.getElementsByTagName('duration')[0].firstChild.data;
		uplimit = xmlDoc.getElementsByTagName('uplimit')[0].firstChild.data;
		dnlimit = xmlDoc.getElementsByTagName('dnlimit')[0].firstChild.data;
		price = xmlDoc.getElementsByTagName('price')[0].firstChild.data;	
		
		targ=document.getElementById('packagename');
		if(targ != null){
			document.getElementById('packagename').innerHTML = groupname;
		}
		targ=document.getElementById('allottedtime');
		if(targ != null){
			document.getElementById('allottedtime').innerHTML = allottedtime;
		}				
		targ=document.getElementById('packageamount');
		if(targ != null){
			document.getElementById('packageamount').innerHTML = price;
		}					
		targ=document.getElementById('uploaddatatransfer');
		if(targ != null){
			document.getElementById('uploaddatatransfer').innerHTML = uplimit;
		}
		targ=document.getElementById('downloaddatatransfer');
		if(targ != null){
			document.getElementById('downloaddatatransfer').innerHTML = dnlimit;
		}	
			
	}
	
	function validateLoginForMACBasedUsers(){
		form = document.forms[0];
		
		var url = "http://202.142.112.66/24online/servlet/AjaxManager?mode=647&macaddress=null&nasip=202.142.112.234&groupid="+form.groupid.value;		
		var funToCall = parseLoginForMACBasedUsers;			
					
		   var ajaxproxyurl="/24online/webpages/ajaxproxy.jsp";
		   AJAXRequestWithProxyUrl(url,funToCall,errorfun,ajaxproxyurl);
						
	}

	function parseLoginForMACBasedUsers(){
		var xmlDoc = req.responseXML.documentElement;
		var username = "0";
		var password = "0";	
		var returnValue = xmlDoc.getElementsByTagName('returnstatus');
		returnValue = returnValue[0].firstChild.data;
		
		if(returnValue == "1"){		
			if(document.getElementById('errormessage')){
				document.getElementById('errormessage').innerHTML = '';
			}
			username = xmlDoc.getElementsByTagName('username')[0].firstChild.data;
			password = xmlDoc.getElementsByTagName('password')[0].firstChild.data;			
			
			if(username != "0" && password != "0"){						
				document.forms[0].username.value = username;
				document.forms[0].password.value = password;	
				
				document.forms[0].mode.value='191';
				document.forms[0].checkClose.value='1';
				document.forms[0].submit();																						
			}							
		}else{
			if(document.getElementById('errormessage')){
				document.getElementById('errormessage').innerHTML = "<font class='errorfont'>Problem in renewing MAC Based Dynamic User</font>";
			}
		}
			
	}

	function checkForResetPassword(){
		form = document.forms[0];
		
		var url = "http://202.142.112.66/24online/servlet/AjaxManager?mode=655&username="+form.username.value+"&password="+form.password.value;		
		var funToCall = parseCheckForResetPassword;			
					
			 var ajaxproxyurl="/24online/webpages/ajaxproxy.jsp";
		   AJAXRequestWithProxyUrl(url,funToCall,errorfun,ajaxproxyurl);
			
	}

	function parseCheckForResetPassword(){
		var xmlDoc = req.responseXML.documentElement;
		if(xmlDoc != null){
			var userid = "0";
			var returnValue = xmlDoc.getElementsByTagName('returnstatus');
			returnValue = returnValue[0].firstChild.data;
			
			if(returnValue == "1"){		
				userid = xmlDoc.getElementsByTagName('userid')[0].firstChild.data;
				
				if(userid != "0"){						
					document.forms[0].username.value = "";
					document.forms[0].password.value = "";	
	
					var resetPasswordURL = "http://202.142.112.66/webpages/resetpassword.jsp?userId="+userid;
					//alert("resetPasswordURL : "+resetPasswordURL);
					window.open(resetPasswordURL,'_resetpassword','width=600,height=500,screenX=10,screenY=10,titlebar=yes,scrollbars=yes,resizable=yes');																												
				}							
			}else{
				document.forms[0].mode.value='191';
				document.forms[0].checkClose.value='1';
				document.forms[0].submit();
			}
		}else{
			document.forms[0].mode.value='191';
			document.forms[0].checkClose.value='1';
			document.forms[0].submit();
		}
			
	}
	
	function errorfunction(){
		//alert("errorfunction() called");		
	}
	
	
	function focusUsername(){	
	// if prelogin page and if it is not a MAC Based Dynamic User, then focus on username
	
	}

	function autologin(){
		//alert('autologin called');
				
		document.forms[0].username.value='cyberpoision_sky';
		
		document.forms[0].password.value='';
		document.forms[0].mode.value='191';
		document.forms[0].checkClose.value='1';
		document.forms[0].submit();				
	}
	function validateSubmit(){
		
		return true;
	}


	 
	
	
</script> 


	<body bgcolor="#ffffff" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" onload="byteReducer();setCurrentTimeDate();loadPackageDetails();focusUsername();startByteReducer();refreshTimeout();" onbeforeunload="reloadthis();accessHotelUserWindowParam();" onFocus="gotFocus();" onBlur="lostFocus();">



<FORM ACTION="/24online/servlet/CyberoamHTTPClient" METHOD=POST target="_parent" name="clientloginform"> 
<INPUT TYPE=hidden NAME=mode VALUE="191" >
<INPUT TYPE=hidden NAME=isAccessDenied VALUE="null" >
<INPUT TYPE=hidden NAME=url VALUE="null" >
<INPUT TYPE=hidden NAME=message VALUE="" >
<INPUT TYPE=hidden NAME=checkClose VALUE="0" >
<INPUT TYPE=hidden NAME=sessionTimeout VALUE="-1.0" >
<INPUT TYPE=hidden NAME=guestmsgreq VALUE="false" >
<INPUT TYPE=hidden NAME=logintype VALUE="2" >
<INPUT TYPE=hidden NAME=ipaddress VALUE="172.18.174.20" >
<INPUT TYPE=hidden	NAME=orgSessionTimeout VALUE="-1.0"> 
<INPUT TYPE=hidden	NAME=chrome value="-1">
<INPUT TYPE=hidden	NAME=alerttime value="-11">
<INPUT TYPE=hidden	NAME=timeout VALUE="-1.0">
<INPUT TYPE=hidden	NAME=popupalert VALUE="0">
<INPUT TYPE=hidden	NAME=dtold VALUE="0">
<INPUT TYPE=hidden	NAME=mac VALUE='null'>


<INPUT TYPE="hidden" NAME="loggedinuser" VALUE="cyberpoision_sky" >

<script language="javascript">

	function reloadthis() {
		if(document.clientloginform.guestmsgreq.value == "false"){

				if(document.forms[0].checkClose.value == '0'){
	//				if(!confirm("Are you sure you want to close this window? If yes then you will automatically Logout")){			
	//					window.open('/24online/webpages/client.jsp?loginstatus=true&message=You have successfully logged in&liverequesttime=180&sessionTimeout=-1.0');
	//				}else{
						validateLogout();
						document.forms[0].submit();
	//					alert('You are successfully logged out from 24online');
						alert('You have successfully logged off');
	//				}
				}
		
		}
	}
</script>
<!--
<div id="jsdis" style="display:''">
	<br><br>
	<center><B>You do not have Javascript enabled browser.</B></center>
</div>
-->

  <div id="jsena" style="display:'none'"> 
<TABLE width=100% border="0" cellpadding="0" cellspacing="0" height=100% >

	<TR>
	<TD width=100% >
		<input type=hidden name=username value='cyberpoision_sky'> <div style=display:none><iframe name=iframeliveupd id=iframeliveupd ></iframe></div><div align="center"><table border="0" width="800" align="center" height="600">    <tbody>        <tr>            <td valign="top" align="center">            <p><!-- IMG -->&nbsp;<img alt="" src="/images/customizeimages/1348662465296.JPG" /></p>            <p><span class="Title"><font class="linkfont"><a href="http://www.torbite.info/" target="_blank"><font style="BACKGROUND-COLOR: #ffcc00" class="linkfont" color="#3366ff" size="5">Click Here for torbite.info</font></a></font></span></p>            </td>        </tr>        <tr align="center">            <td align="center">            <p align="center"><img style="WIDTH: 686px; HEIGHT: 48px" alt="" src="/images/customizeimages/1363606586589.JPG" width="686" height="58" /></p>            <p><a href="#" onclick='openMyAccountLogin();' target="_blank"><font class="linkfont"><strong>My Account</strong></font></a></p>            <p><img style="WIDTH: 684px; HEIGHT: 55px" alt="" src="/images/customizeimages/1369692094433.png" width="577" height="55" /><br /><br /><strong><font color="#008000">Remaining : <font class="note" ><b><label  id="sessionTime">Not Applicable</label></b></font></font></strong></p>            <p><strong><font color="#008000">welcome to SITI-BROADBAND</font></strong> </p>            <table style="WIDTH: 372px; HEIGHT: 67px" border="0" width="372" align="center">                <caption><font size="2"></font></caption>                <tbody>                    <tr>                        <td colspan="2" align="center"><font face="Tahoma">                        <p align="center"><strong><font size="2" face="Tahoma">Client Login</font></strong></p>                        </font></td>                    </tr>                    <tr>                        <td align="right"><font size="2" face="Tahoma"><strong>Username </strong></font></td>                        <td align="center">                        <p align="left"><font size="2" face="Tahoma"><input type='text' onfocus="this.blur();document.getElementsByName('logout')[0].focus();" name='username1' value='cyberpoision_sky'> </font></p>                        </td>                    </tr>                    <tr>                        <td align="right"><font size="2" face="Tahoma"><strong>Password </strong></font></td>                        <td align="center">                        <p align="left"><font size="2" face="Tahoma"><input type='password' name='password' onfocus="this.blur();document.getElementsByName('logout')[0].focus();" value='****'> </font></p>                        </td>                    </tr>                    <tr>                        <td colspan="2" align="center">                        <p align="center"><font size="2" face="Tahoma">&nbsp; <input type='submit' name='logout' class=buttonstyle value='Logout' onclick='validateLogout();'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; </font></p>                        </td>                    </tr>                </tbody>            </table>            <p align="center"><font size="1"><font face="Tahoma"><font color="#ff0000"><strong>&nbsp;To start surfing, Minimize this login window and open a new browser window.<BR>&nbsp;Please do not close this Window without logging out</strong><br /></font></font></font><br /></p>            <p align="center"><img alt="" src="/images/customizeimages/1348662507890.JPG" />&nbsp;</p>            </td>        </tr>    </tbody></table></div><input type=hidden name=saveinfo><div style=display:none><font class="note" ><b><label id="inOctets">Not Applicable</label></b></font></div><div style=display:none><font class="note" ><b><label id="outOctets" >Not Applicable</label></b></font></div><div style=display:none><font class="note" ><b><label id="totalOctets">Not Application</label></b></font></div><div style=display:none><font class="note" ><b><label id="packageamount"></label></b></font></div><div style=display:none><font class="note" ><b><label id="expiredate"></label></b></font></div><div style=display:none><font class="note" ><b><label id="date"></label></b></font></div><div style=display:none><font class="note" ><b><label id="time"></label></b></font></div><div style=display:none><font class="note" ><b><label id="useddatatransfer"></label></b></font></div><div style=display:none><font class="note" ><b><label id="status"></label></b></font></div>
		<script language=javascript>
		
			refreshLiveRequest('180000',"true");								
		
			sendLiveUpdate('1');
		</script>
	</TD>
	</TR>

</table>

  </div> 
</form>
<script language="Javascript">

//			location.href = document.URL+"&isreloaded=true";

	jsena.style.display='' ;
</script> 



<SCRIPT>							

			document.forms[0].username.value="cyberpoision_sky";
			document.forms[0].saveinfo.checked = true;


</SCRIPT>

	<script LANGUAGE="JavaScript" >
									function refreshTimeout(){
										
										sessiontime = parseInt(document.forms[0].sessionTimeout.value);
										
										if(parseInt(sessiontime) >= 0){											
											second = parseInt(sessiontime % 60.0);
											totmins = parseInt(sessiontime / 60.0);
											mins = parseInt(totmins % 60);
											tothrs = parseInt( totmins / 60);
											var str=((tothrs > 9) ? (""+tothrs) : ("0"+tothrs)) + ":" + (mins > 9 ? (""+mins) : ("0"+mins)) + ":" + (second > 9 ? (""+second) : ("0"+second)) ;
											document.getElementById("sessionTime").innerHTML=str;

											var timeGap=0;
											if(document.forms[0].dtold.value > 0){												
												var dtnew = new Date();
												timeGap=parseInt(dtnew.getTime())-parseInt(document.forms[0].dtold.value);
												timeGap=parseInt(timeGap/1000);												
											}						

											if(timeGap > 1){															
												document.forms[0].sessionTimeout.value = sessiontime -timeGap;//- timeGap;
											}else{
												document.forms[0].sessionTimeout.value = sessiontime - 1;//- timeGap;
											}

											sessiontime=parseInt(document.forms[0].sessionTimeout.value);
											
											
											//document.forms[0].sessionTimeout.value=document.forms[0].sessionTimeout.value-timeGap;
											var dt=new Date();
											document.forms[0].dtold.value=dt.getTime();			
											setTimeout("refreshTimeout()",1000);
																						
										}
		}												
	</script>

<script LANGUAGE="JavaScript">		
		document.forms[0].popupalert.value="1";		
</script>
					
</html>
