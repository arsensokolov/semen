<?php
if ($_GET['db']=='hs') {
include_once __DIR__.'/../db.php';
$hs='';
if (!isset($_GET['action']))  {
    $hs.= showtable_hs($my);
   } else {
  if (isset($_GET['action'])) {
    if ($_GET['action']=='cancel') {
      echo showtable_hs($my);
      exit();
    }
    if ($_GET['action']=='search') {
      echo showtable_hs($my);
      exit;
    }
    if ($_GET['action']=='new') {
      echo hs_new_form($my);
      exit;
    }
   if ($_GET['action']=='edit') {
      echo showtable_hs($my);
      echo hs_edit_form($my);
      exit;
    }
    if ($_GET['action']=='del') {
      echo showtable_hs($my);
      echo hs_del_form($my);
      exit;
    }
    if ($_GET['action']=='hs_new_data') {
      //echo 'insert into `hs` values ("",'.$_GET['id_house'].','.$_GET['id_service'].' )';
      echo hs_new_data($my);
      echo showtable_hs($my);
      exit;
    }
  if ($_GET['action']=='hs_edit_data') {
      //echo 'update `service_for_house` set id_house='.$_GET['id_house'].' , id_service='.$_GET['id_service'].' where id_sfh='.$_GET['check'];
      echo hs_edit_data($my);
      echo showtable_hs($my);
      exit;  
    }
  if ($_GET['action']=='hs_del_data') {
      echo hs_del_data($my);
      echo showtable_hs($my);
      exit;  
    }
  } 
}
}

function hs_new_data($my) {
  $proc=$my->query('insert into `service_for_house` values ("",'.$_GET['id_house'].','.$_GET['id_service'].','.$_GET['counter'].' )');
  if ($_GET['counter']==1) {
  if ($_GET['hs_counter_direct']>0) {
  for ($i=1; $i<=$_GET['hs_counter_direct'];$i++) {
  $q=$my->query('select max(id_counter) as max from counter_house');
  $row=$q->fetch_assoc();
  if ($row['max']=='') {
  $row['max']=1;
  }
  $w=$my->query('select max(id_sfh) as max from service_for_house');
  $num=$w->fetch_assoc();
  if ($num['max']=='') {
  $num['max']=1;
  }
  $proc=$my->query('insert into counter_house values("",'.$row['max'].','.$num['max'].',1)');
  }
  }
  $i=0;
  if ($_GET['hs_counter_return']>0) {
  for ($i=1; $i<=$_GET['hs_counter_return'];$i++) {
  $q=$my->query('select max(id_counter) as max from counter_house');
  $row=$q->fetch_assoc();
  if ($row['max']=='') {
  $row['max']=1;
  }
  $w=$my->query('select max(id_sfh) as max from service_for_house');
  $num=$w->fetch_assoc();
  if ($num['max']=='') {
  $num['max']=1;
  }
  $proc=$my->query('insert into counter_house values("",'.$row['max'].','.$num['max'].',2)');
  }
  }
  }
  
  unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='hs';
}                   

function hs_edit_data($my) {
 $proc=$my->query('update `service_for_house` set counter='.$_GET['counter'].' , id_house='.$_GET['id_house'].' , id_service='.$_GET['id_service'].' where id_sfh='.$_GET['check']);
 unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='hs';
}

function hs_del_data($my) {
 $proc=$my->query('DELETE FROM `service_for_house` WHERE id_sfh='.$_GET['check']); 
  unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='hs';
}

function hs_del_form($my) {
  $hs.= "<h1>Удаление записи </h1> <br>";
  $hs.= "<center><font color='red'>Вы хотите удалить выбранную запись?</font></center><br>";
  $hs.= "<center><button type=\"button\" id=\"hs_del_data\">Удалить запись</button>";
  $hs.= "<button type=\"button\" id=\"hs_cancel\">Отмена</button></center>";   
  return $hs;
} 

