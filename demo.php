<?php
  require_once "tinyrss.php";

  tinyRssHeader("My blog", "My blog news", "john@example.com");

  $news = explode("\n",file_get_contents("demo.txt"));
  for ($i=0; $i<count($news); $i++)
    tinyRssItem("New post", $news[$i], "http://blog.example.com/view?id=$i");

  tinyRssFooter();
  
?>
