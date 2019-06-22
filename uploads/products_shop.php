<?php
/**
 * Fichero para ejecutar e imprimir el sql a ejecutar en producción o test para crear productos.
 */
?>
<html lang="en">
<?php include_once('sections/section_head.php') ?>
<?php
$path        = 'variables/';
$defaultFile = 'variables_pt.php';

$env    = $_GET['environment'];
$file   = $_GET['filename'];
$isFile = file_exists($path . $file . '.php');

if ($isFile) {
    include_once($path . $file);
} else {
    include_once($path . $defaultFile);
}
?>
<article class="container-fluid">
	<h1>PRINTING SQL</h1>
	<div class="alert alert-info">The file being displayed is: <?php echo ($isFile) ? $file : $defaultFile ?></div>
    <?php include_once('sections/section_process_data.php'); ?>
	<pre>
<?php
print_r(utf8_encode($sql));
?>
</pre>
	<hr>
	<a href="/index.php" class="btn btn-info text-md-center">BACK</a>
	<hr>
</article>
</html>
