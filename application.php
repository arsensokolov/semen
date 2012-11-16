<?php
include_once 'db.php';

//Карточка квартиросъемщика-------------------------------------------
//Карточка квартиросъемщика->обработка выбора дома, квартиры или услуги 
if (isset($_POST['tc_new_id_house']) && isset($_POST['tc_new_number_flat']) && isset($_POST['tc_new_id_service'])) {
	$id_house=$_POST['tc_new_id_house'];
	$nf=$_POST['tc_new_number_flat'];
	$id_service=$_POST['tc_new_id_service'];
	$ten=$my->query('SELECT * FROM  `the_tenant` where id_house="'.$id_house.'" and number_flat="'.$nf.'"');
	if($num=$ten->fetch_assoc()) {
		$id=$num['id_tenant'];
		$fio=$num['surname'].' '.$num['name_tenant'].' '.$num['patronomic'];
		$kolvo=$num['quantity_of_lodger'];
		$s=$num['square'];
		$id_tenant=$num['id_tenant'];
	}
	else $fio = "[Данные отсутствуют. Уточните номер дома и квартиры]";
	$ser=$my->query('SELECT * FROM  `service` where id_service="'.$id_service.'"');
	if($num=$ser->fetch_assoc()) {
		$sum=$s*$num['price_for_1_sqr_metre_k1']*$num['price_for_1_sqr_metre_k2']+$kolvo*$num['price_for_1_people_k1']*$num['price_for_1_people_k2'];
	}
	echo json_encode(array("fio"=>$fio,"kolvo"=>$kolvo,"s"=>$s,"amount"=>$sum,"id_tenant"=>$id_tenant));
}

//Карточка квартиросъемщика->Редактирование Услуга 
if (isset($_POST['tc_edit_id_tenant']) && isset($_POST['tc_edit_id_service'])) {
	$ten=$my->query('SELECT * FROM  `the_tenant` where id_tenant='.$_POST['tc_edit_id_tenant']);
	$num=$ten->fetch_assoc(); 
	$kolvo=$num['quantity_of_lodger'];
	$s=$num['square'];
	$ser=$my->query('SELECT * FROM  `service` where id_service='.$_POST['tc_edit_id_service']);
	$num=$ser->fetch_assoc();
	$sum=$s*$num['price_for_1_sqr_metre_k1']*$num['price_for_1_sqr_metre_k2']+$kolvo*$num['price_for_1_people_k1']*$num['price_for_1_people_k2'];
	echo json_encode(array("amount"=>$sum));	
}

//Карточка квартиросъемщика->Редактирование Услуга 	
if (isset($_POST['tc_edit_id_card']) && isset($_POST['tc_edit_id_service'])) {
	$ten=$my->query('SELECT * FROM  `tenant_card` where id_card='.$_POST['tc_edit_id_card']);
	$num=$ten->fetch_assoc(); 
	$q=$my->query('SELECT * FROM  `the_tenant` where id_tenant='.$num['id_tenant']);
	$ten=$q->fetch_assoc();
	$kolvo=$ten['quantity_of_lodger'];
	$s=$ten['square'];
	$ser=$my->query('SELECT * FROM  `service` where id_service='.$_POST['tc_edit_id_service']);
	$w=$ser->fetch_assoc();
	$sum=$s*$w['price_for_1_sqr_metre_k1']*$w['price_for_1_sqr_metre_k2']+$kolvo*$w['price_for_1_people_k1']*$w['price_for_1_people_k2'];
	echo json_encode(array("amount"=>$sum));
 }

//--------------------------------------------------------------------

