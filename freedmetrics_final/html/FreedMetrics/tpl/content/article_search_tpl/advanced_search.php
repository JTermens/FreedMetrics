<?php

// Advanced search is only available for registered users
if (!isset($_SESSION['username'])) {
	header("Location: index.php?pagename=Home");
}

$header = "Error";
$subheader = "Sorry, seems that something went wrong.";
$title = "FreedMetrics - Advanced Search";

print(page_head($_SESSION['pagename'],$title));

print(page_header($header, $subheader));
?>
<!-- Main Content -->
<div class="container">
	<div class="row">
		<div class="col-lg-8 col-md-10 mx-auto">
			<h2>Error 404: Page Not Found</h2>
		</div>
	</div>
</div>

<?php print(page_footer($_SESSION['pagename']));