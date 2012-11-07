<?php
if ($_GET['db']=='service') {
include_once __DIR__.'/../db.php';
$service='';
#Сохранение отредактированной записи
if (isset($_GET['action']) && ($_GET['action']=='edit.save')) {
  $proc=$my->query('update `service` set name_service="'.$_GET['name_service'].'", price_for_1_sqr_metre_k1='.$_GET['kvm1'].', 
  price_for_1_sqr_metre_k2='. $_GET['kvm2'].', price_for_1_people_k1='.$_GET['kvc1'].',price_for_1_people_k2='.$_GET['kvc2'].',
  id_company='. $_GET['name_company'].', id_gs='.$_GET['name_gs'].', id_sertype='.$_GET['id_sertype'].' where id_service='.$_GET['id_service']);
  $class=new oper;  
  $func=$class->service_edit($_GET['id_service'],$_GET['kvm1'],$_GET['kvm2'],$_GET['kvc1'],$_GET['kvc2']);
  header("location: index.php?page=spravochnik&db=service");
  exit();
}    
#Сохранение новой записи
if (isset($_GET['action']) && ($_GET['action']=='new.save')) {
  $q=$my->query('select max(id_service) as max from `service`');
  @$row=$q->fetch_assoc();   
  $proc=$my->query('insert into `service` values ('.($row['max']+1).',\''.$_GET['name_service'].'\','.
  $_GET['kvm1'].','.$_GET['kvm2'].','.$_GET['kvc1'].','.$_GET['kvc2'].','
  .$_GET['name_company'].','.$_GET['name_gs'].','.$_GET['id_sertype'].')');
  header("location: index.php?page=spravochnik&db=service");
  exit;
} 

if (isset($_GET['action']) && ($_GET['action']=='del_data')) {
  $proc=$my->query('DELETE FROM service WHERE id_service='.$_GET['check']);
  unset($_GET['check']);
  unset ($_GET['action']);
  echo showtable_service($my);
  exit;
}

#Создние таблицы
if ((!isset($_GET['action']) )) {
  $service.=showtable_service($my);
} else {
 if (isset($_GET['action'])) {
#Отмена действий
if ($_GET['action']=='cancel') {
  echo showtable_service($my);
  exit();
} 

#Редактирование выбранной записи
if (($_GET['action']=='edit') && (isset($_GET['check']))) {
  echo showtable_service($my);
  echo edit_data($my);
  exit();
}
 
#Создание новой записи
if ($_GET['action']=='new') {
  echo insert_data($my);
  exit();
} 

#Удаление выбранной записи
if (($_GET['action']=='del') && (isset($_GET['check']))) {
  echo showtable_service($my);
  echo del_data($my);
  exit();
}
//Поиск
if ($_GET['action']=='search') {
  echo showtable_service($my);
  exit();
}

}
}
}
function del_data($my) {
$bool=false;
$q=$my->query('select  *  from  `accrued_items` where  id_service='.$_GET['check']);
if ($q->num_rows<>0) {
  $service.="Начисление по нормативу<br>";
  $service.=$q->num_rows." запись(и/ей) используется с данной услугой" ;
  $service.="<br><br>" ;
  $q->close();
  $bool=true;
 }
$q=$my->query('select  *  from  `calculation_counter` where  service='.$_GET['check']);
if ($q->num_rows<>0) {
  $service.="Начисление по счетчику<br>";
  $service.=$q->num_rows." запись(и/ей) используется с данной услугой" ;
  $service.="<br><br>" ;
  $q->close();
  $bool=true;
 }
 $q=$my->query('select  *  from  `calculation_parts` where  service='.$_GET['check']);
if ($q->num_rows<>0) {
  $service.="Начисление по одс<br>";
  $service.=$q->num_rows." запись(и/ей) используется с данной услугой" ;
  $service.="<br><br>" ;
  $q->close();
  $bool=true;
 }
 $q=$my->query('select  *  from  `common_parts` where  service='.$_GET['check']);
 if ($q->num_rows<>0) {
  $service.="Общедомовые счетчики<br>";
  $service.=$q->num_rows." запись(и/ей) используется с данной услугой" ;
  $service.="<br><br>" ;
  $q->close();
  $bool=true;
 }
 $q=$my->query('select  *  from  `deduction` where  id_service='.$_GET['check']);
 if ($q->num_rows<>0) {
   $service.="Перерасчеты<br>";
   $service.=$q->num_rows." запись(и/ей) используется с данной услугой" ;
   $service.="<br><br>" ;
   $q->close();
   $bool=true;
 }
 $q=$my->query('select  *  from  `leftover` where  id_service='.$_GET['check']);
 if ($q->num_rows<>0) {
   $service.="Остатки<br>";
   $service.=$q->num_rows." запись(и/ей) используется с данной услугой" ;
   $service.="<br><br>" ;
   $q->close();
   $bool=true;
 }
 $q=$my->query('select  *  from  `payment` where  id_service='.$_GET['check']);
 if ($q->num_rows<>0) {
   $service.="Оплата<br>";
   $service.=$q->num_rows." запись(и/ей) используется с данной услугой" ;
   $service.="<br><br>" ;
   $q->close();
   $bool=true;
 }
   $q=$my->query('select  *  from  `service_for_house` where  id_service='.$_GET['check']);
 if ($q->num_rows<>0) {  
   $service.="Услуги для дома<br>";
   $service.=$q->num_rows." запись(и/ей) используется с данной услугой  " ;
   $service.="<br><br>" ;
   $q->close();
   $bool=true;
 }
  $q=$my->query('select  *  from  `tenant_card` where  id_service='.$_GET['check']);
if ($q->num_rows<>0) {   
  $service.="Карта квартиросъемщика<br>";
  $service.=$q->num_rows." запись(и/ей) используется с данной услугой" ;
  $service.="<br><br>" ;
  $q->close();
  $bool=true;
 } 
if ($bool==true) { 
  $service.= "<font color='red'>Удалите данные записи, после чего повторите процедуру <br></font>";
  $service.= "<center><button type=\"button\" id=\"ser_cancel\">Отмена</button></center>"; 
} else {
  $service.= "<center>Вы хотите удалить выбранную запись?</center>";
  $service.= "<center><button type=\"button\" id=\"ser_del_data\">Удалить запись</button>";
  $service.= "<button type=\"button\" id=\"ser_cancel\">Отмена</button></center>";  
}   
return $service;
}

function edit_data($my) {
$q=$my->query('select  *  from  `service` where  id_service='.$_GET['check']);
while (@$row=$q->fetch_assoc()) {
$service.= "<form id='ser_edit_form' name='edit_form' action='index.php' method='get'>";
$service.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$service.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$service.= "<input type='hidden' name='action' value='edit.save'>";
$service.= "<input type='hidden' name='id_service' value=".$_GET['check'].">";
#if (isset($_GET['search'])) {$service.= "<input type='hidden' name='search' value=".$_GET['search'].">";}

$service.= "<label for='name_service'> Название: </label>";
$service.= "<input type='text' name='name_service' data-form='requered' value=".$row['name_service']." > <br>";

$service.= "<label for='kvm1'> Норматив(кв.м.): </label>";
$service.= "<input type='text' name='kvm1' data-form='requered' value=".$row['price_for_1_sqr_metre_k1']."><br>";

$service.= "<label for='kvm2'> Тариф (кв.м.): </label>";
$service.= "<input type='text' name='kvm2' data-form='requered' value=".$row['price_for_1_sqr_metre_k2']."><br>";

$service.= "<label for='kvc1'> Норматив(чел.): </label>";
$service.= "<input type='text' name='kvc1' data-form='requered' value=".$row['price_for_1_people_k1']."><br>";

$service.= "<label for='kvc2'> Тариф (чел.): </label>";
$service.= "<input type='text' name='kvc2' data-form='requered' value=".$row['price_for_1_people_k2']."  ><br>";

$service.= "<label for='name_company'>Организация: </label>";
$service.= "<select name='name_company' size=1>";
$adr=$my->query('select * from  `company`');
while (@$num=$adr->fetch_assoc()) {
  if ($row['id_company']<>$num['id_company'])  {
      $service.= "<option value=".$num['id_company'].">".$num['name_company']."</option>";
  }  else {
    $service.= "<option value=".$num['id_company']. " selected> ".$num['name_company']."</option>";
  }
}                   
$service.= "</select><br>";
$adr->close();
$service.= "<label for='name_gs'> Основная услуга: </label>";
$service.= "<select name='name_gs' size=1>";
$adr=$my->query('select * from  `general_service`');
while (@$num=$adr->fetch_assoc()) {
if ($row['id_gs']<>$num['id_gs'])  {
    $service.= "<option value=".$num['id_gs'].">".$num['name_gs']."</option>";
}  else {
  $service.= "<option value=".$num['id_gs']. " selected> ".$num['name_gs']."</option>";
}
}                   
$service.= "</select><br>"; 
$service.= "<label for='id_sertype'> Основная услуга: </label>";
$service.= "<select name='id_sertype' size=1>";
$adr=$my->query('select * from  `service_type`');
while (@$num=$adr->fetch_assoc()) {
if ($row['id_sertype']<>$num['id'])  {
    $service.= "<option value=".$num['id'].">".$num['name_type']."</option>";
}  else {
  $service.= "<option value=".$num['id']. " selected> ".$num['name_type']."</option>";
}
}                   
$service.= "</select><br>"; 
$service.= "<button type='submit'>Сохранить</button>";
$service.= "<button type=\"button\" id=\"ser_cancel\">Отмена</button>";
$service.= "</form>";
}
return $service;
}

function insert_data($my) {
$service.= "<h1>Новая запись </h1> ";
$service.= "<form id = 'ser_new_form' name='edit' action='index.php' method='get'>";
$service.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$service.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$service.= "<input type='hidden' name='action' value='new.save'>";

$service.= "<label for='name_service'> Название: </label>";
$service.= "<input type='text' id='name_service' name='name_service' data-form='requered'> <br>";

$service.= "<label for='kvm1'> Норматив (кв.м.): </label>";
$service.= "<input type='text' id='kvm1' name='kvm1' data-form='requered'><br>";

$service.= "<label for='kvm2'> Тариф (кв.м.): </label>";
$service.= "<input type='text' name='kvm2' data-form='requered'><br>";

$service.= "<label for='kvc1'> Норматив(чел.): </label>";
$service.= "<input type='text' name='kvc1' data-form='requered'><br>";

$service.= "<label for='kvc2'> Тариф (чел.): </label>";
$service.= "<input type='text' name='kvc2'data-form='requered'><br>";

$service.= "<label for='name_company'>Организация: </label>";
$service.= "<select name='name_company' size=1>";
$adr=$my->query('select * from  `company`');
while (@$num=$adr->fetch_assoc()) {
{
    $service.= "<option value=".$num['id_company'].">".$num['name_company']."</option>";
}                   
$service.= "</select><br>";
$adr->close();
$service.= "<label for='name_gs'> Основная услуга: </label>";
$service.= "<select name='name_gs' size=1>";
$adr=$my->query('select * from  `general_service`');
while (@$num=$adr->fetch_assoc()) {
    $service.= "<option value=".$num['id_gs'].">".$num['name_gs']."</option>";
}                   
$service.= "</select><br>";

$service.= "<label for='sertype'> Основная услуга: </label>";
$service.= "<select name='id_sertype' size=1>";
$service.= "<option value=1> Услуги водоснабжения</option>";
$service.= "<option value=2> Услуги водоотведения</option>";
$service.= "<option value=3> Прочие усуги</option>";
$service.= "</select><br>"; 
$service.= "<button type='submit'>Сохранить</button>";
$service.= "<button type=\"button\" id=\"ser_cancel\">Отмена</button>";
$service.= "</form>";
}
return $service;
}

function showtable_service($my) {
//echo var_dump($_GET);
$service.= "<h1>Услуги</h1>";
if (!isset($_GET['check'])) {
$service.= "<input type='text' id='service_search_text' placeholder='Введите первые буквы услуги'> ";
$service.= "<button type=\"button\" id='service_search'>Поиск</button> <br><br>" ;
}
if (isset($_GET['search'])) { 
if ($_GET['search'] != '') {
	$q=$my->query('select  s.* , c.name_company, g.name_gs , st.name_type from  `service` s join company c on c.id_company=s.id_company join general_service g on g.id_gs=s.id_gs join service_type st on st.`id`=s.id_sertype where name_service like "%'.$_GET['search'].'%"  ');
}} 
if (isset($_GET['check'])) {
  $q=$my->query('select  s.* , c.name_company, g.name_gs , st.name_type from  `service` s join company c on c.id_company=s.id_company join general_service g on g.id_gs=s.id_gs join service_type st on st.`id`=s.id_sertype where  id_service='.$_GET['check']);
 } 

if (((!isset($_GET['search'])) && (!isset($_GET['check']))) || (($_GET['search'] == '') &&  (!isset($_GET['check']))))  {
	$q=$my->query('select  s.* , c.name_company, g.name_gs , st.name_type from  `service` s join company c on c.id_company=s.id_company join general_service g on g.id_gs=s.id_gs join service_type st on st.`id`=s.id_sertype');
} 
$service.= "<form name='table_service' id='table_service' action='index.php' method='get'>";
$service.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$service.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$service.= "<input type='hidden' name='action' value=edit.show>";
$service.= "<table border=1 cellspacing=0 cellpadding=2 width=680 px align='center'>";
$service.= "<tr>";
$service.= " <td align='center'> №</td>";
$service.= " <td align='center'> Название </td>";
$service.= " <td align='center'> Тариф (кв.м.) </td>";
$service.= " <td align='center'> Норматив (кв.м.)</td>";
$service.= " <td align='center'> Тариф (чел.) </td>";
$service.= " <td align='center'> Норматив (чел.) </td>";
$service.= " <td align='center'> Компания </td>";
$service.= " <td align='center'> Основная услуга </td>";
$service.= " <td align='center'> Тип услуги </td>";
$service.= "<td></td>";
$service.= " </tr>";
$k=1;
while (@$row=$q->fetch_assoc()) {
	$service.= "<tr>";
	$service.= "<td>".$k."</td>";
	$service.= "<td>".$row['name_service']."</td>";
	$service.= "<td>".$row['price_for_1_sqr_metre_k1']."</td>";
	$service.= "<td>".$row['price_for_1_sqr_metre_k2']."</td>";
	$service.= "<td>".$row['price_for_1_people_k1']."</td>";
	$service.= "<td>".$row['price_for_1_people_k2']."</td>";
	$service.= "<td>".$row['name_company']."</td>";
	$service.= "<td>".$row['name_gs']."</td>";
  $service.= "<td>".$row['name_type']."</td>";
if (!isset($_GET['check'])) {
  $service.= "<td><input type='radio' name = 'check' value=".$row['id_service']."></td>";
  } else {
   $service.= "<td><input type='radio' name = 'check' value=".$row['id_service']." checked></td>";
  }
  $service.= " </tr>";
  $k++;
}
$service.= "</table>";
$service.= "<br>";
if (!isset($_GET['action']) || ($_GET['action']=='cancel') || ($_GET['action']=='search')) {  
$service.= "<button type=\"button\" id=\"ser_new\">Новая запись</button>" ;   
$service.= "<button type=\"button\" id=\"ser_edit\">Редактировать запись</button>";
$service.= "<button type=\"button\" id=\"ser_del\">Удалить запись</button>";
}
$service.= "</form>";
return $service;
 }
?>