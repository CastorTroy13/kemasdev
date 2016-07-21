<?php
include_once "classes/ddSC.php";

$ddSC=new ddSC();
$kata="kemasindo_001";
echo "String Asli 1: $kata <br/>\n";
$kata=$ddSC->getEncString($kata);
echo "Hasil Encrypt 1: $kata <br/>\n";
$kata="	41684088468830484728460846482968444847684488424840084088";
echo "String Asli 2: $kata <br/>\n";
$kata=$ddSC->getDecString($kata);
echo "Hasil Decrypt 2: $kata <br/>\n";
?>