<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>shkode</title>
    <link rel="icon" href="" type="image/icon type">
    <!-- reduce flashbang for some browsers -->
    <style>body { display: none; }</style>
    <script>window.onload = function() { document.body.style.display = 'block'; };</script>
</head>

<body>
    <center>
	<h1>shkode</h1>

	<div>
	    <p>Serve your current coding buffer to a live-updated webpage.</p>
	</div>
    </center>

    <?php
	function stop($msg) { echo $msg; exit(); };
	if (isset($_GET['page']) and isset($_GET['code'])) {
    	    $code = trim(base64_decode($_GET['code']));
	    $page = trim($_GET['page']);

	    /* SECURITY CHECKS */
	    if (empty($page)) {
		stop("[OOPS] Empty page.");
	    }
	    /* no "." in "page" (directory traversal) */
	    if (str_contains($page,".")) {
		stop("[OOPS] Where you goin'? Dots are not allowed in page names.");
	    }
	    /* no "null byte" in "page" */
	    if (strpos($page,"\0") !== false) {
		stop("[OOPS] GET request went to /dev/null. Using null byte?");
	    }
	    /******/

	    if (! is_dir("./@/$page")) { mkdir("./@/$page",0755,true); };
	    /* keep original code in code.txt */
    	    file_put_contents("./@/$page/code.txt", $code);
	    /* add html/css to code in code.html */
    	    $css  = "<link rel=\"stylesheet\" type=\"text/css\" href=\"../../style.css\">";
    	    $head = "<html><head>" . $css . "</head><body><pre><code>\n";
	    $foot = "\n</code></pre></body></html>";
    	    file_put_contents("./@/$page/code.html", $head . $code . $foot);
    	    if (! file_exists("./@/$page/index.html")) {
    	        $template = file_get_contents('template.html');
    	        $template = html_entity_decode($template);
    	        /*$template = str_replace("SRC", "./code.html", $template);*/
    	        file_put_contents("./@/$page/index.html", $template);
    	    };
    	};
    ?>
</body>
</html>
