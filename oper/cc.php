<?php
if ($_GET['op']=='cc') {
include_once 'db.php';
$cc='';
$cc.= "<h1>Начисение по счетчику</h1>";
$cc.='<hr>';		
$cc.= "<form name='cc' action='index.php' method='get'>";
$cc.= "Адрес:<br>" ;
$cc.= "<select id='cc_search_house' size=1>";
  $adr=$my->query('SELECT id_house, adress FROM  `house`');
  while (@$num=$adr->fetch_assoc()) {
    $cc.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
  }
  $cc.= "</select><br>";
$cc.= "Квартира:<br>" ;
$cc.= "<input type='text' id='cc_search_kv' placeholder='Введите номер квартиры'>";
$cc.= "<button type=\"button\" id='cc_search'>Поиск</button> <br><br>" ;
  $cc.= "</form>";

$cc.="<div id='counter_div'> </div>";
$cc.='<hr>';		
} ?>