<?php
$dir = dirname(__FILE__);
require_once $dir . "/BugMeTasker.php";
require_once $dir . "/BugMeTaskerMessager.php";

$action = isset($argv[1]) ? $argv[1] : NULL;
$t = new BugMeTasker();
$t->load();
$t->main($action, new GMessageMessager());
$t->save();

