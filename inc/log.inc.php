<?php
$dt   = time();                             
$page = $_SERVER['REQUEST_URI'];
$ref  = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$path = "$dt|$page|$ref\n";

file_put_contents(__DIR__ . '/../log/' . PATH_LOG, $path, FILE_APPEND);
