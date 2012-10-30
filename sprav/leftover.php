<?php
if ($_GET['db']=='leftover') {
$path='/var/www/html/';
include_once $path.'db.php';
$leftover='';

if (!isset($_GET['action']))  {
    $leftover.= showtable_lef($my);
   } else {
  if (isset($_GET['action'])) {
    if ($_GET['action']=='cancel') {
      echo showtable_lef($my);
      exit();
    }
    if ($_GET['action']=='search') {
      echo showtable_lef($my);
      exit;
    }
    if ($_GET['action']=='new') {
      echo lef_new_form($my);
      exit;
    }
    if ($_GET['action']=='edit') {
      echo showtable_lef($my);
      echo lef_edit_form($my);
      exit;
    }
   if ($_GET['action']=='del') {
      echo showtable_lef($my);
      echo lef_del_form($my);
      exit;
    }
  if ($_GET['action']=='lef_new_data') {
      echo lef_new_data($my);
     // echo showtable_lef($my);
      exit;
    }
  if ($_GET['action']=='lef_edit_data') {
      echo lef_edit_data($my);
      echo showtable_lef($my);
      exit;
    }
  if ($_GET['action']=='lef_del_data') {
      echo lef_del_data($my);
      echo showtable_lef($my);
      exit;
    }
  }
}
}