function hs_edit_form($my) {
	$q=$my->query('SELECT  *  FROM  `service_for_house` where  id_sfh='.$_GET['check']);
	$row=$q->fetch_assoc(); 
	$hs.= "<form name='edit' action='index.php' method='get'>";
	$hs.= "<input type='hidden' name='page' value=".$_GET['page'].">";
	$hs.= "<input type='hidden' name='db' value=".$_GET['db'].">";
	$hs.= "<input type='hidden' name='action' value='edit.save'>";
	$hs.= "<input type='hidden' name='id_sfh' value=".$_GET['check'].">";
	$hs.= "<label for='id_house'> Адрес: </label>";
	$hs.= "<select id='id_house' size=1>";
	$adr=$my->query('SELECT * FROM  `house`');
	while (@$num=$adr->fetch_assoc()) {
		if ($row['id_house']<>$num['id_house']) {
			$hs.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
		} else {
			$hs.= "<option value=".$num['id_house']. " selected> ".$num['adress']."</option>";
		}
	}
	$hs.= "</select><br>";
	$hs.= "<label for='id_service'>Организация: </label>";
	$hs.= "<select id='id_service' size=1>";
	$adr=$my->query('SELECT * FROM  `service`');
	while (@$num=$adr->fetch_assoc()) {
		if ($row['id_service']<>$num['id_service'])  {
			$hs.= "<option value=".$num['id_service'].">".$num['name_service']."</option>";
		} else {
			$hs.= "<option value=".$num['id_service']. " selected> ".$num['name_service']."</option>";
		}
		
	}
	$hs.= "</select><br>";
	$hs.= "<label for='hs_edit_counter'>Установлен ли счетчик: </label>";
	$hs.= "<select id='hs_edit_counter' size=1'>";
	if ($row['counter']==0) {
		$hs.= "<option value=0 selected>Не установлен</option>";
		$hs.= "<option value=1>Установлен</option>";
		$hs.= "</select><br>";	
		$hs.= "<div id='div_counter'> </div>";	
	} else {
		$hs.= "<option value=0>Не установлен</option>";
		$hs.= "<option value=1 selected>Установлен</option>";
		$hs.= "</select><br>";
		$hs.= "<div id='div_counter'> ";
		$q=$my->query('select * from counter_house where id_hs='.$_GET['check']);
		$hs.= "<table border=1 cellspacing=0 cellpadding=2 width=680 px align='center'>";
		$hs.= "<tr>";
		$hs.= " <td> № счетчика</td>";
		$hs.= " <td> Тип счетчика</td>";
		$hs.= "<td></td>";
		$hs.= " </tr>";
		while (@$row=$q->fetch_assoc()) 	{
			$hs.= " <tr>";
			$hs.= "<td>".$row['id_counter']."</td>";
			if ($row['counter_type']==1) {
				$hs.= "<td>Подача</td>";
			} else {
				$hs.= "<td>Обратка</td>";
			}
			$hs.= "<td><input type='radio' name = 'c_check' id = 'c_check'value=".$row['id']."></td>";
			$hs.= " </tr>";
		}
		$hs.= "</table> <br>";
		$hs.= "<center><button type=\"button\" id='hs_counter_add'>Добавить</button> " ;
		$hs.= "<button type=\"button\" id='hs_counter_del'>Удалить</button> </center><br><br>" ;
		$hs.= "</div>";
		$hs.= "<div id='div_counter'> </div>";
	}

	$hs.= "<button type=\"button\" id=\"hs_edit_data\">Сохранить</button></center>"; 
	$hs.= "<button type=\"button\" id=\"hs_cancel\">Отмена</button></center>";
	$hs.= "</form>";
	return $hs;
}

