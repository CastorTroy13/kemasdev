var hariIndonesia = new Array("Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jum'at", "Sabtu");
var hariEnglish = new Array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
var bulanIndonesia = new Array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
var bulanEnglish = new Array("January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December");

String.prototype.trim = function()
{
 return this.replace(/^\s*/, "").replace(/\s*$/, "");
}

function setCookie(cookie_name, value, exp_days)
{
 var expDate=new Date();
 expDate.setDate(expDate.getDate() + exp_days);
 document.cookie = cookie_name + "=" + escape(value) + ((exp_days==null)? "" : ";expires=" + expDate.toGMTString());
 delete expDate;
}

function getCookie(cookie_name)
{
 var return_value="";

 if (document.cookie.length>0)
 {
  cookie_start=document.cookie.indexOf(cookie_name + "=");

  if (cookie_start!=-1)
  {
   cookie_start = cookie_start + cookie_name.length+1;
   cookie_end=document.cookie.indexOf(";",cookie_start);
   if (cookie_end==-1) cookie_end=document.cookie.length;
   return_value = unescape(document.cookie.substring(cookie_start, cookie_end));
  }
 }

 return return_value;
}

function doConfirm(message)
{
 var confirmArray = new Array();
 confirmArray[0] = new Array("Apakah Anda benar-benar akan menghapus produk-produk ini?", "Apakah Anda benar-benar akan mengupdate data-data ini?", "Jika Anda telah melakukan perubahan data, silakan mengupdate data Anda terlebih dahulu.  Apakah Anda benar-benar akan mendaftarkan pesanan Anda?", "Apakah Anda benar-benar akan mengirim pesan ini?", "Apakah Anda benar-benar ingin mendaftarkan pesanan Anda?", "Apakah Anda benar-benar akan mendaftar dengan data ini?");
 confirmArray[1] = new Array("Are you really going to clear these item(s)?", "Are you really going to update these data(s)?", "If you've made change(s), please update your data first.  Are your really going to register your order?", "Are you really going to send this message?", "Are your really going to register your order?", "Are your really going to register with these datas?");
 var indexBahasa = getCookie("bahasa");
 indexBahasa = (indexBahasa == "" || indexBahasa == undefined)?0:indexBahasa;
 var confirmMessage = (isNaN(Number(message)))?message:confirmArray[indexBahasa][message];
 var returnValue = confirm(confirmMessage);
 delete confirmArray, confirmMessage, indexBahasa, message;
 return returnValue;
}

function getNamaHari(index, indexBahasa)
{
 switch (Number(indexBahasa))
 {
  case 0: //indonesia
   var returnValue = hariIndonesia[Number(index)];

   break;

  case 1: //english
   var returnValue = hariEnglish[Number(index)];
   break;
 }

 return returnValue;
}

function getNamaBulan(index, indexBahasa)
{
switch (Number(indexBahasa))
 {
  case 0: //indonesia
   var returnValue = bulanIndonesia[Number(index)];
   break;

  case 1: //english
   var returnValue = bulanEnglish[Number(index)];
   break;
 }

 return returnValue;
}

function getTime()
{
 var dateObj = new Date();
 var jam = dateObj.getHours();
 var menit = dateObj.getMinutes();
 var detik = dateObj.getSeconds();
 var returnValue = ((jam<10)?"0" + jam:jam) + " : " + ((menit<10)?"0" + menit:menit) + " : " + ((detik<10)?"0" + detik:detik);
 delete dateObj, jam, menit, detik;
 return returnValue;
}

