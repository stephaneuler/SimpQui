<div class="container-fluid">  


<h2><?=$menus[$content]['name']?></h2>

<?php
$file =  $content . '.php';
if(file_exists("content/" . $file) ) {
	include $file;
} else {
	include 'error/no_such_page.php';
}
?>

</div>