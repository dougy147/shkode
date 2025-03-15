<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>shkode</title>
    <link rel="icon" href="./favicon.png" type="image/icon type">
    <!-- reduce flashbang for some browsers -->
    <style>body { display: none; }</style>
    <script>window.onload = function() { document.body.style.display = 'block'; };</script>
</head>

<body>
    <center>
	<h1><span style="color:grey">#!/usr/bin/env perl</span> <span style="color:yellow">shkode</span></h1>

	<div>
	    <p>Stream your code to a live-updated webpage.</p>
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

<div class="demo">
<pre><code><span style="color:grey">#!/usr/bin/env bash</span>
<span style="color:cyan">file</span><span style="color:white">=/path/to/code.py</span>
<span style="color:cyan">ur_page</span><span style="color:white">=my_own_page</span> <span style="color:grey"># make this unique</span>
<span style="color:red">while :</span><span style="color:orange">; </span><span style="color:red">do</span>
    <span style="color:cyan">encoded</span><span style="color:white">=</span><span style="color:lightgreen">$(</span><span style="color:orange">base64</span> <span style="color:lightgreen">$file</span> <span style="color:orange">-w</span> <span style="color:magenta">0</span><span style="color:lightgreen">)</span>
    <span style="color:white">curl</span> <span style="color:red">-s</span> <a style="color:white" href="https://shkode.nopub.club">https://shkode.nopub.club</a> <span style="color:red">-G</span> <span style="color:orange">--data-urlencode</span> <span style="color:orange">"</span><span style="color:yellow">code=</span><span style="color:lightgreen">$encoded</span><span style="color:orange">"</span> <span style="color:red">-d</span> <span style="color:orange">"</span><span style="color:yellow">page=</span><span style="color:lightgreen">$ur_page</span><span style="color:orange">"
    <span style="color:red">sleep</span> <span style="color:magenta">5</span>
<span style="color:red">done</span></pre></code>
</div>

</body>
</html>
