<?php
if ($_GET['db']=='gs') {
include_once __DIR__.'/../db.php';
$gs='';
$k=$my->query("SET NAMES utf8");

#Сохранение отредактированной записи
if (isset($_GET['action']) && ($_GET['action']=='edit.save')) {
  $proc=$my->query('update `general_service` set name_gs="'.$_GET['name_gs'].'" where id_gs='.$_GET['id_gs']);
  unset($_GET['check']);
  unset ($_GET['action']); 
  echo showtable_gs($my);
  exit();
 }

#Сохранение новой записи
if (isset($_GET['action']) && ($_GET['action']=='new.save')) {
$proc=$my->query('insert into `general_service` (name_gs) values ("'.$_GET['name_gs']. '")'); 
unset ($_GET['action']);
echo showtable_gs($my);
exit;
} 

#Удаление записи
if (isset($_GET['action']) && ($_GET['action']=='del.data')) {
$proc=$my->query('DELETE FROM `general_service` WHERE id_gs='.$_GET['check']); 
unset ($_GET['action']);
unset ($_GET['check']);
echo showtable_gs($my); 
exit;
} 
 
#Поиск
//Если нет никакого действия просто строим таблицу, если есть то.... 
  if (isset($_GET['search']) && ($_GET['search']<>'')) {
      echo showtable_gs($my);
      exit();
  } else {
    if (!isset($_GET['action']))  {
      $gs.=showtable_gs($my);
     } else {
      if (isset($_GET['action'])) {
       if ($_GET['action']=='cancel') {
          echo showtable_gs($my);
          exit();
        } 
        if ($_GET['action']=='new') {
          echo gs_new($my);
          exit;
        }
        if (($_GET['action']=='edit') && (isset($_GET['check']))) {
          echo showtable_gs($my);
          echo gs_edit($my);
          exit;
        }
        if (($_GET['action']=='del') && (isset($_GET['check']))) {
          echo showtable_gs($my);
          echo gs_del($my);
          exit;
        } 
      } 
    }
  } 
  }
  
function gs_del($my) {
	$gs.= "<h1>Удаление записи </h1> <br>";
	$q=$my->query('select  *  from  `service` where  id_gs='.$_GET['check']);
	
	if ($q->num_rows<>0) {
		$gs.="Данная основная услуга упоминается в следующих записях:<br>";
		
		while (@$row=$q->fetch_assoc()) {  
			$gs.=$row['name_service'];
			$gs.="<br>" ;
		}
		
		$gs.= "<font color='red'>Удалите данные записи, после чего повторите процедуру <br></font>";
		$gs.= "<center><button type=\"button\" id=\"gs_cancel\">Отмена</button></center>";
		$q->close();
	} 
	else {
		$gs.= "<center>Вы хотите удалить выбранную запись?</center>";
		$gs.= "<center><button type=\"button\" id=\"gs_del_data\">Удалить запись</button>";
		$gs.= "<button type=\"button\" id=\"gs_cancel\">Отмена</button></center>";   
	}
	
	return $gs;
}

function gs_edit($my) {
	$gs.= "<h1>Редактирование записи </h1> <br>";
	$q=$my->query('SELECT  *  FROM  `general_service` where  id_gs='.$_GET['check']);
	@$row=$q->fetch_assoc(); 
	
	$gs.= "<form name='edit' action='index.php' method='get'>";
	$gs.= "<input type='hidden' name='page' value=".$_GET['page'].">";
	$gs.= "<input type='hidden' name='db' value=".$_GET['db'].">";
	$gs.= "<input type='hidden' name='action' value='edit.save'>";
	$gs.= "<input type='hidden' id='id_gs' name='id_gs' value=".$_GET['check'].">";
	$gs.= "<label for='name_gs'> Название: </label>";
	$gs.= "<input type='text' id='name_gs' name='name_gs' value=\"".$row['name_gs']."\"> <br>";
	$gs.= "<button type=\"button\" id='gs_edit_save'>Сохранить</button>" ;
	$gs.= "<button type=\"button\" id='gs_cancel'>Отмена</button>" ;
	
	return $gs;
}


