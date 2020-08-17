<?php 
$basePath = "topics";


function getTopics( ) {
	global $basePath;
	$files = glob($basePath . '/*.top' );
	return array_map('basename', $files);
}

function getGroups( $task ) {
	global $basePath;
	$dirs = glob("$basePath/$task" . '/*' , GLOB_ONLYDIR);
	return array_map('basename', $dirs);
}

function getSets( $topic ) {
	global $basePath;
	return file("$basePath/$topic", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
}

function getBuild( $topic, $setName ) {
	global $basePath;
	$lines =  file("$basePath/$topic", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	foreach( $lines as $line ) {
		if( preg_match("/^$setName/", $line ) ) {
			$parts = explode( ":", $line );
			return $parts[1]; 
		}
	}
}

function getAllQuestions( $set ) {
	$questions = array_filter( getQuestions( $set ), function($q) {
    				return $q->question != "-";
  		} );
	$questions = array_merge( $questions, getMultiLineQuestions( $set ) );
	return $questions;
}

function getQuestions( $set ) {
	global $basePath;
	$lines =  file("$basePath/$set.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	return array_map('parseLine', $lines);
}

function getMultiLineQuestions( $set ) {
	global $basePath;
	$questions = [];
	$lines =  file("$basePath/$set.txt", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	for( $i=0; $i<count($lines); ++$i ) {
		$q = [];
		if( preg_match('/^<</', $lines[$i] ) ) {
			while( ! preg_match('/^#/', $lines[++$i] ) ) {
				$q[] = htmlentities( $lines[$i] );
			}
			$a = $lines[++$i];
			$questions[] = new MultiLineQuestion( implode("\n", $q), $a );
		}
	}
	
	return $questions;
}

function getComments( $set, $ext = "txt" ) {
	global $basePath;
	$lines =  file("$basePath/$set.$ext", FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
	$comments =  "";
	foreach( $lines as $line ) {
		if( preg_match('/^!/', $line ) ) {
			$comments .= substr($line,1 ) . " ";
		}
	}
	return $comments;
}

function getSolutions( $task, $group ) {
	global $basePath;
	$dirs = glob("$basePath/$task/$group" . '/*.xml' );
	return array_map('basename', $dirs);
}

function saveTry( $topic, $set, $questionId, $result ) {
	$file = 'protocol/protocol.txt';
	$questions = getAllQuestions( $set );
	$qtext = $questions[$questionId]->getQuestionInfo();
	$current = date("Y-m-d:H:i:sa") . "#$topic#$set#$qtext#$result\n";
	return file_put_contents($file, $current, FILE_APPEND | LOCK_EX);
}

function getProtocol() {
	$file = 'protocol/protocol.txt';
	return file($file,  FILE_SKIP_EMPTY_LINES);
}
?>
