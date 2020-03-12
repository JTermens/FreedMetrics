<?php

include_once('inc/globals.inc.php');

if(array_key_exists('pagename', $_GET)){
    $pagename = $_GET['pagename'];
    $_SESSION['pagename'] = $pagename;

    if (array_key_exists($pagename, $pagename_ref)) {
        include $pagename_ref[$pagename]['route'];
    }else {
        include $pagename_ref['Not-Found']['route'];
    }

    print(page_footer());

}else{
    header('Location: index.php?pagename=Home');
}