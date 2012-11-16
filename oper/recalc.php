<?php
if ($_GET['op']=='recalc') {
$recalc='';
$recalc.= "<h1>Перерасчет</h1>";
$recalc.= "<form name='recalc' action='index.php' method='get'>";
$recalc.= "Адрес:<br>" ;
$recalc.= "<select id='recalc_house' size=1>";
  $adr=$my->query('SELECT id_house, adress FROM  `house`');
  while (@$num=$adr->fetch_assoc()) {
    $recalc.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
  }
$recalc.= "</select><br>";
$recalc.= "Квартира:<br>" ;
$recalc.= "<input type='text' id='recalc_kv' placeholder='Введите номер квартиры'>";
$recalc.="<div id='data_tenant_div'> </div>";
//$recalc.= "<button type=\"button\" id='cc_search'>Поиск</button> <br><br>" ;
$recalc.=  "<label for='tc_fio'>Дата:</label>";
$recalc.= "<input type='text' id='recalc_date' data-form='date' readOnly>  <br>";
$recalc.= "</form>";
$recalc.="<div id='recalc_div'> </div>";
}
?>
	