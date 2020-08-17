<div class="row"> 
<div class="col-md-9 ">



<?php 
$set       = filter_var( $_REQUEST['set'], FILTER_SANITIZE_STRING);
$topic     = filter_var( $_REQUEST['topic'], FILTER_SANITIZE_STRING);
$topicName = str_replace(".top","", $topic);

if( isset( $_REQUEST['name'] ) ) {
	$setName = filter_var( $_REQUEST['name'], FILTER_SANITIZE_STRING);
	$set = getBuild( $topic, $setName );
} else {
	$setName = $set;
}

echo "<h3>Fragen in der Einheit <em>$setName</em>, Thema <a href='index.php?inhalt=topic&topic=$topic'>$topicName</a> </h3>";

$parts =  explode( "|", $set );
$set = trim( $parts[0] );
echo '<div>' . getComments( $set ) . '</div>';

$questions = getAllQuestions( $set );

for( $i=1; $i<count( $parts ); ++$i ) {
	$command = trim( $parts[$i] );
	//echo "command: $command <br>";
	if( $command == "random" ) {
		shuffle( $questions );
	} else if( preg_match( "/head ([0-9]+)/", $command, $matches ) ) {
		$questions = array_slice(  $questions, 0, intval( $matches[1]) );
	} else if( preg_match( "/add (.+)/", $command, $matches ) ) {
		$questions = array_merge( $questions, getAllQuestions( $matches[1] ) );
        }
}

for( $i=1; $i<=count($questions ); ++$i ) {
	echo "<button type='button' id='$i' class='qButton btn btn-secondary' title='Frage $i'>$i</button> ";
}
echo "<h4 id='qCounter'>Bitte eine Frage ausw&auml;hlen</h4>";

$c = 1;
foreach( $questions as $q )  {
	echo "<div id='div$c' class='questions hidden'>" . $q->print() . " </div>";
	echo "<div id='sol$c' class='hidden'>" . $q->answer . " </div>";
	++$c;
}
?>


</div>

<div class="col-md-3 ">
</div>
</div>
<div id="statusCounter">Bisher 0 Fragen beantwortet</div>

<script>
$(document).ready(function() {
	$( ".qButton" ).click(function( event ) {
  		//alert( "Handler for .click() called." + event.target.id );
		id = event.target.id
		sel = "#div" + id;
		$(".questions").addClass("hidden")
		$(sel).removeClass("hidden")
		$("#qCounter").text("Frage " + id )
		questionId = id - 1
	});
	$( ".yesNo" ).click(function( event ) {
  		id = getId( event )
		v1 =  JSON.parse( $("#sol"+id).html() )
		v2 =  JSON.parse( event.target.value )
		changeButton( v1 == v2, id )
	});
	$( ".multiOpts" ).click(function( event ) {
		test = true;
  		id = getId( event )
		v1 =  $("#sol"+id).html() 
		okays = v1.split( "," ).map(item => item.trim())
		boxes = $(event.target).parent().find( ".form-check-input" )
		for( box of boxes ) {
			if( box.checked !=  okays.includes( box.value ) ) {
				test = false;
 			} 
		}
		changeButton( test, id )
	});
	$('.openField, .optionsSelector').on('change', function () {
 		id = getId( event )
		v1 =  $("#sol"+id).text().trim()
		v2 =  event.target.value.trim()
		//console.log( "<" +v1 + "> == <" + v2  +">");
		changeButton( v1 == v2, id )
	});
	$('.regOpenField' ).on('change', function () {
 		id = getId( event )
		v1 =  $("#sol"+id).text().trim()
		var re = new RegExp(v1)
		v2 =  event.target.value.trim()
		//console.log( "<" +v1 + "> == <" + v2  +">");
		changeButton( re.test( v2 ), id )
	});
	$('.orderField' ).on('change', function () {
 		id = getId( event )
		v1 =  $("#sol"+id).text().trim()
		v2 =  event.target.value.trim()
		v2 = v2.toUpperCase()
		v2 = v2.replace( /[^A-H]/g, "")
		//console.log( "<" +v1 + "> == <" + v2  +">");
		changeButton( v1 == v2, id )
	});
	
});

function changeButton( state, id ) {
	++nAnswers
	if( state ) {
		$("#"+id).css("background-color", "green");
		$("#"+id).html("&#128516;");
		++nCorrect
	} else {
		$("#"+id).css("background-color", "red");
		$("#"+id).html( id );
	}
	proz = Math.round( 100 * nCorrect / nAnswers )
	$("#statusCounter").html( "Antworten: "  + nAnswers + ", Richtig: " + nCorrect + " (" + proz + "%)");

	var topic  = <?php echo "'$topicName'"; ?>;
	var set    = <?php echo "'$set'"; ?>;
	$.get("api.php", 
	{action:"protocol", result:state, set:set, topic:topic, questionId:questionId }, function(data){
  		//alert("Data: " + data);
 	});

}

function getId( event ) {
	list = $( event.target ).parents()
  			.filter(function() {
    			return this.id.startsWith( "div" );
  	});
	return list[0].id.substr(3).trim()
}
</script>