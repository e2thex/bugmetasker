<?php
$dir = dirname(__FILE__);
require_once $dir . "/BugMeTasker.php";
require_once $dir . "/BugMeTaskerMessager.php";

$action = isset($argv[1]) ? $argv[1] : NULL;
$file = getenv("HOME") . "/.bmttasks";
$t = new BugMeTasker($file);
$t->load();
$t->main($action, new OsascriptMessager());
//$t->main($action, new GMessageMessager());
$t->save();

