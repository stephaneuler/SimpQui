<div class="row"> 
<div class="col-md-6 col-md-offset-0">

<h2>Themen</h2>

<ol>
<?php 
$topics = getTopics();

foreach( $topics as $topic ) {
	$t = str_replace(".top","", $topic);

	echo "<li><a href='index.php?inhalt=topic&topic=$topic'>$t</a> ";
	$comment = getComments( $t, "top");
	$comment =  preg_replace( "/<br>.*/", "", $comment);
	echo $comment;
	echo "</li>";
}
?>
</ol>
</div>

<div class="col-md-6 ">

</div>
</div>