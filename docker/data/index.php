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
	<h1><span style="color:grey">#!/usr/bin/env</span> <span style="color:yellow">shkode</span></h1>

	<div>
	    <p>Stream your code to a live-updated webpage.</p>

	    <?php
    	        function remove_unused($age) { /* age in minutes*/
    	            $limit = time() - ($age * 60);
    	            $dirs = array_filter(glob("./@/*"), 'is_dir');
    	            foreach ($dirs as $dir) {
    	        	if (filemtime($dir) < $limit) {
    	        	    $files = array_diff(scandir($dir), ['.','..']);
    	        	    foreach ($files as $file) { unlink("$dir/$file"); };
    	        	    rmdir($dir);
    	        	}
    	            }
    	        };
    	        function count_users($max_users) {
    	            $count = count(array_filter(glob("./@/*"), 'is_dir'));
    	            return $count;
    	        };
    	        function stop($msg) { echo $msg; exit(); };

    	        function check_queue() {
    	            remove_unused(15);
    	            $max_users = 10;
    	            $nb_users = count_users($max_users);
    	            $vacancy = $max_users - $nb_users;
    	            $s = ($vacancy > 1) ? "s" : "";
    	            echo "<div class=\"vacancy\">" .$vacancy . " spot$s left</div>";
    	            if ($max_users - $nb_users <= 0) { exit(); };
    	        };
    	        check_queue();

    	        /* if received something */
    	        if (isset($_GET['page']) and isset($_GET['code'])) {
    	            /* GRAB CODE */
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
	</div>
    </center>

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

<!--
<div class="demo">
<pre><code><span style="color:grey">#!/usr/bin/env perl</span>
<span style="color:white">wget https://shkode.nopub.club/shkode</span>
<span style="color:red">chmod</span> <span style="color:orange">+x</span> <span style="color:white">./shkode</span>
<span style="color:white">./skode</span> <span style="color:white">/path/to/code.pl</span></pre></code>
</div>
-->

</body>
</html>
