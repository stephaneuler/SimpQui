
var alles = new Array();
var colored = new Array();
var lastMax = 7;
var minSchlaege = 1;


function summe2( el, bahn ) {
  var schlaege = el.value;
  alles[bahn] = parseInt( schlaege );

  updateSum();
}

function summe( el, bahn, schlaege ) {
  var par = el.parentElement;
  if( colored[bahn] ) {
      colored[bahn].classList.remove("success");
      colored[bahn].firstChild.classList.remove("hidden");
  }
  
  par.classList.add("success");
  colored[bahn] = par;
  alles[bahn] = schlaege;

  updateSum();
}

function updateSum() {
  var total = 0;
  alles.map(function(item){
		total += item;
  });
  var count = 0;
  alles.map(function(item){
		count += item? 1 : 0;;
  });
  var el = document.getElementById("sum");
  el.innerHTML = '<strong>' + total + '</strong>';
  if( count > 0 ) {
	var av = total / count;
        el.innerHTML += ' &Oslash; ' +  av.toPrecision(2);
  }
}


function checkRoundInput( rform ) {
  test = true;
  feedback = "";

  /*if( rform.userId.value == -1 ) {
    test = false;
    feedback +=  "bitte Spieler ausw&auml;hlen \n";
  }
  if( rform.courseId.value == -1 ) {
    test = false;
    feedback +=  "bitte Anlage ausw&auml;hlen \n";
  }  */

  if( Object.keys(alles).length != 18 ) {
    test = false;
    feedback +=  "nicht nur " + Object.keys(alles).length + " Bahnen eingeben \n";
  } 

  if( ! test ) {
    //alert( HtmlDecode( feedback ) );
    $("#eingabeFehler").removeClass("hide");
    $("#eingabeFehler").children("span").text( feedback) ;
  }
  return test;

}

function checkRoundInputGast( rform ) {
    console.log("checkRoundInputGast()");
    var feedback = "Als Gast kann man das Ergebnis nicht speichern"
    $("#eingabeFehler").removeClass("hide");
    $("#eingabeFehler").children("span").text( feedback) ;
    return false;
}

function download(text, name, type) {
    var a = document.createElement("a");
    var file = new Blob([text], {type: type});
    a.href = URL.createObjectURL(file);
    a.download = name;
    a.click();
}

function saveToLocalFile() {
  var result = {
  courseName : $("#courseInput option:selected" ).text(),
  courseId   : $("#courseInput").val(),
  date : $("#datumInput").val(),
  holes : alles,
  }
  download( JSON.stringify( result, null, '\t' ), 'minigolf.txt', 'text/plain');
}

function selectAll( el, col, val ) {
  //alert( col + " " + val);
  for( i=1; i<=9; i++ ) {
    e = document.getElementById( 'bahn' + (i + col * 9) +'_' + val );
    e.click();
  }
}

function HtmlDecode(html) {
    var div = document.createElement("div");
    div.innerHTML = html;
    return div.childNodes[0].nodeValue;
}

function generateForm( maxSchlaege, anzahlBahnen ) {
  if( screen.width <= 640 ) {
    return generateFormSmall( maxSchlaege, anzahlBahnen );;
  } else {
    return generateFormLarge( maxSchlaege, anzahlBahnen );
  }
}

function generateFormSmall( maxSchlaege, anzahlBahnen ) {
  res = "";
  res += '<table class="rec" border="2">';
  for( bi=1; bi<=anzahlBahnen; ++bi ) {
    for( var bi2=bi; bi2<=bi+anzahlBahnen; bi2+=anzahlBahnen ) {
        res += '<td>' + bi2 + '</td>'
	res += '<td><input type="number"  class="form-control" min="0" max="' + maxSchlaege + '" name="bahn'+bi2+'" id="bahn' +bi2 + '" onchange="summe2(this,'+bi2+')"></td>'
	res += '</td>';
    }
    res += '</tr>'
    
  }
  res += '<tr> <td  colspan="2">Summe </td> <td id="sum" colspan="2"></td></tr>';
  res += "</table>";
  return res;
}


function generateFormLarge( maxSchlaege, anzahlBahnen ) {
  res = "";
  res += '<table class="rec" border="2">';
  res += ' <table class="table table-striped table-hover table-responsive"><thead><tr>';
    for( col=0; col<2; col++ ) {
    	res += ( '<th style="text-align:center">Bahn</th>' );
    	for( i=minSchlaege; i<=maxSchlaege; i++ ) {
      	    res += ( '<th style="text-align:center">'+i+'</th>');
      	}
    }
    res += ( '</tr></thead>' );

    res += ( '<tbody><tr>' );
    for( bi=0; bi<2; bi++ ) {
    	res += ( '<td style="text-align:center">alle</td>' );
    	for( i=minSchlaege; i<=maxSchlaege; i++ ) {
      		res += ( '<td style="text-align:center"><input type="radio" name="all" value="' + i 
			+ '" onchange="selectAll(this, '+bi+','+i+')"></td>');
      	}
     }
        
    res += ( '</tr>' );

    for( b=1; b<= 9; b++ ) {
    	res += ( '<tr>' );
        for( bi=b; bi<b+10; bi+= 9 ) {
    		res += ( '<td style="text-align:center">' + bi + '</td>' );
    		for( i=minSchlaege; i<=maxSchlaege; i++ ) {
      			res += ( '<td style="text-align:center"><input type="radio" name="bahn'+bi+'" id="bahn' +bi +'_' + i +'" value="' + i 
			+ '" onchange="summe(this, '+bi+','+i+')"></td>');
      		}
	}
        
    	res += ( '</tr>' );
    }
  res += '<tr> <td>Summe </td> <td id="sum" colspan="'+ (2*maxSchlaege+3)+ '"></td></tr>';
  res += ' </table>';
  return res;
}

function changeForm() {
  var el = document.getElementById("inputTable");
  if( lastMax == 7 ) {
    lastMax = 10;
    minSchlaege = 0;
  } else {
    lastMax = 7;
    minSchlaege = 1;
  }
  el.innerHTML = generateForm( lastMax, 18);
}