function gs_new($my) {
	$gs.= "<div class=\"page-header\">";
	$gs.= "<h1>Создание новой записи <small>// Основные услуги</small></h1>";
	$gs.= "</div>";
	$gs.= "<form class='form-horizontal' name='edit' action='index.php' method='get'>";
	$gs.= "<input type='hidden' name='page' value=".$_GET['page'].">";
	$gs.= "<input type='hidden' name='db' value=".$_GET['db'].">";
	$gs.= "<input type='hidden' name='action' value='new.save'>";
	
	$gs.= "<div class='control-group' id='Gogrn'>";
	$gs.= "<label class='control-label' for='name_gs'>Название:</label>";
	$gs.= "<div class='controls'>";
	$gs.= "<input class='span6' type='text' id='name_gs' name='name_gs'> <br>";
	$gs.= "</div></div>";
	
	$gs.= "<div class='form-actions'>";
	$gs.= "<button type=\"button\" class=\"btn btn-primary\" id='gs_new_save'>Новая запись</button> " ;
	$gs.= "<button type=\"button\" class=\"btn\" id='gs_cancel'>Отмена</button>" ;
	$gs.= "</div>";
	$gs.="</form>" ;
	
	return $gs;
}

function showtable_gs($my) {
	
	if (!isset($_GET['check'])) {
		$gs.= '<form class="form-search pull-right" style="margin-top:35px"><div class="input-append">';
		$gs.= "<input type='text' class='span3 search-query' id='gs_search_text' 
				placeholder='Введите первые буквы услуги'>";
		$gs.= "<button type='button' class='btn' id='gs_search'><i class='icon-search'></i></button>";
		$gs.= '</div></form>';
	}

	$gs.= "<div class=\"page-header\">";
	$gs.= "<h1>Основные услуги</h1>";
	$gs.= "</div>";

	if ((isset($_GET['search'])) && ($_GET['search'] != ''))
		$q=$my->query('SELECT  * FROM  `general_service` where name_gs like "%'.$_GET['search'].'%"  ');
	
	if (isset($_GET['check']))
		$q=$my->query('SELECT  * FROM  `general_service`  where  id_gs='.$_GET['check']);

	if (((!isset($_GET['search'])) && (!isset($_GET['check']))) || (($_GET['search'] == '') &&  (!isset($_GET['check']))))
		$q=$my->query('SELECT  * FROM  `general_service`');
	
	//Создание таблицы
	$gs.= "<form name='table_gs' action='index.php' method='get'>";
	$gs.= "<input type='hidden' name='page' value=".$_GET['page'].">";
	$gs.= "<input type='hidden' name='db' value=".$_GET['db'].">";
	$gs.= "<input type='hidden' name='action' value=edit.show>";
	$gs.= "<table class='table table-bordered table-hover'>";
	$gs.= "<tr>";
	$gs.= " <th>№</td>";
	$gs.= " <th width=100%>Название</td>";
	$gs.= " <th></th>";
	$gs.= "</tr>";

	$k=1;
	while (@$row=$q->fetch_assoc()) {
		$gs.= "<tr>";
		$gs.= "<td>".$k."</td>";
		$gs.= "<td>".$row['name_gs']."</td>";
		if (!isset($_GET['check']))
			$gs.= "<td><input type='radio' name = 'check' value=".$row['id_gs']."></td>";
		else
			$gs.= "<td><input type='radio' name = 'check' value=".$row['id_gs']." checked></td>";
		$gs.= " </tr>";
		$k++;
	}
	
	$gs.= "</table>";
	
	if (!isset($_GET['action']) || ($_GET['action']=='cancel') || ($_GET['action']=='search')) {
		$gs.= '<div class="btn-group">';
		$gs.= "<button type=\"button\" class=\"btn\" id='gs_new'>Новая запись</button>" ;
		$gs.= "<button type=\"button\" class=\"btn\" id='gs_edit'>Редактировать</button>" ;
		$gs.= "<button type=\"button\" class=\"btn\" id='gs_del'>Удалить запись</button>" ;
		$gs.= '</div>';
	} 
	
	$gs.= "</form>";
	
	return $gs;
}

?>
