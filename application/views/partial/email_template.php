<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional //EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width">
	<style type="text/css">
		@import url('https://fonts.googleapis.com/css?family=Lato');
		body {
			margin: 0;
			padding: 0;
			font-size: 125%;
			font-family: 'Lato', sans-serif;
		}
		table {
			border-collapse: collapse;
			table-layout: fixed;
		}
		* {
			line-height: inherit;
		}
		[x-apple-data-detectors],
		[href^="tel"],
		[href^="sms"] {
			color: inherit !important;
			text-decoration: none !important;
		}
		header, footer {
			text-align: center;
			padding: 30px 10px;
			font-size: 0.75em;
			font-weight: lighter;
			color: #999;
		}
		h1 {
			text-align: center;
		}
		section {
			max-width: 650px;
			width: 100%;
			margin: 0 auto;
			padding: 10px;
		}
	</style>
</head>
<body>
	<header><?=$email_title?></header>
	<h1><?=$email_title?></h1>
	<section><?=$content?></section>
	<footer>Arven, 2023</footer>
</body>
</html>