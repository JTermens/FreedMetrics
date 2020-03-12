<?php

$article_data = $_SESSION[$_GET['source']][$_GET['article-ref']];

$title = "FreedMetrics - ".$article_data['title'];
$header = 'Article page';
$subheader = 'Hope you found what you were searching';

print(page_head($_SESSION['pagename'],$title));

print(page_header($header, $subheader));

$metrics = array(
	'metric1' => 1,
	'metric2' => 2,
	'metric3' => 3,
	'metric4' => 4)
?>
<!-- Main Content -->
<div class="container">
	<div class="col-lg-8 col-md-10 mx-auto">
		<div class="row">
			<h2><?php print $article_data['title']?></h2>
			<div style= "font-style: italic;">
				<?php
					$authors = '';
					$author_count = 0;
				    foreach ($article_data['authors'] as $author) {
				      $author_count += 1;
				      if ($author_count == (count($article_data['authors'])-1) ) {
				        $authors .= $author." and ";
				      }elseif ($author_count == count($article_data['authors']) ) {
				        $authors .= $author;
				        break;
				      }else{
				        $authors .= $author.", ";
				      }
				    }
				    print $authors;
				?>
			</div>
		</div>
		<br>
		<div class="row text-justify">
			<h3>Abstract:</h3>
			<p><?php print $article_data['abstract'] ?></p>
			<p>
				<a href="<?php print $article_data['link'] ?>" rel="noopener noreferrer" target="_blank"><b>Link to the source</b></a>
				<br>
				<?php if($article_data['doi'] != ''){
		      		print "<b>DOI: </b><a href=\"https://dx.doi.org/".$article_data['doi']."\" rel=\"noopener noreferrer\" target=\"_blank\">".$article_data['doi']."</a>";
		   		}?>
	   		</p>
		</div>
		<div class="row">
			<h3>Metrics:</h3>
		</div>
		<div class="row">
			<div class="col-4" style="border-right:1px solid;">
				<?php foreach ($metrics as $metric_name => $metric_value) {?>
					<div class="row">
						<b><?php print "$metric_name:"?></b>&nbsp<?php print $metric_value ?>
					</div>
					<hr class="divider">
				<?php } ?>
			</div>
			<div class="col-8">
				<h5>Tweets with this article:</h5>
				...
			</div>
		</div>
	</div>
</div>