function getTanggalHariIni(indexFormat, indexBahasa)
{
 var dateObj = new Date();

 switch (indexFormat)
 {
  case 0: //dd-MM-yyyy
   var hari = dateObj.getDate();
   var bulan = dateObj.getMonth();
   var returnValue = ((hari<10)?"0" + hari:hari) + "-" + ((bulan<10)?"0" + bulan:bulan) + "-" + dateObj.getYear();
   break;

  case 1: //MM-dd-yyyy
   var hari = dateObj.getDate();
   var bulan = dateObj.getMonth();
   var returnValue = ((bulan<10)?"0" + bulan:bulan) + "-" + ((hari<10)?"0" + hari:hari) + "-" + dateObj.getYear();
   break;

  case 2: //yyyy-MM-dd
   var hari = dateObj.getDate();
   var bulan = dateObj.getMonth();
   var returnValue = dateObj.getYear() + "-" + ((bulan<10)?"0" + bulan:bulan) + "-" + ((hari<10)?"0" + hari:hari);
   break;

  case 3: //dd MMMM yyyy
   var hari = dateObj.getDate();
   var bulan = dateObj.getMonth();
   var returnValue = ((hari<10)?"0" + hari:hari) + " " + getNamaBulan(dateObj.getMonth(), indexBahasa) + " " + dateObj.getFullYear();
   break;
 }

 delete dateObj, hari, bulan;
 return returnValue;
}

function getNamaHariIni(indexBahasa)
{
 var dateObj = new Date();
 var returnValue = getNamaHari(dateObj.getDay(), indexBahasa);
 delete dateObj, indexBahasa;
 return returnValue;
}

function disableAllInputControls(value)
{
 var input = document.getElementsByTagName("input");

 for (var i=0;i<input.length;i++)
 {
  input[i].disabled = value;
 }

 input = document.getElementsByTagName("select");

 for (i=0;i<input.length;i++)
  input[i].disabled = value;

 input = document.getElementsByTagName("textarea");

 for (i=0;i<input.length;i++)
  input[i].disabled = value;

 delete input, value, i;
}

function disableControl(id, value)
{
 document.getElementById(id).disabled = value;
}

function goBack()
{
 history.back();
}

function getXMLHTTPObject()
{
 if (window.XMLHttpRequest)
 {
  // code for IE7+, Firefox, Chrome, Opera, Safari
  return new XMLHttpRequest();
 }
 if (window.ActiveXObject)
 {
  // code for IE6, IE5
  return new ActiveXObject("Microsoft.XMLHTTP");
 }

 return null;
}

function setRowColor(tableID, row, color)
{
 var table = document.getElementById(tableID);
 var jumlahCols = table.rows[row].cells.length;

 for (var i=1;i<jumlahCols;i++)
 {
  table.rows[row].cells[i].style.backgroundColor = color;
 }

 delete i, jumlahCols, table;
}

function number_format(angka, separator)
{
 var tempNumber = "";
 angka = String(angka);
 var digit = angka.length;
 var start = angka.indexOf(".");
 start = (start == -1)?angka.length:start;
 tempNumber = angka.substr(start, (digit - start));
 start--;
 var incCounter = 1;

 for (var i=start;i>=0;i--)
 {
  if (incCounter %3 == 0)
   tempNumber = separator + angka.substr(i, 1) + tempNumber;
  else
   tempNumber = angka.substr(i, 1) + tempNumber;

  incCounter++;
 }

 if (tempNumber.substr(0, 1) == separator) tempNumber = tempNumber.substr(1, (tempNumber.length - 1));
 delete angka, separator, digit, start, incCounter, i;
 return tempNumber;
}

function un_number_format(angka, separator)
{
 angka = angka.toString();

 while (angka.search(separator)!=-1)
  angka = angka.replace(separator, "");

 return angka;
}

function clickSearchButton(address)
{
 if (document.getElementById("txtCari").value == "")
  alert("You haven't entered the keyword!");
 else
 {
  var url = address + "?txtCari=" + document.getElementById("txtCari").value + "&cmbCari=" + document.getElementById("cmbCari").value;
  location.href = url;
 }
}

function validateTextAreaMaxlength(control, maxLength, e)
{
 var returnValue = true;

 if (window.event)
  var key = e.keyCode;
 else
  var key = e.which;

 if (!(key == 0 || key == 8))
 {
  if (control.value.length >= maxLength) returnValue = false;
 }

 delete control, maxLength, key, e;
 return returnValue;
}

