<?php defined('BASEPATH') OR exit('No direct script access allowed') ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?= APP_NAME ?> | UnAuthorized Access</title>
		<link href="https://fonts.googleapis.com/css?family=Montserrat:400" rel="stylesheet">
		<link href="https://fonts.googleapis.com/css?family=Chango" rel="stylesheet">
		<?= link_tag('assets/dist/css/error.css','stylesheet','text/css') ?>
	</head>
	<body>
		<div id="notfound">
			<div class="notfound">
				<div>
					<div class="notfound-404">
						<h1>!</h1>
					</div>
					<h2>not<br>authorized</h2>
				</div>
				<p>You are not authorized to view this page.
					<?= anchor('', 'Back to homepage') ?>
				</p>
			</div>
		</div>
	</body>
</html>