function hs_new_form($my) {
$hs.= "<h1>Новая запись </h1> <br><br>";
$hs.= "<form name='edit' action='index.php' method='get'>";
$hs.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$hs.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$hs.= "<input type='hidden' name='action' value='new.save'>";

$hs.= "<label for='id_house'> Адрес: </label>";
$hs.= "<select id='id_house' size=1>";
$adr=$my->query('SELECT * FROM  `house`');
while (@$num=$adr->fetch_assoc()) {
    $hs.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
}
$hs.= "</select><br>";

$hs.= "<label for='id_service'>Услуга: </label>";
$hs.= "<select id='id_service' size=1>";
$adr=$my->query('SELECT * FROM  `service`');
while (@$num=$adr->fetch_assoc()) {
    $hs.= "<option value=".$num['id_service'].">".$num['name_service']."</option>";
}
$hs.= "</select><br>";

  $hs.= "<label for='hs_new_counter'>Установлен ли счетчик: </label>";
  $hs.= "<select id='hs_new_counter' size=1'>";
  $hs.= "<option value=0>Не установлен</option>";
  $hs.= "<option value=1>Установлен</option>";
	$hs.= "</select><br>";

  $hs.= "<div id='div_counter'> </div>";

$hs.= "<button type=\"button\" id=\"hs_new_data\">Сохранить</button></center>"; 
$hs.= "<button type=\"button\" id=\"hs_cancel\">Отмена</button></center>";
$hs.= "</form>";
return $hs;
}

function showtable_hs($my) {
$hs.= "<h1>Услуги дома</h1>";
if (!isset($_GET['check'])) {
$hs.= "<input type='text' id='hs_search_text' placeholder='Введите первые буквы адреса'> ";
$hs.= "<button type=\"button\" id='hs_search'>Поиск</button> <br><br>" ;
}
if (isset($_GET['search'])) { 
if ($_GET['search'] != '') {
	$q=$my->query('SELECT  sfh.*, h.adress, s.name_service FROM  `service_for_house` sfh join house h on h.id_house=sfh.id_house join service s on s.id_service=sfh.id_service where h.adress like "%'.$_GET['search'].'%"  ');
}} 
if (isset($_GET['check'])) {
  $q=$my->query('SELECT  sfh.*, h.adress, s.name_service FROM  `service_for_house` sfh join house h on h.id_house=sfh.id_house join service s on s.id_service=sfh.id_service where sfh.id_sfh='.$_GET['check']);
    //echo 'SELECT  sfh.*, h.adress, s.name_service FROM  `service_for_house` sfh join house h on h.id_house=sfh.id_house join service s on s.id_service=sfh.id_service where sfh.id_sfh='.$_GET['check'];
 
} 
  if (((!isset($_GET['search'])) && (!isset($_GET['check']))) || (($_GET['search'] == '') &&  (!isset($_GET['check']))))  {
	$q=$my->query('SELECT  sfh.*, h.adress, s.name_service FROM  `service_for_house` sfh join house h on h.id_house=sfh.id_house join service s on s.id_service=sfh.id_service order by h.adress' );
}
#Создние таблицы

$hs.= "<form name='table' action='index.php' method='get'>";
$hs.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$hs.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$hs.= "<input type='hidden' name='action' value=edit.show>";
$hs.= "<table border=1 cellspacing=0 cellpadding=2 width=680 px align='center'>";
$hs.= "<tr>";
$hs.= " <td> №</td>";
$hs.= " <td> Адрес </td>";
$hs.= " <td> Услуга </td>";
$hs.= "<td></td>";
$hs.= "<td></td>";
$hs.= " </tr>";

    $k=1;
while (@$row=$q->fetch_assoc()) {
	$hs.= " <tr>";
	$hs.= "<td>".$k."</td>";
	$hs.= "<td>".$row['adress']."</td>";
  $hs.= "<td>".$row['name_service']."</td>";
    if ($row['counter']==0) {
  $hs.= "<td>Не установлен</td>"; }
  else {$hs.= "<td>Установлен</td>";}
  if (!isset($_GET['check'])) {
	$hs.= "<td><input type='radio' name = 'check' value=".$row['id_sfh']."></td>";
  } else {
  $hs.= "<td><input type='radio' name = 'check' value=".$row['id_sfh']." checked></td>";
  }
	$hs.= " </tr>";
  $k++;
}
$hs.= "</table>";
$hs.= "<br>";
if (!isset($_GET['action']) || ($_GET['action']=='cancel') || ($_GET['action']=='search')) { 
    $hs.= "<button type=\"button\" id=\"hs_new\">Новая запись</button>" ;   
    $hs.= "<button type=\"button\" id=\"hs_edit\">Редактировать запись</button>";
    $hs.= "<button type=\"button\" id=\"hs_del\">Удалить запись</button>";
  }
$hs.= "</form>";
return $hs;
}
?>
