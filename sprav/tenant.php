<?php
if ($_GET['db']=='tenant') {
$path='/var/www/html/';
include_once $path.'db.php';
$k=$my->query("SET NAMES utf8");
$tenant='';

if (!isset($_GET['action']))  {
    $tenant.= showtable_tenant($my);
   } else {
  if (isset($_GET['action'])) {
    if ($_GET['action']=='cancel') {
      echo showtable_tenant($my);
      exit();
    }
    if ($_GET['action']=='search') {
      echo showtable_tenant($my);
      exit;
    }
    if ($_GET['action']=='new') {
      echo tc_new_form($my);
      exit;
    }
    if ($_GET['action']=='edit') {
      echo showtable_tenant($my);
      echo tenant_edit_form($my);
      exit;
    }
   if ($_GET['action']=='del') {
      echo showtable_tenant($my);
      echo tenant_del_form($my);
      exit;
    }
  if ($_GET['action']=='ten_new_data') {
      echo ten_new_data($my);
      echo showtable_tenant($my);
      exit;
    }
  if ($_GET['action']=='ten_edit_data') {
      echo ten_edit_data($my);
      echo showtable_tenant($my);
      exit;  
    }
  if ($_GET['action']=='ten_del_data') {
      echo ten_del_data($my);
      echo showtable_tenant($my);
      exit;  
    } 
  } 
} 
}

function ten_new_data($my) {
$proc=$my->query('insert into the_tenant (`living`,`id_house`,`id_domain`,`quantity_registration`,
`quantity_of_lodger`,`square`,`patronomic`,`name_tenant`,`surname`,`number_flat`,`id_tenant`) values ('.
$_GET['living'].','.$_GET['adress'].','.$_GET['id_domain'].','.$_GET['quantity_registration'].','
.$_GET['quantity_of_lodger'].','.$_GET['square'].',"'.$_GET['patronomic'].'","'
.$_GET['name_tenant'].'","'.$_GET['surname'].'",'.$_GET['number_flat'].','.$_GET['id_tenant'].')');
  unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='tenant';
}                   

function ten_edit_data($my) {
$proc=$my->query('update the_tenant set id_tenant='.$_GET['new_id_tenant'].',number_flat='.$_GET['number_flat'].',surname="'.$_GET['surname'].'",name_tenant="'.
$_GET['name_tenant'].'",patronomic="'.$_GET['patronomic'].'"  ,square='.$_GET['square'].',quantity_of_lodger='.
$_GET['quantity_of_lodger'].',quantity_registration='.$_GET['quantity_registration'].',id_domain='.
$_GET['id_domain'].',id_house='.$_GET['adress'].',living='.$_GET['living'].' where id_tenant='.$_GET['id_tenant']);
$tena=$my->query('select * from tenant_card where id_tenant='.$_GET['new_id_tenant']);
while (@$row=$tena->fetch_assoc()) {
  $w=$my->query('select * from service where id_service='.$row['id_service']);
   @$num=$w->fetch_assoc();
  $sum=$num['price_for_1_sqr_metre_k1']*$num['price_for_1_sqr_metre_k2']*$_GET['square']+
   $num['price_for_1_people_k1']*$num['price_for_1_people_k2']*$_GET['quantity_of_lodger'];
     $sum=number_format(round($sum,2), 2, '.','');
    $tencard=$my->query('update tenant_card set amount='.$sum.' where id_card='.$row['id_card']);
} 
 unset ($_GET);
 $_GET['page']='spravochnik';
 $_GET['db']='tenant';
                     
}

function ten_del_data($my) {
 $proc=$my->query('DELETE FROM `the_tenant` WHERE id_tenant='.$_GET['check']); 
  unset ($_GET);
  $_GET['page']='spravochnik';
  $_GET['db']='tenant';      
}

