<?php
if ($_GET['op']=='cp') {
include_ONCE	 'db.php';
$cp='';
$cp.= "<h1>Начисение по ОДПУ</h1>";
$cp.= "<form name='cp' action='index.php' method='get'>";
$cp.=  "<label for='tc_fio'>Дата:</label>";
$cp.= "<input type='text' id='cp_date' data-form='date' readOnly>  <br>";
$cp.= "Адрес:<br>" ;
$cp.= "<select id='cp_search_house' size=1>";
$adr=$my->query('SELECT id_house, adress FROM  `house`');
while (@$num=$adr->fetch_assoc()) {
	$cp.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
}
$cp.= "</select><br>";
$cp.='<div id="cp_serv"></div>';
$cp.= "</form>";
$cp.='<div id="cp_count"></div>';
$cp.='<div id="cp_ved"></div>';


}

?>