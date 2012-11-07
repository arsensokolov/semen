<?php
if ($_GET['db']=='tc') {
include_once __DIR__.'/../db.php';
$k=$my->query("SET NAMES utf8");
$tc='';

if (!isset($_GET['action']))  {
    $tc.= showtable_tc($my);
   } else {
  if (isset($_GET['action'])) {
    if ($_GET['action']=='cancel') {
      echo showtable_tc($my);
      exit();
    }
    if ($_GET['action']=='search') {
      echo showtable_tc($my);
      exit;
    }
    if ($_GET['action']=='new') {
      echo tc_new_form($my);
      exit;
    }
    if ($_GET['action']=='edit') {
      echo showtable_tc($my);
      echo tc_edit_form($my);
      exit;
    }
   if ($_GET['action']=='del') {
      echo showtable_tc($my);
      echo tc_del_form($my);
      exit;
    }
  if ($_GET['action']=='tc_new_data') {
      echo tc_new_data($my);
      echo showtable_tc($my);
      exit;
    }
  if ($_GET['action']=='tc_edit_data') {
      echo tc_edit_data($my);
      echo showtable_tc($my);
      exit;  
    }
  if ($_GET['action']=='tc_del_data') {
      echo tc_del_data($my);
      echo showtable_tc($my);
      exit;  
    } 
  } 
}  
}
 
function tc_new_data($my) {
   $proc=$my->query('insert into `tenant_card` values ("",'.$_GET['id_service'].','.$_GET['id_tenant'].','.$_GET['amount'].','.$_GET['counter'].')');
   if (($_GET['counter']==1)) {
   $g=$my->query('select max(id_card) as max from tenant_card');
   $r=$g->fetch_assoc();
   $max=$r['max'];
  $fun =$my->query('insert into counter values ("", '.$max.' , ' .$max.')'); 
  }
    unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='tc';
}                   
                   

function tc_edit_data($my) {
  $proc=$my->query('update `tenant_card` set id_service='.$_GET['id_service'].', amount='.$_GET['amount'].', counter= '.$_GET['counter']. ' where id_card='.$_GET['check']);
   if (($_GET['old_counter']==0) &&  ($_GET['counter']==1)) {
   $g=$my->query('select max(id) as max from counter');
   $r=$g->fetch_assoc();
   $max=$r['max'];
   if ($max=='') {$max=1;} else {$max++;}
   $fun=$my->query('insert into counter values ("", '.$_GET['check'].' , ' .$_GET['check'].')'); 
   //echo 'insert into counter values ("", '.$_GET['id_service'].$_GET['id_tenant'].' , ' .$_GET['id_tenant'].' , '.$_GET['id_service'].')';
   }
   if ($_GET['old_counter']==1 &&  $_GET['counter']==0) {
  $proc=$my->query('delete from counter id_counter= '.$_GET['id_service'].$_GET['id_tenant']); 
   }
    unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='tc';
}
 
function tc_del_data($my) {
 $proc=$my->query('DELETE FROM `tenant_card` WHERE id_card='.$_GET['check']); 
  unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='tc';
}

function tc_del_form($my) {
  $tc.= "<center><font color='red'>Вы хотите удалить выбранную запись?</font></center><br>";
  $tc.= "<center><button type=\"button\" id=\"tc_del_data\">Удалить запись</button>";
  $tc.= "<button type=\"button\" id=\"tc_cancel\">Отмена</button></center>";
  return $tc;   
} 