function isValidEmail(str)
{
 var returnValue = true
 var regExp = /^[a-zA-Z]+([_\.-]?[a-zA-Z0-9]+)*@[a-zA-Z0-9]+([\.-]?[a-zA-Z0-9]+)*(\.[a-zA-Z]{2,4})+$/
 returnValue = str.search(regExp);

 if (returnValue == -1)
  returnValue = false;
 else
  returnValue = true;

 delete regExp, str;
 return returnValue;
}

function validateNumeric(control, e, isNumeric)
{
 var keyNum;
 var regExp;
 var keyChar;
 var value;

 var indexBahasa = getCookie("bahasa");
 indexBahasa = (indexBahasa == "")?0:indexBahasa;
 var alertStr = (indexBahasa == 0)?"Anda perlu memasukkan nilai numeric.  Terima kasih.":"You need to input a numeric value.  Thank you.";
 var returnValue = true;

 if (isNumeric==1)
 {
  if (window.event)
   keyNum = e.keyCode;
  else
   keyNum = e.which;

  value = control.value;
  keyChar = String.fromCharCode(keyNum);
  regExp = /[\d\.]/;
  result = regExp.test(keyChar);

  if (keyNum != 13 && keyNum != 0 && keyNum != 8 && keyNum != 45 && keyNum != 46 && keyNum != 9)
  {
   if (!result)
   {
    returnValue = false;
    alert(alertStr);
   }
  }
  else if (keyChar==".")
  {
   regExp = /\./;
   if (regExp.test(value)) returnValue = false;
  }
 }

 delete control, e, isNumeric, keyNum, regExp, keyChar, value, indexBahasa, alertStr;
 return returnValue;
}

function trimTable(controlID)
{
 var control = document.getElementById(controlID);
 var cols = control.rows[0].cells.length;
 var rows = control.rows.length;
 var maxLength = 0;
 var totalLength = 0;
 var k = 0;
 var tempLength = 0;

 for (var i=0;i<cols;i++)
 {
  for (var j=0;j<rows;j++)
  {
   if (control.rows[j].cells[i].childNodes[0] == undefined)
   {
    if (control.rows[j].cells[i].innerHTML.trim().length > maxLength) maxLength = control.rows[j].cells[i].innerHTML.trim().length;
   }
   else
   {
    if (control.rows[j].cells[i].childNodes.length == 1)
    {
     //alert(   control.rows[j].cells[i].childNodes[2].innerHTML);
     if (control.rows[j].cells[i].childNodes[0].innerHTML != undefined)
     {
      if (control.rows[j].cells[i].childNodes[0].innerHTML.trim().length > maxLength) maxLength = control.rows[j].cells[i].childNodes[0].innerHTML.trim().length;
     }
    }
    else
    {
     for (k=0;k<(control.rows[j].cells[i].childNodes.length-1);k++)
     {
      if (control.rows[j].cells[i].childNodes[k].innerHTML != undefined) tempLength += control.rows[j].cells[i].childNodes[k].innerHTML.trim().length;
     }

     if (tempLength > maxLength) maxLength = tempLength;
     tempLength = 0;
    }
   }
  }

  control.rows[0].cells[i].style.width = (maxLength * 1.1) + "ex";
  totalLength += maxLength;
  maxLength = 0;
 }

 if ((totalLength * 1.1) > 61)
  totalLength = totalLength * 1.1;
 else
  totalLength = 61;

 document.getElementById(controlID).style.width = totalLength + "ex";
 delete control, cols, rows, controlID, maxLength, i, j, k;
}

function ceil(angka)
{
 return Math.round(Number(angka)+0.4);
}

function setPage(phpSelf, action, namaDB, from, orderBy, asc)
{
 var target = phpSelf + "?action=" + action + ((namaDB!="")?"&namaDB=" + namaDB:"") + "&from=" + from + ((document.getElementById("page"))?"&page=" + document.getElementById("page").value:"") + "&orderBy=" + orderBy + "&asc=" + asc;


 if (document.getElementById("txtCari"))
 {
  if (document.getElementById("txtCari").value != "") target += "&txtCari=" + document.getElementById("txtCari").value + "&cmbCari=" + document.getElementById("cmbCari").value;
 }

 delete phpSelf, action, namaDB, from, orderBy, asc;
 location.href = target;
}

