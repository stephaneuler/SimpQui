<div class="container-fluid" style="margin-top:30px; margin-right:50px">  
<h2>Letzte &Auml;nderungen</h2>
<?php
$files = glob('topics/*.txt');
usort($files, function($a, $b) {
    return filemtime($a) < filemtime($b);
});
echo '<table class="table table-hover" style="margin-bottom:200px;">';
for( $i=0; $i<6 & $i < count( $files ); $i++ ) {
	$t = str_replace(".txt","", $files[$i]);
	$t = str_replace("topics/","", $t);
	$time = date('F d, H:i',filemtime($files[$i]));
	echo  "<tr><td><a href='index.php?inhalt=set&set=$t''>$t</a> </td><td> $time </td></tr>";
}
echo "</table>";
?>
</div>
