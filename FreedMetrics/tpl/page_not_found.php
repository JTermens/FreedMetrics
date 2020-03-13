<?php

$header = "Error";
$subheader = "Sorry, seems that something went wrong.";
$title = "FreedMetrics - Not Found";

print(page_head($_SESSION['pagename'],$title));

print(page_header($header, $subheader,1));
?>
<!-- Main Content -->
<div class="container">
	<div class="row">
		<div class="col-lg-8 col-md-10 mx-auto">
			<h2>Error 404: Page Not Found</h2>
			Page not found or invalid search query. Return to <a href="index.php?pagename=Home">Home</a> or try and <a href="index.php?pagename=Advanced-Search">Advanced Search</a>.
		</div>
	</div>
</div>