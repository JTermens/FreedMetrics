<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);
include_once("history.php");

$header = "User Page";
$subheader = "Check your last queries";
$title = "User Name";

print(page_head($_SESSION['pagename'],$title));

print(page_header($header, $subheader,1));
?>


<div class="container">
	<div class="col-lg- <?php print $lg_width;?> col-md-<?php print $lg_width;?> mx-auto">
		
		<div class="row">
			<?php
				$entries = user_history("c@c");
				$tag = "History";
				if (!count($entries)) {
				   	print ("<h4 style=\"text-align: center;\">No articles found.</h4>
				   			<p style=\"text-align: center;\"><i>It seems that you have not searched any article yet.</i><p>");
				} else {
			?>
			<h5>User History: <?php print count($entries);?> queries found</h5>
	    	<?php print results_table($entries,$tag); }?>
		</div>
		
		<div class="row"><p><br><br></p></div>

		<div class="row">
	    	<div class="clearfix">
    			<a class="btn btn-primary float-left" href="index.php?pagename=Advanced-Search&new=1">Search more articles</a>
			</div>
		</div>

	</div>
</div>