//Начисление----------------------------------------------------------
//Начисление->Произведение начисления  
if (isset($_POST['ai_month']) && isset($_POST['ai_year']) && isset($_POST['month_text'])) {
	$result='';
	$q=$my->query('SELECT tc.id_tenant,tc.id_service, round(tc.amount,2) as amount, (round(s.price_for_1_sqr_metre_k2,2)+round(s.price_for_1_people_k2,2)) as norma FROM `tenant_card` tc join service s on tc.id_service=s.id_service where counter=0 order by tc.id_tenant');
	$s='';
	$k=1;
	$result.='insert into accrued_items values ';
	while (@$row=$q->fetch_assoc()) {
		if (($k % 500)==0) {
			$result.='; insert into accrued_items values ';
			$result.=' ("" , "' .date("Y.m.d",mktime(0, 0, 0, $_POST['ai_month']+1, 0, $_POST['ai_year'])).
		'" , '.$row['id_tenant'].' , '.$row['id_service'].' , '.$row['norma'].' , '.$row['amount'].' , 
		 "начислено за '.$_POST['month_text'].' '.$_POST['ai_year'].'") ';
		}
		if ($k==1) {
			$result.=' ("" , "' .date("Y.m.d",mktime(0, 0, 0, $_POST['ai_month']+1, 0, $_POST['ai_year'])).
			'" , '.$row['id_tenant'].' , '.$row['id_service'].' , '.$row['norma'].' , '.$row['amount'].' , 
			"начислено за '.$_POST['month_text'].' '.$_POST['ai_year'].'") ';
		} else {
			$result.=', ("" , "' .date("Y.m.d",mktime(0, 0, 0, $_POST['ai_month']+1, 0, $_POST['ai_year'])).
			'" , '.$row['id_tenant'].' , '.$row['id_service'].' , '.$row['norma'].' , '.$row['amount'].' , 
			"начислено за '.$_POST['month_text'].' '.$_POST['ai_year'].'") '; 
		 }
		$k++;	
	}
	$result.=';';
	file_put_contents(__DIR__.'/temp.sql', $result);
	$res = shell_exec('mysql -ujkhuser -pjkhpassword jkh < temp.sql');
	echo json_encode(array("result"=>'Операция выполнена!'));
}

//--------------------------------------------------------------------

