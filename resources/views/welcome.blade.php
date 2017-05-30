<?php
/*
        $url = "http://www.dr.dk/";
        if(isset($_GET["url"]) && !empty($_GET["url"])) {
            $url = $_GET["url"];
        }
        if (!starts_with($url,"http")) {
            $url = "http://".$url;
        }




	$apiUrl = "https://gsnedders.html5.org/outliner/process.py?url=" . urlencode($url);
	$result = getFile($apiUrl);
	//$html = mb_strtolower($result);
	$result = str_ireplace("</style>","</style></head><body>",$result);
	$result = str_ireplace("<!doctype html>","<!doctype html><html><head>",$result);
	$result .= "</body></html>";
	var_dump($result); //die();
    $dom = new \Htmldom();
    $dom->load($result);
    var_dump($dom->find("ol"));
    //var_dump($dom->find("title"));//die();
	die();
*/
	?>
<!DOCTYPE html>
<html>
    <head>
        <title>Laravel</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
		<link rel="stylesheet" href="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
		<script src="//cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
        <style>
            html, body {
                height: 100%;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                display: table;
                font-weight: 100;
                font-family: 'Lato';
                text-align: center;
 			    counter-reset: errors;
 			    counter-reset: warnings;
           }


            .title {
                font-size: 96px;
            }
            li {
            	list-style: none;
            }
            .error-msg {
            	display: block; 
            	font-size: 1em;
 			    font-weight: normal;
			    margin-top: 1rem;
			    counter-increment: errors;
			    color: #FFABAB;
            }
			.error-msg:before {
				content: counter(errors) ") ";
			}
           .error-extract {
            	display: block; 
            	font-size: 1em; 
            	font-weight: normal;
            	font-style: normal;
            }

            .warning-msg {
            	display: block; 
            	font-size: 1em;
 			    font-weight: normal;
			    margin-top: 1rem;
			    counter-increment: warnings;
			    color: #F7F794;
            }
			.warning-msg:before {
				content: counter(warnings) ") ";
			}
           .warning-extract {
            	display: block; 
            	font-size: 1em; 
            	font-weight: normal;
            	font-style: normal;
            }

			#html-validator {
			    background-color: #695074;
			    color: white;
			    text-align: left;
			    padding: 1% 5% 5% 5%;
			}






.ct-series-a .ct-slice-pie {
  /* fill of the pie slieces */
  fill: #FF5365;
  /* give your pie slices some outline or separate them visually by using the background color here */
  stroke: white;
  /* outline width */
  stroke-width: 4px;
}
.ct-series-b .ct-slice-pie {
  /* fill of the pie slieces */
  fill: #62B783;
  /* give your pie slices some outline or separate them visually by using the background color here */
  stroke: white;
  /* outline width */
  stroke-width: 4px;
}
text.ct-label {
    fill: #000;
    color: #000;
    font-size: 2em;
}
figure.ct-chart.ct-perfect-fourth {
    max-width: 700px;
}
        </style>
    </head>
    <body>
                <p style="color:red;">The idea is to make fun of websites that use div tags.
                </p>


<?php



		// Super mange valideringsfejl: http://english.cntv.cn/program/bizasia/20100826/100970.shtml

        $url = "http://www.dr.dk/";
        if(isset($_GET["url"]) && !empty($_GET["url"])) {
            $url = $_GET["url"];
        }
        if (!starts_with($url,"http")) {
            $url = "http://".$url;
        }
 

 //echo "<textarea>";



        $options = array(
            'follow_redirects'  => true,
            'verify'            => false,
            'nobody'            => false,
            'redirects'         => 10,
            'timeout'           => 30,
            'CURLOPT_ENCODING'  => "UTF-8"
        );
        try{
            $response = \Requests::get($url,array(),$options);

            \Debugbar::addMessage("Checking URL: ".$url,"Requests");
            //var_dump($response->status_code);
            \Debugbar::addMessage("Response","Requests");
            \Debugbar::addMessage($response,"Requests");
            //var_dump($response->redirects);
            if($response->success) {
                \Debugbar::addMessage("Url successfully responded","Requests");
            } else {
                throw new \Requests_Exception_HTTP('HTTP not successful response: '.$response->status_code,$response);
            }
            \Debugbar::addMessage("Status Code: ".$response->status_code,"Requests");
            if($response->redirects>0){
                \Debugbar::addMessage("URL REDIRECT: ".$response->url,"Requests");
            }
            \Debugbar::addMessage($response,"Requests"); // log object
        }
        catch(\Requests_Exception_HTTP $e) {
            \Debugbar::addException($e);
            \Debugbar::error($e->getMessage());
        }