function tc_edit_form($my) {
  $q=$my->query('SELECT  *  FROM  `tenant_card` tc join `the_tenant` t on t.id_tenant=tc.id_tenant where  id_card='.$_GET['check']);
	@$row=$q->fetch_assoc();        
	$tc.= "<br><br><form name='edit' action='index.php' method='get'>";
	$tc.= "<input type='hidden' name='page' value=".$_GET['page'].">";
	$tc.= "<input type='hidden' name='db' value=".$_GET['db'].">";
	$tc.= "<input type='hidden' name='action' value='edit.save'>";
	$tc.= "<input type='hidden' name='id_card' value=".$_GET['check'].">";
	$tc.= "<input type='hidden' name='id_tenant' id='tc_edit_id_tenant' value=".$row['id_tenant'].">";
	$tc.= "<label for='tenant'> Квартиросъемщик: </label>";
	$tc.= "<label for='tenant'>".$row['surname']."</label> <br> <br>";
	$tc.= "<label for='id_service'>Услуга: </label>";
	$tc.= "<select name='tc_edit_service' size=1 id='tc_edit_service'>";
	$adr=$my->query('SELECT * FROM  `service`');
	while (@$num=$adr->fetch_assoc()) {
		if ($row['id_service']<>$num['id_service'])  {
		    $tc.= "<option value=".$num['id_service'].">".$num['name_service']."</option>";
		}  else {
			$tc.= "<option value=".$num['id_service']. " selected> ".$num['name_service']."</option>";
		}
	}
	$tc.= "</select><br>";
	
	$tc.= "<label for='amount'>Сумма:</label>";
	$tc.= "<input type='text' name='amount' id='tc_edit_amount' value=\"".$row['amount']."\"> <br>";
	
  $tc.= "<label for='tc_edit_counter'>Установлен ли счетчик: </label>";
  
  $tc.= "<input type='hidden' name='old_counter' id='tc_old_counter' value=".$row['counter'].">";
  $tc.= "<select id='tc_edit_counter' size=1'>";
  if ($row['counter']==0) {
  $tc.= "<option value=0 selected>Не установлен</option>";
  $tc.= "<option value=1>Установлен</option>";
   } else {
  $tc.= "<option value=0>Не установлен</option>";
  $tc.= "<option value=1 selected>Установлен</option>";
   }
   $tc.= "</select><br>";
	 $tc.= "<button type=\"button\" id=\"tc_edit_data\">Сохранить</button></center>"; 
  $tc.= "<button type=\"button\" id=\"tc_cancel\">Отмена</button></center>";
  $tc.= "</form>";
  return $tc;
}

function tc_new_form($my) {
 $tc.= "<h1>Новая запись </h1> <br><br>";
  $tc.= "<form name='new' action='index.php' method='get'>";
  $tc.= "<input type='hidden' name='page' value=".$_GET['page'].">";
  $tc.= "<input type='hidden' name='db' value=".$_GET['db'].">";
  $tc.= "<input type='hidden' name='action' value='new.save'>";
  $tc.= "<input type='hidden' name='tc_new_id_tenant' id='tc_new_id_tenant'>";
  #$tc.= "<label for='tenant'> Квартиросъемщик: </label>";
  #$tc.= "<label for='tenant'>".$row['surname']."</label> <br> <br>";
  #$tc.= "<input type='text' name='name_domain' value=\"".$row['surname']."\"> <br>";
  $tc.= "<label for='tc_id_house'> Адрес: </label>";
  $tc.= "<select id='tc_id_house'  size=1>";
  $adr=$my->query('SELECT * FROM  `house`');
  while (@$num=$adr->fetch_assoc()) {
    $tc.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
  }
  $tc.= "</select><br>";
  
  
  $tc.=  "<label for='tc_number_flat'>Квартира:</label>";
  $tc.= "<input type='text' id='tc_number_flat' > <br>";
  
  $tc.=  "<label for='tc_fio'>Лицевой счет:</label>";
  $tc.= "<input type='text' id='tc_id_tenant' disabled='disabled'> <br>";
    
  $tc.=  "<label for='tc_fio'>ФИО:</label>";
  $tc.= "<input type='text' id='tc_fio' disabled='disabled'> <br>";
  
  $tc.=  "<label for='tc_s'>Площадь:</label>";
  $tc.= "<input type='text' id='tc_S'  disabled='disabled'> <br>";
  
  $tc.=  "<label for='tc_kolvo'>Количество человек:</label>";
  $tc.= "<input type='text' id='tc_kolvo'  disabled='disabled'> <br>";
  
  $tc.= "<label for='tc_id_service'>Услуга: </label>";
  $tc.= "<select id='tc_id_service' size=1 '>";
  $adr=$my->query('SELECT * FROM  `service`');
    while ($num=$adr->fetch_assoc()) {
		$tc.= "<option value=".$num['id_service'].">".$num['name_service']."</option>";
	}
  $tc.= "</select><br>";
  
  $tc.=  "<label for='tc_amount'>Сумма:</label>";
  $tc.= "<input type='text' id='tc_amount' id='tc_amount' value=\"".$row['amount']."\"> <br>";
  
  $tc.= "<label for='tc_new_counter'>Установлен ли счетчик: </label>";
  $tc.= "<select id='tc_new_counter' size=1'>";
  $tc.= "<option value=0>Не установлен</option>";
  $tc.= "<option value=1>Установлен</option>";
	$tc.= "</select><br>"; 
   
  $tc.= "<button type=\"button\" id=\"tc_new_data\">Сохранить</button></center>"; 
  $tc.= "<button type=\"button\" id=\"tc_cancel\">Отмена</button></center>";
  $tc.= "</form>";
  return $tc;
}

