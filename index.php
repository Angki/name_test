<?php
function GetBetween($content,$start,$end){
    $r = explode($start, $content);
    if (isset($r[1])){
        $r = explode($end, $r[1]); return $r[0];
    }
    return '';
}
function get_web_page( $url ) {
	$user_agent='Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0';
    $options = array(
        CURLOPT_CUSTOMREQUEST  =>"GET",        //set request type post or get
        CURLOPT_POST           =>false,        //set to GET
        CURLOPT_USERAGENT      => $user_agent, //set user agent
        CURLOPT_COOKIEFILE     =>"cookie.txt", //set cookie file
        CURLOPT_COOKIEJAR      =>"cookie.txt", //set cookie jar
        CURLOPT_RETURNTRANSFER => true,     // return web page
        CURLOPT_HEADER         => false,    // don't return headers
        CURLOPT_FOLLOWLOCATION => true,     // follow redirects
        CURLOPT_ENCODING       => "",       // handle all encodings
        CURLOPT_AUTOREFERER    => true,     // set referer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
        CURLOPT_TIMEOUT        => 120,      // timeout on response
        CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
    );
    $ch      = curl_init( $url );
    curl_setopt_array( $ch, $options );
    $content = curl_exec( $ch );
    $err     = curl_errno( $ch );
    $errmsg  = curl_error( $ch );
    $header  = curl_getinfo( $ch );
    curl_close( $ch );
    $header['errno']   = $err;
    $header['errmsg']  = $errmsg;
    $header['content'] = $content;
    return $header;
}
?>
<?php
if(isset($_POST['tblSubmit'])){
	if (isset($_POST['nama']) && !empty($_POST['nama'])){
		$output = get_web_page("http://en.nametests.com/test/calculate/311/waiting/?answer=".rawurlencode($_POST['nama'])."&resid=1841");
		$json_a = json_decode($output['content'], true);
		$OK = false; $ID = ""; $SLUG = "";
		foreach($json_a as $key => $value){
			if(!is_array($value)){
				if(($key == "ok") && ($value == "yes")){
					$OK = true;
				}
				if(($key == "combi_id")){
					$ID = $value;
				}
				if(($key == "slug")){
					$SLUG = $value;
				}
			}
		}
		$output = get_web_page("http://en.nametests.com/test/result/".$SLUG."/".$ID."/");

		die('<center><div class="well"><a href="https://www.facebook.com/sharer/sharer.php?u=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'"><i class="fa fa-3x fa-facebook-square"></i></a>
<a href="https://plus.google.com/share?url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'"><i class="fa fa-3x fa-google-plus-square"></i></a>
<a href="https://twitter.com/intent/tweet?text=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'"><i class="fa fa-3x fa-twitter-square"></i></a>
<a href="http://www.pinterest.com/pin/create/button/?url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&description=Arti%20Nama"><i class="fa fa-3x fa-pinterest-square"></i></a>
<a href="http://www.reddit.com/submit?url=http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'&title=Arti%20Nama"><i class="fa fa-3x fa-reddit-square"></i></a></div><div class="alert alert-success"><a class="close" data-dismiss="alert">×</a><h3>Hasil</h3><img src="'.GetBetween($output['content'], '<meta property="og:image" content="', '"/>').'" /></div></center>');
	} else{
		die('<center><div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a><h3>Error</h3>Parameter tidak boleh kosong!</div></center>');
	}

} else{
	//highlight_file(__FILE__);
}
?>
<!DOCTYPE html>
<html class="full" lang="en">
<!-- The full page image background will only work if the html has the custom class set to it! Don't delete it! -->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Angki Ang">

    <title>Kurang Kerjaan</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet" />
    <link href="css/font-awesome.css" rel="stylesheet" />

    <!-- Custom CSS for the 'Full' Template -->
    <link href="css/the-big-picture.css" rel="stylesheet" />
</head>

<body>

    <nav class="navbar navbar-fixed-bottom navbar-inverse" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="http://angki.techcode-society.com/">TechCode-Society</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-ex1-collapse">
                <ul class="nav navbar-nav">
                    <li><a href="https://facebook.com/anonim.gov">Facebook</a></li>
                    <li><a href="https://twitter.com/angki_ang">Twitter</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>

    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-sm-12" style="color:white">
                <h1>Kurang Kerjaan</h1>
                <p>Mumpung lagi rame di FB xD</p><hr /><br />
<div class="container">
	<div class="well">
		<form name="test" id="test">
			<table border="0" class="table table-hovered">
				<tr><td><input type="text" name="nama" class="form-control" onkeydown="if(event.keyCode == 13){document.getElementById('tblSubmit').click(); return false;}" /></td><td style="width:13px"><button class="btn btn-info" type="button" id="tblSubmit" name="tblSubmit" onclick="loading();"><i class="glyphicon glyphicon-search"></i></button></td></tr>
			</table>
		</form><br /><div id="output" name="output"></div>
	</div>
	<hr />
	<div class="row">
		<div class="col-xs-12 col-sm-4 col-lg-3 hidden-xs text-right">
			<img class="img-circle" src="http://img5.visualizeus.com/thumbs/25/bf/4chan,alone,comics,forever,foreveralone,guy-25bf445aaa03d0a666673afc7b9ad621_h.jpg" style="width: 75px; height: 75px;">
		</div>
		<div class="col-xs-12 col-sm-8 col-lg-9">
			<blockquote>
			  <p>Kurang kerjaan</p>
			  <small>Angki</small>
			</blockquote>
		</div>
	</div>
</div>
            </div>
        </div>
    </div>


    <!-- JavaScript -->
    <script src="js/jquery-1.10.2.js"></script>
    <script src="js/bootstrap.js"></script>
<script type="text/javascript">
<?php
$jsSrcTamfan = "
$(document).ready(function() {
	$(\"#tblSubmit\").click(function() {
		$.post(\"index.php\", { nama: test.nama.value, tblSubmit: \"yeah\"},
		function(newdata) {
			$(\"#output\").html(newdata).show();
		});
	});
});

function loading(){
	document.getElementById(\"output\").innerHTML = \"<center><div class='alert alert-info'><a class='close' data-dismiss='alert'>×</a><h3>Tunggu bentar...</h3><div class='progress progress-striped active'><div style='width: 100%' class='progress-bar progress-bar-info'></div></div></div></center>\";
}";
echo str_replace("
","",$jsSrcTamfan);
?>
</script>
</body>

</html>