//var_dump($response->body); die();


        
        $html = str_ireplace("<!--[if","",mb_strtolower($response->body));
        $dom = new \Htmldom($html);
        //var_dump($dom->find("[id]"));die();
		$doctypes = array(
	        array(
	            "name" => "HTML 4.01 Strict",
	            "identifier" => "/html4/strict.dtd"
	        ),
	        array(
	            "name" => "HTML 4.01 Transitional",
	            "identifier" => "/html4/loose.dtd"
	        ),
	        array(
	            "name" => "HTML 4.01 Frameset",
	            "identifier" => "/html4/frameset.dtd"
	        ),
	        array(
	            "name" => "XHTML 1.0 Strict",
	            "identifier" => "/xhtml1/DTD/xhtml1-strict.dtd"
	        ),
	        array(
	            "name" => "XHTML 1.0 Transitional",
	            "identifier" => "/xhtml1/DTD/xhtml1-transitional.dtd"
	        ),
	        array(
	            "name" => "XHTML 1.0 Frameset",
	            "identifier" => "/xhtml1/DTD/xhtml1-frameset.dtd"
	        ),
	        array(
	            "name" => "XHTML 1.1",
	            "identifier" => "/xhtml11/DTD/xhtml11.dtd"
	        ),
	        array(
	            "name" => "XHTML Basic 1.1",
	            "identifier" => "/xhtml-basic/xhtml-basic11.dtd"
	        ),
	        array(
	            "name" => "HTML 5",
	            "identifier" => "<!doctype html>"
	        ),
	        array(
	            "name" => "HTML 2.0",
	            "identifier" => "IETF//DTD HTML 2.0//EN"
	        ),
	        array(
	            "name" => "HTML 3.2",
	            "identifier" => "W3C//DTD HTML 3.2 Final//EN"
	        ),
	        array(
	            "name" => "XHTML Basic 1.0",
	            "identifier" => "TR/xhtml-basic/xhtml-basic10.dtd"
	        )
        );
		function compare($str1,$str2){
		    $str1 = mb_strtolower($str1,'UTF-8');
		    $str2 = mb_strtolower($str2,'UTF-8');
		    if(stripos($str1,$str2)!== false) {
		        return true;
		    } else {
		        return false;
		    }
		}
		$doctype = null;
		foreach($doctypes as $dt) {
            if(compare($html,$dt["identifier"])) {
                $doctype =  $dt["name"];
            }
        }
        //var_dump($doctype);
        if($doctype) {
        	echo "Doctype: ".$doctype."<br>";
        } else {
        	echo "no doctype!";
        }

        $number_of = array(
        	"body" => array(
	 	        "<div>" => count($dom->find("div")),
		        "<article>" => count($dom->find("article")),
		        "<section>" => count($dom->find("section")),
		        "<footer>" => count($dom->find("footer")),
		        "<header>" => count($dom->find("header")),
		        "<nav>" => count($dom->find("nav")),
		        "<aside>" => count($dom->find("aside")),
		        "<div>" => count($dom->find("div")),
		        "<main>" => count($dom->find("main")),
		        "<h1>" => count($dom->find("h1")),
		        "<h2>" => count($dom->find("h2")),
		        "<h3>" => count($dom->find("h3")),
		        "<h4>" => count($dom->find("h4")),
		        "<h5>" => count($dom->find("h5")),
		        "<h6>" => count($dom->find("h6")),
		        "<br>" => count($dom->find("br")),
		        "<hr>" => count($dom->find("hr")),
		        "<span>" => count($dom->find("span")),
		        "<ol>" => count($dom->find("ol")),
		        "<ul>" => count($dom->find("ul")),
		        "<li>" => count($dom->find("li")),
		        "<img>" => count($dom->find("img")),
		        "<form>" => count($dom->find("form")),
		        "<label>" => count($dom->find("label")),
		        "<input>" => count($dom->find("input")),
		        "<textarea>" => count($dom->find("textarea")),
		        "<button>" => count($dom->find("button")),
		        "<em>" => count($dom->find("em")),
		        "<strong>" => count($dom->find("strong")),
		        "<strike>" => count($dom->find("strike")),
		        "<b>" => count($dom->find("b")),
		        "<i>" => count($dom->find("i")),
	 	        "<details>" => count($dom->find("details")),
		        "<figure>" => count($dom->find("figure")),
		        "<figcaption>" => count($dom->find("figcaption")),
		        "<mark>" => count($dom->find("mark")),
		        "<summary>" => count($dom->find("summary")),
		        "<time>" => count($dom->find("time")),
		        "<address>" => count($dom->find("address")),
		        "<a>" => count($dom->find("a")),
		        "<abbr>" => count($dom->find("abbr")),
		        "<acronym>" => count($dom->find("acronym")),
		        "<embed>" => count($dom->find("embed")),
		        "<object>" => count($dom->find("object")),
		        "<applet>" => count($dom->find("applet")),
		        "<area>" => count($dom->find("area")),
		        "<audio>" => count($dom->find("audio")),
		        "<base>" => count($dom->find("base")),
		        "<basefont>" => count($dom->find("basefont")),
		        "<bdi>" => count($dom->find("bdi")),
		        "<bdi>" => count($dom->find("bdi")),
		        "<big>" => count($dom->find("big")),
		        "<blockquote>" => count($dom->find("blockquote")),
		        "<canvas>" => count($dom->find("canvas")),
		        "<caption>" => count($dom->find("caption")),
		        "<center>" => count($dom->find("center")),
		        "<cite>" => count($dom->find("cite")),
		        "<code>" => count($dom->find("code")),
		        "<col>" => count($dom->find("col")),
		        "<colgroup>" => count($dom->find("colgroup")),
		        "<datalist>" => count($dom->find("datalist")),
		        "<dd>" => count($dom->find("dd")),
		        "<del>" => count($dom->find("del")),
		        "<details>" => count($dom->find("details")),
		        "<dfn>" => count($dom->find("dfn")),
		        "<dialog>" => count($dom->find("dialog")),
		        "<dir>" => count($dom->find("dir")),
		        "<dl>" => count($dom->find("dl")),
		        "<dt>" => count($dom->find("dt")),
		        "<fieldset>" => count($dom->find("fieldset")),
		        "<font>" => count($dom->find("font")),
		        "<frame>" => count($dom->find("frame")),
		        "<frameset>" => count($dom->find("frameset")),
		        "<iframe>" => count($dom->find("iframe")),
		        "<ins>" => count($dom->find("ins")),
		        "<kbd>" => count($dom->find("kbd")),
		        "<keygen>" => count($dom->find("keygen")),
		        "<legend>" => count($dom->find("legend")),
		        "<map>" => count($dom->find("map")),
		        "<mark>" => count($dom->find("mark")),
		        "<menu>" => count($dom->find("menu")),
		        "<menuitem>" => count($dom->find("menuitem")),
		        "<meter>" => count($dom->find("meter")),
		        "<noframes>" => count($dom->find("noframes")),
		        "<noscript>" => count($dom->find("noscript")),
		        "<optgroup>" => count($dom->find("optgroup")),
		        "<option>" => count($dom->find("option")),
		        "<output>" => count($dom->find("output")),
		        "<p>" => count($dom->find("p")),
		        "<param>" => count($dom->find("param")),
		        "<pre>" => count($dom->find("pre")),
		        "<progress>" => count($dom->find("progress")),
		        "<q>" => count($dom->find("q")),
		        "<rp>" => count($dom->find("rp")),
		        "<rt>" => count($dom->find("rt")),
		        "<ruby>" => count($dom->find("ruby")),
		        "<s>" => count($dom->find("s")),
		        "<samp>" => count($dom->find("samp")),
		        "<select>" => count($dom->find("select")),
		        "<small>" => count($dom->find("small")),
		        "<source>" => count($dom->find("source")),
		        "<sub>" => count($dom->find("sub")),
		        "<sup>" => count($dom->find("sup")),
		        "<summary>" => count($dom->find("summary")),
		        "<table>" => count($dom->find("table")),
		        "<tbody>" => count($dom->find("tbody")),
		        "<td>" => count($dom->find("td")),
		        "<tfoot>" => count($dom->find("tfoot")),
		        "<tr>" => count($dom->find("tr")),
		        "<th>" => count($dom->find("th")),
		        "<thead>" => count($dom->find("thead")),
		        "<tt>" => count($dom->find("tt")),
		        "<u>" => count($dom->find("u")),
		        "<var>" => count($dom->find("var")),
		        "<video>" => count($dom->find("video")),
		        "<wbr>" => count($dom->find("wbr")),
				"<bgsound>"  => count($dom->find("bgsound")),
				"<blink>"  => count($dom->find("blink")),
				"<hgroup>"  => count($dom->find("hgroup")),
				"<isindex>"  => count($dom->find("isindex")),
				"<listing>"  => count($dom->find("listing")),
				"<marquee>"  => count($dom->find("marquee")),
				"<multicol>"  => count($dom->find("multicol")),
				"<nextid>"  => count($dom->find("nextid")),
				"<nobr>"  => count($dom->find("nobr")),
				"<noembed>"  => count($dom->find("noembed")),
				"<noframes>"  => count($dom->find("noframes")),
				"<plaintext>"  => count($dom->find("plaintext")),
				"<spacer>"  => count($dom->find("spacer")),
				"<strike>"  => count($dom->find("strike")),
				"<xmp>"  => count($dom->find("xmp")),
	   		),
        	"head" => array(
  	        	"<link>" => count($dom->find("link")),
 	        	"<meta>" => count($dom->find("meta")),
	 	        "<script>" => count($dom->find("script")),
		        "<style>" => count($dom->find("style")),
 	        	"<title>" => count($dom->find("title")),
       		),
       );

		arsort($number_of["body"]);
		//dd($number_of["body"]);

		$non_semantic_tags = array(
				"<div>",
				"<span>",
				"<br>",
				"<b>",
				"<i>",
				"<center>",
				"<acronym>",
				"<applet>",
				"<basefont>",
				"<bgsound>",
				"<big>",
				"<blink>",
				"<dir>",
				"<font>",
				"<frame>",
				"<frameset>",
				"<hgroup>",
				"<isindex>",
				"<listing>",
				"<marquee>",
				"<multicol>",
				"<nextid>",
				"<nobr>",
				"<noembed>",
				"<noframes>",
				"<plaintext>",
				"<spacer>",
				"<strike>",
				"<tt>",
				"<xmp>",
			);

	/*	
		$content =  array(
			"metadata" = array(
				"base",
				"command",
				"link",
				"meta",
				"noscript",
				"script",
				"style",
				"title",
			),
			"flow" = array(
				"abbr",
				"address",
				"area",
				"article",
				"aside",
				"b",
				"bdi",
				"bdo",
				"blockquote",
				"br",
				"button",
				"cite",
				"code",
				"command",
				"datalist",
				"del",
				"details",
				"dialog",
				"div",
				"dl",
				"em",
				"embed",
				"fieldset",
				"figure",
				"form",
				"h1",
				"h2",
				"h3",
				"h4",
				"h5",
				"h6",
				"header",
				"hr",
				"i",
				"img",
				"ins",
				"kbd",
				"keygen",
				"label",
				"map",
				"math",
				"menu",
				"nav",
				"noscript",
				"ol",
				"p",
				"pre",
				"progress",
				"q",
				"s",
				"samp",
				"script",
				"section",
				"select",
				"small",
				"span",
				"strong",
				"sub",
				"sup",
				"svg",
				"table",
				"textarea",
				"u",
				"ul",
				"var",
				"wbr",		
			),
			"sectioning" = array(
				"article",
				"aside",
				"nav",
				"section",
			),
			"heading" = array(
				"h1",
				"h2",
				"h3",
				"h4",
				"h5",
				"h6",
				"hgroup",
			),
			"phrasing" = array(
				"a",
				"abbr",
				"area",
				"audio",
				"b",
				"bdi",
				"bdo",
				"br",
				"button",
				"canvas",
				"cite",
				"code",
				"command",
				"datalist",
				"del",
				"dfn",
				"em",
				"embed",
				"i",
				"iframe",
				"img",
				"input",
				"ins",
				"",
				"kbd",
				"keygen",
				"label",
				"map",
				"",
				"mark",
				"math",
				"meter",
				"noscript",
				"object",
				"output",
				"progress",
				"q",
				"ruby",
				"s",
				"samp",
				"script",
				"select",
				"small",
				"span",
				"strong",
				"sub",
				"sup",
				"svg",
				"textarea",
				"time",
				"u",
				"var",
				"video",
				"wbr",
			),
			"embedded" = array(
				"audio",
				"canvas",
				"embed",
				"iframe",
				"img",
				"math",
				"object",
				"svg",
				"video",
			),
			"interactive" = array(
				"a",
				"audio",
				"button",
				"details",
				"embed",
				"iframe",
				"img",
				"input",
				"keygen",
				"label",
				"menu",
				"object",
				"select",
				"textarea",
				"video",
			),
			"palpable" = array(
				"a",
				"abbr",
				"address",
				"article",
				"aside",
				"audio",
				"b",
				"bdi",
				"bdo",
				"blockquote",
				"button",
				"canvas",
				"cite",
				"code",
				"details",
				"dfn",
				"div",
				"dl",
				"em",
				"embed",
				"fieldset",
				"figure",
				"footer",
				"form",
				"h1",
				"h2",
				"h3",
				"h4",
				"h5",
				"h6",
				"header",
				"hgroup",
				"i",
				"iframe",
				"img",
				"input",
				"ins",
				"kbd",
				"keygen",
				"label",
				"map",
				"mark",
				"math",
				"menu",
				"meter",
				"nav",
				"object",
				"ol",
				"output",
				"p",
				"pre",
				"progress",
				"q",
				"ruby",
				"s",
				"samp",
				"section",
				"select",
				"small",
				"span",
				"strong",
				"sub",
				"sup",
				"svg",
				"table",
				"textarea",
				"time",
				"u",
				"ul",
				"var",
				"video",
			),
		);
	*/