function trim(str)
{
 var startStr = -1;
 var endStr = -1;
 var panjang = str.length;

 for (var i=0;i<panjang;i++)
 {
  if (str.substr(i, 1) != " " && startStr == -1)
  {
   startStr = i;
   break;
  }
 }

 for (i=(panjang-1);i>=0;i--)
 {
  if (str.substr(i, 1) != " " && endStr == -1)
  {
   endStr = i;
   break;
  }
 }

 var returnValue = str.substr(startStr, (endStr + 1));
 delete str, startStr, endStr, panjang, i;
 return returnValue;
}

function isALink(target)
{
 if (target.search(".php") != -1 || target.search(".html") != -1 || target.search(".htm") != -1)
  var returnValue = true;
 else
  var returnValue = false;

 delete target;
 return returnValue;
}

function clearCombo(id)
{
 var options = document.getElementById(id).options.length;

 for (var i=0;i<options;i++)
  document.getElementById(id).remove(0);

 delete id, options, i;
}

function element(id)
{
 return document.getElementById(id);
}

function formatDecimal(angka, decimal)
{
 angka = String(angka);
 var indexTitik = angka.indexOf(".");
 var panjang = angka.length;

 if (indexTitik == -1)
 {
  angka += ".";
  var pengulangan = decimal;
 }
 else if ((panjang - indexTitik - 1) == decimal)
  var pengulangan = 0;
 else
  var pengulangan = decimal - (panjang - indexTitik - 1);

 for (var i=0;i<pengulangan;i++)
  angka += "0";

 delete decimal, indexTitik, panjang, pengulangan, i;
 return angka;
}

function animateResize(id, tipe, oldSize, newSize)
{
 /* tipe: horizontal
          vertical */

 if (element(id))
 {
  alert(oldSize + "::" + newSize);
  var faktor = 5;

  if (oldSize > newSize)
  {
   var ulang = ceil((oldSize - newSize) / faktor);

   if (tipe == "horizontal")
   {
    for (var i=0;i<ulang;i++)
    {
     if ((element(id).offsetWidth - faktor) > newSize)
      element(id).style.width = element(id).offsetWidth - faktor + "px";
     else
      element(id).style.width = newSize + "px";
    }
   }
   else if (tipe == "vertical")
   {
    for (var i=0;i<ulang;i++)
    {
     if ((element(id).offsetWidth - faktor) > newSize)
      element(id).style.height = element(id).offsetWidth - faktor + "px";
     else
      element(id).style.height = newSize + "px";
    }
   }
  }
  else
  {
   var ulang = ceil((newSize - oldSize) / faktor);

   if (tipe == "horizontal")
   {
    for (var i=0;i<ulang;i++)
    {
     if ((element(id).offsetWidth - faktor) > newSize)
      element(id).style.width = element(id).offsetWidth + faktor + "px";
     else
      element(id).style.width = newSize + "px";
    }
   }
   else if (tipe == "vertical")
   {
    alert(element(id).offsetHeight);
    for (var i=0;i<ulang;i++)
    {
     if ((element(id).offsetHeight - faktor) > newSize)
      element(id).style.height = element(id).offsetHeight + faktor + "px";
     else
      element(id).style.height = newSize + "px";
    }
    alert(element(id).offsetHeight);
   }
  }

  delete faktor, ulang, i;
 }

 delete id, tipe, oldSize, newSize;
}

function getTimeOfDay(indexBahasa)
{
 var message = new Array();
 message[0] = new Array("Selamat malam", "Selamat pagi", "Selamat siang", "Selamat sore");
 message[1] = new Array("Good night", "Good morning", "Good afternoon", "Good evening");
 var dateObj = new Date();
 var jam = dateObj.getHours();

 if ((jam >= 0 && jam < 6) || (jam > 18 && jam <= 23))
  var index = 0;
 else if (jam >= 6 && jam < 10)
  var index = 1;
 else if (jam >= 10 && jam < 15)
  var index = 2;
 else if (jam >= 15 && jam < 18)
  var index = 3;

 var returnValue = message[indexBahasa][index];
 delete indexBahasa, message, dateObj, jam, index;
 return returnValue;
}

