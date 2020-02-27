<?php

include_once("$search_incDir/check_and_search.search.php");

$header = "Search results";
$subheader = "The search is done, now the real work begins.";

print(page_header($header, $subheader));
?>
<!-- Main Content -->

<div class="container">
	<div class="col-lg- <?php print $lg_width;?> col-md-<?php print $lg_width;?> mx-auto">
		<div class="row">
			<?php
				$tag = 'arXiv';
				if (!count($arxiv_entries)) {
				   	print ("<h4 style=\"text-align: center;\">Not Found:</h4>
				   			<p style=\"text-align: center;\"><i>Sorry,your query didn’t match any sequence. Adjust your terms or try an Advanced Search.<i><p>");
				} else {
			?>
			<h5><?php print $tag;?> Results, Num Hits: <?php print count($arxiv_entries) ?></h5>
	    	<?php print results_table($arxiv_entries,$tag); }?>
		</div>
		<div class="row"><p><br><br></p></div>
		<div class="row">
			<?php
				$tag = 'PubMed';
				if (!count($pubmed_entries)) {
				   	print ("<h4 style=\"text-align: center;\">Not Found:</h4>
				   			<p style=\"text-align: center;\"><i>Sorry,your query didn’t match any sequence. Adjust your terms or try an Advanced Search.<i><p>");
				} else {
			?>
			<h5><?php print $tag;?> Results, Num Hits: <?php print count($pubmed_entries) ?></h5>
	    	<?php print results_table($pubmed_entries,$tag); }?>
		</div>
		<div class="row">
	    	<div class="clearfix">
    			<a class="btn btn-primary float-left" href="index.php?pagename=arXiv-browser&new=1">New Search</a>
			</div>
		</div>
	</div>
</div>