?>
<section id="html-validator">
<?php
// W3C HTML Validator
//var_dump(strpos($url, "localhost"));die();
if(strpos($url, "localhost")=== false){
	$ch = curl_init("http://validator.w3.org/nu/?doc=".$url."&out=json");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


	$result = curl_exec($ch);
	curl_close($ch);
	//var_dump($ch);
	?><h2>HTML Validation</h2>
	<textarea name="" id="" cols="30" rows="10">
		<?php 
		var_dump($result);
		?>
	</textarea><br>
	<?php 
	$result = json_decode($result, true);
	//dd($result);
	$errors = 0;
	$warnings = 0;
	foreach ($result["messages"] as $message) {
		if($message["type"]==="error") {
			$errors++;
		} 
		if($message["type"]==="info" && $message["subType"]==="warning") {
			$warnings++;
		}
	}
	if ($errors===0) {
		?>
		<h3>No errors</h3>
		<?php
	} else {
	}
	?>
	<h3><?php echo $errors;?> errors</h3>
	<h4><?php echo $warnings;?> warnings</h4> 

	<?php 
	foreach ($result["messages"] as $message) {
		if($message["type"]==="error") {
			//?><strong class="error-msg"><?php echo "[ERROR] ". $message["message"];?></strong><?php
			//?><em class="error-extract"><?php if(isset($message["lastLine"])) {?>line <?php echo $message["lastLine"];?>: <?php }?><code><?php if(isset($message["extract"])){ echo htmlentities($message["extract"]);}?></code></em><?php
		}
		if($message["type"]==="info" && $message["subType"]==="warning") {
			//?><strong class="warning-msg"><?php echo "[WARNING] ". $message["message"];?></strong><?php
			//?><em class="warning-extract"><?php if(isset($message["lastLine"])) {?>line <?php echo $message["lastLine"];?>: <?php }?><code><?php if(isset($message["extract"])){ echo htmlentities($message["extract"]);}?></code></em><?php
		}
	}

}
?>
</section>
	<?php 
	// API key: AIzaSyDXMpExKtuG3WW208ljByEGoB4wfvC8fOk
	// 
	$googleApiKey = "AIzaSyDXMpExKtuG3WW208ljByEGoB4wfvC8fOk";
	?>