function tenant_del_form($my) {
 $bool=false;
 $tenant.= "<h1>Удаление записи </h1> <br>";
$q=$my->query('select  *  from  `accrued_items` ai where  ai.id_tenant='.$_GET['check']);
if ($q->num_rows<>0) {
  $tenant.="У данного квартиросъемщика есть начисления по нормативу<br>";
  $bool=true;
}
$q=$my->query('select  *  from  `calculation_counter` cc where  cc.tenant='.$_GET['check']);
if ($q->num_rows<>0) {
  $tenant.="У данного квартиросъемщика есть начисления по счетчику<br>";
  $bool=true;
}
$q=$my->query('select  *  from  `calculation_parts` cp where  cp.tenant='.$_GET['check']);
if ($q->num_rows<>0) {
  $tenant.="У данного квартиросъемщика есть начисления по ОДС<br>";
  $bool=true;
}
$q=$my->query('select  *  from  `deduction` d where  d.id_tenant='.$_GET['check']);
if ($q->num_rows<>0) {
  $tenant.="У данного квартиросъемщика есть перерасчеты<br>";
  $bool=true;
}
$q=$my->query('select  *  from  `inhabitant` i where  i.id_tenant='.$_GET['check']);
if ($q->num_rows<>0) {
  $tenant.="C данным квартиросъемщиком есть проживающие<br>";
  $bool=true;
}
$q=$my->query('select  *  from  `leftover` l where  l.id_tenant='.$_GET['check']);
if ($q->num_rows<>0) {
  $tenant.="У данного квартиросъемщика имеются остатки<br>";
  $bool=true;
}
$q=$my->query('select  *  from  `payment` p where  p.id_tenant='.$_GET['check']);
if ($q->num_rows<>0) {
  $tenant.="У данного квартиросъемщика имеются оплаты<br>";
  $bool=true;
}
$q=$my->query('select  *  from  `tenant_card` tc where  tc.id_tenant='.$_GET['check']);
if ($q->num_rows<>0) {
  $tenant.="У данного квартиросъемщика имеются прикрепленные услуги<br>";
  $bool=true;
}
if ($bool==true) {  
  $tenant.= "<font color='red'>Нежелательно удалять выше перечисленные записи т.к. это приведет к изменению расчетов предыдущих месяцев  <br></font>";
  $tenant.= "<font color='red'>Удалите данные записи, после чего повторите данную процедуру <br></font>";
  $tenant.= "<center><button type=\"button\" id=\"tenant_cancel\">Отмена</button></center>";
  $q->close();
 } else {
  $tenant.= "<center><font color='red'>Вы хотите удалить выбранную запись?</font></center><br>";
  $tenant.= "<center><button type=\"button\" id=\"ten_del_data\">Удалить запись</button>";
  $tenant.= "<button type=\"button\" id=\"tenant_cancel\">Отмена</button></center>";   
 }
 return $tenant;
} 

function tenant_edit_form($my) {
$q=$my->query('SELECT t . * , h.adress,d.name_domain FROM  `the_tenant` t JOIN  `house` h ON t.id_house = h.id_house JOIN  `domain` d ON d.id_domain = t.id_domain where id_tenant='.$_GET['check']);
while (@$row=$q->fetch_assoc()) {
$tenant.= "<form name='edit' action='index.php' method='get'>";
$tenant.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$tenant.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$tenant.= "<input type='hidden' name='action' value='edit.save'>";
$tenant.= "<input type='hidden' id='id_tenant' value=".$row['id_tenant'].">";
if (isset($_GET['search'])) {$tenant.= "<input type='hidden' name='search' value=".$_GET['search'].">";}

$tenant.= "<label for='id_tenant'> Лицевой счет: </label>";
$tenant.= "<input type='text' data-form='requered' id='new_id_tenant' value=".$row['id_tenant']."> <br>";

$tenant.= "<label for='adress'> Адрес: </label>";
$tenant.= "<select id='adress' size=1>";
$adr=$my->query('SELECT * FROM  `house` t');
while (@$num=$adr->fetch_assoc()) {
if ($row['id_house']<>$num['id_house'])  {
    $tenant.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
}  else {
  $tenant.= "<option value=".$num['id_house']. " selected> ".$num['adress']."</option>";
}
}
$tenant.= "</select><br>"; 

$tenant.= "<label for='number_flat'> № квартиры: </label>";      
$tenant.= "<input type='text' data-form='requered' id='number_flat' value=".$row['number_flat']."><br>";

$tenant.= "<label for='surname'> Фамилия: </label>";
$tenant.= "<input type='text' data-form='requered' id='surname' value=".$row['surname']."><br>";

$tenant.= "<label for='name_tenant'> Имя: </label>";
$tenant.= "<input type='text' data-form='requered' id='name_tenant' value=".$row['name_tenant']."><br>";

$tenant.= "<label for='patronomic'> Отчество: </label>";
$tenant.= "<input type='text' data-form='requered' id='patronomic' value=".$row['patronomic']."><br>";

$tenant.= "<label for='square'> Площадь: </label>";
$tenant.= "<input type='text' data-form='requered' id='square' value=".$row['square']."><br>";

$tenant.= "<label for='quantity_of_lodger'> Количетво проживающих: </label>";
$tenant.= "<input type='text' data-form='requered' id='quantity_of_lodger' value=".$row['quantity_of_lodger']."><br>";

$tenant.= "<label for='quantity_registration'> Количетво зарегистрированных: </label>";
$tenant.= "<input type='text' data-form='requered' id='quantity_registration' value=".$row['quantity_registration']."><br>";

$tenant.= "<label for='id_domain'>Тип собственности: </label>";
$tenant.= "<select id='id_domain' size=1>";
$adr=$my->query('SELECT * FROM  `domain`');
while (@$num=$adr->fetch_assoc()) {
if ($row['id_domain']<>$num['id_domain'])  {
    $tenant.= "<option value=".$num['id_domain'].">".$num['name_domain']."</option>";
}  else {
  $tenant.= "<option value=".$num['id_domain']. " selected> ".$num['name_domain']."</option>";
}
}
$tenant.= "</select><br>";
 
$tenant.= "<label for='living'>Тип помещения: </label>";
$tenant.= "<select id='living' size=1>";
if ($row['living']==0) {
$tenant.= "<option selected value=0 >Не жилая</option>";
$tenant.= "<option value=1>Жилая</option>";
} else {
$tenant.= "<option value=0>Не жилая</option>";
$tenant.= "<option selected value=1 >Жилая</option>";
}
$tenant.= "</select><br>"; 
$tenant.= "<button type=\"button\" id=\"ten_edit_data\">Сохранить</button></center>"; 
$tenant.= "<button type=\"button\" id=\"tenant_cancel\">Отмена</button></center>";
$tenant.= "</form>";                     
}            
return $tenant;
}

