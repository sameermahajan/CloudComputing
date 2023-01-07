<html>
<head>
<script>
function showRSS(str) {
  if (str.length==0) {
    document.getElementById("rssOutput").innerHTML="";
    return;
  }
  if (window.XMLHttpRequest) {
  //code for IE7+, Firefox, Chrome, Opera, Safari 
  xmlhttp=new XMLHttpRequest();
  } else { 
  // code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
  xmlhttp.onreadystatechange=function() {
   if (this.readyState==4 && this.status==200) {
     document.getElementById("rssOutput").innerHTML=this.responseText;
    }
   }
   xmlhttp.open("GET","webfeed.php?q="+str,true);
  xmlhttp.send();
  }
</script>
</head>
<body>

<form>
<select onchange="showRSS(this.value)">
<option value="">Select an RSS-feed:</option>
<option value="Google">Google News</option>
<option value="ZDN">ZDNet News</option>
</select>
</form>
<br>
<div id="rssOutput">RSS-feed will be listed here...</div>

<?php
//get the q parameter from URL
$q=$_GET["q"];
//find out which feed was selected
if($q=="Google") {
$xml=("http://news.google.com/news?ned=us&topic=h&output=rss");
} elseif($q=="ZDN") {
$xml=("https://www.zdnet.com/news/rss.xml");
}

$xmlDoc = new DOMDocument();
$xmlDoc->load($xml);

//get elements from "<channel>"
$channel=$xmlDoc->getElementsByTagName('channel')->item(0);
$channel_title = $channel->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
$channel_link = $channel->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
$channel_desc = $channel->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;

//output elements from "<channel>"
echo("<p><a href='" . $channel_link
. "'>" . $channel_title . "</a>");
echo("<br>");
echo($channel_desc . "</p>");

//get and output "<item>" elements
$x=$xmlDoc->getElementsByTagName('item');
for ($i=0; $i<=2; $i++) {
$item_title=$x->item($i)->getElementsByTagName('title')->item(0)->childNodes->item(0)->nodeValue;
$item_link=$x->item($i)->getElementsByTagName('link')->item(0)->childNodes->item(0)->nodeValue;
$item_desc=$x->item($i)->getElementsByTagName('description')->item(0)->childNodes->item(0)->nodeValue;
echo ("<p><a href='" . $item_link . "'>" . $item_title . "</a>");
echo ("<br>");
echo ($item_desc . "</p>");
}
?>
</body>
</html>