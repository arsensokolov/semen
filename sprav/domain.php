<?php

if ($_GET['db']=='domain') {
$path='/var/www/html/';
include_once $path.'db.php';
$k=$my->query("SET NAMES utf8");
$domain='';

#Поиск
if (!isset($_GET['action']))  {
    $domain.= showtable_domain($my);
   } else {
  if (isset($_GET['action'])) {
    if ($_GET['action']=='cancel') {
      echo showtable_domain($my);
      exit();
    }
    if ($_GET['action']=='search') {
      echo showtable_domain($my);
      exit;
    }
    if ($_GET['action']=='new') {
      echo domain_new_form($my);
      exit;
    }
    if ($_GET['action']=='edit') {
      echo showtable_domain($my);
      echo domain_edit_form($my);
      exit;
    }
   if ($_GET['action']=='del') {
      echo showtable_domain($my);
      echo domain_del_form($my);
      exit;
    }
  if ($_GET['action']=='dom_new_data') {
     
      echo dom_new_data($my);
      echo showtable_domain($my);
      exit;
    }
  if ($_GET['action']=='dom_edit_data') {
      echo dom_edit_data($my);
      echo showtable_domain($my);
      exit;  
    }
  if ($_GET['action']=='dom_del_data') {
      echo dom_del_data($my);
      echo showtable_domain($my);
      exit;  
    } 
  } 
} 
}
function dom_new_data($my) {
  $proc=$my->query('insert into `domain` values ("","'.$_GET['name_domain'].'" )');
  unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='domain';
}                   

function dom_edit_data($my) {
 $proc=$my->query('update `domain` set name_domain="'.$_GET['name_domain'].'" where id_domain='.$_GET['check']);
  echo 'update `domain` set name_domain="'.$_GET['name_domain'].'" where id_domain='.$_GET['check'];
  unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='domain';
}

function dom_del_data($my) {
 $proc=$my->query('DELETE FROM `domain` WHERE id_domain='.$_GET['check']); 
  unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='domain';
}

function domain_del_form($my) {
 $domain.= "<h1>Удаление записи </h1> <br>";
  $q=$my->query('select  *  from  `the_tenant` t join house h on t.id_house=h.id_house where  t.id_domain='.$_GET['check']);
if ($q->num_rows<>0) {
  $domain.="Данный тип собственности выбран у проживающих по адресу:<br>";
  while (@$row=$q->fetch_assoc()) {  
    $domain.=$row['adress'].' кв. '.$row['number_flat'];
    $domain.="<br>" ;
  }
  $domain.= "<font color='red'>Удалите данные записи, после чего повторите данную процедуру <br></font>";
  $domain.= "<center><button type=\"button\" id=\"dom_cancel\">Отмена</button></center>";
  $q->close();
 } else {
  $domain.= "<center><font color='red'>Вы хотите удалить выбранную запись?</font></center><br>";
  $domain.= "<center><button type=\"button\" id=\"dom_del_data\">Удалить запись</button>";
  $domain.= "<button type=\"button\" id=\"dom_cancel\">Отмена</button></center>";   
 }
 return $domain;
} 

function domain_edit_form($my) {
$q=$my->query('SELECT  *  FROM  `domain` where  id_domain='.$_GET['check']);
@$row=$q->fetch_assoc(); 
$domain.= "<form name='edit' action='index.php' method='get'>";
$domain.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$domain.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$domain.= "<input type='hidden' name='action' value='edit.save'>";
$domain.= "<input type='hidden' id='id_domain' value=".$_GET['check'].">";
$domain.= "<label for='name_domain'> Название: </label>";
$domain.= "<input type='text' id='name_domain' value=\"".$row['name_domain']."\"> <br>";
$domain.= "<button type=\"button\" id=\"dom_edit_data\">Сохранить</button></center>"; 
$domain.= "<button type=\"button\" id=\"dom_cancel\">Отмена</button></center>";
$domain.= "</form>";
return $domain;
}

function domain_new_form($my) {
$domain.= "<h1>Новая запись </h1> <br><br>";
$domain.= "<form name='edit' action='index.php' method='get'>";
$domain.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$domain.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$domain.= "<input type='hidden' name='action' value='new.save'>";
$domain.= "<label for='name_domain'> Название: </label>";
$domain.= "<input type='text' id='name_domain'> <br>";
$domain.= "<button type=\"button\" id=\"dom_new_data\">Сохранить</button></center>"; 
$domain.= "<button type=\"button\" id=\"dom_cancel\">Отмена</button></center>";
$domain.= "</form>";
return $domain;
}

function showtable_domain($my) {
$domain.= "<h1>Тип собственности</h1>";
if (!isset($_GET['check'])) {
$domain.= "<input type='text' id='domain_search_text' placeholder='Введите первые буквы искомого слова'> ";
$domain.= "<button type=\"button\" id='domain_search'>Поиск</button> <br><br>" ;
}
if (isset($_GET['search'])) { 
if ($_GET['search'] != '') {
	$q=$my->query('SELECT  * FROM  `domain` where name_domain like "%'.$_GET['search'].'%"  ');
}} 
if (isset($_GET['check'])) {
  $q=$my->query('SELECT  * FROM  `domain`  where  id_domain='.$_GET['check']);
    #$domain.= 'SELECT  *  FROM  `service` s where s.id_service='.$_GET['check'];
 #exit;  
} 
  if (((!isset($_GET['search'])) && (!isset($_GET['check']))) || (($_GET['search'] == '') &&  (!isset($_GET['check']))))  {
	$q=$my->query('SELECT  * FROM  `domain`');
}
#Создние таблицы
$domain.= "<form name='table' action='index.php' method='get'>";
$domain.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$domain.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$domain.= "<input type='hidden' name='action' value=edit.show>";
$domain.= "<table border=1 cellspacing=0 cellpadding=2 width=680 px align='center'>";
$domain.= "<tr>";
$domain.= " <td> №</td>";
$domain.= " <td> Название </td>";
$domain.= "<td></td>";
$domain.= " </tr>";

    $k=1;
while (@$row=$q->fetch_assoc()) {
	$domain.= " <tr>";
	$domain.= "<td>".$k."</td>";
	$domain.= "<td>".$row['name_domain']."</td>";
  if (!isset($_GET['check'])) {
	$domain.= "<td><input type='radio' name = 'check' value=".$row['id_domain']."></td>";
  } else {
 $domain.= "<td><input type='radio' name = 'check' value=".$row['id_domain']." checked></td>";
  }
	$domain.= " </tr>";
  $k++;
}
$domain.= "</table>";
$domain.= "<br>";
 if (!isset($_GET['action']) || ($_GET['action']=='cancel') || ($_GET['action']=='search')) { 
    $domain.= "<button type=\"button\" id=\"dom_new\">Новая запись</button>" ;   
    $domain.= "<button type=\"button\" id=\"dom_edit\">Редактировать запись</button>";
    $domain.= "<button type=\"button\" id=\"dom_del\">Удалить запись</button>";
  }

$domain.= "</form>";
return $domain;
}

 
?>