function tenant_new_form($my) {
$tenant.= "<h1>Новая запись </h1> <br><br>";
$tenant.= "<form name = 'new' action='index.php' method='get'>";
$tenant.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$tenant.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$tenant.= "<input type='hidden' name='action' value='new.save'>";

$tenant.= "<label for='id_tenant'> Лицевой счет: </label>";
$tenant.= "<input type='text' id='id_tenant' data-form='requered'> <br>";

$tenant.= "<label for='adress'> Адрес: </label>";
$tenant.= "<select id='adress' size=1>";
$adr=$my->query('SELECT * FROM  `house` t');
while (@$num=$adr->fetch_assoc()) {
if ($row['id_house']<>$num['id_house'])  {
    $tenant.= "<option value=".$num['id_house'].">".$num['adress']."</option>";
}
}
$tenant.= "</select><br>"; 

$tenant.= "<label for='number_flat'> № квартиры: </label>";      
$tenant.= "<input type='text' id='number_flat' data-form='requered'><br>";

$tenant.= "<label for='surname'> Фамилия: </label>";
$tenant.= "<input type='text' id='surname' data-form='requered'><br>";

$tenant.= "<label for='id_tenant'> Имя: </label>";
$tenant.= "<input type='text' id='name_tenant' data-form='requered'><br>";

$tenant.= "<label for='patronomic'> Отчество: </label>";
$tenant.= "<input type='text' id='patronomic' data-form='requered'><br>";

$tenant.= "<label for='square'> Площадь: </label>";
$tenant.= "<input type='text' id='square' data-form='requered'><br>";

$tenant.= "<label for='quantity_of_lodger'> Количетво проживающих: </label>";
$tenant.= "<input type='text' id='quantity_of_lodger' data-form='requered'><br>";

$tenant.= "<label for='quantity_registration'> Количетво зарегистрированных: </label>";
$tenant.= "<input type='text' id='quantity_registration' data-form='requered'><br>";

$tenant.= "<label for='id_domain'>Тип собственности: </label>";
$tenant.= "<select id='id_domain' size=1>";
$adr=$my->query('SELECT * FROM  `domain`');
while (@$num=$adr->fetch_assoc()) {
if ($row['id_domain']<>$num['id_domain'])  {
    $tenant.= "<option value=".$num['id_domain'].">".$num['name_domain']."</option>";
}  
}
$tenant.= "</select><br>"; 

$tenant.= "<label for='living'>Тип помещения: </label>";
$tenant.= "<select id='living' size=1>";
$tenant.= "<option value=0>Не жилая</option>";
$tenant.= "<option value=1>Жилая</option>";
$tenant.= "</select><br>"; 

$tenant.= "<button type=\"button\" id=\"ten_new_data\">Сохранить</button></center>"; 
$tenant.= "<button type=\"button\" id=\"ten_cancel\">Отмена</button></center>";
$tenant.= "</form>"; 
return $tenant;
}

