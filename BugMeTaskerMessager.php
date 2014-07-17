<?php

interface BugMeTaskerMessager {
  public function setMessage($msg);
  public function addButton($key, $text);
  public function execute();
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
}

