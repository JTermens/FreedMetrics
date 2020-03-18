<?php

$header = "FreedMetrics";
$subheader = "A free and open website of scientific article analytics.";
$title = 'FreedMetrics - Home';

print(page_head($_SESSION['pagename'],$title));

// if there is no entry in the Web_Statistics table, create it
$query = "INSERT IGNORE INTO Web_Statistics(num_users,num_searches,idWeb_Statistics) VALUES (0,0,1)";
mysqli_query($conn, $query);


//retrive web statistics
$statistics= $conn->query("SELECT * FROM Web_Statistics WHERE idWeb_Statistics='1'");
$statistics = $statistics->fetch_assoc();

$num_users = $statistics['num_users'];
$num_searches =$statistics['num_searches'];
?>
  <!-- Site Header -->
<header class="masthead">
  <div class="container h-100">
  <div class="row h-100 align-items-center justify-content-center text-center">
      <div class="col-lg-10 align-self-end">
        <img src="<?php print $logo_no_bg; ?>" alt="logo" width="40%">
        <h1 class="text-white font-weight-bold">FreedMetrics</h1>
        <hr class="divider my-4">
      </div>
      <div class="col-lg-8 align-self-baseline">
        <p class="text-white-75 mb-4">FreedMetrics is a free and open web application to analyse article-level metrics of academic papers on arXiv and Pubmed. <a href="#search" style="color: white; font-weight: bold;">Try a search!</a></p>
      </div>
    </div>
  </div>
</header>
<!-- Main Content -->
<!-- About Section -->
  <section class="page-section bg-primary" id="search">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
          <h2 class="text-white mt-0">Search and analyse what you need</h2>
          <hr class="divider light my-4">
          <p class="text-white-50 mb-4">FreedMetrics will give you the metadata as well as alt-metrics for the large pool of articles present on arXiv and Pubmed (by now).
          <?php if (!isset($_SESSION['username'])) {
            print "Give it a try and <a href=\"index.php?pagename=Login\" style=\"color: white; font-weight: bold;\">Register</a> for more tools.</p>";
            }?>
          <form action="index.php?pagename=Search-Results" id="search_query" name="search_query" method="POST" enctype="multipart/form-data">
            <div class="d-flex justify-content-center h-100">
              <div class="searchbar">
                <input class="search_input" type="text" name="search_query" placeholder="Enter the article's title, or doi, or author, or ...">
                <button type="submit" class="search_icon"><i class="fas fa-search"></i></button>
              </div>
            </div>
          </form>
          <br>
          <?php if (isset($_SESSION['username'])) {
            print "<p class=\"text-white-50 mb-4\">Do you want a more precise search? Try the <a href=\"index.php?pagename=Advanced-Search\" style=\"color: white; font-weight: bold;\">Advanced Search</a> tool.</p>";
            }?>
        </div>
      </div>
    </div>
  </section>
  <section class="page-section" id="statistics">
    <div class="container">
      <h2 class="text-center mt-0">At Your Service!</h2>
      <hr class="divider my-4">
      <br>
      <h4 class="text-center mt-0"><b><?php print $num_users ?></b> registered users.</h4><br>
      <h4 class="text-center mt-0"><b><?php print $num_searches ?></b> searches done.</h4>
    </div>
  </section>
  <section class="page-section bg-dark text-white" id="Twitter">
    <div class="container text-center">
      <h3 class="mb-4">Take a look at our twitter page</h3>
      <a class="twitter-timeline" href="https://twitter.com/FreedMetrics?ref_src=twsrc%5Etfw">Tweets by FreedMetrics</a> <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
      <div class="row">
        <span><a href="https://twitter.com/FreedMetrics?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-show-count="false">Follow @FreedMetrics</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></span>
        <span><a href="https://twitter.com/intent/tweet?screen_name=FreedMetrics&ref_src=twsrc%5Etfw" class="twitter-mention-button" data-show-count="false">Tweet to @FreedMetrics</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></span>
      </div>
    </div>
  </section>
  <section class="page-section bg-dark" id="about">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center">
        <h2 class="text-white mt-0">About us</h2>
        <hr class="divider light my-4">
        <p class="text-white-50 mb-4">FreedMetrics is a web service created by a multidisciplinary group of 4 students from the University Pompeu Fabra (UPF) of Barcelona coursing the MSc in Bioinformatics for Health Sciences.
        <p class="text-white-50 mb-4">We believe that the impact of scientific articles is a valuable information for any student and researcher. Our philosophy is that access to information should be free and easy for everyone.
          <div class="clearfix">
               <a class="btn btn-primary" href="index.php?pagename=About-us">Meet our team</a>
          </div>
          <br>
          <br>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-lg-8 text-center">
        <h2 class="text-white mt-0">Institutions</h2>
        <br>
        <img src="tpl/img/upf_logo.png" alt="upf logo" width="40%">
      </div>
    </div>
  </div>
</section>
  <!-- Portfolio Section
  <section id="portfolio">
    <div class="container-fluid p-0">
      <div class="row no-gutters">
      	<?php
      		$category = 'Exemple';
      		print portfolio_view('#top','tpl/img/exemples/1.jpg','Example1',$category,'Example 1');
      		print portfolio_view('#top','tpl/img/exemples/2.jpg','Example2',$category,'Example 2');
      		print portfolio_view('#top','tpl/img/exemples/3.jpg','Example3',$category,'Example 3');
      		print portfolio_view('#top','tpl/img/exemples/4.jpg','Example4',$category,'Example 4');
      	?>
      </div>
    </div>
  </section>-->

  <?php print(page_footer($_SESSION['pagename']));