/*$leftover.= "<form name='lo_search' action='index.php' method='get'>";
$leftover.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$leftover.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$leftover.= "<select name='lo_search_id_house' id='lo_id_house' size=1>";
  $adr=mysql_query('SELECT * FROM  `house`');
  while (@$num=mysql_fetch_assoc($adr)) {
    $leftover.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
  }
  $leftover.= "</select><br>";
$leftover.= "<br>" ;
$leftover.= "<input type='text' name='lo_search_kv' id='search' placeholder='Найти...'>";


$leftover.= "<button type='submit'>Найти</button>";
$leftover.= "<br> " ;
$leftover.= "<br>" ;
$leftover.= "</form>";   



#Сохранение отредактированной записи
if (isset($_GET['action']) && ($_GET['action']=='edit.save')) {
  #$leftover.= 'update `tenant_card` set amount='.$_GET['amount'].', id_service='.$_GET['id_service'].', id_tenant='.$_GET['id_tenant'].' where id_card='.$_GET['id_card']; 
 
  header("Location: index.php?page=spravochnik&db=leftover");
  exit();                                               

}   
#Сохранение новой записи
if (isset($_GET['action']) && ($_GET['action']=='new.save')) {
  $q=mysql_query('select max(id_leftover) as max from `leftover`');
  @$row=mysql_fetch_assoc($q);
  $proc=mysql_query('insert into `leftover` values ("",'.$_GET['tc_new_id_tenant'].','.$_GET['tc_id_service'].','.$_GET['lo_amount'].',"'.$_GET['lo_node'].'")');
//$leftover.= 'insert into `leftover` values ("",'.$_GET['tc_new_id_tenant'].','.$_GET['tc_id_service'].','.$_GET['lo_amount'].',"'.$_GET['lo_node'].'")';
header("Location: index.php?page=spravochnik&db=leftover");
exit;
}
 
#Поиск
if ((isset($_GET['lo_search_kv'])) && (isset($_GET['lo_search_id_house']))) { 

}
#Редактирование выбранной записи
if (isset($_GET['action']) && ($_GET['action']=='edit.show') && (isset($_GET['check'])))   {
	$q=mysql_query('SELECT  *  FROM  `leftover` l join `the_tenant` t on t.id_tenant=l.id_tenant where  id_leftover='.$_GET['check']);
	@$row=mysql_fetch_assoc($q);        
	$leftover.= "<br><br><form name='edit' action='index.php' method='get'>";
	$leftover.= "<input type='hidden' name='page' value=".$_GET['page'].">";
	$leftover.= "<input type='hidden' name='db' value=".$_GET['db'].">";
	$leftover.= "<input type='hidden' name='action' value='edit.save'>";
	$leftover.= "<input type='hidden' name='id_leftover' value=".$_GET['check'].">";
	$leftover.= "<input type='hidden' name='id_tenant' id='id_tenant' value=".$row['id_tenant'].">";
	$leftover.= "<label for='tenant'> Квартиросъемщик: </label>";
	$leftover.= "<label for='tenant'>".$row['surname']."</label> <br> <br>";
	#$leftover.= "<input type='text' name='name_domain' value=\"".$row['surname']."\"> <br>";
	
	$leftover.= "<label for='id_service'>Услуга: </label>";
	$leftover.= "<select name='id_service' size=1 id='id_service'>";
	$adr=mysql_query('SELECT * FROM  `service`');
	while (@$num=mysql_fetch_assoc($adr)) {
		if ($row['id_service']<>$num['id_service'])  {
		    $leftover.= "<option value=".$num['id_service'].">".$num['name_service']."</option>";
		}  else {
			$leftover.= "<option value=".$num['id_service']. " selected> ".$num['name_service']."</option>";
		}
	}
	$leftover.= "</select><br>";
	
	$leftover.= "<label for='amount'>Сумма:</label>";
	$leftover.= "<input type='text' name='amount' id='amount' value=\"".$row['amount']."\"> <br>";
	
	
	$leftover.= "<button type='submit'>Сохранить</button>";
}

 
#Создание новой записи
if (isset($_GET['action']) && ($_GET['action']=='new.show')) {
  $leftover.= "<h1>Новая запись </h1> <br><br>";
  $leftover.= "<form name='new' action='index.php' method='get'>";
  $leftover.= "<input type='hidden' name='page' value=".$_GET['page'].">";
  $leftover.= "<input type='hidden' name='db' value=".$_GET['db'].">";
  $leftover.= "<input type='hidden' name='action' value='new.save'>";
  $leftover.= "<input type='hidden' name='id_leftover' value=".$_GET['check'].">";
  $leftover.= "<input type='hidden' name='tc_new_id_tenant' id='tc_new_id_tenant'>";
  #$leftover.= "<label for='tenant'> Квартиросъемщик: </label>";
  #$leftover.= "<label for='tenant'>".$row['surname']."</label> <br> <br>";
  #$leftover.= "<input type='text' name='name_domain' value=\"".$row['surname']."\"> <br>";
  $leftover.= "<label for='tc_id_house'> Адрес: </label>";
  $leftover.= "<select name='tc_id_house' id='tc_id_house' size=1>";
  $adr=mysql_query('SELECT * FROM  `house`');
  while (@$num=mysql_fetch_assoc($adr)) {
    $leftover.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
  }
  $leftover.= "</select><br>";


  $leftover.=  "<label for='tc_number_flat'>Квартира:</label>";
  $leftover.= "<input type='text' name='tc_number_flat' id='tc_number_flat'> <br>";

  $leftover.=  "<label for='tc_fio'>ФИО:</label>";
  $leftover.= "<input type='text' name='tc_fio' id='tc_fio' disabled='disabled'> <br>";

  $leftover.=  "<label for='tc_s'>Площадь:</label>";
  $leftover.= "<input type='text' name='tc_S' id='tc_S' disabled='disabled'> <br>";

  $leftover.=  "<label for='tc_kolvo'>Количество человек:</label>";
  $leftover.= "<input type='text' name='tc_kolvo' id='tc_kolvo' disabled='disabled'> <br>";

  $leftover.= "<label for='tc_id_service'>Услуга: </label>";
  $leftover.= "<select name='tc_id_service' size=1 id='tc_id_service'>";
  $adr=mysql_query('SELECT * FROM  `service`');
    while (@$num=mysql_fetch_assoc($adr)) {
		$leftover.= "<option value=".$num['id_service'].">".$num['name_service']."</option>";
	}
  $leftover.= "</select><br>";

  $leftover.=  "<label for='lo_amount'>Сумма:</label>";
  $leftover.= "<input type='text' name='lo_amount' id='lo_amount' value=\"".$row['amount']."\"> <br>";

  $leftover.=  "<label for='lo_kolvo'>Примечание:</label>";
  $leftover.= "<input type='text' name='lo_node' id='lo_node'> <br>";


  $leftover.= "<button type='submit'>Сохранить</button>";
  $leftover.= "</form>";
}
*/
function lef_new_data($my) {
  $proc=$my->query('insert into `leftover` values ("",'.$_GET['lef_new_id_tenant'].','.$_GET['lef_new_id_service'].','.$_GET['lef_new_amount'].',"'.$_GET['lef_new_node'].'")');
  //echo 'insert into `leftover` values ("",'.$_GET['lef_new_id_tenant'].','.$_GET['lef_new_id_service'].','.$_GET['lef_new_amount'].',"'.$_GET['lef_new_node'].'")';
 unset ($_GET);
 $_GET['page']='spravochnik';
 $_GET['db']='leftover';
}

