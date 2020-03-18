<?php

include_once("$search_incDir/search_functions.search.php");

$header = "Welcome ".$_SESSION['username'];
$subheader = "Check your last queries";
$title = "FreedMetrics - ".$_SESSION['username'];

print(page_head($_SESSION['pagename'],$title));
print(page_header($header, $subheader,1));

?>
<div class="container">
	<div class="col-lg- <?php print $lg_width;?> col-md-<?php print $lg_width;?> mx-auto">
		<?php
			$entries = user_history($_SESSION['person_id'],$conn);
			$tag = "FreedMetrics_Database";
					
			if (count($entries) == 0) {
			   	print ("<div class=\"row\" style=\"justify-content: center;\">
			   		<h4>No articles found.</h4>
			   		</div>
			   		<div class=\"row\" style=\"justify-content: center;\">
			   		<p><i>It seems that you have not searched any article yet.</i><p>
			   		</div>");
			} else {
				$_SESSION['FreedMetrics_Database'] = $entries;
		?>
			<div class="row">
				<h5>User History: <?php print count($entries);?> queries found</h5>
			</div>
    	<?php print results_table($entries,$tag); }?>
	
		<div class="row">
	    	<div class="clearfix">
    			<a class="btn btn-primary float-left" href="index.php?pagename=Advanced-Search">Advanced Search</a>
			</div>
		</div>
	</div>
</div>
<?php print(page_footer($_SESSION['pagename']));