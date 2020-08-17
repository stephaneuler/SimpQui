<?php 

include_once "php/lib.php";
include_once "php/questions.php";
include_once "php/dyn.php";
include_once "php/frontend.php";

session_start(); 
if( ! isset(  $_SESSION['loggedin'] ) ) {
	 $_SESSION['loggedin'] = false;
} 

$menus = array();
$menus['home']       = array( 'file' => './content/template.php', 'name' => 'START', 'nav' => 'main'   );
$menus['statistic']  = array( 'file' => './content/template.php', 'name' => 'STATISTIK', 'nav' => 'main'   );

$menus['help']       = array( 'name' => 'HILFE', 'dropdown' => 'help', 'nav' => 'main'  );
$menus['info']       = array( 'file' => './content/template.php', 'name' => 'HILFE',    'type' => 'help'  );
$menus['questions']  = array( 'file' => './content/template.php', 'name' => 'FRAGEN',    'type' => 'help'  );
$menus['about']      = array( 'file' => './content/template.php', 'name' => '&Uuml;BER', 'type' => 'help'  );
$menus['impressum']       = array( 'file' => './content/template.php', 'name' => 'IMPRESSUM', 'hide' => true    );

$menus['topic']      = array( 'file' => './content/template.php', 'name' => 'Thema', 'hide' => true    );
$menus['set']        = array( 'file' => './content/template.php', 'name' => 'Sammlung', 'hide' => true    );


if( isset(  $_REQUEST['inhalt'] ) ) {
    $content = $_REQUEST['inhalt'];
} else {
    $content = "home";
} 


?>

<!DOCTYPE html>
<html lang="de">
<head>

  <title>Quiz <?= ucfirst( $content ) ?> </title>
  <LINK REL="SHORTCUT ICON" HREF="images/icon_32.ico">
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

  <link href="css/gallery.css" rel="stylesheet" type="text/css">
  <script src="js/bib.js"></script>


</head>
<body>

   <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
       <img class="img-responsive img-fluid navbar-brand" src="images/bos.jpg" alt="Logo" style="height: 50px">';
       <div class="container">
          <div class="navbar-header">
           <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
           </button>
      </div>
    <div class="collapse navbar-collapse" id="myNavbar" style="width: 100%">
	<ul class="nav navbar-nav navbar-left">
	<?php
		foreach( $menus as $key=>$menu ) {
			if( ! (isset( $menu['hide'] )) && (isset( $menu['nav'] )) &&($menu['nav'] == 'main')) {
 				if(isset( $menu['dropdown'] )){
					echo '<li class="dropdown">';
					echo '<a class="dropdown-toggle" data-toggle="dropdown" href="">' . $menu['name'] . ' <span class="caret"></span></a>';
					echo '<ul class="dropdown-menu">';
					foreach( $menus as $key=>$eintrag ) {
						if(!(isset( $eintrag['hide'])) && (isset( $eintrag['type'] )) && ($eintrag['type'] == $menu['dropdown'])){
							if( isset( $eintrag['divider']) ) {
								echo '<li role="presentation" class="divider"></li>';
							} else {
								echo '<li><a href="index.php?inhalt=' . $key . '">' . $eintrag['name'] . '</a></li>';
							}
						}
					}
					echo '</ul>';
					echo '</li>';
				}else{
					echo '<li><a href="index.php?inhalt=' . $key . '">' . $menu['name'] . '</a></li>';
				}
			}
		}
		?>
		</ul>


	</div>
  </div>

</nav>

<div class="row">

<div id="Inhalt" class="col-md-8 col-md-offset-1" style="padding-bottom:75px;">
<!-- Container Content -->
<?php
if(file_exists($menus[$content]['file'])) {
	include $menus[$content]['file'];
} else {
	include 'content/error/no_such_page.php';
}
?>
</div>
<div id="Inhalt" class="col-md-3" style="padding-bottom:75px;">
<?php
include 'content/neu.php';
?>
</div>
</div>


<footer class="container-fluid text-center no-padding">
  <a href="#home" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
  <p>Ein Projekt der Web&amp;Mobile Gruppe der Fachbereiche IEM/MND 
  | <a href="https://www.thm.de/site/impressum.html" title="Impressum">Impressum</a>
  | <a href="https://www.thm.de/site/datenschutz.html" title="Datenschutz">Datenschutz</a>
  </p>
</footer>

<script>
$(document).ready(function(){
	nAnswers = 0;
	nCorrect   = 0;

  // Add smooth scrolling to all links in navbar + footer link
  $(".nav-tabs li,.navbar a, footer a[href='#home']").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
  
  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });


});
</script>


</body>
</html>
