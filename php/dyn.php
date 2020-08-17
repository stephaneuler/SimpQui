<?php
class Dyn {

	static function intDiv() {
		$a = random_int(9, 30);
                do {
			$b = random_int(2, 7);
		} while( $a % $b == 0 );
		return new OpenQuestion("$a / $b",  intdiv($a, $b) );
	}
	static function mod() {
		$a = random_int(12,30);
		$b = random_int(2, 7);
		return new OpenQuestion("$a % $b",  $a % $b );
	}
	static function mod10() {
		$a = random_int(1234, 2234);
		$b = 10 ** random_int(1, 3);
		return new OpenQuestion("$a % $b",  $a % $b );
	}
	static function plusplus() {
		$i = random_int(2, 5);
		$j = random_int(2, 5);
		$question = "Mit <em>i=$i;j=$j;</em> was ergibt <pre>++i * j</pre>?" ;
		$answer = ++$i * $j;
		return new OpenQuestion($question,  $answer );
	}
	static function plusplusPost() {
		$i = random_int(2, 5);
		$j = random_int(2, 5);
		$question = "Mit <em>i=$i;j=$j;</em> was ergibt <pre>i++ * j</pre>?" ;
		$answer = $i++ * $j;
		return new OpenQuestion($question,  $answer );
	}
	static function minusminus() {
		$i = random_int(2, 5);
		$j = random_int(2, 5);
		$question = "Mit <em>i=$i;j=$j;</em> was ergibt <pre>--i * j</pre>?" ;
		$answer = --$i * $j;
		return new OpenQuestion($question,  $answer );
	}
	static function minusminusPost() {
		$i = random_int(2, 5);
		$j = random_int(2, 5);
		$question = "Mit <em>i=$i;j=$j;</em> was ergibt <pre>i-- * j</pre>?" ;
		$answer = $i-- * $j;
		return new OpenQuestion($question,  $answer );
	}
	static function array1() {
                $a = [];
		$question = "int[] a= {" ;
		for( $i=0; $i<5; ++$i ) {
			$a[$i] =  random_int(2, 7);
			$question .= $a[$i] . ", ";
		}
		$i = random_int(0, 4);
		$j = random_int(0, 4);
		$answer = $a[$i] * $a[$j];
		$question .= "}; a[$i]*a[$j]";
		return new OpenQuestion("<pre>$question</pre>",  $answer );
	}
}

?>