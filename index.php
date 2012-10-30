 <?php
$path='/var/www/html/';
include_once $path.'db.php';
include 'sprav/class.php';
include 'sprav/company.php';
include 'sprav/domain.php';
include 'sprav/adress.php';
include 'sprav/general_service.php';
include 'sprav/service.php';
include 'sprav/hs.php';
include 'sprav/tenant.php';
include 'sprav/leftover.php';
include 'sprav/tc.php';
include 'oper/ai.php';
include 'oper/cc.php';
include 'print.php';
session_start();
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
$tpl=str_replace("{adress}", $adress, $tpl);
$tpl=str_replace("{gs}", $gs, $tpl);
$tpl=str_replace("{domain}", $domain, $tpl);
$tpl=str_replace("{hs}", $hs, $tpl);
$tpl=str_replace("{leftover}", $leftover, $tpl);
$tpl=str_replace("{service}", $service, $tpl);
$tpl=str_replace("{tc}", $tc, $tpl);
$tpl=str_replace("{tenant}", $tenant, $tpl);
$tpl=str_replace("{ai}", $ai, $tpl);
$tpl=str_replace("{cc}", $cc, $tpl);
echo $tpl;
?>
