<html>
<script type="text/javascript">

function mytest1() 
{
 var Excel, Book;	// Declare the variables
 Excel = new ActiveXObject("Excel.Application");	// Create the Excel application object.
 Excel.Visible = false;	// Make Excel invisible.
 Book = Excel.Workbooks.Add()	// Create a new work book.
 Book.ActiveSheet.Cells(1,1).Value = document.all.my_textarea1.value;
 Book.SaveAs("C:/Documents and Settings/ProGamer/Desktop/word to text/TEST.xls");		
 Excel.Quit();	// Close Excel with the Quit method on the Application object.
}

function mytest2() 
{
 var Excel;
 Excel = new ActiveXObject("Excel.Application");	
 Excel.Visible = false;
 form1.my_textarea2.value = Excel.Workbooks.Open("H:/WINDOWS/Temp/Book1.xls").ActiveSheet.Cells(1,1).Value;
 Excel.Quit();
}

</script>
<body>
<form name="form1">
<input type=button onClick="mytest1();" value="Send Excel Data"><input type=text name="my_textarea1" size=70 value="enter ur data here">
<br><br>
<input type=button onClick="mytest2();" value="Get Excel Data"><input type=text name="my_textarea2" size=70  value="no data collected yet">
</form>
</body>