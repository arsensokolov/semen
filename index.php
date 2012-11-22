<?php
session_start();
include_once __DIR__.'/db.php';
include 'sprav/class.php';
switch($_GET['db']) {
	case 'company':
		include 'sprav/company.php';
		break;
	case 'gs':
		include 'sprav/general_service.php';
		break;
	case 'service':
		include 'sprav/service.php';
		break;
	case 'domain':
		include 'sprav/domain.php';
		break;
	case 'adress':
		include 'sprav/adress.php';
		break;
	case 'hs':
		include 'sprav/hs.php';
		break;
	case 'tenant':
		include 'sprav/tenant.php';
		break;
	case 'tc':
		include 'sprav/tc.php';
		break;
	case 'leftover':
		include 'sprav/leftover.php';
		break;
}
switch($_GET['op']) {
	case 'ai':
		include 'oper/ai.php';
		break;
	case 'cc':
		include 'oper/cc.php';
		break;
	case 'cp':
		include 'oper/cp.php';
		break;
	case 'recalc':
		include 'oper/recalc.php';
		break;
	case 'recalc_house':
		include 'oper/recalc_house.php';
		break;
}

if (isset($_GET['logout'])) {
    session_unset();
    session_destroy();
    header("Location: auth.php?logout");
    exit();
}
if (isset($_SESSION['login'])) {
$hello="Здравствуйте, <a href=\"?logout\">{$_SESSION['login']}</a>";
} else {
header("Location: auth.php");
}
if (isset($_GET['print'])) {
$tpl=file_get_contents("tpl/print.tpl");
$tpl=str_replace("{print}", $print, $tpl);
echo $tpl;
}
if (!isset($_GET['page'])) {
$menu="spravochnik.tpl";
} else $menu=$_GET['page'].'.tpl' ;
if ($menu=="spravochnik.tpl") {$content='sprav/'.$_GET['db'].'.tpl' ; }
if ($menu=="operation.tpl") {$content='oper/'.$_GET['op'].'.tpl' ;}
$tpl=file_get_contents("tpl/header.tpl");
$tpl.=file_get_contents("tpl/menu/".$menu);
$tpl.=file_get_contents("tpl/slide.tpl");
$tpl.=file_get_contents("tpl/content/".$content);
$tpl.=file_get_contents("tpl/footer.tpl");
$tpl=str_replace("{Hello}", $hello, $tpl);
$tpl=str_replace("{title}", $title, $tpl);
$tpl=str_replace("{company}", $company, $tpl);
$tpl=str_replace("{gs}", $gs, $tpl);
$tpl=str_replace("{adress}", $adress, $tpl);
$tpl=str_replace("{domain}", $domain, $tpl);
$tpl=str_replace("{hs}", $hs, $tpl);
$tpl=str_replace("{leftover}", $leftover, $tpl);
$tpl=str_replace("{service}", $service, $tpl);
$tpl=str_replace("{tc}", $tc, $tpl);
$tpl=str_replace("{tenant}", $tenant, $tpl);
$tpl=str_replace("{ai}", $ai, $tpl);
$tpl=str_replace("{cc}", $cc, $tpl);
$tpl=str_replace("{cp}", $cp, $tpl);
$tpl=str_replace("{recalc}", $recalc, $tpl);
$tpl=str_replace("{recalc_house}", $recalc_house, $tpl);
echo $tpl;
?>