<section id="page-speed">
	<h2>PageSpeed Insights (google)</h2>

<?php

	$apiUrl = "https://www.googleapis.com/pagespeedonline/v2/runPagespeed?screenshot=false&strategy=desktop";
	$result = json_decode(getFile($apiUrl."&url=".$url, $googleApiKey), true);
//var_dump($result);
	if(isset($result['ruleGroups']['SPEED']['score'])) {
		//$pass = $result['ruleGroups']['SPEED']['pass'];
		
		?>
		<h3>Score: <?php echo $result['ruleGroups']['SPEED']['score'];?> 
		<?php
	}

?>
	<p>This page has <?php echo $result['pageStats']['numberResources']; ?> resources divided over <?php echo $result['pageStats']['numberHosts']; ?> hosts.</p>
	<p>Total size of &lt;img&gt; images: <?php echo human_filesize($result['pageStats']['imageResponseBytes'],2); ?></p>
	<small>See more at <a href="https://developers.google.com/speed/pagespeed/insights/?url=<?php echo $url;?>">Google PageSpeed Insights</a></small>
</section>
<section id="mobile-friendly">
	<h2>Mobile Friendliness (google)</h2>
	<?php
	$apiUrl = "https://www.googleapis.com/pagespeedonline/v3beta1/mobileReady";
	$result = json_decode(getFile($apiUrl."?url=".$url, $googleApiKey), true);
	if(isset($result['ruleGroups']['USABILITY']['pass'])) {
		$pass = $result['ruleGroups']['USABILITY']['pass'];
		
		?>
		<h3>Score: <?php echo $result['ruleGroups']['USABILITY']['score'];?> (
		<?php
		if($pass) {
			echo "Passed! Mobile friendly";
		} else {
			echo "Failed! NOT mobile friendly";
		}
		?>)</h3>
		<?php

	} elseif (isset($result['ruleGroups']['USABILITY']['score'])) {
		?><h3>Score: <?php echo $result['ruleGroups']['USABILITY']['score'];?></h3><?php
	} else {
		echo "something went wrong...";
		var_dump($result);
	}
	?>
	<small>See more at <a href="https://www.google.com/webmasters/tools/mobile-friendly/?url=<?php echo $url;?>">Google Mobile-Friendly Test</a></small>
