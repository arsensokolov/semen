$(document).ready(function(){   
//Глобальные фунцкции
//Выбор по строке таблицы
$('#col2').on('click', 'tr', function(e) {
	if (e.target.type !== 'radio') {
		$(':radio', this).click();
	}
})
//-------------------------------------------------

//Функции для справочника Услуги
//Услуги->Удаление записи
$('#col2').on('click', '#ser_del', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
  $.get("sprav/service.php", {page: "spravochnik", db:"service",action:"del", check: chdel}, function (data) {
   $('#col2').html(data);
   })
 }
})

//Услуги->Новая запись
$('#col2').on('click', '#ser_new', function() { 
  $.get("sprav/service.php", {page: "spravochnik", db:"service",action:"new"}, function (data) {
   $('#col2').html(data);   
   })
 })  
 
//Услуги->Редактирование записи 
$('#col2').on('click', '#ser_edit', function() {
     var chdel = $('input[name=check]:radio:checked').val(); 
 if (chdel!== undefined) {     
  $.get("sprav/service.php", {page: "spravochnik", db:"service",action:"edit", check:chdel}, function (data) {
   $('#col2').html(data);   
   })
   }
   })

//Услуги->Отмена   
$('#col2').on('click', '#ser_cancel', function() {
  $.get("sprav/service.php", {page: "spravochnik", db:"service", action:"cancel"}, function (data) {
   $('#col2').html(data);   
   })
 })

//Услуги->Форма новая запись
$('#col2').on('submit','#ser_new_form', function () {
  var req = $('[data-form*=requered]').val();
  if (req == '') {
  alert ('Пожалуйста, заполните все поля')
  return false;
  } else { return true;}
 })

//Услуги->Форма редактирование записи 
$('#col2').on('submit','#ser_edit_form', function () {
  var req = $('[data-form*=requered]').val();
  if (req == '') {
  alert ('Пожалуйста, заполните все поля')
  return false;
  } else { return true;}
 })

//Услуги->Форма удаление записи
$('#col2').on('click', '#ser_del_data', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
  $.get("sprav/service.php", {page: "spravochnik", db:"service",action:"del_data", check: chdel}, function (data) {
   $('#col2').html(data);
   })
 }
})

//Услуги->Поиск
$('#col2').on('click', '#service_search', function() {
 var search=$('#service_search_text').val()
 if (search!=='') {
  $.get("sprav/service.php", {page: "spravochnik", db:"service",action:"search", search: search}, function (data) {
   $('#col2').html(data);
   })
 } else {
 $.get("sprav/service.php", {page: "spravochnik", db:"service",action:"cancel"}, function (data) {
   $('#col2').html(data);                                                       
   })
 }
})

//---------------------------------------------------------------------------

//Функции для справочника Основные услуги
//Основные услуги->Открытие формы Новая запись
$('#col2').on('click', '#gs_new', function() {
  $.get("sprav/general_service.php", {page: "spravochnik", db:"gs",action:"new"}, function (data) {
   $('#col2').html(data);
   })
 })

 //Основные услуги->Открытие формы Редактировать запись
