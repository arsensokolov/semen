<?php
if ($_GET['db']=='company') {
	include_once 'db.php';
	$company='';
	$my->query("SET NAMES utf8");
	
	switch ($_GET['action']) {
		case 'cancel':
			echo showtable_company($my);
			break;
		
		case 'search':
			echo showtable_company($my);
			break;
		
		case 'new':
			echo company_new_form($my);
			break;
			
		case 'edit':
			echo showtable_company($my);
			echo company_edit_form($my);
			break;
		
		case 'del':
			echo showtable_company($my);
			echo company_del_form($my);
			break;
		
		case 'com_new_data':
			echo com_new_data($my);
			echo showtable_company($my);
			break;
			
		case 'com_edit_data':
			echo com_edit_data($my);
			echo showtable_company($my);
			break;
			
		case 'com_del_data':
			echo com_del_data($my);
			echo showtable_company($my);
			break;
			
		case 'edit.save': // Сохранение отредактированной записи
			$proc=$my->query('update `company` set name_company=\''.$_GET['name_company'].'\',
							surname_accountant=\''.$_GET['surname_accountant'].'\', inn='.$_GET['inn'].',
							kpp='.$_GET['kpp'].',adress=\''.$_GET['adress'].'\', ogrn='.$_GET['ogrn'].'
							where id_company='.$_GET['id_company']);
			header("Location: index.php?page=spravochnik&db=company");
			break;
			
		case 'new.save': // Сохранение новой записи
			$q=$my->query('select max(id_company) as max from `company`');
			@$row=mysql_fetch_assoc($q);
			$proc=$my->query('insert into `company` values ('.($row['max']+1).',\''
							.$_GET['name_company'].'\',\''.$_GET['surname_accountant'].'\','.$_GET['inn'].','
							.$_GET['kpp'].',\''.$_GET['adress'].'\','.$_GET['ogrn'].')');
			header("Location: index.php?page=spravochnik&db=company");
			break;
		
		default:
			$company.= showtable_company($my);
			break;
	}
}

function com_new_data($my) {
	$name_company = htmlspecialchars($_GET['name_company']);
	$surname_accountant = htmlspecialchars($_GET['surname_accountant']);
	$inn = str_replace(" ", "", $_GET['inn']);
	$kpp = str_replace(" ", "", $_GET['kpp']);
	$adress = htmlspecialchars($_GET['adress']);
	$ogrn = str_replace(" ", "", $_GET['ogrn']);
	
	$my->query("insert into `company` values ('','$name_company','$surname_accountant',
				'$inn','$kpp','$adress','$ogrn')");
	unset ($_GET);
	$_GET['page']='spravochnik';
	$_GET['db']='company';
}

function com_edit_data($my) {
	$name_company = htmlspecialchars($_GET['name_company']);
	$surname_accountant = htmlspecialchars($_GET['surname_accountant']);
	$inn = str_replace(" ", "", $_GET['inn']);
	$kpp = str_replace(" ", "", $_GET['kpp']);
	$adress = htmlspecialchars($_GET['adress']);
	$ogrn = str_replace(" ", "", $_GET['ogrn']);
	$check = $_GET['check'];
	
	$my->query("update `company` set name_company='$name_company', surname_accountant='$surname_accountant', 
				inn='$inn', kpp='$kpp',adress='$adress', ogrn='$ogrn' where id_company='$check'");
	unset ($_GET);
	$_GET['page']='spravochnik';
	$_GET['db']='company';
}

function com_del_data($my) {
	$my->query('DELETE FROM `company` WHERE id_company='.$_GET['check']); 
	unset ($_GET);
	$_GET['page']='spravochnik';
	$_GET['db']='company';
}

function company_del_form($my) {
	$gs.= "<h3>Удаление записи </h3>";
	$q=$my->query('select  *  from  `service` where  id_company='.$_GET['check']);
	
	if ($q->num_rows<>0) {
		$gs.="<p class='lead'>Данная организация предоставляет следующие услуги:</p>";
		$gs.="<ol>";
		while (@$row=$q->fetch_assoc()) {  
			$gs.="<li>".$row['name_service']."</li>";
		}
		$gs.="</ol>";
		$gs.= "<div class='well' style='max-width: 400px; margin: 0 auto 10px;'>";
		$gs.= "<p class='lead text-error' style='text-align: center;'>Удалите данные записи, после чего повторите процедуру.</p>";
		$gs.= "<center><button type=\"button\" class=\"btn btn-large btn-block\" id=\"com_cancel\">Отмена</button></center>";
		$gs.= "</div>";
		$q->close();
	} 
	else {
		$gs.= "<div class='well' style='max-width: 400px; margin: 0 auto 10px;'>";
		$gs.= "<p class='lead' style='text-align: center;'>Вы хотите удалить выбранную запись?</p>";
		$gs.= "<center><button type=\"button\" class=\"btn btn-large btn-block btn-primary\" id=\"com_del_data\">Удалить запись</button> ";
		$gs.= "<button type=\"button\" class=\"btn btn-large btn-block\" id=\"com_cancel\">Отмена</button></center>";   
		$gs.= "</div>";
	}
	
	return $gs;
}

function company_edit_form($my) {
	$q=$my->query('SELECT  *  FROM  `company` where  id_company='.$_GET['check']);
	@$row=$q->fetch_assoc();
	
	$company.= "<form class='form-horizontal' name='edit' action='index.php' method='get'>";
	$company.= "<input type='hidden' name='page' value=".$_GET['page'].">";
	$company.= "<input type='hidden' name='db' value=".$_GET['db'].">";
	$company.= "<input type='hidden' name='action' value='edit.save'>";
	$company.= "<input type='hidden' id='id_company' value=".$_GET['check'].">";
	
	$company.= "<legend>Редактирование записи</legend>";
	
	$company.= "<div class='control-group'>";
	$company.= "<label class='control-label' for='name_company'> Название: </label>";
	$company.= "<div class='controls'>";
	$company.= "<input class='span6' type='text' id='name_company' value='".htmlspecialchars_decode($row['name_company'])."'>";
	$company.= "</div></div>";

	$company.= "<div class='control-group'>";
	$company.= "<label class='control-label' for='surname_accountant'> Директор: </label>";
	$company.= "<div class='controls'>";
	$company.= "<input class='span6' type='text' id='surname_accountant' value='".htmlspecialchars_decode($row['surname_accountant'])."'>";
	$company.= "</div></div>";
	
	$company.= "<div class='control-group'>";
	$company.= "<label class='control-label' for='inn'> ИНН: </label>";
	$company.= "<div class='controls'>";
	$company.= "<input class='span6' type='text' id='inn' value=\"".$row['inn']."\">";
	$company.= "</div></div>";
	
	$company.= "<div class='control-group'>";
	$company.= "<label class='control-label' for='kpp'> КПП: </label>";
	$company.= "<div class='controls'>";
	$company.= "<input class='span6' type='text' id='kpp' value=\"".$row['kpp']."\">";
	$company.= "</div></div>";
	
	$company.= "<div class='control-group'>";
	$company.= "<label class='control-label' for='adress'> Адрес: </label>";
	$company.= "<div class='controls'>";
	$company.= "<input class='span6' type='text' id='adress' value='".htmlspecialchars_decode($row['adress'])."'>";
	$company.= "</div></div>";
	
	$company.= "<div class='control-group'>";
	$company.= "<label class='control-label' for='ogrn'> ОГРН: </label>";
	$company.= "<div class='controls'>";
	$company.= "<input class='span6' type='text' id='ogrn' value=\"".$row['ogrn']."\">";
	$company.= "</div></div>";
	
	$company.= "<div class='form-actions'>";
	$company.= "<button type=\"button\" class=\"btn btn-primary\" id=\"com_edit_data\">Сохранить</button> "; 
	$company.= "<button type=\"button\" class=\"btn\" id=\"com_cancel\">Отмена</button>"; 
	$company.= "</div>";
	$company.= "</form>"; 
	
	return $company;
}

function company_new_form($my) {
	$company.= "<div class=\"page-header\">";
	$company.= "<h1>Новая запись <small>// Поставщики услуг</small></h1>";
	$company.= "</div>";
	$company.= "<form class='form-horizontal' name='new' action='index.php' method='get'>";
	$company.= "<input type='hidden' name='page' value=".$_GET['page'].">";
	$company.= "<input type='hidden' name='db' value=".$_GET['db'].">";
	$company.= "<input type='hidden' name='action' value='new.save'>";
	
	$company.= "<div class='control-group' id='Gname_company'>";
	$company.= "<label class='control-label' for='name_company'>Название:</label>";
	$company.= "<div class='controls'>";
	$company.= "<input class='span6' type='text' id='name_company'>";
	$company.= "</div></div>";
	
	$company.= "<div class='control-group' id='Gsurname_accountant'>";
	$company.= "<label class='control-label' for='surname_accountant'>Директор:</label>";
	$company.= "<div class='controls'>";
	$company.= "<input class='span6' type='text' id='surname_accountant'>";
	$company.= "</div></div>";
	
	$company.= "<div class='control-group' id='Ginn'>";
	$company.= "<label class='control-label' for='inn'>ИНН:</label>";
	$company.= "<div class='controls'>";
	$company.= "<input class='span6' type='text' id='inn'>";
	$company.= "</div></div>";
	
	$company.= "<div class='control-group' id='Gkpp'>";
	$company.= "<label class='control-label' for='kpp'>КПП:</label>";
	$company.= "<div class='controls'>";
	$company.= "<input class='span6' type='text' id='kpp'>";
	$company.= "</div></div>";
	
	$company.= "<div class='control-group' id='Gaddress'>";
	$company.= "<label class='control-label' for='adress'>Адрес:</label>";
	$company.= "<div class='controls'>";
	$company.= "<input class='span6' type='text' id='adress'>";
	$company.= "</div></div>";
	
	$company.= "<div class='control-group' id='Gogrn'>";
	$company.= "<label class='control-label' for='ogrn'>ОГРН:</label>";
	$company.= "<div class='controls'>";
	$company.= "<input class='span6' type='text' id='ogrn'>";
	$company.= "</div></div>";
	
	$company.= "<div class='form-actions'>";
	$company.= "<button type=\"button\" class=\"btn btn-primary\" id=\"com_new_data\">Сохранить</button> "; 
	$company.= "<button type=\"button\" class=\"btn\" id=\"com_cancel\">Отмена</button>";
	$company.= "</div>";
	$company.= "</form>";
	
	return $company;
}

function showtable_company($my) {
	
	if (!isset($_GET['check'])) {
		$company.= '<form class="form-search pull-right" style="margin-top:35px"><div class="input-append">';
		$company.= '<input type="text" class="span3 search-query" id="company_search_text" 
					placeholder="Введите первые буквы организации">';
		$company.= '<button type="button" class="btn" id="company_search"><i class="icon-search"></i></button>';
		$company.= '</div></form>';
	}
	
	$company.= "<div class=\"page-header\">";
	$company.= "<h1>Поставщики услуг</h1>";
	$company.= "</div>";
	
	if (isset($_GET['search']) && $_GET['search'] != '')
		$q=$my->query('SELECT  * FROM  `company` where name_company like "%'.$_GET['search'].'%"  ');
	
	if (isset($_GET['check']))
		$q=$my->query('SELECT  * FROM  `company`  where  id_company='.$_GET['check']);   

	if (((!isset($_GET['search'])) && (!isset($_GET['check']))) || (($_GET['search'] == '') &&  (!isset($_GET['check']))))
		$q=$my->query('SELECT  * FROM  `company`');

	$company.= "<form name='table' action='index.php' method='get'>";
	$company.= "<input type='hidden' name='page' value=".$_GET['page'].">";
	$company.= "<input type='hidden' name='db' value=".$_GET['db'].">";
	$company.= "<input type='hidden' name='action' value=edit.show>";
	$company.= "<table class='table table-bordered table-hover'>";
	$company.= "<tr>";
	$company.= " <th>№</th>";
	$company.= " <th>Название</th>";
	$company.= " <th>Руководитель</th>";
	$company.= " <th>ИНН</th>";
	$company.= " <th>КПП</th>";
	$company.= " <th>Адрес</th>";
	$company.= " <th>ОГРН</th>";
	$company.= "<th></th>";
	$company.= "</tr>";

	$k=1;
	while (@$row=$q->fetch_assoc()) {
	  	$company.= "<tr>";
	  	$company.= "<td>".$k."</td>";
	  	$company.= "<td>".$row['name_company']."</td>";
	  	$company.= "<td>".$row['surname_accountant']."</td>";
	  	$company.= "<td>".$row['inn']."</td>";
	  	$company.= "<td>".$row['kpp']."</td>";
	  	$company.= "<td>".$row['adress']."</td>";
	  	$company.= "<td>".$row['ogrn']."</td>";
	    if (!isset($_GET['check']))
		  	$company.= "<td><input type='radio' name = 'check' value=".$row['id_company']."></td>";
	    else
		    $company.= "<td><input type='radio' name = 'check' value=".$row['id_company']." checked></td>";
	    $company.= "</tr>";
	    $k++;
	}
	$company.= "</table>";
	
	if (!isset($_GET['action']) || ($_GET['action']=='cancel') || ($_GET['action']=='search')) {
		$company.= '<div class="btn-group">';
		$company.= '<button type="button" class="btn" id="com_new">Новая запись</button>';   
		$company.= '<button type="button" class="btn" id="com_edit">Редактировать запись</button>';
		$company.= '<button type="button" class="btn" id="com_del">Удалить запись</button>';
		$company.= '</div>';
	}
	$company.= "</form>";
	
	return $company;
}
?>
