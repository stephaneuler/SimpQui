<h3>Stand <?php echo date("d.m.Y - H:i",time() ) . ' Uhr';?> </h3>
<div class='margin_to_footer_content'>
	<?php
	$lines = getProtocol();
	$correct = 0;
	foreach( $lines as $line ) {
		$parts = explode( "#", $line );
		$result = trim( end( $parts ) );
		if( $result == "true" ) {
			++$correct;
		}
	}

	$anz = count( $lines );
	$proz = round( 100 * $correct / $anz );

	echo "Bisher insgesamt $anz Versuche, davon $correct richtige Antworten ($proz%)<br>";
	echo "Die letzten 10:";
	echo "<pre>";
	for( $i=1; $i<=12 & $anz >= $i; ++$i ) { 
		//echo html_entity_decode( htmlentities( $lines[$anz - $i] ) );
		echo htmlentities( $lines[$anz - $i]  );
	}
	echo "</pre>";

	?>
</div>