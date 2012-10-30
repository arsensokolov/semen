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
	window.open('/print.php?print=cc', '_blank');
}) 


$("#col2").on('click', '#cc_table td', function(){
if  (((($(this).index()==4) && ($(this).closest("tr").index()!='0')) || 
(($(this).index()==3) && ($(this).closest("tr").index()!='0')))) {
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
       $("#col2 #cc_table tr:eq("+k+") td:eq(5)").text(count)
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