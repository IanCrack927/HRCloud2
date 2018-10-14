<!doctype html>
<?php
/*//
HRCLOUD2-PLUGIN-START
App Name: JSPaint
App Version: v1.0 (10-14-2018 00:00)
App License: GPLv3
App Author: Isaiah Odhner (1j01)
App Description: A simple HRCloud2 App for creating and editing pictures.
App Integration: 0 (False)
App Permission: 1 (Everyone)
App Website: https://github.com/1j01/jspaint
HRCLOUD2-PLUGIN-END
//*/
?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Paint</title>
		<link href="styles/normalize.css" rel="stylesheet" type="text/css">
		<link href="styles/layout.css" rel="stylesheet" type="text/css">
		<link href="styles/print.css" rel="stylesheet" type="text/css" media="print">
		<link rel="icon" href="images/icons/16.png" sizes="16x16" type="image/png">
		<link rel="icon" href="images/icons/32.png" sizes="32x32" type="image/png">
		<link rel="icon" href="images/icons/48.png" sizes="48x48" type="image/png">
		<link rel="icon" href="images/icons/128.png" sizes="128x128" type="image/png">
		<link rel="icon" href="images/icons/windows.ico" sizes="16x16 32x32 48x48" type="image/icon">
		<meta name="viewport" content="width=device-width, user-scalable=no">
		<meta name="description" content="MS Paint recreated in JavaScript, with extra features" />
		<meta property="og:title" content="JS Paint" />
		<meta property="og:description" content="MS Paint recreated in JavaScript, with extra features" />
		<meta property="og:type" content="website" />
		<meta property="og:url" content="https://jspaint.app" />
		<meta property="og:locale" content="en_US" />
		<meta property="og:image" content="https://jspaint.app/images/meta/facebook-card.png" />
		<meta name="twitter:title" content="JS Paint">
		<meta name="twitter:description" content="MS Paint recreated in JavaScript, with extra features">
		<meta name="twitter:image" content="https://jspaint.app/images/meta/twitter-card.png">
		<meta name="twitter:card" content="summary_large_image">
		<meta name="twitter:site" content="@isaiahodhner">
		<meta name="twitter:creator" content="@isaiahodhner">

		<script type="text/javascript">
			// Partial support for IE with a general polyfill
			if(/MSIE \d|Trident.*rv:/.test(navigator.userAgent)){
				document.write('<script src="https://cdn.polyfill.io/v2/polyfill.min.js"><\/script>');
				
				// document.write('<script src="https://cdnjs.cloudflare.com/ajax/libs/fetch/2.0.4/fetch.min.js"><\/script>');
				// this polyfill doesn't support base64 data URIs, leading to a confusing error message when loading the document from localStorage
				// we shouldn't really be storing images as data URIs tho (ideally)
				
				document.write('<style>.help-window iframe { height: 100% } .horizontal { flex-shrink: 0; flex-grow: 1; flex-basis: 0; } </style>');
				
				var last_error_message_time = +new Date;
				var error_message_debounce_ms = 200;
				window.onerror = function(){
					var current_time = +new Date;
					if(!last_error_message_time || (current_time > last_error_message_time + error_message_debounce_ms)){
						alert("Internet Explorer is not supported!");
						last_error_message_time = +new Date;
					}
				};
			}
		</script>
		<script src="src/theme.js"></script>
	</head>
	<body>
		<div id="about-paint" style="display: none">
			<h1><img src='images/icons/32.png'/> JS Paint <small class='version-number' title='Is that a thing? What I mean is, expect bugs!'>Public Alpha</small><hr/></h1>
			<p>JS Paint is a web-based remake of MS Paint by <a href='https://isaiahodhner.ml/'>Isaiah Odhner</a>.</p>
			<p>Read about the project and <b>extra features</b> on <a href='https://github.com/1j01/jspaint#readme'>the README</a>.</p>
			<p>Request features and report bugs <a href='https://github.com/1j01/jspaint/issues'>on GitHub</a>
			or <a href='mailto:isaiahodhner@gmail.com?subject=JS%20Paint'>by email</a>.</p>
			<p>If you want to support development and keep the site running,<br>
			you can send me some cash via PayPal:</p>
			<form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
				<input type="hidden" name="cmd" value="_s-xclick">
				<input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----">
				<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
				<!--<img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">-->
			</form>
		</div>
		<script src="lib/jquery.min.js"></script>
		<script src="lib/pep.js"></script>
		<script src="lib/canvas.toBlob.js"></script>
		<script src="lib/gif.js/gif.js"></script>
		<script src="lib/palette.js"></script>
		<script src="lib/FileSaver.js"></script>
		<script src="lib/font-detective.js"></script>
		<script src="./lib/libtess.min.js"></script>
		<script src="src/helpers.js"></script>
		<script src="src/storage.js"></script>
		<script src="src/$Component.js"></script>
		<script src="src/$Window.js"></script>
		<script src="src/$MenuBar.js"></script>
		<script src="src/$ToolBox.js"></script>
		<script src="src/$ColorBox.js"></script>
		<script src="src/$FontBox.js"></script>
		<script src="src/$Handles.js"></script>
		<script src="src/OnCanvasObject.js"></script>
		<script src="src/Selection.js"></script>
		<script src="src/TextBox.js"></script>
		<script src="src/image-manipulation.js"></script>
		<script src="src/tool-options.js"></script>
		<script src="src/tools.js"></script>
		<!--<script src="src/extra-tools.js"></script>-->
		<script src="src/functions.js"></script>
		<script src="src/manage-storage.js"></script>
		<script src="src/imgur.js"></script>
		<script src="src/help.js"></script>
		<script src="src/app.js"></script>
		<script src="src/menus.js"></script>
		<script src="src/canvas-change.js"></script>
		<script src="src/sessions.js"></script>
		<script src="lib/konami.js"></script>
		<script src="src/vaporwave-fun.js"></script>
	</body>
</html>
