tinyrss
=======

Small (3kB) and simple (5 functions) PHP library for creating RSS feeds.

Functions
---------

- tinyRssHeader ($ATitle, $ADescription, $AAuthorEmail, $ALinkToRssItself=NULL)

  Print header with some basic information.

- tinyRssItem ($ATitle, $ADescription, $ALink, $ALinkComments=NULL, $AGuid=NULL, $ACategory='news', $ADate=NULL)

  Adds single news item.
  GUID is by default md5($ATitle.$ADescription) or you can specify your 
  own, e.g. serial from some table. If you don't specify date then 
  current date will be used, but if GUID is unique then it works fine.

- tinyRssFooter ()

  Ends feed.

- tinyRssComment($AComment)

  Usefull for debuging. Also you can use ?debug=true to view feed in browser.

- tinyRssDie ($AMessage)
  
  When something bad happen while you generating feed and you need to abort
  but still needs for feed to be valid.

Example
-------

```php
<?php
  require_once "tinyrss.php";

  tinyRssHeader("My blog", "My blog news", "john@example.com", "http://blog.example.com/");
  
  $news = explode("\n",file_get_contents("demo.txt"));
  for ($i=0; $i<count($news); $i++)
    tinyRssItem("New post", $news[$i], "http://blog.example.com/view?id=$i");

  tinyRssFooter();
?>
```

Output
------

```xml
<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
    <title>My blog</title>
    <link>http://blog.example.com/</link>
    <atom:link href="http://blog.example.com/" rel="self" type="application/rss+xml" />
    <description>My blog news</description>
    <webMaster>john@example.com</webMaster>
    <generator>tinyrss</generator>

    <item>
      <guid>6c8590fdf48556c3618357504c876aaf</guid>
      <title>New post</title>
      <link>http://blog.example.com/view?id=0</link>
      <category>news</category>
      <pubDate>Sun, 09 Dec 2012 20:30:53 +0100</pubDate> 
      <description>First message</description>
    </item>

    <item>
      <guid>ed8f77a4120285726f28332a392fea01</guid>
      <title>New post</title>
      <link>http://blog.example.com/view?id=1</link>
      <category>news</category>
      <pubDate>Sun, 09 Dec 2012 20:30:53 +0100</pubDate> 
      <description>Second &lt;span onclick=&quot;document.title='aaa'&quot;&gt;me&lt;/span&gt;ssage</description>
    </item>

    <item>
      <guid>c9ced14f6001ca723de8c4906e1e04a7</guid>
      <title>New post</title>
      <link>http://blog.example.com/view?id=2</link>
      <category>news</category>
      <pubDate>Sun, 09 Dec 2012 20:30:53 +0100</pubDate> 
      <description>Third message</description>
    </item>

    <item>
      <guid>6fe76ae3544b6d9b64d89124506b1304</guid>
      <title>New post</title>
      <link>http://blog.example.com/view?id=3</link>
      <category>news</category>
      <pubDate>Sun, 09 Dec 2012 20:30:53 +0100</pubDate> 
      <description></description>
    </item>

  </channel>
</rss>
```