function lef_edit_data($my) {
  $proc=$my->query('update `leftover` set the_note="'.$_GET['lef_edit_node'].'", amount='.$_GET['lef_edit_amount'].', id_service='.$_GET['lef_edit_id_service'].' where id_leftover='.$_GET['lef_edit_id_leftover']);
  echo 'update `leftover` set the_note="'.$_GET['lef_edit_node'].'", amount='.$_GET['lef_edit_amount'].', id_service='.$_GET['lef_edit_id_service'].' where id_leftover='.$_GET['lef_edit_id_leftover'];
  unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='leftover';
}

function lef_del_data($my) {
$proc=$my->query('delete from `leftover` where id_leftover= '.$_GET['lef_del_id_leftover']);
  unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='leftover';
}

function lef_del_form($my) {
 $leftover.= "<center><font color='red'>Вы хотите удалить выбранную запись?</font></center><br>";
  $leftover.= "<center><button type=\"button\" id=\"lef_del_data\">Удалить запись</button>";
  $leftover.= "<button type=\"button\" id=\"lef_cancel\">Отмена</button></center>";
  return $leftover;   
}

function lef_edit_form($my) {
	$q=$my->query('SELECT  *  FROM  `leftover` l join `the_tenant` t on t.id_tenant=l.id_tenant where  id_leftover='.$_GET['check']);
	@$row=$q->fetch_assoc();
	$leftover.= "<br><br><form name='edit' action='index.php' method='get'>";
	$leftover.= "<input type='hidden' name='page' value=".$_GET['page'].">";
	$leftover.= "<input type='hidden' name='db' value=".$_GET['db'].">";
	$leftover.= "<input type='hidden' name='action' value='edit.save'>";
	$leftover.= "<input type='hidden' name='id_leftover' value=".$_GET['check'].">";
	$leftover.= "<input type='hidden' name='id_tenant' id='id_tenant' value=".$row['id_tenant'].">";
	$leftover.= "<label for='tenant'> Квартиросъемщик: </label>";
	$leftover.= "<label for='tenant'>".$row['surname']."</label> <br> <br>";
	#$leftover.= "<input type='text' name='name_domain' value=\"".$row['surname']."\"> <br>";

	$leftover.= "<label for='id_service'>Услуга: </label>";
	$leftover.= "<select size=1 id='lef_id_service'>";
	$adr=$my->query('SELECT * FROM  `service`');
	while (@$num=$adr->fetch_assoc()) {
		if ($row['id_service']<>$num['id_service'])  {
		    $leftover.= "<option value=".$num['id_service'].">".$num['name_service']."</option>";
		}  else {
			$leftover.= "<option value=".$num['id_service']. " selected> ".$num['name_service']."</option>";
		}
	}
	$leftover.= "</select><br>";

	$leftover.= "<label for='amount'>Сумма:</label>";
	$leftover.= "<input type='text' id='lef_amount' value=\"".$row['amount']."\"> <br>";

    $leftover.=  "<label for='lef_node'>Примечание:</label>";
  $leftover.= "<input type='text' id='lef_node' value=\"".$row['the_note']."\"> <br>";

  $leftover.= "<button type=\"button\" id=\"lef_edit_data\">Сохранить</button></center>";
  $leftover.= "<button type=\"button\" id=\"lef_cancel\">Отмена</button></center>";
  $leftover.= "</form>";
  return $leftover;

}

