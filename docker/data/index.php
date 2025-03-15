<!DOCTYPE html>
<html>

<head>
    <!--<meta charset="UTF-8">-->
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>shkode</title>
    <link rel="icon" href="" type="image/icon type">
</head>

<body>
    <!--
    <noscript>
      <style>html{display:none;}</style>
      <meta http-equiv="refresh" content="0.0;url=./index.html">
    </noscript>
    -->
    <?php
        //if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //    $data = $_POST['data'];
        //    echo 'Received data: ' . htmlspecialchars($data);
	//};
	if ($_SERVER["REQUEST_METHOD"] == "GET") {
	    if (isset($_GET['page']) and isset($_GET['code'])) {
		//ob_start();
		$code = $_GET['code'];
		//$code = str_replace(' ', '', $code);
		$code = base64_decode($code);
		//$code = mb_convert_encoding($code, 'UTF-8', 'auto');
		$page = $_GET['page'];
		if (! is_dir("./@/$page")) {
		    mkdir("./@/$page",0755,true);
		};
		file_put_contents("./@/$page/code.txt", $code);
		if (! file_exists("./@/$page/index.html")) {
		    $template = file_get_contents('template.html');
		    $template = html_entity_decode($template);
		    //$template = str_replace("SRC", "./code.txt", $template);
		    file_put_contents("./@/$page/index.html", $template);
		};
		//ob_end_flush();
		////echo '<form action="post_handler.php" method="post">
		////    <input type="hidden" name="data" value="some_value">
		////    <input type="submit" value="Submit">
		////    </form>';
	    };
	};
    ?>
</body>
</html>
