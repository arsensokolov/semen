<?php
if ($_GET['db']=='adress') {
include_once __DIR__.'/../db.php';
$adress='';
$k=$my->query("SET NAMES utf8");

 if (!isset($_GET['action']))  {
    $adress.= showtable_adress($my);
   } else {
  if (isset($_GET['action'])) {
    if ($_GET['action']=='cancel') {
      echo showtable_adress($my);
      exit();
    }
    if ($_GET['action']=='search') {
      echo showtable_adress($my);
      exit;
    }
    if ($_GET['action']=='new') {
      echo adress_new_form($my);
      exit;
    }
  if ($_GET['action']=='edit') {
      echo showtable_adress($my);
      echo adress_edit_form($my);
      exit;
    }
   if ($_GET['action']=='del') {
      echo showtable_adress($my);
      echo adress_del_form($my);
      exit;
    } 
  if ($_GET['action']=='adr_new_data') {
      echo adr_new_data($my);
      echo showtable_adress($my);
      exit;
    }
  if ($_GET['action']=='adr_edit_data') {
      echo adr_edit_data($my);
      echo showtable_adress($my);
      exit;  
    }
  if ($_GET['action']=='adr_del_data') {
      echo adr_del_data($my);
      echo showtable_adress($my);
      exit;  
    }  
  } 
} 
}

function adr_new_data($my) {
 $proc=$my->query('insert into `house` values ("",\''.$_GET['adress'].'\',\''. 
  $_GET['full_adress'].'\',\''.$_GET['quality_quarters'].'\',\''.
  $_GET['quantity_flat'].'\','.$_GET['square'].')');
  unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='adress';
}

function adr_edit_data($my) {
 $proc=$my->query('update `house` set adress="'.$_GET['adress'].'", 
   full_adress="'.$_GET['full_adress'].'", quality_quarters="'.$_GET['quality_quarters'].'", quantity_flat='.
   $_GET['quantity_flat'].',square='.$_GET['square'].' where id_house='.$_GET['check']);
  unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='adress';
}
function adr_del_data($my) {
 $proc=$my->query('DELETE FROM `house` WHERE id_house='.$_GET['check']); 
  unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='adress';
}

function adress_del_form($my) {
 $adress.= "<h1>Удаление записи </h1> <br>";
  $bool=false;
  $q=$my->query('select  *  from  `the_tenant` where  id_house='.$_GET['check']);
if ($q->num_rows<>0) {
  $bool=true;
  $adress.="По данному адресу проживают следующие жители:<br>";
  while (@$row=$q->fetch_assoc()) {  
    $adress.='кв. '.$row['number_flat']. ' '.$row['surname'];
    $adress.="<br>" ;
  }
  }
  // $q=$my->query('select  *  from  `common_parts` where  house='.$_GET['check']);
// if ($q->num_rows<>0) {
  // $bool=true;
  // $adress.="У данного дома имеются показания счетчиков:";
 // }
   $q=$my->query('select  *  from  `service_for_house` sfh join service s on sfh.id_service=s.id_service where  id_house='.$_GET['check']);
if ($q->num_rows<>0) {
  $bool=true;
  $adress.="К данному дому прикреплены следующие услуги:<br>";
  while (@$row=$q->fetch_assoc()) {  
    $adress.=$row['name_service'];
    $adress.="<br>" ;
  }
  }
  if ($bool==true) {
  $adress.= "<font color='red'>Удалите данные записи, после чего повторите процедуру <br></font>";
  $adress.= "<center><button type=\"button\" id=\"adr_cancel\">Отмена</button></center>";
  $q->close();
 } else {
  $adress.= "<center>Вы хотите удалить выбранную запись?</center>";
  $adress.= "<center><button type=\"button\" id=\"adr_del_data\">Удалить запись</button>";
  $adress.= "<button type=\"button\" id=\"adr_cancel\">Отмена</button></center>";   
 }
 return $adress;
}
function adress_edit_form($my) {
  $q=$my->query('SELECT *  FROM  `house` where id_house='.$_GET['check']);
	@$row=$q->fetch_assoc();
	$adress.= "<form name='edit' action='index.php' method='get'>";
	$adress.= "<input type='hidden' name='page' value=".$_GET['page'].">";
	$adress.= "<input type='hidden' name='db' value=".$_GET['db'].">";
	$adress.= "<input type='hidden' name='action' value='edit.save'>";
	
	$adress.= "<input type='hidden' id='id_house' value=".$row['id_house']."> <br>";
  $adress.= "<label for='adress'> Адрес: </label>";
	$adress.= "<input type='text' id='adress' value=\"".$row['adress']."\"> <br>";
	
	$adress.= "<label for='full_adress'> Полный адрес: </label>";
	$adress.= "<input type='text' id='full_adress' value=\"".$row['full_adress']."\"><br>";
	
	$adress.= "<label for='quality_quarters'> Качество жилья: </label>";
	$adress.= "<input type='text' id='quality_quarters' value=".$row['quality_quarters']."><br>";
	
	$adress.= "<label for='quantity_flat'> Количество квартир: </label>";
	$adress.= "<input type='text' id='quantity_flat' value=".$row['quantity_flat']."><br>";
  
  $adress.= "<label for='square'> Общая площадь: </label>";
	$adress.= "<input type='text' id='square' value=".$row['square']."><br>";
  
  // $adress.= "<label for='counter'> Счетчик: </label>";
  // $adress.= "<select id='counter' size=1>";
  // if ($row['counter']==1) {
  // $adress.= "<option value='0'>Не установлен</option>";
  // $adress.= "<option value='1' selected=''>Установлен</option>";
  // }
  // if ($row['counter']==0) {
  // $adress.= "<option value='0' selected=''>Не установлен</option>";
  // $adress.= "<option value='1'>Установлен</option>";
  // } 
  // $adress.= "</select><br>";
  $adress.= "<button type=\"button\" id=\"adr_edit_data\">Сохранить</button></center>"; 
  $adress.= "<button type=\"button\" id=\"adr_cancel\">Отмена</button></center>";
  $adress.= "</form>";
  return $adress;
}

