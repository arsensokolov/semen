<?php
if ($_GET['op']=='recalc_house') {
	$recalc_house='';
	$recalc_house.= "<h1>Перерасчет</h1>";
	$recalc_house.= "<form name='recalc_house' action='index.php' method='get'>";
	$recalc_house.=  "<label for='tc_fio'>Дата:</label>";
    $recalc_house.= "<input type='text' id='recalc_house_date'>  <br>";
      
    $recalc_house.=  "<label for='tc_fio'>Начальная дата:</label>";
    $recalc_house.= "<input type='text' id='recalc_house_date1'> <br>"; 
	
    $recalc_house.=  "<label for='tc_fio'>Конечная дата:</label>";
    $recalc_house.= "<input type='text' id='recalc_house_date2'> <br>";
	
	$recalc_house.= "Адрес:<br>" ;
	$recalc_house.= "<select id='recalc_house_adr' size=1>";
	$recalc_house.= "<option value='0'>	</option>";
	$adr=$my->query('SELECT id_house, adress FROM  `house`');
	while (@$num=$adr->fetch_assoc()) {
		$recalc_house.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
	}
	$recalc_house.= "</select><br>";

	$recalc_house.= '<div id="recalc_house_service"></div><br>';
	$recalc_house.= '<div id="recalc_house_table"></div>';
	
}
?>