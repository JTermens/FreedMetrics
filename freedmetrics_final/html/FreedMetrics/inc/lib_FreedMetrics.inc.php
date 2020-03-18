<?php

function page_head($pagename,$title){

  global $logo_no_bg;
  global $pagename_ref;

  $navbar_ref = array(
  'search_bar' => "<form action=\"index.php?pagename=Search-Results&action=new\" id=\"search_query\" name=\"search_query\" method=\"POST\" enctype=\"multipart/form-data\">
            <div class=\"d-flex justify-content-center h-100\">
              <li class=\"nav-item\">
                <input class=\"nav-link js-scroll-trigger nav-search\" type=\"text\" name=\"search_input1\" placeholder=\"Search article\">
                <input type=\"hidden\" name=\"field1\" value=\"all\">
                <input type=\"hidden\" name=\"num_conditions\" value=\"1\">
              </li>
              <li class=\"nav-item\">
                <button type=\"submit\" class=\"nav-link js-scroll-trigger\" style=\"background: transparent; border: 0px;\"><i class=\"fas fa-search\"></i></button>
              </li>
            </div>
          </form>",

  'Advanced Search' => "<li class=\"nav-item\">
            <a class=\"nav-link js-scroll-trigger\" href=\"index.php?pagename=Advanced-Search\">Advanced Search</a>
          </li>",

  'Personal Zone' => "<li class=\"nav-item\">
            <a class=\"nav-link js-scroll-trigger\" href=\"index.php?pagename=User-Page\">Personal Zone</a>
          </li>",

  'LOGOUT' => "<li class=\"nav-item\">
            <a class=\"nav-link js-scroll-trigger\" href=\"index.php?pagename=Logout\">LOGOUT</a>
          </li>",

  'LOGIN & REGISTER' => "<li class=\"nav-item\">
            <a class=\"nav-link js-scroll-trigger\" href=\"index.php?pagename=Login\">LOGIN & REGISTER</a>
          </li>",);

	$header = "<!DOCTYPE html>
    <html lang=\"en\">

    <head>

      <meta charset=\"utf-8\">
      <meta name=\"viewport\" content=\"width=device-width, initial-scale=1, shrink-to-fit=no\">
      <meta name=\"description\" content=\"FreedMetrics is a free and open website of scientific article analytics.\">
      <meta name=\"author\" content=\"Oscar Camacho, Miguel Luengo, David Sotillo and Joan Termens\">

      <title>$title</title>

      <!-- Bootstrap core CSS -->
      <link rel=\"stylesheet\" href=\"https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css\">

      <!-- Custom fonts for this template
      <link href='https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic' <link href=\"https://fonts.googleapis.com/css?family=Merriweather+Sans:400,700\" rel=\"stylesheet\">
      <link href='https://fonts.googleapis.com/css?family=Merriweather:400,300,300italic,400italic,700,700italic' rel='stylesheet' type='text/css'> -->

      <!-- Font Awesome Icons -->
      <link href=\"tpl/vendor/fontawesome-free/css/all.css\" rel=\"stylesheet\">

      <!-- Datatable css -->
      <link rel=\"stylesheet\" href=\"tpl/vendor/DataTable/jquery.dataTables.min.css\"/>

      <!-- Custom styles for this template -->
      <link href=\"tpl/css/creative.css\" rel=\"stylesheet\">
    </head>
    <body";

    if (($pagename == 'Login') or ($pagename == 'Article-Page') or ($pagename == 'Advanced-Search') or ($pagename == 'ForgotPassword') or ($pagename == 'PasswordChange')  or ($pagename == 'About-us')){
      $header .= " class=\"full-image\"";
    }

    $header .=">
      <!-- Navigation -->
      <nav class=\"navbar navbar-expand-lg navbar-light fixed-top py-3\" id=\"mainNav\">
        <div class=\"container\">
           <img src=\"$logo_no_bg\" alt=\"logo\" width=\"5%\">
          <a class=\"navbar-brand js-scroll-trigger\" href=\"index.php?pagename=Home\">Freedmetrics</a>
          <button class=\"navbar-toggler navbar-toggler-right\" type=\"button\" data-toggle=\"collapse\" data-target=\"#navbarResponsive\" aria-controls=\"navbarResponsive\" aria-expanded=\"false\" aria-label=\"Toggle navigation\">
            <span class=\"navbar-toggler-icon\"></span>
          </button>
          <div class=\"collapse navbar-collapse\" id=\"navbarResponsive\">
            <ul class=\"navbar-nav ml-auto my-2 my-lg-0\">";

  foreach ($pagename_ref[$pagename]['navbar_tags'] as $nav_item) {
    $header .= $navbar_ref[$nav_item];
  }

  $header .= "</ul></div></div></nav>";

  return $header;
}


function page_header($header,$subheader){
  global $logo_no_bg;

  return "<!-- Page Header -->
  <header class=\"masthead_page\">
    <div class=\"container\">
      <div class=\"row\">
        <div class=\"col-lg-8 col-md-10 mx-auto\">
          <div class=\"page-heading\">
            <h1>$header</h1>
            <span class=\"subheading\">$subheader</span>
          </div>
        </div>
      </div>
    </div>
  </header>";
}

function portfolio_view($link,$img_route,$img_alt,$category,$name){
  return "<div class=\"col-lg-3 col-sm-6\">
          <a class=\"portfolio-box\" href=\"$link\">
            <img class=\"img-fluid\" src=\"$img_route\" alt=\"$img_alt\">
            <div class=\"portfolio-box-caption p-3\">
              <div class=\"project-category text-white-50\">
                $category
              </div>
              <div class=\"project-name\">
                $name
              </div>
            </div>
          </a>
        </div>";
}

function page_footer($pagename){

  global $lg_width;
  global $md_width;
  global $conn;

	$footer = "<!-- Footer -->
  <footer>
    <div class=\"container\">
      <div class=\"row\">
        <div class=\"col-lg-$lg_width col-md-$md_width mx-auto\">
          <ul class=\"list-inline text-center\">
            <li class=\"list-inline-item\">
              <a href=\"https://twitter.com/FreedMetrics\" rel=\"noopener noreferrer\" target=\"_blank\">
                <span class=\"fa-stack fa-lg\">
                  <i class=\"fas fa-circle fa-stack-2x\"></i>
                  <i class=\"fab fa-twitter fa-stack-1x fa-inverse\"></i>
                </span>
              </a>
            </li>
            <li class=\"list-inline-item\">
              <a href=\"https://github.com/JTermens/FreedMetrics/\" rel=\"noopener noreferrer\" target=\"_blank\">
                <span class=\"fa-stack fa-lg\">
                  <i class=\"fas fa-circle fa-stack-2x\"></i>
                  <i class=\"fab fa-github fa-stack-1x fa-inverse\"></i>
                </span>
              </a>
            </li>
          </ul>
          <br>
          <p class=\"copyright text-muted\">Copyright &copy; FreedMetrics Website ".date("Y")."</p>
        </div>
      </div>
    </div>
  </footer>
  <!-- Bootstrap core JavaScript  -->
  <script src=\"tpl/vendor/jquery/jquery.min.js\"></script>
  <script src=\"tpl/vendor/bootstrap/js/bootstrap.bundle.min.js\"></script>
  <!-- MathJax -->
  <script src=\"https://polyfill.io/v3/polyfill.min.js?features=es6\"></script>
  <script id=\"MathJax-script\" async src=\"https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js\"></script>
  <!-- Custom scripts for this template -->
  <script src=\"tpl/js/creative.js\"></script>";

  if (in_array($pagename, array('User-Page','Search-Results'))) {

    $footer .= "<script type=\"text/javascript\" src=\"tpl/vendor/DataTable/jquery-2.2.0.min.js\"></script>
    <script type=\"text/javascript\" src=\"tpl/vendor/DataTable/jquery.dataTables.min.js\"></script>";

    if ($pagename == 'Search-Results') {
      $footer .= "
      <script type=\"text/javascript\">
      $(document).ready(function () {
          $('#table_arXiv').DataTable({
            ordering: false
          });
      });
      </script>
      <script type=\"text/javascript\">
        $(document).ready(function () {
            $('#table_PubMed').DataTable({
              ordering: false
            });
        });
      </script>
      <script type=\"text/javascript\">
        $(document).ready(function () {
            $('#table_FreedMetrics').DataTable({
              ordering: false
            });
        });
      </script>";
    }elseif ($pagename == 'User-Page') {
      $footer .= "<script type=\"text/javascript\">
        $(document).ready(function () {
            $('#table_History').DataTable({
              ordering: false
            });
        });
      </script>";
    }
  }

  $footer .= "</body></html>";

  //mysqli_close($conn);
  return $footer;
}

function results_table($entries,$tag){

  $table = "<table border=\"0\" cellspacing=\"2\" cellpadding=\"4\" id=\"table_$tag\">
              <thead>
                <tr>
                  <th>Articles</th>
                </tr>
              </thead>
            <tbody>";

  $article_counter = 0;
  foreach($entries as $key => $entry) {
    $article_counter += 1;
    $table .= "<tr>
                  <td>
                    <h5><a href=\"index.php?pagename=Article-Page&source=$tag&article-ref=$key\" rel=\"noopener noreferrer\" target=\"_blank\">".$entry['title']."</a>";

    if($entry['doi'] != ''){
      $table .= "&nbsp<a href=\"https://dx.doi.org/".$entry['doi']."\" rel=\"noopener noreferrer\" target=\"_blank\"><span class=\"doi-label\">DOI</span></a>";
    }

    $table .= "</h5><div style= \"font-style: italic;\">";

    $author_count = 0;
    foreach ($entry['authors'] as $author) {
      $author_count += 1;
      if ($author_count >= 10) {
        $table .= "...";
        break;
      }elseif ($author_count == (count($entry['authors'])-1) ) {
        $table .= $author." and ";
      }elseif ($author_count == count($entry['authors']) ) {
        $table .= $author;
        break;
      }else{
        $table .= $author.", ";
      }
    }

    $table .="</div>
              <a class=\"btn expand\" type=\"button\" data-toggle=\"collapse\" data-target=\"#abstract$article_counter\" aria-expanded=\"false\" aria-controls=\"abstract$article_counter\" style=\"color: var(--color3)\">Abstract</a>
              <div class=\"collapse\" id=\"abstract$article_counter\">
                <div class=\"card card-body text-justify\">
                  <p>";

    if($entry['abstract'] != ''){
      $table .= $entry['abstract'];
    }
    if($entry['doi'] != ''){
      $table .= "<br><br><b>DOI: </b><a href=\"https://dx.doi.org/".$entry['doi']."\" rel=\"noopener noreferrer\" target=\"_blank\">".$entry['doi']."</a>";
    }

    $table .= "</p></div></div></td></tr>";
  }
  $table .= "</tbody></table>";

  return $table;
}

function embedd_tweet($count,$tweet_id){
  // Written by Amit Agarwal amit@labnol.org //

  print "<div id=\"tweet$count\" tweetID=\"$tweet_id\"></div>";

  print"<script>
          window.onload = (function(){
            var tweet = document.getElementById(\"tweet$count\");
            var id = tweet.getAttribute(\"tweetID\");
            twttr.widgets.createTweet(
              id, tweet,
              {
                conversation : 'none',    // or all
                cards        : 'visible',  // or hidden
                theme        : 'light'    // or dark
              })
              .then (function (el) {
                el.contentDocument.querySelector(\".footer\").style.display = \"none\";
              });
          });
        </script>";
}