function adress_new_form($my) {
$adress.= "<h1>Новая запись </h1> <br><br>";
$adress.= "<form name = 'new' action='index.php' method='get'>";
$adress.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$adress.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$adress.= "<input type='hidden' name='action' value='new.save'>";

$adress.= "<label for='adress'> Адрес: </label>";
	$adress.= "<input type='text' id='adress'> <br>";
	
	$adress.= "<label for='full_adress'> Полный адрес: </label>";
	$adress.= "<input type='text' id='full_adress'><br>";
	
	$adress.= "<label for='quality_quarters'> Качество жилья: </label>";
	$adress.= "<input type='text' id='quality_quarters'><br>";
	
	$adress.= "<label for='quantity_flat'> Количество квартир: </label>";
	$adress.= "<input type='text' id='quantity_flat'><br>";
  
  $adress.= "<label for='square'> Общая площадь: </label>";
	$adress.= "<input type='text' id='square' value=".$row['quantity_flat']."><br>";
  
  // $adress.= "<label for='counter'> Счетчик: </label>";
	// $adress.= "<select id='counter' size=1>";
  // $adress.= "<option value='0'>Не установлен</option>";
  // $adress.= "<option value='1'>Установлен</option>";
  // $adress.= "</select><br>";

  $adress.= "<button type=\"button\" id=\"adr_new_data\">Сохранить</button></center>"; 
  $adress.= "<button type=\"button\" id=\"adr_cancel\">Отмена</button></center>";
  $adress.= "</form>";
 return $adress; 
}

function showtable_adress($my) {
$adress.= "<h1>Жилфонд</h1>";
if (!isset($_GET['check'])) {
$adress.= "<input type='text' id='adr_search_text' placeholder='Введите первые буквы адреса'> ";
$adress.= "<button type=\"button\" id='adr_search'>Поиск</button> <br><br>" ;
}
if (isset($_GET['search'])) { 
if ($_GET['search'] != '') {
	$q=$my->query('SELECT *  FROM  `house` WHERE adress LIKE "%'.$_GET['search'].'%"');
}} 
if (isset($_GET['check'])) {
  $q=$my->query('SELECT *  FROM  `house` where id_house='.$_GET['check']);
} 
if (((!isset($_GET['search'])) && (!isset($_GET['check']))) || (($_GET['search'] == '') &&  (!isset($_GET['check']))))  {
	$q=$my->query('SELECT *  FROM  `house` order by adress');
}
#Создние таблицы
$adress.= "<form name='table' action='index.php' method='get'>";
$adress.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$adress.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$adress.= "<input type='hidden' name='action' value=edit.show>";
$adress.= "<table border=1 cellspacing=0 cellpadding=2 width=700 px align='center'>";
$adress.= "<tr>";
$adress.= " <td align='center'> № </td>";
$adress.= " <td align='center'> № дома </td>";
$adress.= " <td align='center'> Полный адрес </td>";
$adress.= " <td align='center'> Качество </td>";
$adress.= " <td align='center'> Кол-во квартир </td>";
$adress.= " <td align='center'> Общая площадь </td>";
// $adress.= " <td align='center'> Счетчик </td>";
$adress.= "<td></td>";
$adress.= " </tr>";
 $k=1;
while (@$row=$q->fetch_assoc()) {
	$adress.= " <tr>";
	$adress.= "<td>".$k."</td>";
	$adress.= "<td>".$row['adress']."</td>";
	$adress.= "<td>".$row['full_adress']."</td>";
	$adress.= "<td>".$row['quality_quarters']."</td>";
	$adress.= "<td>".$row['quantity_flat']."</td>";
  $adress.= "<td>".$row['square']."</td>";
  // if ($row['counter']==1) { 
  // $adress.= "<td>Установлен</td>";
  // } else {
  // $adress.= "<td>Не установлен</td>";
  // }
   if (!isset($_GET['check'])) {
  $adress.= "<td><input type='radio' name = 'check' value=".$row['id_house']."></td>";
  } else {
  $adress.= "<td><input type='radio' name = 'check' value=".$row['id_house']." checked></td>";
  }
	$adress.= " </tr>";
  $k++; 
}
$adress.= "</table>";
$adress.= "<br>";
  if (!isset($_GET['action']) || ($_GET['action']=='cancel') || ($_GET['action']=='search')) { 
    $adress.= "<button type=\"button\" id=\"adr_new\">Новая запись</button>" ;   
    $adress.= "<button type=\"button\" id=\"adr_edit\">Редактировать запись</button>";
    $adress.= "<button type=\"button\" id=\"adr_del\">Удалить запись</button>";
  }

$adress.= "</form>";
return $adress;
}
?>
