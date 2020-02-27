<?php

include_once('inc/globals.inc.php');

if(array_key_exists('pagename', $_GET)){
    $pagename = $_GET['pagename'];

    $title = $pagename;

    print(page_head($title));

    if (array_key_exists($pagename, $pagename_ref)) {
        include $pagename_ref[$pagename];
    }else {
        include("$tplDir/page_not_found.php");
    }

    print(page_footer());

}else{
    header('Location: index.php?pagename=Home');
}