function lef_new_form($my) {
$leftover.= "<h1>Новая запись </h1> <br><br>";
  $leftover.= "<form name='new' action='index.php' method='get'>";
  $leftover.= "<input type='hidden' name='page' value=".$_GET['page'].">";
  $leftover.= "<input type='hidden' name='db' value=".$_GET['db'].">";
  $leftover.= "<input type='hidden' name='action' value='new.save'>";
  $leftover.= "<input type='hidden' name='id_leftover' value=".$_GET['check'].">";
  #$leftover.= "<input type='hidden' name='tc_new_id_tenant' id='tc_new_id_tenant'>";
  #$leftover.= "<label for='tenant'> Квартиросъемщик: </label>";
  #$leftover.= "<label for='tenant'>".$row['surname']."</label> <br> <br>";
  #$leftover.= "<input type='text' name='name_domain' value=\"".$row['surname']."\"> <br>";
  $leftover.= "<label for='lef_id_house'> Адрес: </label>";
  $leftover.= "<select id='lef_id_house' size=1>";
  $adr=$my->query('SELECT * FROM  `house`');
  while (@$num=$adr->fetch_assoc()) {
    $leftover.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
  }
  $leftover.= "</select><br>";


  $leftover.=  "<label for='lef_number_flat'>Квартира:</label>";
  $leftover.= "<input type='text' id='lef_number_flat'> <br>";

  $leftover.=  "<label for='lef_id_tenant'>Лицевой счет:</label>";
  $leftover.= "<input type='text' id='lef_id_tenant' disabled='disabled'> <br>";

  $leftover.=  "<label for='lef_fio'>ФИО:</label>";
  $leftover.= "<input type='text' id='lef_fio' disabled='disabled'> <br>";

  $leftover.=  "<label for='lef_s'>Площадь:</label>";
  $leftover.= "<input type='text' id='lef_S' disabled='disabled'> <br>";

  $leftover.=  "<label for='lef_kolvo'>Количество человек:</label>";
  $leftover.= "<input type='text' id='lef_kolvo' disabled='disabled'> <br>";

  $leftover.= "<label for='lef_id_service'>Услуга: </label>";
  $leftover.= "<select size=1 id='lef_id_service'>";
  $adr=$my->query('SELECT * FROM  `service`');
    while (@$num=$adr->fetch_assoc()) {
		$leftover.= "<option value=".$num['id_service'].">".$num['name_service']."</option>";
	}
  $leftover.= "</select><br>";

  $leftover.=  "<label for='lef_amount'>Сумма:</label>";
  $leftover.= "<input type='text' id='lef_amount' value=\"".$row['amount']."\"> <br>";

  $leftover.=  "<label for='lef_node'>Примечание:</label>";
  $leftover.= "<input type='text' id='lef_node'> <br>";

  $leftover.= "<button type=\"button\" id=\"lef_new_data\">Сохранить</button></center>";
  $leftover.= "<button type=\"button\" id=\"lef_cancel\">Отмена</button></center>";
  $leftover.= "</form>";
  return $leftover;
}

