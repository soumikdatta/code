
	//////////F12 disable code////////////////////////
		document.onkeypress = function (event) {
			event = (event || window.event);
			if (event.keyCode == 123) {
			   //alert('No F-12');
				return false;
			}
		}
		document.onmousedown = function (event) {
			event = (event || window.event);
			if (event.keyCode == 123) {
				//alert('No F-keys');
				return false;
			}
		}
	document.onkeydown = function (event) {
			event = (event || window.event);
			if (event.keyCode == 123) {
				//alert('No F-keys');
				return false;
			}
		}
	/////////////////////end///////////////////////


	//Disable right click script 
	//visit http://www.rainbow.arch.scriptmania.com/scripts/ 
	var message="Sorry, right-click has been disabled"; 
	/////////////////////////////////// 
	function clickIE() {if (document.all) {(message);return false;}} 
	function clickNS(e) {if 
	(document.layers||(document.getElementById&&!document.all)) { 
	if (e.which==2||e.which==3) {(message);return false;}}} 
	if (document.layers) 
	{document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;} 
	else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;} 
	document.oncontextmenu=new Function("return false") 
	// 
	function disableCtrlKeyCombination(e)
	{
	//list all CTRL + key combinations you want to disable
	var forbiddenKeys = new Array('a', 'c', 'v', 's', 'n', 'x', 'j' , 'w', 'u');
	var key;
	var isCtrl;
	if(window.event)
	{
	key = window.event.keyCode;     //IE
	if(window.event.ctrlKey)
	isCtrl = true;
	else
	isCtrl = false;
	}
	else
	{
	key = e.which;     //firefox
	if(e.ctrlKey)
	isCtrl = true;
	else
	isCtrl = false;
	}
	//if ctrl is pressed check if other key is in forbidenKeys array
	if(isCtrl)
	{
	for(i=0; i<forbiddenKeys.length; i++)
	{
	//case-insensitive comparation
	if(forbiddenKeys[i].toLowerCase() == String.fromCharCode(key).toLowerCase())
	{
	alert('Key combination CTRL + '+String.fromCharCode(key) +' has been disabled.');
	return false;
	}
	}
	}
	return true;
	}

	function createFacility()
	{
		alert("Facility creation started");
		getLatLng(document.getElementById("facility_address").value);
		alert("Facility creation complete");
	}
	
	function getLatLng(address)
	{
		var geocoder = new google.maps.Geocoder();
		
		alert(address);

		geocoder.geocode( { 'address': address}, function(results, status) {

		if (status == google.maps.GeocoderStatus.OK) {
			var latitude = results[0].geometry.location.lat();
			var longitude = results[0].geometry.location.lng();
			alert(latitude);
			}
		else
			alert("GeocoderStatus not OK");
		}); 

	}

	function searchBook()
	{
		book_name=document.getElementById("book_name").value;
		author=document.getElementById("author").value;
		genre=document.getElementById("genre").value;
		if(book_name!="" || author!="" || genre!="")
		{
			var xhttp;    
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					document.getElementById("bookList").innerHTML = xhttp.responseText;
				}
			}
			xhttp.open("GET", "get_books.php?book_name="+book_name+"&author="+author+"&genre="+genre, true);
			xhttp.send();
		}
	}
	function searchEBook()
	{
		book_name=document.getElementById("book_name").value;
		author=document.getElementById("author").value;
		genre=document.getElementById("genre").value;
		if(book_name!="" || author!="" || genre!="")
		{
			var xhttp;    
			xhttp = new XMLHttpRequest();
			xhttp.onreadystatechange = function() {
				if (xhttp.readyState == 4 && xhttp.status == 200) {
					document.getElementById("bookList").innerHTML = xhttp.responseText;
				}
			}
			xhttp.open("GET", "get_ebooks.php?book_name="+book_name+"&author="+author+"&genre="+genre, true);
			xhttp.send();
		}
	}
	function getImage()
	{
		//alert("Mistu");
		url = document.getElementById("book_cover").value;
		//alert(url);
		document.getElementById("cover_photo").src=url;
		document.getElementById("cover_photo").width="200";
		document.getElementById("cover_photo").height=auto;
	}

	var m_strUpperCase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	var m_strLowerCase = "abcdefghijklmnopqrstuvwxyz";
	var m_strNumber = "0123456789";
	var m_strCharacters = "!@#$%^&*?_~"
	
	function checkPassword(strPassword)
	{
		// Reset combination count
		var nScore = 0;

		// Password length
		// -- Less than 4 characters
		if (strPassword.length < 5)
		{
			nScore += 5;
		}
		// -- 5 to 7 characters
		else if (strPassword.length > 4 && strPassword.length < 8)
		{
			nScore += 10;
		}
		// -- 8 or more
		else if (strPassword.length > 7)
		{
			nScore += 25;
		}
//		alert(nScore);

		// Letters
		var nUpperCount = countContain(strPassword, m_strUpperCase);
		var nLowerCount = countContain(strPassword, m_strLowerCase);
		var nLowerUpperCount = nUpperCount + nLowerCount;
		// -- Letters are all lower case
		if (nUpperCount == 0 && nLowerCount != 0) 
		{ 
			nScore = 0;
/*					return nScore;
			break;
*/				}
		// -- Letters are all upper case
		else if (nUpperCount != 0 && nLowerCount == 0) 
		{ 
			nScore = 0; 
/*					return nScore;
			break;
*/				}
		// -- Letters are upper case and lower case
		else if (nUpperCount != 0 && nLowerCount != 0) 
		{ 
			nScore += 20; 
		}

		// Numbers
		var nNumberCount = countContain(strPassword, m_strNumber);
		// -- 1 number
		if (nNumberCount == 1)
		{
			nScore += 10;
		}
		// -- 3 or more numbers
		if (nNumberCount >= 3)
		{
			nScore += 20;
		}

		// Characters
		var nCharacterCount = countContain(strPassword, m_strCharacters);
		// -- 1 character
		if (nCharacterCount == 1)
		{
			nScore += 10;
		}   
		// -- More than 1 character
		if (nCharacterCount > 1)
		{
			nScore += 25;
		}

		// Bonus
		// -- Letters and numbers
		if (nNumberCount != 0 && nLowerUpperCount != 0)
		{
			nScore += 2;
		}
		// -- Letters, numbers, and characters
		if (nNumberCount != 0 && nLowerUpperCount != 0 && nCharacterCount != 0)
		{
			nScore += 3;
		}
		// -- Mixed case letters, numbers, and characters
		if (nNumberCount != 0 && nUpperCount != 0 && nLowerCount != 0 && nCharacterCount != 0)
		{
			nScore += 5;
		}


		return nScore;
	}

	// Runs password through check and then updates GUI 


	function runPassword(strFieldID) 
	{
		
		//alert(document.getElementById("password_text").textContent);
		
		// Check password
		var strPassword = document.getElementById(strFieldID).value;
		if(strPassword.length < 8 || strPassword.lenght > 16)
			nScore = 0;
		else
		{
//			alert("Calculating nScore");
			nScore = checkPassword(strPassword);
//			alert("nScore="+nScore);
		}


		 // Get controls
			var ctlBar = document.getElementById(strFieldID + "_bar"); 
			var ctlText = document.getElementById(strFieldID + "_text");
			if (!ctlBar || !ctlText)
				return;

			// Set new width
			nScore_width = nScore*1.25;
			ctlBar.style.width = nScore_width+"px";
			if(nScore_width > 100)
				ctlBar.style.width = "100px";
//					ctlBar.style.width = (nScore_width>100) ? 100 : nScore_width + "px;";

		// Color and text
		// -- Very Secure
		/*if (nScore >= 90)
		{
			var strText = "Very Secure";
			var strColor = "#0ca908";
		}
		// -- Secure
		else if (nScore >= 80)
		{
			var strText = "Secure";
			vstrColor = "#7ff67c";
		}
		// -- Very Strong
		else 
		*/
		//alert(nScore);
		if (nScore == 0)
		{
			var strText = "Invalid Password";
			var strColor = "#e71a1a";
		}
		else if (nScore >= 80)
		{
			var strText = "Very Strong";
			var strColor = "#008000";
		}
		// -- Strong
		else if (nScore >= 60)
		{
			var strText = "Strong";
			var strColor = "#006000";
		}
		// -- Average
		else if (nScore >= 40)
		{
			var strText = "Average";
			var strColor = "#e3cb00";
		}
		// -- Weak
		else if (nScore >= 20)
		{
			var strText = "Weak";
			var strColor = "#Fe3d1a";
		}
		// -- Very Weak
		else
		{
			var strText = "Very Weak";
			var strColor = "#e71a1a";
		}

		if(strPassword.length == 0)
		{
		ctlBar.style.backgroundColor = "";
		ctlText.innerHTML =  "";
		}
		else
		{
			ctlBar.style.backgroundColor = strColor;
			ctlText.innerHTML =  strText;
//					ctlText.innerHTML =  strText + "(" + nScore + ")(" + nScore_width + ")" + " -> " + ctlBar.style.width;
		}
	}

	// Checks a string for a list of characters
	function countContain(strPassword, strCheck)
	{ 
		// Declare variables
		var nCount = 0;

		for (i = 0; i < strPassword.length; i++) 
		{
			if (strCheck.indexOf(strPassword.charAt(i)) > -1) 
			{ 
					nCount++;
			} 
		} 

		return nCount;
	}
	function submit_review()
	{
		val1 = document.getElementById("review").value;
//		alert(val1);
		val2 = val1.replace(/\n/g,"<br>");
		val = val2.replace(/,,/g,"<br>");
//		alert(val);
		document.getElementById("review").value = val;
	}
