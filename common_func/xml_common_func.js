function loadXMLDoc(nama_file)
{
 var xmlDoc;

 if (window.XMLHttpRequest)
  xhttp = new XMLHttpRequest();
 else // Internet Explorer 5/6
  xhttp = new ActiveXObject("Microsoft.XMLHTTP");

 xhttp.open("GET", nama_file, false);
 xhttp.send("");
 return xhttp.responseXML;
}

function createArray(dim1,dim2)
{
 if (createArray.arguments.length == 1)
  return new Array(dim1);
 else if (createArray.arguments.length == 2)
 {
  var multiArray = new Array(dim1)

  for (var i = 0; i < dim1; i++)
  {
   multiArray[i] = new Array(dim2);
  }

  return multiArray;
 }
}

function getArrayFromXMLFile(nama_file)
{
 var xmlDoc = loadXMLDoc(nama_file);
 var tmp_node = xmlDoc.getElementsByTagName("record_counts");
 var record_counts = tmp_node[0].childNodes[0].nodeValue;
 tmp_node = xmlDoc.getElementsByTagName("field_counts");
 var field_counts = tmp_node[0].childNodes[0].nodeValue;

 if (field_counts>1)
 {
  var return_value = createArray(record_counts, field_counts);

  for (i=0;i<field_counts;i++)
  {
   tmp_node = xmlDoc.getElementsByTagName("field" + i);

   for (j=0;j<record_counts;j++)
    return_value[j][i] = tmp_node[j].childNodes[0].nodeValue;
  }
 }
 else
 {
  var return_value = new Array(record_counts);
  tmp_node = xmlDoc.getElementsByTagName("field0");

  for (i=0;i<record_counts;i++)
   return_value[i] = tmp_node[i].childNodes[0].nodeValue;
 }

 return return_value;
}

function getRecordCounts(nama_file)
{
 xmlDoc = loadXMLDoc(nama_file);
 record_node = xmlDoc.getElementsByTagName("record_counts");
 return record_node[0].childNodes[0].nodeValue;
}

function getFieldCounts(nama_file)
{
 xmlDoc = loadXMLDoc(nama_file);
 field_node = xmlDoc.getElementsByTagName("field_counts");
 return field_node[0].childNodes[0].nodeValue;
}

function getXMLToTable(nama_file)
{
 var returnValue = "<table id=\"xmlTable\" name=\"xmlTable\" style=\"width: 100%\" class=\"dataTable\">\n";

 if ((xmlDoc = loadXMLDoc(nama_file)) != undefined)
 {
  var tmp_node = xmlDoc.getElementsByTagName("record_counts");
  var numberOfRecord = tmp_node[0].childNodes[0].nodeValue;
  tmp_node = xmlDoc.getElementsByTagName("field_counts");
  var numberOfField = tmp_node[0].childNodes[0].nodeValue;
  var fieldNames = xmlDoc.getElementsByTagName("name");
  var records = new Array();

  for (var i=1;i<=numberOfField;i++)
  {
   records[i-1] = new Array();
   tmp_node = xmlDoc.getElementsByTagName("field" + i);

   for (var j=0;j<tmp_node.length;j++)
    records[i-1][j] = tmp_node[j].childNodes[0].nodeValue;
  }

  returnValue += "<tr>\n" +
                 "<th>No.</th>\n";

  for (i=0;i<numberOfField;i++)
   returnValue += "<th>" + fieldNames[i].childNodes[0].nodeValue + "</th>\n";

  returnValue += "</tr>\n";

  for (i=0;i<numberOfRecord;i++)
  {
   returnValue += "<tr>\n" +
                  "<th>" + (i+1) + "</th>\n";

   for (j=0;j<numberOfField;j++)
    returnValue += "<td><input type=\"text\" id=\"" + fieldNames[j].childNodes[0].nodeValue + (i+1) + "\" name=\"" + fieldNames[j].childNodes[0].nodeValue + (i+1) + "\" value=\"" + records[j][i] + "\" style=\"width: 100%\" /></td>\n";

   returnValue += "</tr>\n";
  }

  delete tmp_node, numberOfRecord, numberOfField, fieldNames, records, i, j;
 }

 returnValue += "</table>\n";
 delete xmlDoc, nama_file;
 return returnValue;
}