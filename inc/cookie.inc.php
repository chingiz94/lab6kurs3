<?php
$visitCounter = 0;                     
if (isset($_COOKIE['visitCounter'])) {  
    $visitCounter = (int)$_COOKIE['visitCounter'];
}
$visitCounter++;                       

$lastVisit = '';                         
if (isset($_COOKIE['lastVisit'])) {
    $lastVisit = date('d-m-Y H:i:s', (int)$_COOKIE['lastVisit']);
}

if (!isset($_COOKIE['lastVisit']) ||
    date('d-m-Y', (int)$_COOKIE['lastVisit']) != date('d-m-Y')) {
    $expires = time() + 60 * 60 * 24 * 1;
    setcookie('visitCounter', $visitCounter, $expires);
    setcookie('lastVisit', time(), $expires);
}