</section>
<section id="violations">
	<h2>Content Layer Violations</h2>
	<p>In file xxxx.html:31 onclick attribute used. (level: violation)</p>
	<p>(or onload, onchange etc)</p>
	
	<h2>Presentation Layer Violations</h2>
	<p>In file xxxx.css:1 content property is used. (level: notice/beware/could be crap)</p>
	
	<h2>Behaviour Layer Violations</h2>
	<p>In file xxxx.js:132 css attributes are set. Consider defining these changes as a css rule instead. (level: potentional violation)</p>

	<h3>Seperation of layers</h3>
	<p>The simple seperation of the three layers is an outdated way of thinking, some even say that <a href="http://blog.teamtreehouse.com/the-separation-of-structure-presentation-and-behavior-is-dead">the seperation is dead</a>, however I argue that is not the case.</p>
	<p>The simple form of the layers does not hold up. The content layer should not be seen as belonging to HTML. In CSS we can also insert html content. Does that mean that we have content layer structure in our presentation layer? No, because it is not the technology that defines the layer. HTML in CSS ≠ content layer structure in presentation layer. HTML can also be fully in the presentation layer.</p>

</section>
<section id="outline">
	<iframe src="https://gsnedders.html5.org/outliner/process.py?url=<?php echo urlencode($url);?>"></iframe>
	
