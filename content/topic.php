<div class="row"> 
<div class="col-md-9 ">



<?php 
$topic  = filter_var( $_REQUEST['topic'], FILTER_SANITIZE_STRING);
$t = str_replace(".top","", $topic);

echo "<h3>Fragen-Sammlungen zum Thema <em>$t</em></h3>";
echo getComments( $t, "top" );
echo "<ul>";

$sets = getSets( $topic );
foreach( $sets as $set ) {
	if( ! preg_match('/^!/', $set ) ) {
		if( preg_match('/.*:/', $set ) ) {
			$parts = explode( ":", $set );
			$name = $parts[0];
			$url  = $parts[1]; 
			echo "<li><a href='index.php?inhalt=set&set=$name&topic=$topic&name=$name'>$name</a></li>";
		} else {
			echo "<li><a href='index.php?inhalt=set&set=$set&topic=$topic'>$set</a></li>";
		}
	}
}
?>
</ul>


</div>

<div class="col-md-3 ">
</div>

</div>