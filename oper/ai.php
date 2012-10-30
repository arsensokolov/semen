<?php
if ($_GET['op']=='ai') {
$ai='';
$ai.='<h1>Начисление по нормативу</h1>';
$ai.= "<form id='ai' method='get'>";
$ai.= "<label for='ai_month'> Адрес: </label>";
$ai.= "<select id='ai_month' size=1>";
$ai.= "<option value=01>Январь</option>";
$ai.= "<option value=02>Февраль</option>";
$ai.= "<option value=03>Март</option>";
$ai.= "<option value=04>Апрель</option>";
$ai.= "<option value=05>Май</option>";
$ai.= "<option value=06>Июнь</option>";
$ai.= "<option value=07>Июль</option>";
$ai.= "<option value=08>Август</option>";
$ai.= "<option value=09>Сентябрь</option>";
$ai.= "<option value=10>Октябрь</option>";
$ai.= "<option value=11>Ноябрь</option>";
$ai.= "<option value=12>Декабрь</option>";
$ai.= "</select><br>";
$ai.= "<label for='year'>Год:</label>";
$ai.= "<input type='text' id='ai_year' placeholder='Введите год'> <br>";
$ai.= "<button type=\"button\" id=\"ai_commit\">Начислить</button></center>";
$ai.= "</form>";
$ai.= "<div id='ai_result'></div>";
}
?>