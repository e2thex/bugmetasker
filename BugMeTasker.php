<?php
class BugMeTasker {
  protected $inc;
  protected $tasks = array();
  protected $running = false;
  function __construct($file= '~/.bmttasks', $inc = .5) {
    $this->inc = $inc;
    $this->file = $file;
  }
  function load() {
    $config = json_decode(file_get_contents($this->file));
    $config = $config ?: (object) array("running"=>TRUE, 'tasks' => array());
    $this->tasks = (array) $config->tasks;
    $this->running = $config->running;
  }
  function save() {
    $config = array("tasks" => $this->tasks, 'running' => $this->running);
    file_put_contents($this->file,json_encode($config));
  }
  function main($action = NULL, $messager) {
    if($action == 'cron') {
      exec("echo 'cron me' >> /tmp/eriktest");
      if($this->running) {
        $action = NULL;
      }
      else {
        return;
      }
    }
    if(!$action) {
      exec("echo 'should display' >> /tmp/eriktest");
      
      $action = $this->display_options($messager);
    }

    $a = print_r(array($action), TRUE);
      exec("echo '$a--' >> /tmp/eriktest");
    //one load so that we do not blow away queue up changes
    $this->load();
    switch($action) {
      case "new":
        $new = $messager->requestItem("New Task");
        $this->inc($new);
      break;
      case "clear":
        $this->tasks = array();
      break;
      case "start":
        $this->running = TRUE;
      break;
      case "stop":
        $this->running = FALSE;
      break;
      case "cancel":
      break;
      default:
        $this->inc($action);
    }
  }

  function inc($task) {
    if(!isset($this->tasks[$task])) {
      $this->tasks[$task] = 0;
    }
      exec("echo '$task---' >> /tmp/eriktest");
      $this->tasks[$task] += $this->inc;
  }

  function display_options($messager) {
    $msg = "What did you do in the last Pom?";
    $display_tasks = $this->tasks;
    ksort($display_tasks);
    foreach($display_tasks as $name => $time) {
      $msg .="\n". $time."\t".$name;
      $sum += $time;
      $messager->addButton($name);
    }
    $msg .="\n---";
    $msg .="\n" . $sum . "\tTotal";
    $messager->setMessage($msg);
    $messager->addButton('clear');
    $messager->addButton('new');
    $messager->addButton('cancel');
    if($this->running) {
      $messager->addButton('stop');
    }
    else {
      $messager->addButton('start');
    }
    return $messager->execute();
  }
}