//Начисление по счетчику ---------------------------------------------
//Начислеие по счетчику->Первоначальная форма 
if (isset($_POST['cc_number_flat']) && isset($_POST['cc_adress'])) {
    $id_house=$_POST['cc_adress'];
	$nf=$_POST['cc_number_flat'];
   	$ten=$my->query('SELECT * FROM  `the_tenant` where id_house="'.$id_house.'" and number_flat="'.$nf.'"');
    $row=$ten->fetch_assoc();
    $z=$my->query('SELECT c.id_counter,s.name_service, (select end_count from  calculation_counter where counter=c.id order by date LIMIT 1) 
    as end_count, round((s.price_for_1_sqr_metre_k1+s.price_for_1_people_k1),2) as price, s.id_sertype FROM counter c 
    join tenant_card tc on tc.id_card=c.id_card join service s on s.id_service=tc.id_service where tc.id_tenant='.$row['id_tenant'].' order by s.id_sertype');
    $cc='';
    $cc.= "<form name='new' action='index.php' method='get'>";
   
    $cc.=  "<label for='tc_fio'>Дата:</label>";
    $cc.= "<input type='text' id='cc_date' data-form='date' readOnly>  <br>";
       
    $cc.=  "<label for='tc_fio'>Лицевой счет:</label>";
    $cc.= "<input type='text' id='cc_id_tenant' disabled='disabled' value=".$row['id_tenant'].">  <br>";
      
    $cc.=  "<label for='tc_fio'>ФИО:</label>";
    $cc.= "<input type='text' id='cc_fio' disabled='disabled' value=\"".$row['surname']." ".$row['name_tenant']. " ".$row['patronomic']."\"> <br>";
    
    $cc.=  "<label for='tc_s'>Площадь:</label>";
    $cc.= "<input type='text' id='cc_S'  disabled='disabled' value=".$row['square']."> <br>";
    
    $cc.=  "<label for='tc_kolvo'>Количество человек:</label>";
    $cc.= "<input type='text' id='cc_kolvo'  disabled='disabled' value=".$row['quantity_of_lodger']."> <br>";
    $cc.= "</form>";
    
    $cc.= "<table id='cc_table' border=1 cellspacing=0 cellpadding=2 width=680 px align='center'>";
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
    $k=1;
    
    while (@$zz=$z->fetch_assoc()) {
		$vodd=$my->query('SELECT s.id_sertype FROM  `service` s join tenant_card tc on s.id_service=tc.id_service 
		 where tc.id_card='.$zz['id_counter']);
		$vod=$vodd->fetch_assoc();
		if ($vod['id_sertype']==2) {
			$cc.= " <tr id='vod'> "; 
		} else {
			$cc.= " <tr> ";
		}
		$cc.= "<td>".$k."</td>";
		$cc.= "<td>".$zz['id_counter']."</td>";
		$cc.= "<td >".$zz['name_service']."</td>";
		if ($vod['id_sertype']==1) {
			if ($zz['end_count']<>'') {$cc.= "<td>".$zz['end_count']."</td>";} else {$cc.= "<td>0</td>";}
		} else {
			$cc.= "<td></td>";
		}
		$cc.= "<td></td>";
		$cc.= "<td></td>";
		$cc.= "<td>".$zz['price']."</td>";
		$cc.= "<td></td>";
		$cc.= " <tr>";
		$k++;
    }
    $cc.= " <tr>";
   	$cc.= "<td></td>";
  	$cc.= "<td></td>";
    $cc.= "<td></td>";
    $cc.= "<td></td>";
    $cc.= "<td></td>";
    $cc.= "<td></td>";
    $cc.= "<td>Итого</td>";
    $cc.= "<td></td>";
    $cc.= " <tr>";
    $cc.= " </table><br>";
    $cc.= "<button type=\"button\" id='cc_save' class='button'>Сохранить</button> " ;
    $cc.= "<button type=\"button\" id='cc_print' class='button'>Печать</button> <br><br>" ;
    $cc.= "<div id='cc_data'></div>";
    $cc.= "<form>";
	echo json_encode(array("result"=>$cc));   
  }

//Услуги дома --------------------------------------------------------  
//Услуги дома->Новый счетчик->Новая запись  
if (isset($_POST['hs_counter'])) {
	$result='';
	if ($_POST['hs_counter']==1) {
    	$result.=  "<label for='hs_counter_direct'>Количество счетчиков прямой подачи:</label>";
		$result.= "<input type='text' id='hs_counter_direct'>  <br>";
		$result.=  "<label for='hs_counter_return'>Количество счетчиков обратной подачи:</label>";
		$result.= "<input type='text' id='hs_counter_return'>  <br>";
	}
	echo json_encode(array("result"=>$result));
}

//Услуги дома->Существующие счетчики->Редактирование записи
if (isset($_POST['hs_edit_counter'])) {
	$hs='';
	if ($_POST['hs_edit_counter']==1) {
	$q=$my->query('select * from counter_house where id_hs='.$_POST['id_sfh']);
		$hs.= "<table border=1 cellspacing=0 cellpadding=2 width=680 px align='center'>";
		$hs.= "<tr>";
		$hs.= " <td> № счетчика</td>";
		$hs.= " <td> Тип счетчика</td>";
		$hs.= "<td></td>";
		$hs.= " </tr>";
		while (@$row=$q->fetch_assoc()) {
			$hs.= " <tr>";
			$hs.= "<td>".$row['id_counter']."</td>";
			if ($row['counter_type']==1) {
			$hs.= "<td>Подача</td>";
			} else {
			$hs.= "<td>Обратка</td>";
			}
			$hs.= "<td><input type='radio' name = 'c_check' value=".$row['id']."></td>";
			$hs.= " </tr>";
		}
		$hs.= "</table> <br>";
		$hs.= "<center><button type=\"button\" id='hs_counter_add'>Добавить</button> " ;
		$hs.= "<button type=\"button\" id='hs_counter_del'>Удалить</button> </center><br><br>" ;
		$hs.= "<div id='div_counter_hs'> </div>";
	}
	echo json_encode(array("result"=>$hs));
  }

//Услуги дома->Добавление счетчика в услуги дома
if (isset($_POST['ch']) && $_POST['ch']=='add') {
	$hs='';
	$hs.=  "<label for='tc_fio'>№ счетчика:</label>";
	$hs.= "<input type='text' id='hs_id_counter'>  <br>";
	$hs.= "Тип счетчмка:<br>" ;
	$hs.= "<select id='hs_type_counter' size=1>";
	$hs.= "<option value=1>Прямая подача</option>";
	$hs.= "<option value=2>Обратная</option>";	
	$hs.= "</select><br>";
	$hs.= "<center><button type=\"button\" id='hs_counter_save'>Сохранить</button> " ;
	$hs.= "<button type=\"button\" id='hs_counter_cancel'>Отмена</button> </center><br><br>" ;
	echo json_encode(array("result"=>$hs));
}

//Услуги дома->СОХРАНЕНИЕ Добавление счетчика в услуги дома
if (isset($_POST['ch']) && $_POST['ch']=='add_save') {
	$id_sfh=$_POST['id_sfh'];
	$id_counter=$_POST['id_counter'];
	$type_counter=$_POST['type_counter'];
	$q=$my->query('insert into counter_house values("",'.$id_counter.','.$id_sfh.','.$type_counter.')');
}
//--------------------------------------------------------------------

//Услуги дома->Удаление счетчика из услуги дома
if (isset($_POST['ch']) && $_POST['ch']=='add_del') {
	$id_sfh=$_POST['id_sfh'];
	$q=$my->query('delete from counter_house where id='.$id_sfh);
}

//ХЗ------------------------------------------------------------------ 
if (isset($_POST['cc_text'])) {
	$result=preg_split('/;/',$_POST['cc_text'],-1, PREG_SPLIT_NO_EMPTY);
	foreach ($result as &$value) {
		$ten=$my->query($value);  
	}  
}

//--------------------------------------------------------------------

//Начисление по ОДПУ -------------------------------------------------
//Начисление по ОДПУ->Адрес
if (isset($_POST['cp']) && $_POST['cp']=='cp_serv') {
	$cp='';
	$adr=$my->query('SELECT s.id_service, s.name_service FROM  `service` s join service_for_house sfh on s.id_service=sfh.id_service
	where sfh.counter=1 and sfh.id_house='.$_POST['cp_house']);
	if ($adr->num_rows==0) {
		$cp.= "У данного дома не установлено счетчиков";
	} else {
		$cp.= "<select id='cp_search_service' size=1>";
		$cp.= "<option ></option>";
		while (@$num=$adr->fetch_assoc()) {
			$cp.= "<option value=".$num['id_service'].">".$num['name_service']."</option>";
		}
	//$cp.= "<button type=\"button\" id='cp_search'>Поиск</button> <br><br>" ;
	}
	echo json_encode(array("result"=>$cp));
}

//Начисление по ОДПУ->Услуга 
if (isset($_POST['cp']) && $_POST['cp']=='cp_counter') {
	$cp='';
	$house=$_POST['cp_house'];
	$service=$_POST['cp_service'];
	$c=$my->query('SELECT ch.id, ch.id_counter, ch.counter_type FROM `service_for_house` sfh join service s on sfh.id_service=s.id_service 
	join house h on sfh.id_house=h.id_house join counter_house ch on ch.id_hs=sfh.id_sfh
	where s.id_service='.$service.' and h.id_house = '.$house);
	if ($c->num_rows==0) {
		$cp.= "У данной услуги нет счетчиков";
	} else {
		$cp.= "<select id='cp_search_counter' size=1>";
		$cp.= "<option ></option>";
		while (@$num=$c->fetch_assoc()) {
			if ($num['counter_type']==1) {
				$cp.= "<option value=".$num['id']."> Счетчик № ".$num['id_counter']." прямой подачи</option>";
			} else {
				$cp.= "<option value=".$num['id']."> Счетчик № ".$num['id_counter']." обратной подачи</option>";
			}
		}
		$cp.= "</select><br>";
	}
	echo json_encode(array("result"=>$cp));
}

//Начисление по ОДПУ->Счетчик
if (isset($_POST['cp']) && $_POST['cp']=='cp_data') {
	$cp='';
	$date=$_POST['cp_date'];
	if ($date=='') { 
		$cp.='Не указана дата начисления';
	} else {
		$counter=$my->query('select counter_type from counter_house where id='.$_POST['cp_counter']);
		$counter1=$counter->fetch_assoc();
		if ($counter1['counter_type']==1) {
		$house=$_POST['cp_house'];
		$service=$_POST['cp_service'];
		$month=substr($date, -5, 2);
		$year=substr($date, -10, 4);
		$date1=date("Y-m-d",mktime(0, 0, 0, $month, 1, $year));
		$date2=date("Y-m-d",mktime(0, 0, 0, $month+1, 0, $year));
		$cp.="Расчетный период с ".$date1." по ".$date2."<br><br>";
		$cp.="Показание на начало месяца <input type='text' id='min_counter'> <br> ";
		$cp.="Показание на конец месяца <input type='text' id='max_counter'> <br>  ";
		$cp.="Объем по норме <input type='text' id='v_norma'> <br>  ";
		//по норме
		$norma=$my->query('SELECT (round(sum(s.price_for_1_sqr_metre_k2* t.square+price_for_1_people_k2* t.quantity_of_lodger),2)) as sum FROM 
		`tenant_card` tc join the_tenant t on t.id_tenant=tc.id_tenant join service s on s.id_service=tc.id_service
		where t.id_house ='.$house.' and t.living=1 and tc.counter=0 and s.id_service='.$service);
		//по счетчикам
		$cc=$my->query('SELECT (sum(cc.count)) as sum  FROM `calculation_counter` cc join  counter c on cc.counter = c.id join tenant_card tc on c.id_card=tc.id_card 
		join the_tenant t on t.id_tenant=tc.id_tenant where t.living=1 and tc.counter=1 
		and tc.id_service='.$service.' and t.id_house='.$house.' and date between "'.$date1.'" and "'.$date2.'"');
		$normanej=$my->query('SELECT (round(sum(s.price_for_1_sqr_metre_k2* t.square+price_for_1_people_k2* t.quantity_of_lodger),2)) as sum FROM 
		`tenant_card` tc join the_tenant t on t.id_tenant=tc.id_tenant join service s on s.id_service=tc.id_service
		where t.id_house ='.$house.' and t.living=0 and tc.counter=0 and s.id_service='.$service);
		//по счетчикам
		$ccnej=$my->query('SELECT sum(cc.count)  FROM `calculation_counter` cc join  counter c on cc.counter = c.id join tenant_card tc on c.id_card=tc.id_card 
		join the_tenant t on t.id_tenant=tc.id_tenant where t.living=0 and tc.counter=1 
		and tc.id_service='.$service.' and t.id_house='.$house.' and date between "'.$date1.'" and "'.$date2.'"');
		//по перерасчетам
		//$recalc=$my->query('');
		
		$norma1=$norma->fetch_assoc();
		$cc1=$cc->fetch_assoc();
		$normanej1=$normanej->fetch_assoc();
		$ccnej1=$ccnej->fetch_assoc();
		//$recalc1=$recalc->fetch_assoc();
		if ($norma1['sum']=='') $norma1['sum']=0;
		if ($cc1['sum']=='') $cc1['sum']=0;
		if ($normanej1['sum']=='') $normanej1['sum']=0;
		if ($ccnej1['sum']=='') $ccnej1['sum']=0;
		//if ($recalc1['sum']=='') $recalc1['sum']=0;
		$cp.= 'Объем за месяц ';
		$cp.=	"<input type='text' id='cp_v' readOnly > <br>";
		$cp.= 'Начислено по нормативу ';
		$cp.=	"<input type='text' id='cp_norma' readOnly value=".$norma1['sum']."> <br>";
		$cp.= 'Начислено по ИПУ ';
		$cp.=	"<input type='text' id='cp_ipu' readOnly value=".$cc1['sum']."> <br>";
		$cp.= 'Начислено по нежилым помещениям ';
		$cp.=	"<input type='text' id='cp_nej' readOnly value=".($normanej1['sum']+$ccnej1['sum'])." > <br>";
		$cp.= 'Начислено перерасчетов ';
		$cp.=	"<input type='text' id='cp_recalc' readOnly value=0 > <br>";
		$cp.= 'Общедомовые нужды ';
		$cp.=	"<input type='text' id='odn' readOnly> <br>";
		$cp.= 'Общедомовые нужды (сумма) ';
		$cp.=	"<input type='text' id='odn_sum' readOnly> <br>";
		$cp.= 'Примечание ';
		$cp.=	"<input type='text' id='cp_node'> <br>";
		$cp.= "<button type=\"button\" id='cp_rasch'>Рассчитать</button> <br><br>" ;
		} else {
		$cp.="Показание на начало месяца <input type='text' id='min_counter'> <br> ";
		$cp.="Показание на конец месяца <input type='text' id='max_counter1'> <br>  ";
		$cp.="Объем по норме <input type='text' id='v_norma1'> <br>  ";
		$cp.= 'Общедомовые нужды ';
		$cp.=	"<input type='text' id='odn' readOnly> <br>";
		$cp.= 'Общедомовые нужды (сумма) ';
		$cp.=	"<input type='text' id='odn_sum' readOnly> <br>";
		$cp.= 'Примечание ';
		$cp.=	"<input type='text' id='cp_node'> <br>";
		$cp.= "<button type=\"button\" id='cp_rasch'>Рассчитать</button> <br><br>" ;
		}
	}
	echo json_encode(array("result"=>$cp));
}

//Начисление по ОДПУ->Конечные показания счетчика 
if (isset($_POST['cp']) && $_POST['cp']=='cp_v') {
	$q=$my->query('select (price_for_1_people_k1+price_for_1_sqr_metre_k1) as price from service where id_service='.$_POST['cp_service']);
	$q1=$q->fetch_assoc();
	$min=$_POST['cp_min'];
	$max=$_POST['cp_max'];
	$v=$_POST['cp_v'];
	$v_norma=$_POST['cp_norma'];
	$od=round($max-$min+$v_norma,3);
	$ost=round(($od-$v),3);
	$amount=round($ost*$q1['price'],2);
	echo json_encode(array("result"=>$od,"ost"=>$ost,"amount"=>$amount));
  }

//Начисление по ОДПУ->Рассчитать
if (isset($_POST['cp']) && $_POST['cp']=='cp_ved') {
	$t='';
	$t.= "<table id='ved_table' border=1 cellspacing=0 cellpadding=2 width=680 px align='center'>";
	$t.= "<tr>";
	$t.= " <td> № ЛС</td>";
	$t.= " <td> № кв-ры </td>";
	$t.= " <td> Фамилия </td>";
	$t.= " <td> Объем </td>";
	$t.= " <td> Сумма </td>";
	$t.= " <td> Примечание </td>";
	$t.= " </tr>";
	$house=$_POST['cp_house'];
	$service=$_POST['cp_service'];
	$odn=$_POST['cp_odn'];
	$node=$_POST['cp_node'];
	$ser=$my->query('SELECT * FROM service where id_service='.$service);
	$serv=$ser->fetch_assoc();
	$price=($serv['price_for_1_people_k1'])+($serv['price_for_1_sqr_metre_k1']);
	$s=$my->query('SELECT id_tenant,number_flat, surname, 
	round(square/(SELECT round(sum(square),2) as sqare FROM the_tenant where id_house='.$house.'),5) as sum  
	FROM the_tenant t  where t.id_house='.$house);
	$a=0;
	while (@$sq=$s->fetch_assoc()) {
		$t.= "<tr>";
		$t.= " <td> ".$sq['id_tenant']."</td>";
		$t.= " <td> ".$sq['number_flat']."</td>";
		$t.= " <td> ".$sq['surname']."</td>";
		$summa=$sq['sum']*$odn;
		$t.= " <td> ".round($summa,2)."</td>";
		$amount=$summa*$price;
		$t.= " <td> ".round($amount,2)."</td>";
		$t.= " <td> ".$node."</td>";
		$t.= " </tr>";		
		$a=$a+round($amount,2);
	}
	$t.= "<tr>";
	$t.= " <td> </td>";
	$t.= " <td> </td>";
	$t.= " <td> </td>";
	$t.= " <td> Итого</td>";
	$t.= " <td> ".round($a,2)."</td>";
	$t.= " <td> </td>";
	$t.= " </tr>";		
	$t.="</table> <br>";
	$t.="<form name='table' action='index.php' method='get'>"; 
	$t.="<center><button type=\"button\" id='cp_save_data'>Сохранить</button></center>";
	echo json_encode(array("result"=>$t));
}

//Начисление по ОДПУ->Сохранить данные
if (isset($_POST['cp']) && $_POST['cp']=='cp_save_data') {
	$t='';
	$date_cp = $_POST['cp_date'];
	$id_ch = $_POST['id_ch'];
	$begin_count = $_POST['begin_count'];
	$end_count = $_POST['end_count'];
	$cp_count = $_POST['cp_count'];
	$cp_amount = $_POST['cp_amount'];
	$cp_node = $_POST['cp_node'];
	$cp_service = $_POST['cp_service'];
	$norma=$POST['v_norma'];
	$mas=$_POST['cp_mas'];
	$q=$my->query('select max(id) as max from common_parts');
	$q1=$q->fetch_assoc();
	$id=$q1['max'];
	if ($id=='') {$id=1;}	
	$q=$my->query('insert into common_parts values ('.$id.',"'.$date_cp.'",'.$id_ch.','.$begin_count.','.$end_count.','.$cp_count.','.$cp_amount.',"'.$cp_node.'")');
	for($i=1;$i<count($mas)-2;$i++) {
		$q=$my->query('insert into calculation_parts values ("","'.$date_cp.'",'.$mas[$i][0][0].','.$cp_service.','.$id.','.$mas[$i][3][0].','.$mas[$i][4][0].',"'.$mas[$i][5][0].'")');
	}
	$t.="</form>";
 echo json_encode(array("result"=>$t));	
}
//-------------------------------------------------------------------

//Перерасчет---------------------------------------------------------
//Перерасчет->Вывод данных о квартиросъемщике
if (isset($_POST['action']) && $_POST['action']=='recalc_tenant') {
	$recalc='';
	$house = $_POST['recalc_house'];
	$kv = $_POST['recalc_kv'];
	$ten=$my->query('SELECT * FROM  `the_tenant` where id_house="'.$house.'" and number_flat="'.$kv.'"');
    $row=$ten->fetch_assoc();
	$recalc.=  "<label for='tc_fio'>Лицевой счет:</label>";
    $recalc.= "<input type='text' id='recalc_id' disabled='disabled' value=".$row['id_tenant'].">  <br>";
      
    $recalc.=  "<label for='tc_fio'>ФИО:</label>";
    $recalc.= "<input type='text' id='recalc_fio' disabled='disabled' value=\"".$row['surname']." ".$row['name_tenant']. " ".$row['patronomic']."\"> <br>";
    
    $recalc.=  "<label for='tc_s'>Площадь:</label>";
    $recalc.= "<input type='text' id='recalc_S'  disabled='disabled' value=".$row['square']."> ";
    
    $recalc.=  "<label for='tc_kolvo'>Количество человек:</label>";
    $recalc.= "<input type='text' id='recalc_kolvo'  disabled='disabled' value=".$row['quantity_of_lodger']."> <br>";
	 echo json_encode(array("result"=>$recalc));	
}

//Перерасчет->Вывод данных о квартиросъемщике
if (isset($_POST['action']) && $_POST['action']=='recalc_data') {
	$recalc='';
	$recalc.= "<table id='recalc_table' border=1 cellspacing=0 cellpadding=2 width=680 px align='center'>";
	$recalc.= "<tr>";
	$recalc.= " <td> №</td>";
	$recalc.= " <td> Начальная дата </td>";
	$recalc.= " <td> Конечная дата </td>";
	$recalc.= " <td> Услуга </td>";
	$recalc.= " <td> Кол-во </td>";
	$recalc.= " <td> Сумма </td>";
	$recalc.= " <td> Примечание </td>";
	$recalc.= " </tr>";
	$recalc.= " </table> <br>";
	$recalc.="<center><button type=\"button\" id='recalc_add_data'>Добавить</button>";
	$recalc.="<button type=\"button\" id='recalc_rem_data'>Удалить</button></center>";
	$recalc.="<div id='recalc_add_new_data'> </div>";
	echo json_encode(array("result"=>$recalc));
}

//Перерасчет->Вывод формы добавление записи
if (isset($_POST['action']) && $_POST['action']=='recalc_add_data') {
	$recalc='';
	$recalc.= "<form name='recalc' action='index.php' method='get'>";
	$recalc.= "Услуга:<br>" ;
	//$recalc.= 'SELECT id_service, name_service FROM  `service` s join tenant_card tc on tc.id_service=s.id_service where tc.id_tenant='.$_POST['recalc_id'];
	$recalc.= "<select id='recalc_service' size=1>";
	$adr=$my->query('SELECT s.id_service, s.name_service FROM  `service` s join tenant_card tc on tc.id_service=s.id_service where tc.id_tenant='.$_POST['recalc_id']);
	while (@$num=$adr->fetch_assoc()) {
		$recalc.= "<option value=".$num['id_service'].">".$num['name_service']."</option>";
	}
	$recalc.= "</select><br>";

	$recalc.=  "<label for='tc_fio'>Начальная дата:</label>";
    $recalc.= "<input type='text' id='recalc_date1'>  <br>";
      
    $recalc.=  "<label for='tc_fio'>Конечная дата:</label>";
    $recalc.= "<input type='text' id='recalc_date2'> <br>";
    
    $recalc.=  "<label for='tc_s'>Количество:</label>";
    $recalc.= "<input type='text' id='recalc_v'  > ";
    
    $recalc.=  "<label for='tc_kolvo'>Сумма:</label>";
    $recalc.= "<input type='text' id='recalc_summa'  > <br>";
	
	$recalc.=  "<label for='tc_kolvo'>Примечание:</label>";
    $recalc.= "<input type='text' id='recalc_node'> <br>";
	
	$recalc.="<br><button type=\"button\" id='recalc_save_data'>Сохранить</button>";
	
	$recalc.="</form>";
	echo json_encode(array("result"=>$recalc));
}

//Перерасчет->Выбрана конечная дата
if (isset($_POST['action']) && $_POST['action']=='recalc_data1') {
	$recalc='';
	$id_tenant=$_POST['id_tenant'];
	$id_service=$_POST['id_service'];
	$date1=$_POST['date1'];
	$date2=$_POST['date2'];
	$day1=substr($date1,-2,2);
	$day2=substr($date2,-2,2);
	$month1=substr($date1,-5,2);
	$month2=substr($date2,-5,2);
	$year1=substr($date1,-10,4);
	$year2=substr($date2,-10,4);
	$v=0;
	$summ=0;
	for ($j=$year1;$j<=$year2;$j++) {
		for ($i=$month1;$i<=$month2;$i++) {
			if (($month1==$month2) && ($year1==$year2)) {
				$date_t1=date("Y-m-d", mktime(0, 0, 0, $i, 1, $year1));
				$date_t2=date("Y-m-d", mktime(0, 0, 0, $i+1, 0, $year2));
				$q=$my->query('select round(sum(count),2) as count, round(sum(amount),2) as amount from accrued_items where id_tenant='.$id_tenant.' and id_service='.$id_service.' 
				and date_accrued_items between "'.$date_t1.'" and "'.$date_t2.'"');
				$row=$q->fetch_assoc();
				$date_t1= mktime(0, 0, 0, $i, 0, $year1);
				$date_t2= mktime(0, 0, 0, $i+1, 0, $year2);
				$days=($date_t2-$date_t1)/86400;
				$day=round($day2)-round($day1)+1;
				$v=$row['count']*$day/$days;
				$summ=$row['amount']*$day/$days;
				// $recalc.= $days.' |';
				// $recalc.= $day.' |';	
			}
		}
	}
	$v = round($v,3);
	$summ = round($summ,2);
	echo json_encode(array("v"=>$v,"sum"=>$summ));
}

//-------------------------------------------------------------------
?>                     