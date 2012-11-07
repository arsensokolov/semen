<?php
if ($_GET['op']=='cc') {
include_once 'db.php';
$cc='';
$cc.= "<h1>Начисение по счетчику</h1>";
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

//$cc.= "<h1>Новая запись </h1> <br><br>";
 /* $cc.= "<form name='new' action='index.php' method='get'>";
 
  $cc.=  "<label for='tc_fio'>Лицевой счет:</label>";
  $cc.= "<input type='text' id='cc_id_tenant' disabled='disabled'> <br>";
    
  $cc.=  "<label for='tc_fio'>ФИО:</label>";
  $cc.= "<input type='text' id='cc_fio' disabled='disabled'> <br>";
  
  $cc.=  "<label for='tc_s'>Площадь:</label>";
  $cc.= "<input type='text' id='cc_S'  disabled='disabled'> <br>";
  
  $cc.=  "<label for='tc_kolvo'>Количество человек:</label>";
  $cc.= "<input type='text' id='cc_kolvo'  disabled='disabled'> <br>";
  $cc.= "</form>";

  
$cc.= "<table id='table1' border=1 cellspacing=0 cellpadding=2 width=680 px align='center'>";
$cc.= "<tr>";
$cc.= " <td> №</td>";
$cc.= " <td> № счетчика </td>";
$cc.= " <td> Услуга </td>";
$cc.= " <td> Начальные показания </td>";
$cc.= " <td> Конечные показания </td>";
$cc.= " <td> Объем </td>";
$cc.= " <td> Цена </td>";
$cc.= "<td>Сумма</td>";
$cc.= " </tr>";
//$q=$my->query('select '

$cc.="<table id='table' border='1px'>
<tr>
	<td>1</td>
	<td width='0 px'>15</td>
	<td>3</td>
</tr>
<tr>
	<td>4</td>
	<td width='0 px'>15</td>
	<td>6</td>
</tr>
<tr>
	<td>7</td>
	<td width='0 px'>15</td>
	<td>9</td>
</tr>
</table>";    
*/
} ?>