<?php
	$apiUrl = "https://gsnedders.html5.org/outliner/process.py?url=" . urlencode($url);

	$result = getFile($apiUrl);
	$result = str_ireplace("</style>","</style></head><body>",$result);
	$result = str_ireplace("<!doctype html>","<!doctype html><html><head>",$result);
	$result .= "</body></html>";
	if(strpos($result,"<!doctype")>=0) {
		echo "yup";
	}
	/*var_dump($result); die();
	//$html = mb_strtolower($result);
    $dom = new \Htmldom();
    $dom->load($result);
    var_dump($dom);
    var_dump($dom->find("title"));//die();
	die();
	*/
?>


	<small>See more at <a href="https://gsnedders.html5.org/outliner/process.py?url=<?php echo urlencode($url);?>">HTML 5 Outliner</a></small>
</section>
<?php

// Page Speed Insights
// Google Mobile Friendliness


        //dd($dom->find("*"));
        //$dom_as_string = $str = $dom->save();
        //var_dump(substr_count($dom_as_string,"/>"));

        $divs = $number_of["body"]["<div>"];
        
        $number_of_body_tags = 0;
        foreach ($number_of["body"] as $tag => $number) {
        	$number_of_body_tags += $number;
        }

        echo "Number of body tags: ". $number_of_body_tags . "<br>";

        $number_of_non_semantic_tags = 0;
        foreach ($non_semantic_tags as $tag) {
        	$number_of_non_semantic_tags += $number_of["body"][$tag];
        }
        echo "Number of NON SEMANTIC tags:" . $number_of_non_semantic_tags."<br>";

        $non_semantic_percentage = round(($number_of_non_semantic_tags/$number_of_body_tags)*100,2);