function showtable_tc($my) {
$tc.= "<h1>Карточка квартиросъемщика</h1>";
if (!isset($_GET['check'])) {
$tc.= "Адрес:<br>" ;
$tc.= "<select id='tc_search_house' size=1>";
  $adr=$my->query('SELECT id_house, adress FROM  `house`');
  while (@$num=$adr->fetch_assoc()) {
    $tc.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
  }
  $tc.= "</select><br>";
$tc.= "Квартира:<br>" ;
$tc.= "<input type='text' id='tc_search_kv' placeholder='Введите номер квартиры'>";
$tc.= "<button type=\"button\" id='tc_search'>Поиск</button> <br><br>" ;
}

if ((isset($_GET['tc_search_kv'])) && (isset($_GET['tc_search_house']))) { 
if ($_GET['tc_search_kv'] != '') {
	$q=$my->query('SELECT tc.*, h.adress,t.id_house, t.number_flat, t.surname, s.name_service FROM `tenant_card` tc join the_tenant t on t.id_tenant=tc.id_tenant join house h on h.id_house=t.id_house join service s on s.id_service=tc.id_service  where t.id_house ='.$_GET['tc_search_house'].' and t.number_flat='.$_GET['tc_search_kv']);
  }} 
if (isset($_GET['check'])) {
  $q=$my->query('SELECT * FROM `tenant_card` tc join the_tenant t on t.id_tenant=tc.id_tenant join house h on h.id_house=t.id_house join service s on s.id_service=tc.id_service where tc.id_card='.$_GET['check']);
 } 
  if (((!isset($_GET['tc_search_kv'])) && (!isset($_GET['check']))) || (($_GET['tc_search_kv'] == '') &&  (!isset($_GET['check']))))  {
	$q=$my->query('SELECT tc.*, h.adress, t.number_flat, t.surname, s.name_service FROM `tenant_card` tc join the_tenant t on t.id_tenant=tc.id_tenant join house h on h.id_house=t.id_house join service s on s.id_service=tc.id_service order by h.adress, t.number_flat LIMIT 50');
}
#Создние таблицы

$tc.= "<form name='table' action='index.php' method='get'>";
$tc.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$tc.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$tc.= "<input type='hidden' name='action' value=edit.show>";
$tc.= "<table border=1 cellspacing=0 cellpadding=2 width=680 px align='center'>";
$tc.= "<tr>";
$tc.= " <td> №</td>";
$tc.= " <td> Адрес </td>";
$tc.= " <td> № квартиры </td>";
$tc.= " <td> Фамилия </td>";
$tc.= " <td> Услуга </td>";
$tc.= " <td> Сумма </td>";
$tc.= " <td> Счетчик </td>";
$tc.= "<td></td>";
$tc.= " </tr>";
 $summ=0;
    $k=1;
while (@$row=$q->fetch_assoc()) {
	$tc.= " <tr>";
	$tc.= "<td>".$k."</td>";
	$tc.= "<td>".$row['adress']."</td>";
  $tc.= "<td>".$row['number_flat']."</td>";
  $tc.= "<td>".$row['surname']."</td>";
  $tc.= "<td>".$row['name_service']."</td>";
  $tc.= "<td>".$row['amount']."</td>";
  if ($row['counter']==0) {
  $tc.= "<td>Не установлен</td>"; }
  else {$tc.= "<td>Установлен</td>";}
  if (!isset($_GET['check'])) {
	$tc.= "<td><input type='radio' name = 'check' value=".$row['id_card']."></td>";
  } else {
  $tc.= "<td><input type='radio' name = 'check' value=".$row['id_card']." checked></td>";
  }
	$tc.= " </tr>";
  $k++;
  $summ=$summ+$row['amount'];
}
	$tc.= " <tr>";
	$tc.= "<td></td>";
	$tc.= "<td></td>";
  $tc.= "<td></td>";
  $tc.= "<td></td>";
  $tc.= "<td>Итого</td>";
  $tc.= "<td>".$summ."</td>";
	$tc.= "<td></td>";
  $tc.= "<td></td>";
	$tc.= " </tr>";
$tc.= "</table>";
$tc.= "<br>";

if (!isset($_GET['action']) || ($_GET['action']=='cancel') || ($_GET['action']=='search')) { 
    $tc.= "<button type=\"button\" id=\"tc_new\">Новая запись</button>" ;   
    $tc.= "<button type=\"button\" id=\"tc_edit\">Редактировать запись</button>";
    $tc.= "<button type=\"button\" id=\"tc_del\">Удалить запись</button>";
  }
$tc.= "</form>"; 
return $tc;
}

 
?>
