<div class="container-fluid margin_to_footer_content">  


<h2 style="margin-top:50px;"><?=$menus[$content]['name']?></h2>

<?php
$file =  $content . '.php';
if(file_exists("content/" . $file) ) {
	include $file;
} else {
	include 'error/no_such_page.php';
}
?>

</div>