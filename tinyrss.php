<?php
  // Interface for creating RSS XML files
    
  function tinyRssComment($AComment) {
    // comment
    echo "  <!-- ".str_replace('-','_',htmlspecialchars($AComment))." -->\n";
  }

  function tinyRssRootNode() {
    // return either "rss" or "rss_debug" depending on "debug=true" set int url attributes
    if (@$_REQUEST['debug'] == 'true')
      return "rss_debug"; 
    else
      return "rss"; 
  }
  
  function tinyRssHeader ($ATitle, $ADescription, $AWebMaster, $ALinkToRssItself) {
    // create RSS file header
    // debuging
    $tiny_rss_content_type = "text/xml";
    if (@$_REQUEST['debug'] == 'true')
      $tiny_rss_content_type = "text/plain"; 
    // FIXME: perhaps $ALinkToRssItself can be determined from environment variables of executing script or so. Bbut maybe the feed itself is somewhere else and this is just filter of rss
    $ALinkToRssItself = htmlspecialchars($ALinkToRssItself);
    $ATitle = htmlspecialchars($ATitle);
    $ADescription = htmlspecialchars($ADescription);
    header("Content-Type: $tiny_rss_content_type");
    echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
    echo "<".tinyRssRootNode()." version=\"2.0\" xmlns:atom=\"http://www.w3.org/2005/Atom\">\n";
    echo "  <channel>\n";
    echo "    <title>$ATitle</title>\n";
    if (isset($ALinkToRssItself)) {
      echo "    <link>$ALinkToRssItself</link>\n";
      echo "    <atom:link href=\"$ALinkToRssItself\" rel=\"self\" type=\"application/rss+xml\" />\n";
    }
    echo "    <description>$ADescription</description>\n";
    echo "    <webMaster>$AWebMaster</webMaster>\n";
    echo "    <generator>tinyrss</generator>\n\n";
  }

  function tinyRssItem ($ATitle, $ADescription, $ALink, $ALinkComments=NULL, $AGuid=NULL, $ACategory='news', $ADate=NULL) {
    $AGuid = htmlspecialchars($AGuid);
    if (empty($AGuid))
      $AGuid = md5($ATitle.$ADescription);
    $ALink = htmlspecialchars($ALink);
    $ALinkComments = htmlspecialchars($ALinkComments);
    $ADescription = htmlspecialchars($ADescription);
    $ATitle = htmlspecialchars($ATitle);
    $ACategory = htmlspecialchars($ACategory);
    echo "    <item>\n";
    echo "      <guid>$AGuid</guid>\n";
    echo "      <title>$ATitle</title>\n";
    echo "      <link>$ALink</link>\n";
    if (!empty($ALinkComments))
      echo "      <comments>$ALinkComments</comments>\n";
    echo "      <category>$ACategory</category>\n";
    if ($ADate == 0)
      $ADate = date('r');
    echo "      <pubDate>$ADate</pubDate> \n";
    echo "      <description>$ADescription</description>\n";
    echo "    </item>\n\n";
  }

  function tinyRssFooter() {
    // end of rss file
    echo "  </channel>\n";
    echo "</".tinyRssRootNode().">\n";
  }
  
  function tinyRssDie($AMessage) {
    // terminate RSS file and stop running script, e.g. for db error or other reasons, but keeps XML valid
    tinyRssComment($AMessage);
    tinyRssEnd();
    die();
  }

?>
