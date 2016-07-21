function loadXLSToTable(file)
{
 var returnValue = "";

 if (xls = new ActiveXObject("Excel.Application"))
 {
  xls.Visible = false;
  var row = 1;
  var col = 1;
  var text = "";
  var no = 1;
  var selesai = false;
  var judul = new Array();

  if (xlsHandler = xls.Workbooks.Open(file))
  {
   returnValue = "<table id=\"xlsTable\" name=\"xlsTable\" border=\"1\" class=\"dataTable\" style=\"width: 100%\">\n" +
                 "<tr>\n" +
                 "<th>No.</th>\n";

   do
   {
    text = xlsHandler.ActiveSheet.Cells(1, col).Value;

    if (text != undefined)
    {
     judul[col] = text;

     returnValue += "<th>" + text + "</th>\n" +
                    "<input type=\"hidden\" id=\"judul" + col + "\" name=\"judul" + col + "\" value=\"" + text + "\">\n";
     col++;
    }
   }
   while (text != undefined);

   returnValue += "</tr>\n" +
                  "<input type=\"hidden\" id=\"jumlahCol\" name=\"jumlahCol\" value=\"" + (col-1) + "\">\n";

   col = 1;
   row = 2;

   do
   {
    text = xlsHandler.ActiveSheet.Cells(row, col).Value;

    if (col == 1 && text != undefined)
    {
     returnValue += "<tr>\n" +
                    "<th>" + no++ + "</th>\n";
    }

    if (text != undefined)
    {
     returnValue += "<td><input type=\"text\"id=\"" + judul[col] + (row - 1) + "\" name=\"" + judul[col] + (row - 1) + "\" value=\"" + text + "\" style=\"width: 100%\"></td>\n";
     col++;
    }
    else
    {
     if (col != 1)
     {
      col = 1;
      row++;
      returnValue += "</tr>\n";
     }
     else
      selesai = true;
    }
   }
   while (!selesai);
   returnValue += "</table>\n";

   delete xlsHandler, text, col, row, no, selesai, judul;
   xls.Quit();
   delete xls;
  }
 }
 delete file;
 return returnValue;
}

function tableToXML(fileName)
{
}

function XLSToArray(xlsFile)
{
 var returnValue = new Array();
 var judul = new Array();

 if (xls = new ActiveXObject("Excel.Application"))
 {
  xls.Visible = false;
  var row = 1;
  var col = 1;
  var text = "";
  var no = 0;
  var selesai = false;

  if (xlsHandler = xls.Workbooks.Open(file))
  {
   do
   {
    text = xlsHandler.ActiveSheet.Cells(1, col++).Value;
    if (text != undefined) judul[no++] = text;
   }
   while (text != undefined);

   col = 1;
   row = 2;
   no = 0;

   for (var i=0; i<judul.length; i++)
    returnValue["'" + judul[i] + "'"] = new Array();

   no = 0;
   i = 0;

   do
   {
    text = xlsHandler.ActiveSheet.Cells(row, col).Value;

    if (text != undefined)
    {
     returnValue["'" + judul[no++] + "'"][i] = text;
     col++;
    }
    else
    {
     if (col != 1)
     {
      col = 1;
      row++;
      i++;
      no = 0;
     }
     else
      selesai = true;
    }
   }
   while (!selesai);

   delete xlsHandler, text, col, row, no, selesai, i;
   xls.Quit();
   delete xls;
  }
 }
 delete xlsFile, judul;
 return returnValue;
}