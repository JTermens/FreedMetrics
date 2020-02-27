<?php

$header = "FreedMetrics";
$subheader = "A free and open website of scientific article analytics.";
?>

<body>
<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-light fixed-top py-3" id="mainNav">
  <div class="container">
    <img src="<?php print $logo_no_bg; ?>" alt="logo" width="5%"> 
    <a class="navbar-brand js-scroll-trigger" href="index.php?pagename=Home">Freedmetrics</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarResponsive">
      <ul class="navbar-nav ml-auto my-2 my-lg-0">
        <li class="nav-item">
          <a class="nav-link js-scroll-trigger" href="index.php?pagename=Login">LOGIN & REGISTER</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
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
          <p class="text-white-50 mb-4">FreedMetrics will give you the metadata as well as alt-metrics for the large pool of articles present on arXiv and Pubmed (by now). Give it a try and <a href="index.php?pagename=Register" style="color: white; font-weight: bold;">Register</a> for more tools.</p>
          <form action="index.php?pagename=search-results" id="input_search" name="input_search" method="POST" enctype="multipart/form-data">
            <div class="d-flex justify-content-center h-100">
              <div class="searchbar">
                <input class="search_input" type="text" name="search_query" placeholder="Enter the article's title, or doi, or author, or ...">
                <a href="index.php?pagename=search-results" class="search_icon"><i class="fas fa-search"></i></a>
              </div>
            </div>
          </form>
          <br>
          <p class="text-white-50 mb-4">Do you want a more precise search? Try the <a href="index.php?pagename=Advanced-Search" style="color: white; font-weight: bold;">Advanced Search</a> tool.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Portfolio Section -->
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
  </section>