<?php
class Template {
  private $dir = "";
  private $file = "";
  public function __construct($dir="", $file="") {
    if(empty($dir)) die("Template: No path avaliable");
    $this->dir = $dir;
    if(!$this->isDirValid()) die("Path does not exist");
    $this->file = $file;
    if(!$this->isFileValid()){
      $this->file = "";
    }
  }

  private function isDirValid() {
    return is_dir($this->dir);
  }

  private function path() {
    return $this->dir . "/" . $this->file . ".html";
  }

  private function isFileValid() {
    return is_file($this->path());
  }

  public function html() {
    if(!file_exists($this->path())) die("No such html exists");
    return new Html($this->dir, $this->file);
  }

}

class Html {
  private $file;
  private $path;
  public function __construct($path="", $file="") {
    if(empty($path)) die("No path avaliable");
    if(empty($file)) die("No file avaliable");
    $this->path = $path;
    $fullPath = $path . "/" . $file . ".html";
    if(!file_exists($fullPath)) die("No such file");
    $this->file = file_get_contents($fullPath);
  }

  public function show() {
    echo $this->rendered();
  }

  public function set($key, $val) {
    $this->file = preg_replace("/(#|\?){ . $key  . }/", $val, $this->file);
  }

  public function rendered() {
    return preg_replace("/?{(\w|\ )+}/", "", $this->file);
  }

  public function match() {
    $matches = "";
    preg_match_all("/#include\ (\w+)/", $this->file, $matches);
    $files = $matches[1];
    $matches = $matches[0];
    $count = count($matches);

    if($count <= 0) return "";
    for($i = 0; $i < $count; $i++){
      $thisMatch = "/" . str_replace(" ", "\ ", $matches[$i]) . "/";
      $this->file = preg_replace($thisMatch, file_get_contents($this->path . "/includes/" . $files[$i] . ".html"), $this->file);
    }
    echo $this->file;
  }
}
?>
