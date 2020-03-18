<?php

include_once("$search_incDir/load_and_retrieve.search.php");


$title = "FreedMetrics - ".$article_data['title'];

print(page_head($_SESSION['pagename'],$title));
?>
<!-- Twitter scripts -->
  <script sync src="https://platform.twitter.com/widgets.js"></script>

<!-- Main Content -->
	<div class="container">
		<div class="card border-0 shadow my-5 col-lg-8 col-md-10 mx-auto">
			<div class="card-body p-5">
				<div class="row">
					<h2><?php print $article_data['title']?></h2><br>
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
				<div class="row">
					<?php if (($article_data['journal'] != '') and ($article_data['publish_date'] != '')) { ?>
						<h6>Published by <i><?php print $article_data['journal']?></i> on <?php print $article_data['publish_date']?></h6> 
					<?php } ?>
				</div>
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
				<?php if(!empty($article_data['keywords'])) { ?>
					<div class="row">
						<h5><b>Keywords:</b></h5>&nbsp
						<p>
							<?php
								$keywords = '';
								$keyword_count = 0;
							    foreach ($article_data['keywords'] as $keyword) {
							      $keyword_count += 1;
							      if ($keyword_count == count($article_data['keywords']) ) {
							        $keywords .= $keyword;
							        break;
							      }else{
							        $keywords .= $keyword.", ";
							      }
							    }
							    print $keywords;
							?>
						</p>
					</div>
					<br>
				<?php } ?>
				<div class="row">
					<div class="col-10">
					<h3>Metrics:</h3>
					</div>
					<div class="col-2">
						<?php if (isset($_SESSION['username'])) { ?>
							<div class="clearfix">
	    						<a class="btn btn-primary float-left" href="index.php?pagename=Article-Page&id=<?php print $article_data['article_id'] ?>&action=refresh_metrics">Refresh metrics</a>
							</div>
						<?php }?>
					</div>
				</div>
				<div class="row">
					<div class="col-4" style="border-right:1px solid;">
						<?php foreach ($metrics_dict as $metric_name => $metric_value) {
							if ($metric_value != '') {
								print "<div class=\"row\">
										<b>$metric_name:</b>&nbsp $metric_value
									   </div>
									   <hr class=\"divider\">";
							}else{
								print "<div class=\"row\">
										<b>$metric_name:</b>&nbsp 0
									   </div>
									   <hr class=\"divider\">";
							}
						} ?>
					</div>
					<div class="col-8" style="border-left:1px solid;">
						<h5>Tweets with this article:</h5>
						<?php
							if(empty($tweets_dict)){
								print "<p style=\"text-align: center;\"><i>Sorry, no tweets have been found<i><p>";
							}else{
								$tweet_count = 0;
								foreach ($tweets_dict as $tweet) {
									$tweet_count +=1;
									$tweet_id = $tweet['tweet_id'];
									embedd_tweet($tweet_count,$tweet_id);
								}
							}
						?>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php print(page_footer($_SESSION['pagename']));