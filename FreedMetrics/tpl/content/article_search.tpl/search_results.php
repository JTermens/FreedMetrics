<?php

include_once("$search_incDir/check_and_search.search.php");

$header = "Search results";
$subheader = "The search is done, now the real work begins.";

$title = "FreedMetrics - $header";

print(page_head($_SESSION['pagename'],$title));

print(page_header($header, $subheader,1));
?>
<!-- Main Content -->

<div class="container">
	<div class="col-lg- <?php print $lg_width;?> col-md-<?php print $lg_width;?> mx-auto">
		<?php foreach ($source_ref as $tag) {?>
		<div class="row">
			<?php
				if (!count($_SESSION[$tag])) {
				   	print ("<h4 style=\"text-align: center;\">Not Found on $tag:</h4>
				   			<p style=\"text-align: center;\"><i>Sorry, your query didn’t match any sequence. Adjust your terms or try an <a href=\"index.php?pagename=Advanced-Search\">Advanced Search</a>.</i><p>");
				} else {
			?>
			<h5><?php print $tag;?> Results, Num Hits: <?php print count($_SESSION[$tag]) ?></h5>
	    	<?php print results_table($_SESSION[$tag],$tag); }?>
		</div>
		<div class="row"><p><br><br></p></div>
		<?php }?>
		<div class="row">
	    	<div class="clearfix">
    			<a class="btn btn-primary float-left" href="index.php?pagename=Advanced-Search&new=1">New Search</a>
			</div>
		</div>
	</div>
</div>