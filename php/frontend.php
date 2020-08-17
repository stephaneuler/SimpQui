<?php 
function getYesNoButton( ) {
	$text = '<div><div class="btn-group" role="group">';
	$text .= '<button type="radio" class="yesNo btn btn-secondary" value="true">Ja</button>' ;
	$text .= '<button type="radio" class="yesNo btn btn-secondary" value="false">Nein</button>';
	$text .= '</div></div>';
	return $text;
}
function getOpenField(  ) {
	$text = '<div><input type="text" class="openField form-control-plaintext" title="Antwort - Gro&szlig;- und Kleinschreibung beachten"></div>' ;
	return $text;
}

function getRegOpenField(  ) {
	$text = '<div><input type="text" class="regOpenField form-control-plaintext" title="Antwort - Gro&szlig;- und Kleinschreibung beachten"></div>' ;
	return $text;
}

function getCorrectField( $q ) {
	$text = '<div><input type="text" class="openField form-control-plaintext" style="width:400px;" title="Bitte korrigieren" value="'. $q .'"></div>' ;
	return $text;
}

function getPre( $lines ) {
	$text = "<div><pre>$lines</pre></div>";
	return $text;
}

function getOptionsSelector( $options  ) {
	$text = '<select class="form-control optionsSelector selectpicker">';
	$text .= '<option disabled="disabled" selected="selected">Bitte ausw&auml;hlen</option>';
	for( $i=0; $i<count( $options ); ++$i ) {
		$text .= "<option value='$i'>" . $options[$i] . "</option>";
	}
	$text .= '</select>';
	return $text;
}
function getMultiOptions( $options  ) {
	$text = "";
	for( $i=0; $i<count( $options ); ++$i ) {
		$text .= '<div class="form-check">';
		$text .= '<label class="form-check-label">';
		$text .= "<input type='checkbox' class='form-check-input' value='$i'> " . $options[$i] . "</label></div>";
	}
	$text .=  '<button class="multiOpts btn btn-secondary">Okay</button>' ;
	return $text;
}
function getOrderSelector( $options  ) {
	$text = '<ol type="A">';
	for( $i=0; $i<count( $options ); ++$i ) {
		$text .= "<li>" . $options[$i] . "</li>";
	}
	$text .=  '</ol>' ;
	$text .= '<div><input type="text" class="orderField form-control-plaintext" title="Antwort in der Form ABCD"></div>' ;
	return $text;
}
?>