function showtable_tenant($my) {
$tenant.= "<h1>Квартиросъемщики</h1>";
if (!isset($_GET['check'])) {
$tenant.= "<input type='text' id='tenant_search_text' placeholder='Введите первые буквы фамилии проживающего'> ";
$tenant.= "<button type=\"button\" id='tenant_search'>Поиск</button> <br><br>" ;
}
if (isset($_GET['search'])) { 
if ($_GET['search'] != '') {
	$q=$my->query('SELECT t . * , h.adress,d.name_domain FROM  `the_tenant` t JOIN  `house` h ON t.id_house = h.id_house JOIN  `domain` d ON d.id_domain = t.id_domain WHERE surname LIKE "'.$_GET['search'].'%"');
}}
if (isset($_GET['check'])) {
  $q=$my->query('SELECT t . * , h.adress,d.name_domain FROM  `the_tenant` t JOIN  `house` h ON t.id_house = h.id_house JOIN  `domain` d ON d.id_domain = t.id_domain where t.id_tenant='.$_GET['check']);
} 
  if (((!isset($_GET['search'])) && (!isset($_GET['check']))) || (($_GET['search'] == '') &&  (!isset($_GET['check']))))  {
	$q=$my->query('SELECT t . * , h.adress,d.name_domain FROM  `the_tenant` t JOIN  `house` h ON t.id_house = h.id_house JOIN  `domain` d ON d.id_domain = t.id_domain order by t.id_tenant LIMIT 50');
  }
#Создние таблицы
$tenant.= "<form name='table' action='index.php' method='get'>";
$tenant.= "<input type='hidden' name='page' value=".$_GET['page'].">";
$tenant.= "<input type='hidden' name='db' value=".$_GET['db'].">";
$tenant.= "<input type='hidden' name='action' value=edit.show>";
$tenant.= "<table border=1 cellspacing=0 cellpadding=2 width=680 px align='center'>";
$tenant.= "<tr align='center'>";
$tenant.= " <td > № ЛС </td>";
$tenant.= " <td> № дома </td>";
$tenant.= " <td> № кв-ры </td>";
$tenant.= " <td> Ф.И.О. </td>";
$tenant.= " <td> S </td>";
$tenant.= " <td> Кол-во прописанных </td>";
$tenant.= " <td> Кол-во проживающих </td>";
$tenant.= " <td> Тип собственности </td>";
$tenant.= " <td> Тип помещения </td>";
$tenant.= "<td></td>";
$tenant.= " </tr>";

while ($row=$q->fetch_assoc()) {
	$tenant.= " <tr>";
	$tenant.= "<td>".$row['id_tenant']."</td>";
	$tenant.= "<td>".$row['adress']."</td>";
	$tenant.= "<td>".$row['number_flat']."</td>";
	$tenant.= "<td>".$row['surname'];
	$tenant.= " ".$row['name_tenant'];
	$tenant.= " ".$row['patronomic']."</td>";
	$tenant.= "<td>".$row['square']."</td>";
	$tenant.= "<td>".$row['quantity_of_lodger']."</td>";
	$tenant.= "<td>".$row['quantity_registration']."</td>";
	$tenant.= "<td>".$row['name_domain']."</td>";
  if ($row['living']==0) {
    $tenant.= "<td> Не жилая</td>";
  } else {
    $tenant.= "<td> Жилая</td>";
  } 
  if (!isset($_GET['check'])) {
  $tenant.= "<td><input type='radio' name = 'check' value=".$row['id_tenant']."></td>";
  } else {
  $tenant.= "<td><input type='radio' name = 'check' value=".$row['id_tenant']." checked></td>";
  }
	$tenant.= " </tr>";
}  
           
$tenant.= "</table>";
$tenant.= "<br>";
 if (!isset($_GET['action']) || ($_GET['action']=='cancel') || ($_GET['action']=='search')) { 
    $tenant.= "<button type=\"button\" id=\"ten_new\">Новая запись</button>" ;   
    $tenant.= "<button type=\"button\" id=\"ten_edit\">Редактировать запись</button>";
    $tenant.= "<button type=\"button\" id=\"ten_del\">Удалить запись</button>";
  }
$tenant.= "</form>";
return $tenant; 
} 
?>
