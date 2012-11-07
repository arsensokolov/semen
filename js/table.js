$(document).ready(function(){  


$("#col2").on('click', '#cc_save', function() {
var result = ''
	for (i=1;i<=document.getElementById('cc_table').getElementsByTagName('tr').length-4;i=i+2) {
   result+='insert into calculation_counter values ("", "'
   result+=$("#col2 #cc_date").val()+'" , (select id from counter where id_counter='
   result+=$("#col2 #cc_table tr:eq("+i+") td:eq(1)").text()+') , '
   if ($("#col2 #cc_table tr:eq("+i+") td:eq(3)").text()!='') {
   result+=$("#col2 #cc_table tr:eq("+i+") td:eq(3)").text()+' , '
   } else {
   result+='"",'
   }
   if ($("#col2 #cc_table tr:eq("+i+") td:eq(4)").text()!='') {
   result+=$("#col2 #cc_table tr:eq("+i+") td:eq(4)").text()+' , '
   } else {
   result+='"",'
   }
   result+=$("#col2 #cc_table tr:eq("+i+") td:eq(5)").text()+' , '
   result+=$("#col2 #cc_table tr:eq("+i+") td:eq(7)").text()+' ); '
  }
  $.post('application.php', {cc_text:result}, function(data) {
    $("#col2 #cc_data").text(data.result)
  }, "json")
  })

$("#col2").on('click', '#cc_print', function() {
	var mas = ["","Январь","Февраль","Март","Апрель", "Май", "Июнь", "Июль", "Август","Сентябрь","Октябрь", "Ноябрь", "Декабрь"]
	var adress = ' р.п. Листвянка, '+$('#cc_search_house option:selected').text()+', кв. '+$('#cc_search_kv').val();
	var surname= $('#cc_fio').val();
	var date = $('#cc_date').val();
	var day=date.substring(8, 10)
	var month=date.substring(5, 7)
	var year=date.substring(0, 4)
	//alert(day+'.'+month+'.'+year);
	var w = window.open('/print.php?print=cc' , '_blank');
	w.document.write('<!DOCTYPE html>');
	w.document.write('<html lang="ru">');
	w.document.write('<meta charset="utf-8"> <title>АС «Квартиросъемщик» </title>');
	w.document.write('<link rel="stylesheet" href="css/bootstrap.min.css">"');
	w.document.write('<link rel="stylesheet" href="css/bootstrap-responsive.min.css">');
	w.document.write('<link rel="stylesheet" href="css/datepicker.css">');
	w.document.write('<link rel="stylesheet" href="css/application.css">');
	//w.document.write('<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>');
	w.document.write('</head> <body>');
	w.document.write('<div id="counter_div">');
	w.document.write( "<table width='680' cellspacing='0' cellpadding='2'  align='center' px=''>"); 
	w.document.write( "<tr align='center'>");
	w.document.write( "<td colspan='8'>АКТ</td>");
	w.document.write( "</tr>");
	w.document.write( "<tr align='center'>");
	w.document.write( "<td colspan='8'>по учету горячей и холодной воды в м3</td>");
	w.document.write( "</tr>");
	w.document.write( "<tr align='center'>");
	w.document.write( "<td colspan='8'>за "+mas[parseInt(month)]+" "+ year+" г. </td>");
	w.document.write( "</tr>");
	w.document.write( "<tr align='center'>");
	w.document.write( "<td colspan='8'></td>");
	w.document.write( "</tr>");
	w.document.write( "<tr align='left'>");
	w.document.write( "<td colspan='8'>по адресу:"+adress+"</td>");
	w.document.write( "</tr>");
	w.document.write( "<tr align='left'>");
	w.document.write( "<td colspan='8'></td>");
	w.document.write( "</tr>");
	w.document.write( "<tr align='left'>");
	w.document.write( "<td colspan='8'>Ф.И.О. квартиросъемшика: "+surname+" </td>");
	w.document.write( "</tr>");
	w.document.write( "<tr align='left'>");
	w.document.write( "<td colspan='8'></td>");
	w.document.write( "</tr>");
	w.document.write( "</table>");
	w.document.write( "<table  border=1 width='680' cellspacing='0' cellpadding='2'  align='center' px=''>");
	w.document.write("<tr>");
	w.document.write(" <td> №</td>");
	w.document.write(" <td align='center'> № счетчика </td>");
	w.document.write(" <td align='center'> Услуга </td>");
	w.document.write(" <td align='center'> Начальные показания </td>");
	w.document.write(" <td align='center'> Конечные показания </td>");
	w.document.write(" <td align='center'> Объем </td>");
	w.document.write(" <td align='center'> Цена </td>");
	w.document.write(" <td align='center'> Сумма </td>");
	w.document.write(" </tr>");
	for (i=1;i<=document.getElementById('cc_table').getElementsByTagName('tr').length-2;i=i+2) {
		w.document.write( "<tr align='center'>");
		for (j=0;j<=7;j++) {
			mas[i,j]=$("#col2 #cc_table tr:eq("+i+") td:eq("+j+")").text();
			w.document.write( "<td>");
			w.document.write(mas[i,j]);
			w.document.write( "</td>");
		}
		w.document.write( "</tr>");
	}
	w.document.write( "</table>");
	w.document.write( "<table  border=0	 width='680' cellspacing='0' cellpadding='2'  align='center' px=''>");
	w.document.write("<tr>");
	w.document.write(" <td 	height=25> </td>");
	w.document.write(" <td> </td>");
	w.document.write("</tr>");
	w.document.write("<tr>");
	w.document.write(' <td align="center"> ООО УК "Сервис" </td>');
	w.document.write(" <td align='center'> Владелец квартиры</td>");
	w.document.write("</tr>");
	w.document.write("<tr>");
	w.document.write(" <td align='center'> _______________</td>");
	w.document.write(" <td align='center'> ________________</td>");
	w.document.write("</tr>");
	w.document.write("<tr>");
	w.document.write(" <td align='center'> Дата: "+day+'.'+month+'.'+year+"</td>");
	w.document.write(" <td align='center'> Дата:____________</td>");
	w.document.write("</tr>");
	w.document.write( "</table>");
	
	w.document.write('</div>');
	w.document.close();

	//window.open('/print.php?print=cc', '_blank');
}) 


$("#col2").on('click', '#cc_table td', function(){
var rows = document.getElementById('cc_table').getElementsByTagName('tr').length-2;
if  (((($(this).index()==4) && ($(this).closest("tr").index()!='0') && ($(this).closest("tr").index()!=rows)) || 
(($(this).index()==3) && ($(this).closest("tr").index()!='0') && ($(this).closest("tr").index()!=rows)))) {
 if (!$(this).closest("tr").is("#vod")) {
var col = $(this).prevAll().length;
var row = $(this).closest("tr").index();
    $(this).html("<input id='input' type='text' value='"+$(this).text()+"'/>");
    }
    }
// Что бы input не ставился повторно, запрещаем
}).on('click', '#cc_table td input', function(){
    return false;
// При потере фокуса в input, возвращаем все как было.
}).on('blur', '#cc_table td', function(){
    // text, т.к. html теги не обрабатываются.
    $(this).text($('#col2 #input').val());
    var col = $(this).prevAll().length;
    var row = $(this).parent('tr').prevAll().length;
    var rows = document.getElementById('cc_table').getElementsByTagName('tr').length-2;
    if (col==4) {
    var min=  parseFloat($("#col2 #cc_table tr:eq("+row+") td:eq(3)").text());
	var max = parseFloat($("#col2 #cc_table tr:eq("+row+") td:eq(4)").text());
    var amount =parseFloat($("#col2 #cc_table tr:eq("+row+") td:eq(6)").text());
    if (max<min) { (alert ('Конечное показание меньше, чем начальное показание')) } 
    else {
    if (max>=min) {
    $("#col2 #cc_table tr:eq("+row+") td:eq(3)").text((min).toFixed(3));
	$("#col2 #cc_table tr:eq("+row+") td:eq(4)").text((max).toFixed(3));
    $("#col2 #cc_table tr:eq("+row+") td:eq(5)").text((max-min).toFixed(3));
    $("#col2 #cc_table tr:eq("+row+") td:eq(7)").text(((max-min)*amount).toFixed(2));
    var sum=0;
    var count=0;
    var result;
    }
    for (var i = 1; i<=(rows-2); i=i+2){
    if ($("#col2 #cc_table tr:eq("+i+") td:eq(5)").text()!='') {
    if (!$("#col2 #cc_table tr:eq("+i+")").is("#vod")) {
        count= count+parseFloat($("#col2 #cc_table tr:eq("+i+") td:eq(5)").text());
    }               
    }
    }
     for (var k = 1; k<=(rows-2); k++){
    if ($("#col2 #cc_table tr:eq("+k+")").is("#vod")) {
       $("#col2 #cc_table tr:eq("+k+") td:eq(5)").text(count.toFixed(3))
    }               
    }
     for (var j = 1; j<=(rows-2); j=j+2){
    if ($("#col2 #cc_table tr:eq("+j+") td:eq(5)").text()!='') {
        $("#col2 #cc_table tr:eq("+j+") td:eq(7)").text((parseFloat($("#col2 #cc_table tr:eq("+j+") td:eq(5)").text())*parseFloat($("#col2 #cc_table tr:eq("+j+") td:eq(6)").text())).toFixed(2))
    }
    if ($("#col2 #cc_table tr:eq("+j+") td:eq(7)").text()!='') {
    sum=sum + parseFloat($("#col2 #cc_table tr:eq("+j+") td:eq(7)").text())
 
    }
    }
    $("#col2 #cc_table tr:eq("+rows+") td:eq(7)").text(sum.toFixed(2));     
    }
    } 
 })

})