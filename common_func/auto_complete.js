var target = "";
var targetValue = "";

function searchData(e, data, valueOn)
{
 if (e.which)
  var key = e.which;
 else if (e.keyCode)
  var key = e.keyCode;

 if (key != 13 && key != 38 && key != 27 && key != 9 || key == 8)
 {
  if (e.srcElement)
   target = e.srcElement.id;
  else if (e.target)
   target = e.target.id;

  if (element(target).value != "")
  {
   if (valueOn != "") targetValue = valueOn;
   var keyword = element(target).value;
   if (keyword == "") clearCombo("cmbDropDown");
   var keywords = getWordsArray(keyword);
   fillDropDown(data, keywords, target);
   setDropDownPositions();
   setDropDownSize();
   delete keyword, keywords;
  }
  else
   clearDropDownCombo();
 }

 delete e, data, valueOn, key;
}

function setDropDownSize()
{
 if (element("cmbDropDown").options.length <= 20)
  element("cmbDropDown").size = element("cmbDropDown").options.length;
 else
  element("cmbDropDown").size = 20;

 if (element("cmbDropDown").options.length == 1) element("cmbDropDown").selectedIndex = 0;
}

function setDropDownPositions()
{
 if (element("cmbDropDown").options.length != 0)
 {
  var targetElm = element(target);
  var pos = new Array();
  pos["top"] = targetElm.offsetTop + targetElm.offsetHeight;
  pos["left"] = targetElm.offsetLeft;

  if (targetElm.parentNode)
  {
   if (targetElm.parentNode.tagName.toLowerCase() == "td")
    pos = getTableParentPositions(targetElm);
   else if (targetElm.parentNode.style != undefined)
   {
    if (targetElm.parentNode.style.position == "absolute") pos = getOtherParentPositions(targetElm);
   }
  }

  element("cmbDropDown").style.top = pos["top"] + "px";
  element("cmbDropDown").style.left = pos["left"] + "px";
  element("cmbDropDown").style.visibility = "visible";
  element("cmbDropDown").style.width = targetElm.offsetWidth + "px";
  delete targetElm, pos;
 }
 else
  clearDropDownCombo();
}

function getTableParentPositions(targetElm)
{
 var rv = new Array();
 rv["top"] = 0;
 rv["left"] = 0;
 var currentElm = targetElm;

 while (currentElm.parentNode !== "undefined" && currentElm.parentNode.tagName.toLowerCase() != "form")
 {
  currentElm = currentElm.parentNode;

  if (currentElm.tagName.toLowerCase() == "table" || currentElm.tagName.toLowerCase() == "tbody" || currentElm.tagName.toLowerCase() == "td")
  {
   rv["top"] += Number(currentElm.offsetTop);
   rv["left"] += Number(currentElm.offsetLeft);
  }
 }

 rv["top"] += targetElm.offsetHeight;
 delete currentElm;
 return rv;
}

function getOtherParentPositions(targetElm)
{
 var rv = new Array();
 rv["top"] = targetElm.offsetTop + targetElm.offsetHeight;
 rv["left"] = targetElm.offsetLeft;
 var currentElm = targetElm;

 while (currentElm.parentNode !== "undefined" && currentElm.parentNode.tagName.toLowerCase() != "form")
 {
  currentElm = currentElm.parentNode;

  if (currentElm.style.position == "absolute")
  {
   rv["top"] += Number(currentElm.offsetTop);
   rv["left"] += Number(currentElm.offsetLeft);
   break;
  }
  else
  {
   rv["top"] += Number(currentElm.offsetTop);
   rv["left"] += Number(currentElm.offsetLeft);
  }
 }

 delete currentElm;
 return rv;
}

function getWordsArray(keyword)
{
 var returnValue = new Array();
 var length = keyword.length;
 var temp = "";
 var index = 0;

 for (var i=0;i<length;i++)
 {
  if (keyword.substr(i, 1) != " ")
   temp += keyword.substr(i, 1);
  else
  {
   returnValue[index++] = temp;
   temp = "";
  }
 }

 if (temp != "") returnValue[index] = temp;
 delete keyword, length, temp, index, i;
 return returnValue;
}

function fillDropDown(data, keywords)
{
 clearCombo("cmbDropDown");

 if (data != null)
 {
  var length = data["value"].length;
  var keywordsLength = keywords.length;
  var flag = false;

  for (var i=0;i<length;i++)
  {
   flag = true;

   for (var j=0;j<keywordsLength;j++)
   {
    if (data["caption"][i].search(new RegExp(keywords[j], "i")) == -1)
    {
     flag = false;
     break;
    }
   }

   if (flag)
   {
    var opt = document.createElement("option");
    opt.value = data["value"][i];
    opt.text = data["caption"][i];
    element("cmbDropDown").add(opt, element("cmbDropDown").options.length);
    delete opt;
   }

   delete j;
  }

  delete length, keywordsLength, flag, i;
 }

 delete data, keywords;
}

function detectDropDownKeyDown(e)
{
 if (e.which)
  var key = e.which;
 else if (e.keyCode)
  var key = e.keyCode;

 if (element("cmbDropDown").selectedIndex == 0)
 {
  if (key == 38) element(target).focus();
 }

 if (key == 13 || key == 9)
 {
  element(target).value = deFormatXML(element("cmbDropDown").options[element("cmbDropDown").selectedIndex].innerHTML);
  if (targetValue != "") element(targetValue).value = deFormatXML(element("cmbDropDown").options[element("cmbDropDown").selectedIndex].value);
  clearDropDownCombo();
 }
 else if (key == 27)
  clearDropDownCombo();

 if (key == 13)
  var returnValue = false;
 else
  var returnValue = true;

 delete e, key;
 return returnValue;
}

function doDropDownClick()
{
 element(target).value = deFormatXML(element("cmbDropDown").options[element("cmbDropDown").selectedIndex].innerHTML);
 if (targetValue != "") element(targetValue).value = deFormatXML(element("cmbDropDown").options[element("cmbDropDown").selectedIndex].value);
 clearDropDownCombo();
}

function detectKeyDown(e)
{
 if (e.keyCode)
  var key = e.keyCode;
 else if (e.which)
  var key = e.which;

 if (key == 40)
 {
  if (element("cmbDropDown").options.length != 0) element("cmbDropDown").focus();
 }
 else if (key == 38 || key == 27 || key == 9)
  clearDropDownCombo();

 delete e, key;
}

function clearDropDownCombo()
{
 clearCombo("cmbDropDown");
 targetValue = "";
 element("cmbDropDown").style.visibility = "hidden";
 if (element(target)) element(target).focus();
 target = "";
}