function doAjax(url, target, type, cbFunctions)
{
 var xmlhttp = getXMLHTTPObject()

 xmlhttp.onreadystatechange = function()
 {
  if (xmlhttp.readyState == 4)
  {
//alert(xmlhttp.responseText);
   if(target != "")
   {
    if (type == "html")
     element(target).innerHTML = xmlhttp.responseText;
    else if (type == "value")
     element(target).value = xmlhttp.responseText;
   }

   if (cbFunctions)
   {
    for (var i=0;i<cbFunctions.length;i++)
     eval(cbFunctions[i]);
   }

   delete xmlhttp, type, cbFunctions;
  }
 }

 xmlhttp.open("GET", url + "&rand=" + Math.random(), true);
 xmlhttp.send(null);
 delete url;
}

function loadCaptcha(id, folder, target, cbFunctions)
{
 var url = "../classes/dd_classes_ajax.php?392840084688424844884448=4168408846882728392845284688400842083928&id=" + id + "&folder=" + folder + "&target=" + target;
 doAjax(url, target, "html", cbFunctions);
 delete id, folder, target, url;
}

function getCalendar(cont, id, month, year, width, target, formatIndex)
{
 var url = "../classes/dd_classes_ajax.php?392840084688424844884448=41684088468827283928436840884448404839284608&cont=" + cont + "&id=" + id + "&month=" + month + "&year=" + year + "&width=" + width + "&target=" + target + "&formatIndex=" + formatIndex + "&bahasa=" + getCookie("bahasa");
 var cbFunctions = new Array("setCalendarTargetHeight('" + cont + "', '" + id + "');", "setPrivatePositions();");
 doAjax(url, cont, "html", cbFunctions);
 delete cont, id, month, year, width, target, formatIndex, url, cbFunctions;
}

function setCalendarTargetHeight(cont, id)
{
 if (element(id)) element(cont).style.height = element(id).offsetHeight + "px";
 delete cont, id;
}

function clearCaptcha(id, folder)
{
 var url = "../classes/dd_classes_ajax.php?392840084688424844884448=400843684088392846082728392845284688400842083928&id=" + id + "&folder=" + folder;
 doAjax(url, "", "html", null);
 delete id, folder, url;
}

function getDOMParser(text)
{
 if (window.DOMParser)
 {
  parser = new DOMParser();
  xmlDoc = parser.parseFromString(text, "text/xml");
  delete parser;
 }
 else
 {
  xmlDoc=new ActiveXObject("Microsoft.XMLDOM");
  xmlDoc.async="false";
  xmlDoc.loadXML(text);
 }

 delete text;
 return xmlDoc;
}

function getBrowserName()
{
 if (navigator.appName == "Microsoft Internet Explorer")
  var returnValue = "IE";
 else
 {
  var userAgent = navigator.userAgent;

  if (userAgent.search("Chrome") != -1)
   var returnValue = "Chrome";
  else if (userAgent.search("Opera") != -1)
   var returnValue = "Opera";
  else
   var returnValue = "Firefox";

  delete userAgent;
 }

 return returnValue;
}

function alignControls(form, left)
{
 if (elm = element(form).elements)
 {
  var jumlah = elm.length;

  for (var i=0;i<jumlah;i++)
  {
   if (elm[i].className.search("value") != -1) elm[i].style.marginLeft = left - elm[i].previousSibling.offsetWidth + "px";
  }

  delete jumlah, i;
 }

 if (elm = document.getElementsByTagName("span"))
 {
  var jumlah = elm.length;

  for (var i=0;i<jumlah;i++)
  {
   if (elm[i].className.search("value") != -1) elm[i].style.marginLeft = left - elm[i].previousSibling.offsetWidth + "px";
  }

  delete jumlah, i;
 }

 delete form, left, elm;
}