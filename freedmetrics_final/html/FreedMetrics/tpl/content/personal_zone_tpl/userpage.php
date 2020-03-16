<?php

$header = "UserPage";
$subheader = "Wellcome";
$title = "User Name";

print(page_head($_SESSION['pagename'],$title));

print(page_header($header, $subheader,1));
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