<?php

error_reporting( -1 );
ini_set( 'display_errors', 1 );

require_once(__dir__."/parsedown.php");

$ZEN_readme_path = dirname(__FILE__)."/../lepton_2/upload/templates/zenlike_2/README.md";

# Read file and pass content through the Markdown parser
$text = file_get_contents( $ZEN_readme_path );

$Parsedown = new Parsedown();

$html = $Parsedown->text($text);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>PHP Markdown Lib - Readme</title>
    
     
        <link href='http://fonts.googleapis.com/css?family=Ubuntu|Roboto+Mono:400,400italic,300,300italic' rel='stylesheet' type='text/css'>
    	<link href="http://parsedown.org/reset.css" rel="stylesheet" type="text/css" />
        <link href="http://parsedown.org/main.css" rel="stylesheet" type="text/css" />
   
    		<script src="http://parsedown.org/keymaster/keymaster.min.js" type="text/javascript"></script>
        <script src="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.js" type="text/javascript"></script>
        <script src="http://code.jquery.com/jquery-2.0.3.min.js" type="text/javascript"></script>
        
    
    
    <style type="text/css">

    textarea {
        -moz-box-sizing: border-box;
        -webkit-font-smoothing: subpixel-antialiased;
        -webkit-box-sizing: border-box;
        background: #fff;
        border: none;
        box-sizing: border-box;
        color: #333;
        font-family: monospace;
        font-size: 16px;
        height: 100%;
        line-height: 28px;
        margin: 0;
        padding: 20px;
        resize: none;
        vertical-align: top;
        width: 100%;
    }

    textarea:focus {
        outline: none;
    }

    button {
        background: #fff;
        border: none;
        color: #379;
        cursor: pointer;
        line-height: 24px;
        text-align: left;
        padding: 20px;
        width: 100%;
    }

    div.title {
        background: #222;
        color: #777;
        padding: 20px;
        position: absolute;
    }

    div.title strong {
        color: #fff;
        font-weight: normal;
    }

    div.output {
        background: #222;
        bottom: 289px;
        color: #fff;
        overflow: auto;
        padding: 20px;
/*        position: absolute;
        top: 128px;
*/    }

    div.time {
        background: #222;
        bottom: 225px;
        color: #777;
        position: absolute;
        padding: 20px;
    }

    div.time strong {
        color: #fff;
        font-weight: normal;
    }

    div.output-source {
        background: #222;
        bottom: 0;
        height: 185px;
        overflow: auto;
        padding: 20px;
        position: absolute;
    }


</style>

</head>
    <body>
<div class="output"
		<?php
			# Put HTML content in the document
			echo $html;
		?>
</div>
    </body>
</html>
