<?php

interface BugMeTaskerMessager {
  public function setMessage($msg);
  public function addButton($key, $text);
  public function execute();
  static public function requestItem($item);
}
class GMessageMessager implements BugMeTaskerMessager{
  protected $buttons = array();
  protected $message = '';
  public function setMessage($msg) {
    $this->message = $msg;
  }
  public function addButton($key, $text=NULL) {
    $text = isset($text) ? $text : $key;
    $this->buttons[] = "$key:$text";
  }
  public function execute() {
    $cmd = "gmessage '{$this->message}' -center";
    if($this->buttons) {
      $cmd .= " -print -buttons " . implode(",", $this->buttons);
    }
    return exec($cmd);
  }
  public static function requestItem($message) {
    $new = exec("gmessage '$message' -entry");
    return $new;
  }
}

class OsascriptMessager implements BugMeTaskerMessager{
  protected $buttons = array();
  protected $message = '';
  public function setMessage($msg) {
    $this->message = $msg;
  }
  public function addButton($key, $text=NULL) {
    $text = isset($text) ? $text : $key;
    $this->buttons[] = "$key";
  }
  public function execute() {
    $cmd = "osascript -e 'tell application \"System Events\" to display alert \"bug me tasker\" message \"{$this->message}\"'";
    if($this->buttons) {
      $buttons = array_map(function($a) { return "\"$a\"";}, $this->buttons);
      $cmd = "osascript -e 'tell application (path to frontmost application as text) to choose from list {" . implode(",", $buttons) . "} with prompt \"{$this->message}\"'";
    }
    $rtn = exec($cmd);
    $rtn = in_array($rtn, $this->buttons) ? $rtn : "cancel";
    return $rtn;
  }
  public static function requestItem($message) {
    $cmd = "osascript -e 'tell application (path to frontmost application as text) to display dialog \"$message\" default answer \"\"'";
    $new = exec($cmd);
    //return value
    $new = preg_replace("/.*:/","", $new);
    return $new;
  }
}