?>
<h3>Ratio: <?php echo $non_semantic_percentage;?>% non-semantic tags</h3>
<figure class="ct-chart ct-perfect-fourth"></figure>
<script>
var data = {
  // A labels array that can contain any sort of values
  labels: ['% Semantic', '% Non-semantic'],
  // Our series array that contains series objects or in this case series data arrays
  series: [
    [<?php echo 100-$non_semantic_percentage;?>, <?php echo $non_semantic_percentage;?>]
  ]
};

var settings = {
	donut: true,
	showLabel: false
};

// Create a new line chart object where as first parameter we pass in a selector
// that is resolving to our chart container element. The Second parameter
// is the actual data object.
//new Chartist.Pie('.ct-chart', data, settings);

/*new Chartist.Pie('.ct-chart', data, {
  donut: true
});*/

new Chartist.Pie('.ct-chart', {
  series: [
    <?php echo round($non_semantic_percentage);?>,
    <?php echo round(100-$non_semantic_percentage);?> 
  ],
  labels: ['% Non-semantic', '% Semantic']
}, {
  donut: false,
  showLabel: false
});



</script>
<h4>This site is <?php echo 100-$non_semantic_percentage;?>% semantic markup</h4>
            <h2><?php echo $url;?> uses </h2><h1 class="title"><strong><?php echo $divs;?></strong>  &lt;div&gt; tags.</h1>
            
			<section id="stats">
				<ul>
					<li class="title">Semantic Tags</li>
					<?php
				        foreach ($number_of["body"] as $tag => $number) {
				        	?>
							<li><?php echo htmlentities($tag);?>: <?php echo $number;?></li>
				        	<?php
				        }
				        ?>
				</ul>
				<ul>
					<li class="title">Non-Semantic Tags</li>
					<?php
				        foreach ($non_semantic_tags as $tag) {
				        	//$number_of_non_semantic_tags += $number_of["body"][$tag];
				        	?>
							<li><?php echo htmlentities($tag);?>: <?php echo $number_of["body"][$tag];?></li>
				        	<?php
				        }
				        ?>
				</ul>
			</section>



            <p>Why do web developers use &lt;div&gt; tags?</p>
            <ul><?php //dd($number_of);?>
                <li><q>"But they work just as well"</q></li>
                <!-- It's not about the functional layer. What are you communicating, man! -->

                <li>What else to use?</li>
                <!-- Hmm the semantic choice does suck. -->

                <li>Who cares?</li>
                <!-- I do! It's just intellectual laziness not to -->
                <li></li>
            </ul>

    </body>
</html>

<?php function getFile($url,$api = null) {
	$url = $url;
	if(isset($api)) {$url .="&key=".$api;}
	$ch = curl_init($url);
	//die($url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);



	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
// From http://jeffreysambells.com/2012/10/25/human-readable-filesize-php
function human_filesize($bytes, $decimals = 2) {
    $size = array('B','kB','MB','GB','TB','PB','EB','ZB','YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}
