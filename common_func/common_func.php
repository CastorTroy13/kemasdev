<?php
/*labelArray Structure:
  ["label"]
  ["id"]
  ["tipe"]
  ["value"]
  ["maxLength"]
  ["onchange"]
  ["sql"]
  ["isNumeric"]
*/

/*tipe tanggal format:
 'dd-MM-yyyy':index[0]
 'dd/MM/yyyy':index[1]
 'MM-dd-yyyy':index[2]
 'MM/dd/yyyy':index[3]
 'MM-yyyy':index[4]
*/

 function createGoogleSearch()
 {
  echo "<style type=\"text/css\">\n" .
       " @import url(http://www.google.com/cse/api/branding.css);\n" .
       "</style>\n" .
       "\n" .
       "<div class=\"cse-branding-bottom\" style=\"background-color:#FFFFFF;color:#000000\">\n" .
       "<div class=\"cse-branding-form\">\n" .
       "<form action=\"http://www.google.co.id/cse\" id=\"cse-search-box\" target=\"_blank\">\n" .
       "<div>\n" .
       "<input type=\"hidden\" name=\"cx\" value=\"partner-pub-0968652773750721:g2y7fm-x0iz\" />\n" .
       "<input type=\"hidden\" name=\"ie\" value=\"ISO-8859-1\" />\n" .
       "<input type=\"text\" name=\"q\" size=\"30\" />\n" .
       "<input type=\"submit\" name=\"sa\" value=\"\" />\n" .
       "</div>\n" .
       "</form>\n" .
       "</div>\n" .
       "<div class=\"cse-branding-logo\">\n" .
       "<img src=\"http://www.google.com/images/poweredby_transparent/poweredby_FFFFFF.gif\" alt=\"Google\" />\n" .
       "</div>\n" .
       "<div class=\"cse-branding-text\">\n" .
       "</div>\n" .
       "</div>\n";
 }

 function doAlert($message)
 {
  $message = str_replace("'", "\'", $message);

  echo "<script type=\"text/javascript\">\n" .
       " alert('". $message . "');" .
       "</script>\n";

  unset($message);
 }

 function disableControl($control_id, $value)
 {
  echo "<script type=\"text/javascript\">\n" .
       " document.getElementById(\"" . $control_id . "\").disabled = $value;\n" .
       "</script>\n";
 }

 function changeAddress($newAddress)
 {
  echo "<script type=\"text/javascript\">\n" .
       " parent.document.getElementById(\"change_able\").src = '" . $newAddress . "'\n" .
       "</script>\n";
 }

 function goBack()
 {
  echo "<script type=\"text/javascript\">\n" .
       " history.back();\n" .
       "</script>\n";
 }

 function createJudul($judul)
 {
  echo "<hr />\n" .
       "<div class=\"judulBox\">" . $judul . "</div>\n" .
       "<hr />\n";
 }

 function createGroupOfLabel(&$labelArray, $dbObj=null, $lebar=50, $doubleKolom=false)
 {
  $jumlahLabel = count($labelArray["label"]);
  $lebarLabel = ($doubleKolom==true)?20:40;
  $lebarField = ($doubleKolom==true)?30:60;
  echo "<div class=\"input\">\n";

  for ($i=0;$i<$jumlahLabel;$i++)
  {
   if (isset($labelArray["value"][$i]))
    $value = $labelArray["value"][$i];
   else
    $value = "";

   echo "<label name=\"" . $labelArray["id"][$i] . "\" for=\"" . $labelArray["id"][$i] . "\">" . $labelArray["label"][$i] . "</label>\n";
   $isNumeric = (isset($labelArray["isNumeric"][$i]))?$labelArray["isNumeric"][$i]:false;

   switch ($labelArray["tipe"][$i])
   {
    case "plainText":
     $value = (isset($labelArray["value"][$i])?$labelArray["value"][$i]:"");
     $isNumeric = (isset($labelArray["isNumeric"][$i]))?$labelArray["isNumeric"][$i]:false;
     $value = ($isNumeric)?my_number_format($value, ','):$value;
     echo "<span id=\"" . $labelArray["id"][$i] . "\" name=\"" . $labelArray["id"][$i] . "\">" . $value . "</span>\n";;
     break;

    case "inputText":
     $maxLength = (isset($labelArray["maxLength"][$i]))?$labelArray["maxLength"][$i]:0;
     echo "<input type=\"text\" id=\"" . $labelArray["id"][$i] . "\" name=\"" .  $labelArray["id"][$i] . "\" value=\"" . $value . "\"" . (($maxLength!=0)?(" maxlength=\"" . $maxLength . "\""):"") . " onfocus=\"this.select()\" " . (($isNumeric)?"onkeypress=\"return validateNumeric(this, event, true, 'You must input a numeric value!')\"":"") . " style=\"" . (($isNumeric)?"text-align: right":"text-align: left") . "\" class=\"inputCol2\" />\n";
     break;

    case "password":
     echo "<input type=\"password\" id=\"" . $labelArray["id"][$i] . "\" name=\"" . $labelArray["id"][$i] . "\" value=\"" . $value . "\" class=\"inputCol2\" />\n";
     break;

    case "comboBox":
     if (isset($labelArray["onchange"][$i]))
      $onchange = " onchange=\"" . $labelArray["onchange"][$i] . "\"";
     else
      $onchange = "";

     $isNumeric = (isset($labelArray["isNumeric"][$i]))?$labelArray["isNumeric"][$i]:false;

     echo "<select id=\"" . $labelArray["id"][$i] . "\"" . $onchange . " name=\"" . $labelArray["id"][$i] . "\" class=\"inputCol2\">\n";

     if (isset($labelArray["sql"][$i]))
     {
      if (is_array($labelArray["sql"][$i]))
       fillComboWithArray($labelArray["sql"][$i], ((isset($labelArray["value"][$i]))?$labelArray["value"][$i]:""));
      else
       $dbObj->fillCombo($labelArray["sql"][$i], ((isset($labelArray["value"][$i]))?$labelArray["value"][$i]:""), $isNumeric);
     }

     echo "</select>\n";
     break;

    case "dateControl":
     $dateObj = new ddDateControl($labelArray["id"][$i], $labelArray["sql"][$i], ((isset($labelArray["value"][$i]))?$labelArray["value"][$i]:""), "inputCol2");
     $dateObj->doAction();
     unset($dateObj);
     break;
   }

   echo "<br />\n";
  }

  echo "</div>\n";
  unset($isNumeric);
  unset($lebar);
  unset($doubleKolom);
  unset($jumlahLabel);
  unset($lebarLabel);
  unset($lebarField);
  unset($i);
  unset($value);
  unset($maxLength);
  unset($onchange);
  unset($isNumeric);
 }

 function fillComboWithArray(&$array, $value)
 {
  $jumlah = count($array["key"]);

  for ($i=0;$i<$jumlah;$i++)
  {
   $selected = false;
   if ($array["key"][$i]==$value) $selected = true;
   echo "<option value=\"" . $array["key"][$i] . "\"" . (($selected)?" selected=\"selected\"":"") . ">" . $array["value"][$i] . "</option>\n";
  }

  unset($selected);
  unset($i);
  unset($jumlah);
 }

 function refreshCookie($nama, $waktu)
 {
  $returnValue = true;

  if (isset($_COOKIE[$nama]))
  {
   $value = $_COOKIE[$nama];
   setcookie($nama, $value, $waktu);
  }
  else
  {
   $returnValue = false;
  }

  return $returnValue;
 }

 function clearCookies()
 {
  $jumlahCookie = count($_COOKIE);

  for ($i=0;$i<$jumlahCookie;$i++)
   @deleteCookie($_COOKIE[$i]);
 }

 function deleteCookie($nama)
 {
  setcookie ($nama, "", time()-3600);
  unset($_COOKIE[$nama]);
 }

 function isCookieExpired($nama)
 {
  if (isset($_COOKIE[$nama]))
   $returnValue = false;
  else
   $returnValue = true;

  return $returnValue;
 }

 function reDirect($newAddress)
 {
  $newAddress = ($newAddress == "")?$_SERVER["PHP_SELF"]:$newAddress;

  echo "<script type=\"text/javascript\">\n" .
       " window.location.href = \"" . $newAddress . "\";\n" .
       "</script>\n";
 }

 function createGroupOfMenu(&$menuArray, $defaultLink, $doubleKolom=false)
 {
  try
  {
   $jumlahMenu = count($menuArray["label"]);
   $lebarField = ($doubleKolom)?100:50;
   $lebarMenu = ($doubleKolom)?50:100;
   echo "<table width=\"" . $lebarField . "%\" border=\"0\">\n";

   for ($i=0;$i<$jumlahMenu;$i++)
   {
    if ($doubleKolom)
    {
     if ($i%2==0) echo "<tr>\n";
    }
    else
     echo "<tr>\n";

    echo "<td width=\"" . $lebarMenu . "%\"><a href=\"" . ((isset($menuArray["link"][$i]))?$menuArray["link"][$i]:$defaultLink) . "\">" . $menuArray["label"][$i] . "</a></td>\n";

    if ($doubleKolom)
    {
     if ($i%2!=0 || $i==$jumlahMenu-1) echo "</tr>\n";
    }
    else
     echo "</tr>\n";

   }

   echo "</table>\n";
  }
  catch(Exception $e)
  {
   echo "common_func.php::createGroupOfMenu::" . $e->getMessage();
   die();
  }
 }

 function closeThisWindow()
 {
  echo "<script type=\"text/javascript\">\n" .
       " window.close()\n" .
       "</script>\n";
 }

 function stringToNumber($number)
 {
  $length = strlen($number);
  $returnValue = "";

  for ($i=0;$i<$length;$i++)
  {
   if (is_numeric(substr($number, $i, 1))) $returnValue .= substr($number, $i, 1);
  }

  unset($length);
  unset($i);
  unset($number);
  return $returnValue;
 }

 function formatNumber($number, $option)
 {
  $returnValue = "";

  switch ($option)
  {
   case 1: //to 000x
    $length = strlen($number);

    switch ($length)
    {
     case 1:
      $returnValue = "000" . $number;
      break;

     case 2:
      $returnValue = "00" . $number;
      break;

     case 3:
      $returnValue = "0" . $number;
      break;

     case 4:
      $returnValue= $number;
      break;
    }
    break;

   case 2: //to 0x
    $length = strlen($number);

    switch ($length)
    {
     case 1:
      $returnValue = "0" . $number;
      break;

     case 2:
      $returnValue = $number;
      break;
    }

    break;

   case 4: //to 00000x
    $length = strlen($number);

    switch ($length)
    {
     case 1:
      $returnValue = "00000" . $number;
      break;

     case 2:
      $returnValue = "0000" . $number;
      break;

     case 3:
      $returnValue = "000" . $number;
      break;

     case 4:
      $returnValue = "00" . $number;
      break;

     case 5:
      $returnValue = "0" . $number;
      break;

     case 6:
      $returnValue = $number;
      break;
    }

    break;

   case 3: //to 00x
    $length = strlen($number);

    switch ($length)
    {
     case 1:
      $returnValue = "00" . $number;
      break;

     case 2:
      $returnValue = "0" . $number;
      break;

     case 3:
      $returnValue = $number;
      break;
    }

    break;

   case 5: //to 000000x
    $length = strlen($number);

    switch ($length)
    {
     case 1:
      $returnValue = "000000" . $number;
      break;

     case 2:
      $returnValue = "00000" . $number;
      break;

     case 3:
      $returnValue = "0000" . $number;
      break;

     case 4:
      $returnValue = "000" . $number;
      break;

     case 5:
      $returnValue = "00" . $number;
      break;

     case 6:
      $returnValue = "0" . $number;
      break;

     case 7:
      $returnValue = $number;
      break;
    }

    break;

   case 6: //to 0000x
    $length = strlen($number);

    switch ($length)
    {
     case 1:
      $returnValue = "0000" . $number;
      break;

     case 2:
      $returnValue = "000" . $number;
      break;

     case 3:
      $returnValue = "00" . $number;
      break;

     case 4:
      $returnValue = "0" . $number;
      break;

     case 5:
      $returnValue = $number;
      break;
    }

    break;
  }

  unset($number);
  unset($option);
  unset($length);
  return $returnValue;
 }

 function changeValueToDate($value, $formatIndex, $addTime = true)
 {
  if ($formatIndex!=4)
   $tahun = substr($value, 6, 4);
  else
   $tahun = substr($value, 3, 4);

  if ($formatIndex==0 || $formatIndex==1)
  {
   $tanggal = substr($value, 0, 2);
   $bulan = substr($value, 3, 2);
  }
  else if ($formatIndex==2 || $formatIndex==3)
  {
   $tanggal = substr($value, 3, 2);
   $bulan = substr($value, 0, 2);
  }
  else if ($formatIndex==4)
  {
   $tanggal = "01";
   $bulan = substr($value, 0, 2);
  }

  $value = $tahun . "-" . $bulan . "-" . $tanggal . (($addTime)?" 00:00:00":"");
  unset($tanggal);
  unset($bulan);
  unset($tahun);
  return $value;
 }

 function my_number_format($angka, $separator)
 {
  $tempNumber = "";
  $digit = strlen($angka);
  $start = strpos($angka, ".");
  $start = (!$start)?strlen($angka):$start;
  $tempNumber = substr($angka, $start, ($digit-$start));
  $start = ($start - 1);
  $incCounter = 1;

  for ($i=$start;$i>=0;$i--)
  {
   if ($incCounter %3 == 0)
    $tempNumber = $separator . substr($angka, $i, 1) . $tempNumber;
   else
    $tempNumber = substr($angka, $i, 1) . $tempNumber;

   $incCounter++;
  }

  if (substr($tempNumber, 0, 1) == $separator) $tempNumber = substr($tempNumber, 1, strlen($tempNumber) - 1);
  unset($incCounter);
  unset($start);
  unset($angka);
  unset($separator);
  unset($digit);
  unset($i);
  return $tempNumber;
 }

 function un_number_format($angka, $separator)
 {
  $returnValue = str_replace($separator, "", $angka);
  unset($angka);
  unset($separator);
  return $returnValue;
 }

 function fixString($string)
 {
  $returnValue = $string;
  if (strpos($string, '"')) $returnValue = str_replace('"', '\"', $returnValue);
  $returnValue = str_replace("\n", "\" + \"\\n\" + \"", $returnValue);
  unset($string);
  return $returnValue;
 }

 function addColon($string)
 {
  if (strpos($string, '\"'))
   $returnValue = "'" . $string . "'";
  else
   $returnValue = "\"" . $string . "\"";

  unset($string);
  return $returnValue;
 }

 function getArrayString($sql, &$dbObj)
 {
  if (!$result = $dbObj->executeQuery($sql))
  {
   $returnValue = null;
   $dbObj->showError();
  }
  else
  {
   $fields = $dbObj->fieldNumber();
   $returnValue = array();

   for ($i=0;$i<$fields;$i++)
    $returnValue[$i] = "";

   while ($rs = $result->fetch_row())
   {
    for ($i=0;$i<$fields;$i++)
     $returnValue[$i] .= "\"" . ((!is_null($rs[$i]))?$rs[$i]:"") . "\", ";
   }

   for ($i=0;$i<$fields;$i++)
   {
    $returnValue[$i] = trim($returnValue[$i]);
    $returnValue[$i] = substr($returnValue[$i], 0, strlen($returnValue[$i]) - 1);
   }

   unset($fields);
   unset($i);
   unset($rs);
   unset($i);
  }

  unset($sql);
  unset($result);
  return $returnValue;
 }

 function createDateControl($id, $format, $value)
 {
  $ddDate = new ddDateControl($id, $format, $value);
  $ddDate->doAction();
  unset($id);
  unset($format);
  unset($value);
  unset($ddDate);
 }

 function createDate($id, $format, $value)
 {
  $ddDate = new ddDateControl($id, $format, $value);
  echo $ddDate->getHTML();
  unset($id);
  unset($format);
  unset($value);
  unset($ddDate);
 }

 function getDateHTML($id, $format, $value)
 {
  $ddDate = new ddDateControl($id, $format, $value);
  $returnValue = $ddDate->getHTML();
  unset($id);
  unset($format);
  unset($value);
  unset($ddDate);
  return $returnValue;
 }

 function encStr($str)
 {
  $ddSC = new ddSC();
  $returnValue = $ddSC->getEncString($str);
  unset($ddSC);
  unset($str);
  return $returnValue;
 }

 function decStr($str)
 {
  $ddSC = new ddSC();
  $returnValue = $ddSC->getDecString($str);
  unset($ddSC);
  unset($str);
  return $returnValue;
 }

 function checkSettings($server, $userName, $password, $db, $data)
 {
  $file = "./xml_files/settings.xml";

  if (!file_exists($file))
  {
   $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n" .
              "<root>\n" .
              "<settings>\n" .
              "<server>" . encStr($server) . "</server>\n" .
              "<user_name>" . encStr($userName) . "</user_name>\n" .
              "<password>" . encStr($password) . "</password>\n" .
              "<default_db>" . encStr($db) . "</default_db>\n" .
              "<data_per_page>" . $data . "</data_per_page>\n" .
              "</settings>\n" .
              "</root>";

   if ($handler = fopen($file, "x"))
   {
    fwrite($handler, $content);
    fclose($handler);
   }

   unset($handler);
   unset($content);
  }

  unset($server);
  unset($userName);
  unset($password);
  unset($db);
  unset($data);
  unset($file);
 }

 function getNamaHari($tanggal, $bahasa = 0)
 {
  $tahun = substr($tanggal, 0, 4);
  $bulan = intval(substr($tanggal, 5, 2));
  $hari = intval(substr($tanggal, 8, 2));
  $indexHari = date("N",  mktime(0, 0, 0, $bulan, $hari, $tahun, -1));
  $nama = array();
  $nama[0] = array(1 => "Senin", 2 => "Selasa", 3 => "Rabu", 4 => "Kamis", 5 => "Jum'at", 6 => "Sabtu", 7 => "Minggu");
  $nama[1] = array(1 => "Monday", 2 => "Tuesday", 3 => "Wednesday", 4 => "Thursday", 5 => "Friday", 6 => "Saturday", 7 => "Sunday");
  $returnValue = $nama[$bahasa][$indexHari];
  unset($tanggal);
  unset($bahasa);
  unset($tahun);
  unset($bulan);
  unset($hari);
  unset($indexHari);
  unset($nama);
  return $returnValue;
 }

 function getSessionID()
 {
  $sesID = encStr("sesID");
  $returnValue = "";

  if (isset($_COOKIE[$sesID]))
   $returnValue = $_COOKIE[$sesID];
  else
  {
   if (isset($_GET[$sesID])) $returnValue = $_GET[$sesID];
  }

  unset($sesID);
  return $returnValue;
 }

 function getIndexHari($tanggal)
 {
  //print_r($tanggal . "<br />");
  $tahun = substr($tanggal, 0, 4);
  $bulan = intval(substr($tanggal, 5, 2));
  $hari = intval(substr($tanggal, 8, 2));
  $returnValue = date("N",  mktime(0, 0, 0, $bulan, $hari, $tahun, -1));
  unset($tanggal);
  unset($tahun);
  unset($bulan);
  unset($hari);
  return $returnValue;
 }

 function getTerbilang($jumlah, $bahasa = 0)
 {
  $bilBulat = getBilBulat($jumlah);
  $bilKoma = getBilKoma($jumlah);

  if ($bahasa == 0)
  {
   $returnValue = getTerbilangIndo($bilBulat);
   if ($bilKoma != "") $returnValue .= " Koma " . getTerbilangIndo($bilKoma);
  }
  else if ($bahasa == 1)
  {
   $returnValue = getTerbilangEng($bilBulat);
   if ($bilKoma != "") $returnValue .= " Point " . getTerbilangEng($bilKoma);
  }

  unset($jumlah);
  unset($bahasa);
  unset($bilBulat);
  unset($bilKoma);
  return $returnValue;
 }

 function getSatuanIndo($jumlah)
 {
  if ($jumlah == 0)
   $returnValue = "Nol";
  else if ($jumlah == 1)
   $returnValue = "Satu";
  else if ($jumlah == 2)
   $returnValue = "Dua";
  else if ($jumlah == 3)
   $returnValue = "Tiga";
  else if ($jumlah == 4)
   $returnValue = "Empat";
  else if ($jumlah == 5)
   $returnValue = "Lima";
  else if ($jumlah == 6)
   $returnValue = "Enam";
  else if ($jumlah == 7)
   $returnValue = "Tujuh";
  else if ($jumlah == 8)
   $returnValue = "Delapan";
  else if ($jumlah == 9)
   $returnValue = "Sembilan";

  unset($jumlah);
  return $returnValue;
 }

 function getRatusanJutaIndo($jumlah)
 {
  $pertama = substr($jumlah, 0, 3);
  $kedua = substr($jumlah, 3, 6);

  if (intval($pertama) == 0)
   $returnValue = "";
  else
   $returnValue = getRatusanIndo($pertama) . " Juta ";

  $returnValue .= " " . getRatusRibuanIndo($kedua);
  $returnValue = trim($returnValue);
  unset($jumlah);
  unset($pertama);
  unset($kedua);
  return $returnValue;
 }

 function getPuluhanJutaIndo($jumlah)
 {
  $pertama = substr($jumlah, 0, 2);
  $kedua = substr($jumlah, 2, 6);

  if (intval($pertama) == 0)
   $returnValue = "";
  else
   $returnValue = getPuluhanIndo($pertama) . " Juta";

  $returnValue .= " " . getRatusRibuanIndo($kedua);
  $returnValue = trim($returnValue);
  unset($jumlah);
  unset($pertama);
  unset($kedua);
  return $returnValue;
 }

 function getJutaanIndo($jumlah)
 {
  $pertama = substr($jumlah, 0, 1);
  $kedua = substr($jumlah, 1, 6);
  $returnValue = getSatuanIndo($pertama);
  $returnValue .= " Juta " . ((intval($kedua) != 0)?getRatusRibuanIndo($kedua):"");
  unset($jumlah);
  unset($pertama);
  unset($kedua);
  return $returnValue;
 }

 function getRatusRibuanIndo($jumlah)
 {
  $pertama = substr($jumlah, 0, 3);
  $kedua = substr($jumlah, 3, 3);
  $returnValue = (intval($pertama) != 0)?getRatusanIndo($pertama) . " Ribu":"";
  $returnValue .= " " . ((intval($kedua) != 0)?getRatusanIndo($kedua):"");
  unset($jumlah);
  unset($pertama);
  unset($kedua);
  return $returnValue;
 }

 function getPuluhRibuanIndo($jumlah)
 {
  $pertama = substr($jumlah, 0, 2);
  $ratusan = substr($jumlah, 2, 3);

  if (intval($pertama) == 0)
   $returnValue = "";
  else if ($pertama < 20)
   $returnValue = getBelasanIndo($pertama) . " Ribu";
  else
   $returnValue = getPuluhanIndo($pertama) . " Ribu";

  $returnValue .= " " . ((intval($ratusan) != 0)?getRatusanIndo($ratusan):"");
  $returnValue = trim($returnValue);
  unset($jumlah);
  unset($pertama);
  unset($ratusan);
  return $returnValue;
 }

 function getRibuanIndo($jumlah)
 {
  $pertama = substr($jumlah, 0, 1);

  if (intval($pertama) == 0)
   $returnValue = "";
  else if ($pertama == 1)
   $returnValue = "Seribu";
  else
   $returnValue = getSatuanIndo($pertama) . " Ribu";

  $ratusan = substr($jumlah, 1, 3);
  $returnValue .= " " . ((intval($ratusan) != 0)?getRatusanIndo($ratusan):"");
  $returnValue = trim($returnValue);
  unset($jumlah);
  unset($pertama);
  unset($ratusan);
  return $returnValue;
 }

 function getRatusanIndo($jumlah)
 {
  $pertama = substr($jumlah, 0, 1);

  if (intval($pertama) == 0)
   $returnValue = "";
  else if ($pertama == 1)
   $returnValue = "Seratus";
  else
   $returnValue = getSatuanIndo($pertama) . " Ratus";

  $puluhan = substr($jumlah, 1, 2);
  $returnValue .= " " . ((intval($puluhan) != 0)?getPuluhanIndo($puluhan):"");
  $returnValue = trim($returnValue);
  unset($pertama);
  unset($jumlah);
  unset($puluhan);
  return $returnValue;
 }

 function getPuluhanIndo($jumlah)
 {
  $pertama = substr($jumlah, 0, 1);
  $kedua = substr($jumlah, 1, 1);

  if (intval($pertama) == 0)
   $returnValue = "";
  else if ($pertama == 1)
   $returnValue = getBelasanIndo($jumlah);
  else
   $returnValue = getSatuanIndo($pertama) . " Puluh ";

  if ($pertama != 1) $returnValue .= (($kedua == 0)?"":getSatuanIndo($kedua));
  $returnValue = trim($returnValue);
  unset($jumlah);
  unset($pertama);
  unset($kedua);
  return $returnValue;
 }

 function getBelasanIndo($jumlah)
 {
  if (intval($jumlah) == 0)
   $returnValue = "";
  else if ($jumlah == 10)
   $returnValue = "Sepuluh";
  else if ($jumlah == 11)
   $returnValue = "Sebelas";
  else
   $returnValue = getSatuanIndo(substr($jumlah, 1, 1)) . " Belas";

  unset($jumlah);
  return $returnValue;
 }

 function getBilBulat($jumlah)
 {
  $titik = strpos($jumlah, ".");
  
  if ($titik)
  {
   $panjangKoma = strlen(substr($jumlah, $titik, strlen($jumlah) - $titik));
   $returnValue = substr($jumlah, 0, strlen($jumlah) - $panjangKoma);
   unset($panjangKoma);
  }
  else
   $returnValue = $jumlah;

  unset($jumlah);
  unset($titik);
  return $returnValue;
 }

 function getBilKoma($jumlah)
 {
  $titik = strpos($jumlah, ".");

  if ($titik)
  {
   $panjangKoma = strlen(substr($jumlah, $titik, strlen($jumlah) - $titik));
   $returnValue = substr($jumlah, ($titik + 1), strlen($jumlah) - 1 - $titik);
   unset($panjangKoma);
  }
  else
   $returnValue = "";

  unset($jumlah);
  unset($titik);
  return $returnValue;
 }

 function getTerbilangIndo($jumlah)
 {
  $panjang = strlen($jumlah);

  if ($panjang == 9)
   $returnValue = getRatusanJutaIndo($jumlah);
  else if ($panjang == 8)
   $returnValue = getPuluhanJutaIndo($jumlah);
  else if ($panjang == 7)
   $returnValue = getJutaanIndo($jumlah);
  else if ($panjang == 6)
   $returnValue = getRatusRibuanIndo($jumlah);
  else if ($panjang == 5)
   $returnValue = getPuluhRibuanIndo($jumlah);
  else if ($panjang == 4)
   $returnValue = getRibuanIndo($jumlah);
  else if ($panjang == 3)
   $returnValue = getRatusanIndo($jumlah);
  else if ($panjang == 2)
   $returnValue = getPuluhanIndo($jumlah);
  else if ($panjang == 1)
   $returnValue = getSatuanIndo($jumlah);
  else if ($panjang == 0)
   $returnValue = "Nol";

  unset($jumlah);
  unset($panjang);
  return $returnValue;
 }

 function getTerbilangEng($jumlah)
 {
  $panjang = strlen($jumlah);

  if ($panjang == 9)
   $returnValue = getRatusanJutaEng($jumlah);
  else if ($panjang == 8)
   $returnValue = getPuluhanJutaEng($jumlah);
  else if ($panjang == 7)
   $returnValue = getJutaanEng($jumlah);
  else if ($panjang == 6)
   $returnValue = getRatusRibuanEng($jumlah);
  else if ($panjang == 5)
   $returnValue = getPuluhRibuanEng($jumlah);
  else if ($panjang == 4)
   $returnValue = getRibuanEng($jumlah);
  else if ($panjang == 3)
   $returnValue = getRatusanEng($jumlah);
  else if ($panjang == 2)
   $returnValue = getPuluhanEng($jumlah);
  else if ($panjang == 1)
   $returnValue = getSatuanEng($jumlah);
  else if ($panjang == 0)
   $returnValue = "Zero";

  unset($jumlah);
  unset($panjang);
  return $returnValue;
 }

 function getSatuanEng($jumlah)
 {
  if ($jumlah == 0)
   $returnValue = "Zero";
  else if ($jumlah == 1)
   $returnValue = "One";
  else if ($jumlah == 2)
   $returnValue = "Two";
  else if ($jumlah == 3)
   $returnValue = "Three";
  else if ($jumlah == 4)
   $returnValue = "Four";
  else if ($jumlah == 5)
   $returnValue = "Five";
  else if ($jumlah == 6)
   $returnValue = "Six";
  else if ($jumlah == 7)
   $returnValue = "Seven";
  else if ($jumlah == 8)
   $returnValue = "Eight";
  else if ($jumlah == 9)
   $returnValue = "Nine";

  unset($jumlah);
  return $returnValue;
 }
 
 function getRatusanJutaEng($jumlah)
 {
  $pertama = substr($jumlah, 0, 3);
  $kedua = substr($jumlah, 3, 6);

  if (intval($pertama) == 0)
   $returnValue = "";
  else
   $returnValue = getRatusanEng($pertama) . " Million ";

  $returnValue .= " " . getRatusRibuanEng($kedua);
  $returnValue = trim($returnValue);
  unset($jumlah);
  unset($pertama);
  unset($kedua);
  return $returnValue;
 }

 function getPuluhanJutaEng($jumlah)
 {
  $pertama = substr($jumlah, 0, 2);
  $kedua = substr($jumlah, 2, 6);

  if (intval($pertama) == 0)
   $returnValue = "";
  else
   $returnValue = getPuluhanEng($pertama) . " Million";

  $returnValue .= " " . getRatusRibuanEng($kedua);
  $returnValue = trim($returnValue);
  unset($jumlah);
  unset($pertama);
  unset($kedua);
  return $returnValue;
 }

 function getJutaanEng($jumlah)
 {
  $pertama = substr($jumlah, 0, 1);
  $kedua = substr($jumlah, 1, 6);
  $returnValue = getSatuanEng($pertama);
  $returnValue .= " Million " . ((intval($kedua) != 0)?getRatusRibuanEng($kedua):"");
  unset($jumlah);
  unset($pertama);
  unset($kedua);
  return $returnValue;
 }

 function getRatusRibuanEng($jumlah)
 {
  $pertama = substr($jumlah, 0, 3);
  $kedua = substr($jumlah, 3, 3);
  $returnValue = (intval($pertama) != 0)?getRatusanEng($pertama) . " Thousand":"";
  $returnValue .= " " . ((intval($kedua) != 0)?getRatusanEng($kedua):"");
  unset($jumlah);
  unset($pertama);
  unset($kedua);
  return $returnValue;
 }

 function getPuluhRibuanEng($jumlah)
 {
  $pertama = substr($jumlah, 0, 2);
  $ratusan = substr($jumlah, 2, 3);

  if (intval($pertama) == 0)
   $returnValue = "";
  else if ($pertama < 20)
   $returnValue = getBelasanEng($pertama) . " Thousand";
  else
   $returnValue = getPuluhanEng($pertama) . " Thousand";

  $returnValue .= " " . ((intval($ratusan) != 0)?getRatusanEng($ratusan):"");
  $returnValue = trim($returnValue);
  unset($jumlah);
  unset($pertama);
  unset($ratusan);
  return $returnValue;
 }

 function getRibuanEng($jumlah)
 {
  $pertama = substr($jumlah, 0, 1);

  if (intval($pertama) == 0)
   $returnValue = "";
  else if ($pertama == 1)
   $returnValue = "One Thousand";
  else
   $returnValue = getSatuanEng($pertama) . " Thousand";

  $ratusan = substr($jumlah, 1, 3);
  $returnValue .= " " . ((intval($ratusan) != 0)?getRatusanEng($ratusan):"");
  $returnValue = trim($returnValue);
  unset($jumlah);
  unset($pertama);
  unset($ratusan);
  return $returnValue;
 }

 function getRatusanEng($jumlah)
 {
  $pertama = substr($jumlah, 0, 1);

  if (intval($pertama) == 0)
   $returnValue = "";
  else
   $returnValue = getSatuanEng($pertama) . " Hundred";

  $puluhan = substr($jumlah, 1, 2);
  $returnValue .= " " . ((intval($puluhan) != 0)?" And " . getPuluhanEng($puluhan):"");
  $returnValue = trim($returnValue);
  unset($pertama);
  unset($jumlah);
  unset($puluhan);
  return $returnValue;
 }

 function getPuluhanEng($jumlah)
 {
  $pertama = substr($jumlah, 0, 1);
  $kedua = substr($jumlah, 1, 1);

  if (intval($pertama) == 0)
   $returnValue = "";
  else if ($pertama == 1)
   $returnValue = getBelasanEng($jumlah);
  else if ($pertama == 2)
   $returnValue = "Twenty";
  else if ($pertama == 3)
   $returnValue = "Thirty";
  else if ($pertama == 5)
   $returnValue = "Fifty";
  else if ($pertama == 8)
   $returnValue = "Eighty";
  else
   $returnValue = getSatuanEng($pertama) . "ty";

  if ($pertama != 1) $returnValue .=  " " . (($kedua == 0)?"":getSatuanEng($kedua));
  $returnValue = trim($returnValue);
  unset($jumlah);
  unset($pertama);
  unset($kedua);
  return $returnValue;
 }

 function getBelasanEng($jumlah)
 {
  if (intval($jumlah) == 0)
   $returnValue = "";
  else if ($jumlah == 10)
   $returnValue = "Ten";
  else if ($jumlah == 11)
   $returnValue = "Eleven";
  else if ($jumlah == 12)
   $returnValue = "Twelve";
  else if ($jumlah == 13)
   $returnValue = "Thirteen";
  else if ($jumlah == 15)
   $returnValue = "Fifteen";
  else if ($jumlah == 18)
   $returnValue = "Eighteen";
  else
   $returnValue = getSatuanEng(substr($jumlah, 1, 1)) . "teen";

  unset($jumlah);
  return $returnValue;
 }

 function getLineBreaks($str)
 {
  $returnValue = "";
  $rows = substr_count($str, "\n");

  for ($i=0;$i<=$rows;$i++)
   $returnValue .= "<br />";

  $returnValue .= "\n";
  unset($str);
  unset($rows);
  unset($i);
  return $returnValue;
 }

 function getDropDownCombo()
 {
  return "<select id=\"cmbDropDown\" name=\"cmbDropDown\" style=\"visibility: hidden; position: absolute; cursor: pointer; z-index: 1500;\" onkeydown=\"return detectDropDownKeyDown(event);\" onclick=\"doDropDownClick();\"></select>\n";
 }

 function formatXML($str)
 {
  $str = str_replace("&", "&amp;", $str);
  $str = str_replace("<", "&lt;", $str);
  $str = str_replace(">", "&gt;", $str);
  $str = str_replace('"', "&quot;", $str);
  $str = str_replace("'", "&apos;", $str);
  return $str;
 }

 function deFormatXML($str)
 {
  $str = str_replace("&amp;", "&", $str);
  $str = str_replace("&lt;", "<", $str);
  $str = str_replace("&gt;", ">", $str);
  $str = str_replace("&quot;", '"', $str);
  $str = str_replace("&apos;", "'", $str);
  return $str;
 }

 function getMinuteDiff($time1, $time2)
 {
  $rv = round(($time2 - $time1) / 60, 2);
  unset($time1);
  unset($time2);
  return $rv;
 }

 function getNamaBulan($bulan, $bahasa = 0)
 {
  switch (intval($bulan))
  {
   case 1:
    $rv = ($bahasa == 0)?"Januari":"January";
    break;

   case 2:
    $rv = ($bahasa == 0)?"Februari":"February";
    break;

   case 3:
    $rv = ($bahasa == 0)?"Maret":"March";
    break;

   case 4:
    $rv = "April";
    break;

   case 5:
    $rv = ($bahasa == 0)?"Mei":"May";
    break;

   case 6:
    $rv = ($bahasa == 0)?"Juni":"June";
    break;

   case 7:
    $rv = ($bahasa == 0)?"Juli":"July";
    break;

   case 8:
    $rv = ($bahasa == 0)?"Agustus":"August";
    break;

   case 9:
    $rv = "September";
    break;

   case 10:
    $rv = ($bahasa == 0)?"Oktober":"October";
    break;

   case 11:
    $rv = "November";
    break;

   case 12:
    $rv = ($bahasa == 0)?"Desember":"December";
    break;
  }

  unset($bulan);
  unset($bahasa);
  return $rv;
 }

 function zipFile($source, $target, $deleteTarget = true, $baseName = true)
 {
  $rv = true;
  set_time_limit(0);
  if (file_exists($target) && $deleteTarget) unlink($target);
  $zip = new ZipArchive();

  if (!$zip->open($target, ZipArchive::CREATE))
   $rv = false;
  else
  {
   if (is_array($source))
   {
    $length = count($source);

    for ($i=0;$i<$length;$i++)
    {
     if (file_exists($source[$i]))
      $zip->addFile($source[$i], (($baseName)?basename($source[$i]):$source[$i]));
     else
      $rv = false;
    }

    unset($length);
    unset($i);
   }
   else
   {
    if (file_exists($source))
     $zip->addFile($source, (($baseName)?basename($source):$source));
    else
     $rv = false;
   }
  }

  $zip->close();
  unset($source);
  unset($target);
  unset($zip);
  unset($deleteTarget);
  unset($baseName);
  return $rv;
 }

 function unzipFile($source, $target)
 {
  $rv = true;

  if (!file_exists($source) || !file_exists($target))
   $rv = false;
  else
  {
   $zip = new ZipArchive();

   if (!$zip->open($source))
    $rv = false;
   else
   {
    $zip->extractTo($target);
    $zip->close();
   }

   unset($zip);
  }

  unset($source);
  unset($target);
  return $rv;
 }

?>