function showtable_lef($my) {
$leftover.= "<h1>Остатки</h1>";
if (!isset($_GET['check'])) {
  $leftover.= "Адрес:<br>" ;
  $leftover.= "<select id='lef_search_house' size=1>";
  $adr=$my->query('SELECT id_house, adress FROM  `house`');
  while (@$num=$adr->fetch_assoc()) {
    $leftover.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
  }
  $leftover.= "</select><br>";
  $leftover.= "Квартира:<br>" ;
  $leftover.= "<input type='text' id='lef_search_kv' placeholder='Введите номер квартиры'>";
  $leftover.= "<button type=\"button\" id='lef_search'>Поиск</button> <br><br>" ;
}
  if ($_GET['lef_search_kv'] != '') {
	 $q=$my->query('SELECT l.*, h.adress,t.id_house, t.number_flat, t.surname, s.name_service FROM `leftover` l join the_tenant t on t.id_tenant=l.id_tenant join house h on h.id_house=t.id_house join service s on s.id_service=l.id_service  where t.id_house ='.$_GET['lef_search_house'].' and t.number_flat="'.$_GET['lef_search_kv'].'" order by h.adress, t.number_flat' );
  }
  if (isset($_GET['check'])) {
    $q=$my->query('SELECT * FROM `leftover` l join the_tenant t on t.id_tenant=l.id_tenant join house h on h.id_house=t.id_house join service s on s.id_service=l.id_service where l.id_leftover='.$_GET['check']);
  }
  if (((!isset($_GET['lef_search_kv'])) && (!isset($_GET['check']))) || (($_GET['lef_search_kv'] == '') &&  (!isset($_GET['check']))))  {
	 $q=$my->query('SELECT l.*, h.adress, t.number_flat, t.surname, s.name_service FROM `leftover` l join the_tenant t on t.id_tenant=l.id_tenant join house h on h.id_house=t.id_house join service s on s.id_service=l.id_service order by h.adress, t.number_flat limit 50');
  }
#Создние таблицы
$leftover.= "<form name='table' action='index.php' method='get'>";
$leftover.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$leftover.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$leftover.= "<input type='hidden' name='action' value=edit.show>";
$leftover.= "<table border=1 cellspacing=0 cellpadding=2 width=680 px align='center'>";
$leftover.= "<tr>";
$leftover.= " <td> №</td>";
$leftover.= " <td> Адрес </td>";
$leftover.= " <td> № квартиры </td>";
$leftover.= " <td> Фамилия </td>";
$leftover.= " <td> Услуга </td>";
$leftover.= " <td> Остаток </td>";
$leftover.= " <td> Примечание </td>";
$leftover.= "<td></td>";
$leftover.= " </tr>";
 $summ=0;
    $k=1;
while (@$row=$q->fetch_assoc()) {
	$leftover.= " <tr>";
	$leftover.= "<td>".$k."</td>";
	$leftover.= "<td>".$row['adress']."</td>";
  $leftover.= "<td>".$row['number_flat']."</td>";
  $leftover.= "<td>".$row['surname']."</td>";
  $leftover.= "<td>".$row['name_service']."</td>";
  $leftover.= "<td>".$row['amount']."</td>";
  $leftover.= "<td>".$row['the_note']."</td>";
   if (!isset($_GET['check'])) {
	$leftover.= "<td><input type='radio' name = 'check' value=".$row['id_leftover']."></td>";
  } else {
  $leftover.= "<td><input type='radio' name = 'check' value=".$row['id_leftover']." checked></td>";
  }
	$leftover.= " </tr>";
  $k++;
  $summ=$summ+$row['amount'];
}
	$leftover.= " <tr>";
	$leftover.= "<td></td>";
	$leftover.= "<td></td>";
  $leftover.= "<td></td>";
  $leftover.= "<td></td>";
	$leftover.= "<td></td>";
   $leftover.= "<td>Итого</td>";
  $leftover.= "<td>".$summ."</td>";
  $leftover.= "<td></td>";
	$leftover.= " </tr>";
$leftover.= "</table>";
$leftover.= "<br>";

 if (!isset($_GET['action']) || ($_GET['action']=='cancel') || ($_GET['action']=='search')) {
    $leftover.= "<button type=\"button\" id=\"lef_new\">Новая запись</button>" ;
    $leftover.= "<button type=\"button\" id=\"lef_edit\">Редактировать запись</button>";
    $leftover.= "<button type=\"button\" id=\"lef_del\">Удалить запись</button>";
  }

$leftover.= "</form>";
return $leftover;
}
 
?>