$('#col2').on('click', '#gs_edit', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
  $.get("sprav/general_service.php", {page: "spravochnik", db:"gs",action:"edit",check: chdel }, function (data) {
   $('#col2').html(data);
   })
   }
 })
 
 //Основные услуги->Открытие формы Удалить запись
  $('#col2').on('click', '#gs_del', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
  $.get("sprav/general_service.php", {page: "spravochnik", db:"gs",action:"del",check: chdel }, function (data) {
   $('#col2').html(data);
   })
   }
 })
 
 //Основные услуги->Отмена
 $('#col2').on('click', '#gs_cancel', function() {
  $.get("sprav/general_service.php", {page: "spravochnik", db:"gs",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
 })
 
 //Основные услуги->Поиск
$('#col2').on('click', '#gs_search', function() {
 var search=$('#gs_search_text').val()
 if (search!=='') {
  $.get("sprav/general_service.php", {page: "spravochnik", db:"gs",action:"search", search: search}, function (data) {
   $('#col2').html(data);
   })
   } else {
   $.get("sprav/general_service.php", {page: "spravochnik", db:"gs",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
   }
 })
 
 //Основные услуги->Сохранение отредактированной записи
$('#col2').on('click', '#gs_edit_save', function() {
 var id_gs=$('#id_gs').val()
 var name_gs=$('#name_gs').val()
 if (name_gs!=='') {
  $.get("sprav/general_service.php", {page: "spravochnik", db:"gs",action:"edit.save", id_gs: id_gs, name_gs:name_gs}, function (data) {
   $('#col2').html(data);
   })
   } 
   })
 
 //Основные услуги->Сохранение новой записи
$('#col2').on('click', '#gs_new_save', function() {
 var name_gs=$('#name_gs').val()
 if (name_gs!=='') {
  $.get("sprav/general_service.php", {page: "spravochnik", db:"gs",action:"new.save", name_gs:name_gs}, function (data) {
   $('#col2').html(data);
   })
   }   
 })
 
 //Основные услуги->Удаление записи
$('#col2').on('click', '#gs_del_data', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
   $.get("sprav/general_service.php", {page: "spravochnik", db:"gs",action:"del.data", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }   
 })

//---------------------------------------------------------------------------

//Функции для справочника Постащики услуг
//Постащики услуг->Поиск
$('#col2').on('click', '#company_search', function() {
 var search=$('#company_search_text').val()
 if (search!=='') {
  $.get("sprav/company.php", {page: "spravochnik", db:"company",action:"search", search: search}, function (data) {
   $('#col2').html(data);
   })
   } else {
   $.get("sprav/company.php", {page: "spravochnik", db:"company",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
   }
 })
 
//Постащики услуг->Создание формы Новая запись
$('#col2').on('click', '#com_new', function() {
	$.get("sprav/company.php", {page: "spravochnik", db:"company",action:"new"}, function (data) {
		$('#col2').html(data);
		$('#col2 #inn').mask("99 99 99 99 99? 99");
		$('#col2 #kpp').mask("999 999 999");
		$('#col2 #ogrn').mask("99 99 99 99 99 999");
	})
})
 
//Постащики услуг->Создание формы Редактирование записи
$('#col2').on('click', '#com_edit', function() {
	var chdel = $('input[name=check]:radio:checked').val()
	if (chdel!== undefined) {
		$.get("sprav/company.php", {page: "spravochnik", db:"company",action:"edit", check:chdel}, function (data) {
			$('#col2').html(data);
			$('#col2 #inn').mask("99 99 99 99 99? 99");
			$('#col2 #kpp').mask("999 999 999");
			$('#col2 #ogrn').mask("99 99 99 99 99 999");
		})
	}
})
 
//Постащики услуг->Создание формы Удалить запись
$('#col2').on('click', '#com_del', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
  $.get("sprav/company.php", {page: "spravochnik", db:"company",action:"del",check: chdel }, function (data) {
   $('#col2').html(data);
   })
   }
 })

//Постащики услуг->Отмена
$('#col2').on('click', '#com_cancel', function() {
	$.get("sprav/company.php", {page: "spravochnik", db:"company",action:"cancel"}, function (data) {
		$('#col2').html(data);
	})
})

//Постащики услуг->Сохранение новой записи
$('#col2').on('click', '#com_new_data', function() {
	var name_company=$('#name_company').val()
	var surname_accountant=$('#surname_accountant').val()
	var inn=$('#inn').val()
	var kpp=$('#kpp').val()
	var adress=$('#adress').val()
	var ogrn=$('#ogrn').val()
	if (name_company == '') { $('#col2 #Gname_company').addClass('error'); var err = 1; }
	if (surname_accountant == '') { $('#col2 #Gsurname_accountant').addClass('error'); var err = 1; }
	if (inn == '') { $('#col2 #Ginn').addClass('error'); var err = 1; }
	if (kpp == '') { $('#col2 #Gkpp').addClass('error'); var err = 1; }
	if (adress == '') { $('#col2 #Gaddress').addClass('error'); var err = 1; }
	if (ogrn == '') { $('#col2 #Gogrn').addClass('error'); var err = 1; }
	if (!err) {
		$.get("sprav/company.php", {page: "spravochnik", db:"company",action:"com_new_data",name_company:name_company, surname_accountant:surname_accountant,inn:inn,kpp:kpp,adress:adress,ogrn:ogrn}, function (data) {
			$('#col2').html(data);
		})
	}
})

//--- Валидация формы (начало)
$('#col2').on('change', '#name_company', function() {
	if ($(this).val() != '') $('#col2 #Gname_company').removeClass('error').addClass('success');
})

$('#col2').on('change', '#surname_accountant', function() {
	if ($(this).val() != '') $('#col2 #Gsurname_accountant').removeClass('error').addClass('success');
})

$('#col2').on('change', '#inn', function() {
	if ($(this).val() != '') $('#col2 #Ginn').removeClass('error').addClass('success');
})

$('#col2').on('change', '#kpp', function() {
	if ($(this).val() != '') $('#col2 #Gkpp').removeClass('error').addClass('success');
})

$('#col2').on('change', '#adress', function() {
	if ($(this).val() != '') $('#col2 #Gaddress').removeClass('error').addClass('success');
})

$('#col2').on('change', '#ogrn', function() {
	if ($(this).val() != '') $('#col2 #Gogrn').removeClass('error').addClass('success');
})
//--- Валидация формы (конец)

 //Постащики услуг->Сохранение редактированной записи
$('#col2').on('click', '#com_edit_data', function() {
     var chdel = $('input[name=check]:radio:checked').val()
     var name_company=$('#name_company').val()
     var surname_accountant=$('#surname_accountant').val()
     var inn=$('#inn').val()
     var kpp=$('#kpp').val()
     var adress=$('#adress').val()
     var ogrn=$('#ogrn').val()
  $.get("sprav/company.php", {page: "spravochnik", db:"company",action:"com_edit_data",name_company:name_company, 
  surname_accountant:surname_accountant,inn:inn,kpp:kpp,adress:adress,ogrn:ogrn,check: chdel}, function (data) {
   $('#col2').html(data);
   })
 })
 
 //Постащики услуг->Удаление записи
 $('#col2').on('click', '#com_del_data', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
   $.get("sprav/company.php", {page: "spravochnik", db:"company",action:"com_del_data", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }   
 }) 

//---------------------------------------------------------------------------

//Функции для справочника Тип собственности
//Тип собственности->Отмена
$('#col2').on('click', '#dom_cancel', function() {
  $.get("sprav/domain.php", {page: "spravochnik", db:"domain",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
 })

//Тип собственности->Поиск
$('#col2').on('click', '#domain_search', function() {
 var search=$('#domain_search_text').val()
 if (search!=='') {
  $.get("sprav/domain.php", {page: "spravochnik", db:"domain",action:"search", search: search}, function (data) {
   $('#col2').html(data);
   })
   } else {
   $.get("sprav/domain.php", {page: "spravochnik", db:"domain",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
   }
 })
 
//Тип собственности->Создание формы Новая запись
$('#col2').on('click', '#dom_new', function() {
  $.get("sprav/domain.php", {page: "spravochnik", db:"domain",action:"new"}, function (data) {
   $('#col2').html(data);
   })
 })
 
//Тип собственности->Создание формы Редактирование записи
$('#col2').on('click', '#dom_edit', function() {
   var chdel = $('input[name=check]:radio:checked').val()
   if (chdel!== undefined) {
  $.get("sprav/domain.php", {page: "spravochnik", db:"domain",action:"edit", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }
 })
 
//Тип собственности->Создание формы Удалить запись
$('#col2').on('click', '#dom_del', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
  $.get("sprav/domain.php", {page: "spravochnik", db:"domain",action:"del",check: chdel }, function (data) {
   $('#col2').html(data);
   })
   }
 })
  
//Тип собственности->Сохранение новой записи
$('#col2').on('click', '#dom_new_data', function() {
     var name_domain=$('#name_domain').val()
   $.get("sprav/domain.php", {page: "spravochnik", db:"domain",action:"dom_new_data",name_domain:name_domain}, function (data) {
   $('#col2').html(data);
   })
 })
 
//Тип собственности->Сохранение редактированной записи
$('#col2').on('click', '#dom_edit_data', function() {
     var chdel = $('input[name=check]:radio:checked').val()
     var name_domain=$('#name_domain').val()
  $.get("sprav/domain.php", {page: "spravochnik", db:"domain",action:"dom_edit_data",name_domain:name_domain,check: chdel}, function (data) {
   $('#col2').html(data);
   })
 })
 
//Тип собственности->Удаление записи
$('#col2').on('click', '#dom_del_data', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
   $.get("sprav/domain.php", {page: "spravochnik", db:"domain",action:"dom_del_data", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }  
   })

//---------------------------------------------------------------------------

//Функции для справочника Жилфонд
//Жилфонд->Отмена
$('#col2').on('click', '#adr_cancel', function() {
  $.get("sprav/adress.php", {page: "spravochnik", db:"adress",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
 })

//Жилфонд->Поиск
$('#col2').on('click', '#adr_search', function() {
 var search=$('#adr_search_text').val()
 if (search!=='') {
  $.get("sprav/adress.php", {page: "spravochnik", db:"adress",action:"search", search: search}, function (data) {
   $('#col2').html(data);
   })
   } else {
   $.get("sprav/adress.php", {page: "spravochnik", db:"adress",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
   }
 })

//Жилфонд->Создание формы Новая запись
$('#col2').on('click', '#adr_new', function() {
  $.get("sprav/adress.php", {page: "spravochnik", db:"adress",action:"new"}, function (data) {
   $('#col2').html(data);
   })
 })

//Жилфонд->Создание формы Редактирование записи
$('#col2').on('click', '#adr_edit', function() {
   var chdel = $('input[name=check]:radio:checked').val()
   if (chdel!== undefined) {
  $.get("sprav/adress.php", {page: "spravochnik", db:"adress",action:"edit", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }
 })

//Жилфонд->Создание формы Удалить запись
$('#col2').on('click', '#adr_del', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
  $.get("sprav/adress.php", {page: "spravochnik", db:"adress",action:"del",check: chdel }, function (data) {
   $('#col2').html(data);
   })
   }
 })

//Жилфонд->Сохранение новой записи
$('#col2').on('click', '#adr_new_data', function() {
    // var name_adress=$('#name_adress').val()
    //var id_house =$('#id_house').val()
    var adress =$('#adress').val()
    var full_adress =$('#full_adress').val()
    var quality_quarters =$('#quality_quarters').val()
    var quantity_flat =$('#quantity_flat').val()
    var square  =$('#square').val()
    var counter =$('#counter option:selected').val()

   $.get("sprav/adress.php", {page: "spravochnik", db:"adress",action:"adr_new_data",id_house :id_house,
adress:adress, full_adress:full_adress, quality_quarters:quality_quarters, quantity_flat:quantity_flat,
square:square, counter:counter}, function (data) {
   $('#col2').html(data);
   })
 })

//Жилфонд->Сохранение редактированной записи
$('#col2').on('click', '#adr_edit_data', function() {
    var adress =$('#adress').val()
    var full_adress =$('#full_adress').val()
    var quality_quarters =$('#quality_quarters').val()
    var quantity_flat =$('#quantity_flat').val()
    var square  =$('#square').val()
    var counter =$('#counter option:selected').val()
    var chdel = $('input[name=check]:radio:checked').val()
   $.get("sprav/adress.php", {page: "spravochnik", db:"adress",action:"adr_edit_data",
adress:adress, full_adress:full_adress, quality_quarters:quality_quarters, quantity_flat:quantity_flat,
square:square, counter:counter, check:chdel}, function (data) {
   $('#col2').html(data);
   })
 })
 
//Жилфонд->Удаление записи
$('#col2').on('click', '#adr_del_data', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
   $.get("sprav/adress.php", {page: "spravochnik", db:"adress",action:"adr_del_data", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }  
   })

//--------------------------------------------------------------------------------------------

//Функции для справочника Услуги дома
//Услуги дома->Отмена
$('#col2').on('click', '#hs_cancel', function() {
  $.get("sprav/hs.php", {page: "spravochnik", db:"hs",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
 })

//Услуги дома->Поиск
$('#col2').on('click', '#hs_search', function() {
 var search=$('#hs_search_text').val()
 if (search!=='') {
  $.get("sprav/hs.php", {page: "spravochnik", db:"hs",action:"search", search: search}, function (data) {
   $('#col2').html(data);
   })
   } else {
   $.get("sprav/hs.php", {page: "spravochnik", db:"hs",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
   }
 })
  
//Услуги дома->Создание формы Новая запись
$('#col2').on('click', '#hs_new', function() {
  $.get("sprav/hs.php", {page: "spravochnik", db:"hs",action:"new"}, function (data) {
   $('#col2').html(data);
   })
 })
 
//Услуги дома->Создание формы Редактирование записи
$('#col2').on('click', '#hs_edit', function() {
	var chdel = $('input[name=check]:radio:checked').val()
	if (chdel!== undefined) {
		$.get("sprav/hs.php", {page: "spravochnik", db:"hs",action:"edit", check:chdel}, function (data) {
		$('#col2').html(data);
		})
	}
 })
 
//Услуги дома->Создание формы Удалить запись
$('#col2').on('click', '#hs_del', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
  $.get("sprav/hs.php", {page: "spravochnik", db:"hs",action:"del",check: chdel }, function (data) {
   $('#col2').html(data);
   })
   }
 })
 
//Услуги дома->Сохранение новой записи
$('#col2').on('click', '#hs_new_data', function() {
    var id_service =$('#id_service').val()
    var id_house =$('#id_house').val()
    var counter = $('#hs_new_counter option:selected').val()
    if (counter==0) {
    $.get("sprav/hs.php", {page: "spravochnik", db:"hs",action:"hs_new_data",id_house :id_house,
    id_service:id_service, counter:counter}, function (data) {
    $('#col2').html(data);
    })
    } 
    if (counter==1) {
    var counter_direct= $('#hs_counter_direct').val()
    var counter_return= $('#hs_counter_return').val()
    $.get("sprav/hs.php", {page: "spravochnik", db:"hs",action:"hs_new_data",id_house :id_house,
    id_service:id_service, counter:counter, hs_counter_direct:counter_direct, hs_counter_return:counter_return}, 
    function (data) {
    $('#col2').html(data);
    })
    }
    
   
   })

//Услуги дома->Сохранение отредактированной записи
$('#col2').on('click', '#hs_edit_data', function() {
    var id_service =$('#id_service').val()
    var id_house =$('#id_house').val()
    var counter = $('#hs_edit_counter option:selected').val()
    var chdel = $('input[name=check]:radio:checked').val()
	if (chdel!== undefined) {
		if (counter==0) {
			$.get("sprav/hs.php", {page: "spravochnik", db:"hs",action:"hs_edit_data",id_house :id_house,
			id_service:id_service, counter:counter,check:chdel}, function (data) {
			$('#col2').html(data);
			})
		} 
    if (counter==1) {
		var counter_direct= $('#hs_counter_direct').val()
		var counter_return= $('#hs_counter_return').val()
		
		$.get("sprav/hs.php", {page: "spravochnik", db:"hs",action:"hs_edit_data",id_house :id_house,
		id_service:id_service, counter:counter, hs_counter_direct:counter_direct, hs_counter_return:counter_return}, 
		function (data) {
		$('#col2').html(data);
		})
    }
   }
})  
 
//Услуги дома->Удаление записи    
$('#col2').on('click', '#hs_del_data', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
   $.get("sprav/hs.php", {page: "spravochnik", db:"hs",action:"hs_del_data", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }  
   })

//Услуги дома->Новая запись->Установлен ли счетчик	
$('#col2').on('change', '#hs_new_counter', function() {
   var hs_counter=$('#hs_new_counter option:selected').val()
    $.post('application.php', {hs_counter:hs_counter}, function(data) {
              $('#div_counter').html(data.result)
      }, "json")
  })
  
//Услуги дома->Редактировать запись->Если счетчик установлен 
$('#col2').on('change', '#hs_edit_counter', function() {
   var id_sfh = $('input[name=check]:radio:checked').val()
   var hs_counter=$('#hs_edit_counter option:selected').val()
    $.post('application.php', {hs_edit_counter:hs_counter,id_sfh:id_sfh}, function(data) {
              $('#div_counter').html(data.result)
      }, "json")
  })
  
//Услуги дома->Добавление счетчика к услуге дома
$('#col2').on('click', '#hs_counter_add', function() {
	var id_sfh = $('input[name=check]:radio:checked').val()
	$.post('application.php', {ch:'add',id_sfh:id_sfh}, function(data) {
              $('#div_counter_hs').html(data.result)
    }, "json")
  })

//Услуги дома->Отмена добавления счетчика к услуге дома  
$('#col2').on('click', '#hs_counter_cancel', function() {
                 $('#div_counter_hs').html('')
  })

//Услуги дома->Сохранение нового счетчика при редактировании услуги
$('#col2').on('click', '#hs_counter_save', function() {
	var id_sfh = $('input[name=check]:radio:checked').val()
	var id_counter=$('#hs_id_counter').val()
	var type_counter=$('#hs_type_counter option:selected').val()	
	var hs_counter=$('#hs_edit_counter option:selected').val()
	$.post('application.php', {ch:'add_save',id_sfh:id_sfh,id_counter:id_counter,type_counter:type_counter}, function(data) {
		}, "json")
	$.post('application.php', {hs_edit_counter:hs_counter,id_sfh:id_sfh}, function(data) {
		$('#div_counter').html(data.result)
    }, "json")
	$('#div_counter_hs').html('')
})

//Услуги дома->Удаление счетчика при редактировании услуги
$('#col2').on('click', '#hs_counter_del', function() {
	var id_c = $('input[name=c_check]:radio:checked').val()
	var id_sfh = $('input[name=check]:radio:checked').val()
	var hs_counter=$('#hs_edit_counter option:selected').val()
	$.post('application.php', {ch:'add_del',id_sfh:id_c}, function(data) {
	}, "json")
	$.post('application.php', {hs_edit_counter:hs_counter,id_sfh:id_sfh}, function(data) {
		$('#div_counter').html(data.result)
    }, "json")
})

//------------------------------------------------------------------

//Функции для справочника Квартиросъемщик
//Квартиросъемщик->Поиск
$('#col2').on('click', '#tenant_search', function() {
 var search=$('#tenant_search_text').val()
 if (search!=='') {
  $.get("sprav/tenant.php", {page: "spravochnik", db:"tenant",action:"search", search: search}, function (data) {
   $('#col2').html(data);
   })
   } else {
   $.get("sprav/tenant.php", {page: "spravochnik", db:"tenant",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
   }
 })

//Квартиросъемщик->Отмена
$('#col2').on('click', '#tenant_cancel', function() {
  $.get("sprav/tenant.php", {page: "spravochnik", db:"tenant",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
 })

//Квартиросъемщик->Создание формы Новая запись
$('#col2').on('click', '#ten_new', function() {
  $.get("sprav/tenant.php", {page: "spravochnik", db:"tenant",action:"new"}, function (data) {
   $('#col2').html(data);
   })
 })

//Квартиросъемщик->Создание формы Редактирование записи
$('#col2').on('click', '#ten_edit', function() {
   var chdel = $('input[name=check]:radio:checked').val()
   if (chdel!== undefined) {
  $.get("sprav/tenant.php", {page: "spravochnik", db:"tenant",action:"edit", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }
 })

//Квартиросъемщик->Создание формы Удаление записи
$('#col2').on('click', '#ten_del', function() {
   var chdel = $('input[name=check]:radio:checked').val()
   if (chdel!== undefined) {
  $.get("sprav/tenant.php", {page: "spravochnik", db:"tenant",action:"del", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }
 })

//Квартиросъемщик->Сохранение новой записи
$('#col2').on('click', '#ten_new_data', function() {
  var req = $('[data-form*=requered]').val();
  if (req == '') {
  alert ('Пожалуйста, заполните все поля')
  return false;
  } else {
 
    // var name_adress=$('#name_adress').val()
    //var id_house =$('#id_house').val()
    var id_tenant =$('#id_tenant').val()
    var number_flat =$('#number_flat').val()
    var surname =$('#surname').val()
    var name_tenant =$('#name_tenant').val()
    var patronomic  =$('#patronomic').val()
    var square =$('#square').val()
    var quantity_of_lodger =$('#quantity_of_lodger').val()
    var quantity_registration =$('#quantity_registration').val()
    var id_domain=$('#id_domain option:selected').val()
    var adress=$('#adress option:selected').val()
    var living = $('#living').val()
  $.get("sprav/tenant.php", {page: "spravochnik", db:"tenant",action:"ten_new_data",id_tenant :id_tenant,
adress:adress, number_flat:number_flat, surname:surname, name_tenant:name_tenant, patronomic:patronomic,
square:square, quantity_of_lodger:quantity_of_lodger, quantity_registration:quantity_registration,id_domain:id_domain,
living:living}, function (data) {
   $('#col2').html(data);
   })
   }
 })
 
//Квартиросъемщик->Редактирование записи
$('#col2').on('click', '#ten_edit_data', function() {
  var req = $('[data-form*=requered]').val();
  if (req == '') {
  alert ('Пожалуйста, заполните все поля')
  return false;
  } else {
 
    // var name_adress=$('#name_adress').val()
    //var id_house =$('#id_house').val()
    var new_id_tenant =$('#new_id_tenant').val()
    var id_tenant =$('#id_tenant').val()
    var number_flat =$('#number_flat').val()
    var surname =$('#surname').val()
    var name_tenant =$('#name_tenant').val()
    var patronomic  =$('#patronomic').val()
    var square =$('#square').val()
    var quantity_of_lodger =$('#quantity_of_lodger').val()
    var quantity_registration =$('#quantity_registration').val()
    var id_domain=$('#id_domain option:selected').val()
    var adress=$('#adress option:selected').val()
    var living = $('#living').val()
  $.get("sprav/tenant.php", {page: "spravochnik", db:"tenant",action:"ten_edit_data",new_id_tenant:new_id_tenant,id_tenant :id_tenant,
adress:adress, number_flat:number_flat, surname:surname, name_tenant:name_tenant, patronomic:patronomic,
square:square, quantity_of_lodger:quantity_of_lodger, quantity_registration:quantity_registration,id_domain:id_domain,
living:living}, function (data) {
   $('#col2').html(data);
   })
   }
 })
   
//Квартиросъемщик->Удаление записи
$('#col2').on('click', '#ten_del_data', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
   $.get("sprav/tenant.php", {page: "spravochnik", db:"tenant",action:"ten_del_data", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }  
   })

//--------------------------------------------------------------------------------------------
 
//Функции для справочника Карточка квартиросъемщика
//Карточка квартиросъемщика->Формы заполнение поле № квартиры
$('#col2').on('keyup', '#tc_number_flat', function() {
   			var id_house = $('#tc_id_house option:selected').val();
			var number_flat = $(this).val();
      var id_service = $('#tc_id_service option:selected').val();
			$.post('application.php', {tc_new_id_house: id_house, tc_new_number_flat:number_flat, tc_new_id_service: id_service}, function(data) {
              $('#tc_id_tenant').val(data.id_tenant)
              $('#tc_fio').val(data.fio)
              $('#tc_kolvo').val(data.kolvo)
              $('#tc_S').val(data.s)
              $('#tc_amount').val(data.amount)
          }, "json")
      })

//Карточка квартиросъемщика->Формы заполнение поле № дома
$('#col2').on('change', '#tc_id_house', function() {
    			var id_house = $(this).val();
			var id_service = $('#tc_id_service option:selected').val();
			var number_flat = $('#tc_number_flat').val();		
			$.post('application.php', {tc_new_id_house: id_house, tc_new_number_flat:number_flat, tc_new_id_service: id_service}, function(data) {
              $('#tc_id_tenant').val(data.id_tenant)
              $('#tc_fio').val(data.fio)
              $('#tc_kolvo').val(data.kolvo)
              $('#tc_S').val(data.s)
              $('#tc_amount').val(data.amount)
          }, "json")
			}) 

//Карточка квартиросъемщика->Формы заполнение поле № услуги 
$('#col2').on('change', '#tc_id_service', function() {
 			var id_service = $(this).val();
			var id_house = $('#tc_id_house option:selected').val();
			var number_flat = $('#tc_number_flat').val();		
      $.post('application.php', {tc_new_id_house: id_house, tc_new_number_flat:number_flat, tc_new_id_service: id_service}, function(data) {
              $('#tc_amount').val(data.amount)
      }, "json")
    })  
    
//Карточка квартиросъемщика->Поиск
$('#col2').on('click', '#tc_search', function() {
 var tc_search_kv=$('#tc_search_kv').val() 
 var tc_search_house=$('#tc_search_house option:selected').val()
 if (tc_search_kv!=='') {
  $.get("sprav/tc.php", {page: "spravochnik", db:"tc",action:"search", tc_search_house: tc_search_house,tc_search_kv:tc_search_kv}, function (data) {
   $('#col2').html(data);
   })
   } else {
   $.get("sprav/tc.php", {page: "spravochnik", db:"tc",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
   }
 })

//Карточка квартиросъемщика->Отмена
$('#col2').on('click', '#tc_cancel', function() {
  $.get("sprav/tc.php", {page: "spravochnik", db:"tc",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
 })
 
//Карточка квартиросъемщика->Создание формы Новая запись
$('#col2').on('click', '#tc_new', function() {
  $.get("sprav/tc.php", {page: "spravochnik", db:"tc",action:"new"}, function (data) {
   $('#col2').html(data);
   })
 })

//Карточка квартиросъемщика->Создание формы Редактирование записи
$('#col2').on('click', '#tc_edit', function() {
    var chdel = $('input[name=check]:radio:checked').val()
   if (chdel!== undefined) {
  $.get("sprav/tc.php", {page: "spravochnik", db:"tc",action:"edit", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }
 }) 

//Карточка квартиросъемщика->Форма новая счетчик
$('#col2').on('change', '#tc_new_counter', function() {
 			var id_counter = $(this).val();
      var id_service = $('#tc_id_service option:selected').val();
			var id_house = $('#tc_id_house option:selected').val();
			var number_flat = $('#tc_number_flat').val();		
		  if (id_counter==1) {
        $('#tc_amount').val('0');       
      } else {
      $.post('application.php', {tc_new_id_house: id_house, tc_new_number_flat:number_flat, tc_new_id_service: id_service}, function(data) {
              $('#tc_amount').val(data.amount)
      }, "json")
      }
     })  

//Карточка квартиросъемщика->Форма редактирование услуга
$('#col2').on('change', '#tc_edit_service', function() {
 			var id_service = $(this).val();
			var id_card = $('input[name=check]:radio:checked').val()
      $.post('application.php', {tc_edit_id_card: id_card, tc_edit_id_service:id_service}, function(data) {
              $('#tc_edit_amount').val(data.amount)
      }, "json")
    }) 

//Карточка квартиросъемщика->Форма редактирование счетчик
$('#col2').on('change', '#tc_edit_counter', function() {
 			var id_counter = $(this).val();
      var id_service= $('#tc_edit_service option:selected').val();
      var id_card = $('input[name=check]:radio:checked').val()
		  if (id_counter==1) {
        $('#tc_edit_amount').val('0');       
      } else {
  $.post('application.php', {tc_edit_id_card: id_card, tc_edit_id_service:id_service}, function(data) {
              $('#tc_edit_amount').val(data.amount)
      }, "json")
      }
     }) 

//Карточка квартиросъемщика->Создание формы удалить запись
$('#col2').on('click', '#tc_del', function() {
   var chdel = $('input[name=check]:radio:checked').val()
   if (chdel!== undefined) {
  $.get("sprav/tc.php", {page: "spravochnik", db:"tc",action:"del", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }
 })
 
//Карточка квартиросъемщика->Удаление записи 
$('#col2').on('click', '#tc_del_data', function() {
 var chdel = $('input[name=check]:radio:checked').val()
 if (chdel!== undefined) {
   $.get("sprav/tc.php", {page: "spravochnik", db:"tc",action:"tc_del_data", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }  
   })  

//Карточка квартиросъемщика->Редактирование записи
$('#col2').on('click', '#tc_edit_data', function() {
  var req = $('[data-form*=requered]').val();
  if (req == '') {
  alert ('Пожалуйста, заполните все поля')
  return false;
  } else {
      var chdel = $('input[name=check]:radio:checked').val()
      var id_tenant = $('#tc_edit_id_tenant').val()
      var id_service = $('#tc_edit_service option:selected').val();
      var amount = $('#tc_edit_amount').val(); 
      var counter = $('#tc_edit_counter option:selected').val();
      var old_counter = $('#tc_old_counter').val();
   $.get("sprav/tc.php", {page: "spravochnik", db:"tc",action:"tc_edit_data",
   check:chdel,id_service:id_service, amount:amount, counter:counter, old_counter:old_counter, id_tenant:id_tenant}, function (data) {
   $('#col2').html(data);
   })
   }
 })  

//Карточка квартиросъемщика->Сохранение новой записи
$('#col2').on('click', '#tc_new_data', function() {
  var req = $('[data-form*=requered]').val();
  if (req == '') {
  alert ('Пожалуйста, заполните все поля')
  return false;
  } else {
      var id_tenant =  $('#tc_id_tenant').val();
      var id_service = $('#tc_id_service option:selected').val();
      var amount = $('#tc_amount').val(); 
      var counter = $('#tc_new_counter option:selected').val();
   $.get("sprav/tc.php", {page: "spravochnik", db:"tc",action:"tc_new_data",
   id_tenant:id_tenant, id_service:id_service, amount:amount, counter:counter}, function (data) {
   $('#col2').html(data);
   })
   }
 })

//--------------------------------------------------------------------------------------------

//Функции для справочника Остатки
//Остатки->Поиск
$('#col2').on('click', '#lef_search', function() {
 var lef_search_kv=$('#lef_search_kv').val()
 var lef_search_house=$('#lef_search_house option:selected').val()
 if (lef_search_kv!=='') {
  $.get("sprav/leftover.php", {page: "spravochnik", db:"leftover",action:"search", lef_search_house: lef_search_house,lef_search_kv:lef_search_kv}, function (data) {
   $('#col2').html(data);
   })
   } else {
   $.get("sprav/leftover.php", {page: "spravochnik", db:"leftover",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
   }
 })

//Остатки->Отмена
$('#col2').on('click', '#lef_cancel', function() {
  $.get("sprav/leftover.php", {page: "spravochnik", db:"leftover",action:"cancel"}, function (data) {
   $('#col2').html(data);
   })
 })

//Остатки->Создание формы Новая запись
$('#col2').on('click', '#lef_new', function() {
  $.get("sprav/leftover.php", {page: "spravochnik", db:"leftover",action:"new"}, function (data) {
   $('#col2').html(data);
   })
 })
 
//Остатки->Создание формы Редактирование записи
$('#col2').on('click', '#lef_edit', function() {
    var chdel = $('input[name=check]:radio:checked').val()
   if (chdel!== undefined) {
  $.get("sprav/leftover.php", {page: "spravochnik", db:"leftover",action:"edit", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }
 })
  
//Остатки->Формы заполнение поле № квартиры
$('#col2').on('keyup', '#lef_number_flat', function() {
   			var id_house = $('#lef_id_house option:selected').val();
			var number_flat = $(this).val();
      var id_service = $('#lef_id_service option:selected').val();
			$.post('application.php', {tc_new_id_house: id_house, tc_new_number_flat:number_flat, tc_new_id_service: id_service}, function(data) {
              $('#lef_id_tenant').val(data.id_tenant)
              $('#lef_fio').val(data.fio)
              $('#lef_kolvo').val(data.kolvo)
              $('#lef_S').val(data.s)
          }, "json")
      })

//Остатки->Формы заполнение поле № дома
$('#col2').on('change', '#lef_id_house', function() {
    			var id_house = $(this).val();
			var id_service = $('#lef_id_service option:selected').val();
			var number_flat = $('#lef_number_flat').val();
			$.post('application.php', {tc_new_id_house: id_house, tc_new_number_flat:number_flat, tc_new_id_service: id_service}, function(data) {
              $('#lef_id_tenant').val(data.id_tenant)
              $('#lef_fio').val(data.fio)
              $('#lef_kolvo').val(data.kolvo)
              $('#lef_S').val(data.s)
          }, "json")
			})
      
//Остатки->Создание формы удалить запись
$('#col2').on('click', '#lef_del', function() {
   var chdel = $('input[name=check]:radio:checked').val()
   if (chdel!== undefined) {
  $.get("sprav/leftover.php", {page: "spravochnik", db:"leftover",action:"del", check:chdel}, function (data) {
   $('#col2').html(data);
   })
   }
 })

//Остатки->Сохранение новой записи
$('#col2').on('click', '#lef_new_data', function() {
  var req = $('[data-form*=requered]').val();
  if (req == '') {
  alert ('Пожалуйста, заполните все поля')
  return false;
  } else {
      var id_tenant =  $('#lef_id_tenant').val();
      var id_service = $('#lef_id_service option:selected').val();
      var amount = $('#lef_amount').val();
      var counter = $('#lef_node').val();
   $.get("sprav/leftover.php", {page: "spravochnik", db:"leftover",action:"lef_new_data",
   lef_new_id_tenant:id_tenant, lef_new_id_service:id_service, lef_new_amount:amount, lef_new_node:counter}, function (data) {
   $('#col2').html(data);
   })
   }
 })

//Остатки->Сохранение отредактированной записи
$('#col2').on('click', '#lef_edit_data', function() {
  var req = $('[data-form*=requered]').val();
  if (req == '') {
  alert ('Пожалуйста, заполните все поля')
  return false;
  } else {
      var chdel = $('input[name=check]:radio:checked').val()
      var id_tenant =  $('#lef_id_tenant').val();
      var id_service = $('#lef_id_service option:selected').val();
      var amount = $('#lef_amount').val();
      var counter = $('#lef_node').val();
   $.get("sprav/leftover.php", {page: "spravochnik", db:"leftover",action:"lef_edit_data",
   lef_edit_id_tenant:id_tenant, lef_edit_id_service:id_service, lef_edit_amount:amount, lef_edit_node:counter, lef_edit_id_leftover:chdel}, function (data) {
   $('#col2').html(data);
   })
   }
 })

//Остатки->Удаление записи
$('#col2').on('click', '#lef_del_data', function() {
      var chdel = $('input[name=check]:radio:checked').val()
   $.get("sprav/leftover.php", {page: "spravochnik", db:"leftover",action:"lef_del_data",
   lef_del_id_leftover:chdel}, function (data) {
   $('#col2').html(data);
   })
 })

//-----------------------------------------------------------------------------------------

//Начисление-------------------------------------------------------------------------------
//Начисление->Кнопка Начислить
$('#col2').on('click', '#ai_commit', function() {
 			 var month=$('#ai_month option:selected').val()
       var month_text=$('#ai_month option:selected').text() 
       var year = $('#ai_year').val()
      $.post('application.php', {ai_month: month, ai_year:year,month_text:month_text}, function(data) {
              $('#ai_result').html(data.result)
      }, "json")
    }) 
     
//Начисление->enter
$('#col2').on('submit', '#ai', function(e) {
        e.preventDefault()
      })

//-----------------------------------------------------------------------------------------	  
	  
//Начисление по счетчику ------------------------------------------------------------------	  
//Начисление по счетчику->(первоначальный расчет)
$('#col2').on('click', '#cc_search', function() {
		 var cc_adress=$('#cc_search_house option:selected').val()
       var cc_number_flat=$('#cc_search_kv').val() 
       //alert('ddd')           
      $.post('application.php', {cc_number_flat:cc_number_flat, cc_adress:cc_adress}, function(data) {
              $('#counter_div').html(data.result)
      }, "json")
    })

//Начисление по счетчику->Календарь	для начисления по счетчику
$('#col2').on('click', '#cc_date', function() {
		$(this).datepicker({
			format: 'yyyy-mm-dd',
			weekStart: 1
		}).focus();
	})

//-----------------------------------------------------------------------------------------	  
	  
//Начисление по ОДПУ ----------------------------------------------------------------------
//Начисление по ОДПУ->Календарь	для начисления по ОДПУ
$('#col2').on('click', '#cp_date', function() {
		$(this).datepicker({
			format: 'yyyy-mm-dd',
			weekStart: 1
		}).focus();
	})

//Начисление по ОДПУ->Адрес
$('#col2').on('change', '#cp_search_house', function() {
	var house=$('#cp_search_house option:selected').val()
	$.post('application.php', {cp:'cp_serv',cp_house:house}, function (data) {
		$('#cp_serv').html(data.result);
		$('#cp_counter').html('');
		$('#cp_count').html('');
		$('#cp_ved').html('');
	}, "json")
  })

//Начисление по ОДПУ->Услуга  
$('#col2').on('change', '#cp_search_service', function() {
	var date = $('#cp_date').val()
	var house=$('#cp_search_house option:selected').val()
	var service=$('#cp_search_service option:selected').val()
	$.post('application.php', {cp:'cp_counter',cp_house:house, cp_service:service,cp_date:date}, function (data) {
		$('#cp_counter').html(data.result);
		$('#cp_count').html('');
		$('#cp_ved').html('');
	}, "json")
  })

//Начисление по ОДПУ->Счетчик 
$('#col2').on('change', '#cp_search_counter', function() {
	var date = $('#cp_date').val()
	var house=$('#cp_search_house option:selected').val()
	var service=$('#cp_search_service option:selected').val()
	var counter=$('#cp_search_counter option:selected').val()
	$.post('application.php', {cp:'cp_data',cp_house:house, cp_service:service,cp_date:date,cp_counter:counter}, function (data) {
		$('#cp_count').html(data.result);
		
	}, "json")
  })
  
//Начисление по ОДПУ->Конечные показания счетчика  
$('#col2').on('keyup', '#max_counter', function() {
	var min = $('#min_counter').val()
	var max = $('#max_counter').val()
	var norma=$('#cp_norma').val()
	var ipu=$('#cp_ipu').val()
	var nej=$('#cp_nej').val()
	var v= parseFloat(norma)+parseFloat(ipu)+parseFloat(nej);
	$.post('application.php', {cp:'cp_v',cp_max:max, cp_min:min,cp_v:v}, function (data) {
		$('#odn').val(data.ost);
		$('#cp_v').val(data.result);
	}, "json")
  })
  
  $('#col2').on('keyup', '#max_counter1', function() {
	var min = $('#min_counter').val()
	var max = $('#max_counter1').val()
	min=min*(-1);
	max=max*(-1);
	var v= 0;
	$.post('application.php', {cp:'cp_v',cp_max:max, cp_min:min,cp_v:v}, function (data) {
		$('#odn').val(data.ost);
		//$('#cp_v').val(data.result);
	}, "json")
  })

//Начисление по ОДПУ->Рассчитать  
$('#col2').on('click', '#cp_rasch', function() {
	var odn=$('#odn').val();
	var house=$('#cp_search_house option:selected').val()
	var service=$('#cp_search_service option:selected').val()
	var cp_node=$('#cp_node').val();
	if (odn=='') {
		alert ('Введите показания счетчиков')
	} else {
		$.post('application.php', {cp:'cp_ved',cp_house:house, cp_service:service,cp_odn:odn,cp_node:cp_node}, function (data) {
			$('#cp_ved').html(data.result);
		}, "json")
	}
  })

//Начисление по ОДПУ->Сохранение данных  
 $('#col2').on('click', '#cp_save_data', function() {
	var mas = [];
	for (i=1;i<=document.getElementById('ved_table').getElementsByTagName('tr').length-4;i=i+2) {
		mas[i][0]=$("#col2 #ved_table tr:eq("+i+") td:eq(0)").text()
		mas[i][1]=$("#col2 #ved_table tr:eq("+i+") td:eq(3)").text()
		mas[i][2]=$("#col2 #ved_table tr:eq("+i+") td:eq(4)").text()	
	}
	$.post('application.php', {cp:'cp_save_data',cp_mas:mas}, function (data) {
			$('#cp_ved').html(data.result);
		}, "json")
 })

//----------------------------------------------------------------------------------------

})