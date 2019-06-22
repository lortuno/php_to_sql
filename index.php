<html lang="en">
<?php include_once ('uploads/sections/section_head.php')?>
<article class="container">
	<h1 class="text-info text-md-left">Get SQL Script to execute</h1>
	<p>The main purpose of this page is loading a file with the variables to process, send them to the file that has the SQL structure and generate
	a SQL script to upload or modify the database in a simple way, avoiding mechanical tasks.</p>
	<p>Of course, the best way to do this is having a database manager, but this script allows to modify data in a quick manner.</p>
	<section>
		<h2>Choose your options</h2>
		<form action="/uploads/products_shop.php" method="get">
			<div class="form-row">
				<div class="form-group col-md-6">
					<label for="file1"><strong>Introduce File name with variables to load</strong></label>
					<input type="text" name="filename" class="form-control" id="file1" placeholder="file">
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-xs-12">
					<p><strong>Environment</strong></p>
					<p>There might be changes between databases</p>
				</div>
			</div>
			<div class="form-row">
				<div class="form-group col-md-6">
					<button type="submit" name="environment" value="dev" class="btn btn-success btn-lg">DEV (test)</button>
				</div>
				<div class="form-group col-md-6">
					<button type="submit" name="environment" value="prod" class="btn btn-info btn-lg">PROD</button>
				</div>
			</div>
		</form>
	</section>
</article>
</html>

