<?php
require_once "./BugMeTasker.php";
require_once "./BugMeTaskerMessager.php";

$action = isset($argv[1]) ? $argv[1] : NULL;
$t = new BugMeTasker();
$t->load();
$t->main($action, new GMessageMessager());
$t->save();

