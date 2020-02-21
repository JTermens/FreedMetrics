<?php

include "search_parsers.inc.php";

$servername = "localhost";
$dbusername = "TestUser";
// IMPORTANT, NEXT VARIABLE WILL HAVE TO CONTAIN THE PASSWORD FOR THE DATABASE (IF THERE IS NONE, LEAVE EMPTY)
$dbpassword = "123456789_AbC";
$dbname = "freedmetrics";

// Create connection
$conn = mysqli_connect($servername, $dbusername, $dbpassword, $dbname);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$user_query = $_GET["user_query"];

$arxiv_entries = arxiv_search($user_query,'ti');
$pubmed_entries = pubmed_search($user_query,'title');
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
 <head>
    <meta charset="utf-8">
    <title><?php echo $user_query;?> Search Page</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css "href="style_scroll.css">
    <link rel="stylesheet" href="DataTable/jquery.dataTables.min.css"/>
        <script type="text/javascript" src="DataTable/jquery-2.2.0.min.js"></script>
        <script type="text/javascript" src="DataTable/jquery.dataTables.min.js"></script>
  </head>
  <body>
    <div class="container">
      <div class="card border-0 shadow my-5">
        <div class="card-body p-5">
            <h4 class="font-weight-light">Search Results of: <?php echo $user_query;?></h4>
            <h5 style="text-align:left">ArXiv Results</h5>
            <?php if(empty($arxiv_entries)){ ?>
              <h6> <?php print "No results found on ArXiv"; ?> </h6>
            <?php }else{ ?>
            <table border="0" cellspacing="2" cellpadding="4" id="dataTable">
              <thead>
                  <tr>
                     <th><b>Title</b></th>
                      <th><b>Authors</b></th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach($arxiv_entries as $arxiv_entry) { ?>
                      <tr>
                          <td><a href= <?php if (empty($arxiv_entry['doi'])) {
                            print '"'.$arxiv_entry['link'].'"';
                          }else{
                            print '"http://dx.doi.org/'.$arxiv_entry['doi'].'"';
                          };?> 
                          rel=\"noopener noreferrer\" target="_blank">
                          <h6><?php print $arxiv_entry['title'];?></h6></a></td>
                          <td><?php foreach ($arxiv_entry['authors'] as $author) {
                            print $author.', ';
                         }; ?></td>
                      </tr>
                  <?php }; ?>
              </tbody>
            </table>
            <?php }; ?>
            <h5 style="text-align:left">PubMed Results</h5>
            <?php if(empty($pubmed_entries)){ ?>
              <h6> <?php print "No results found on PubMed"; ?> </h6>
            <?php }else{?>
            <table border="0" cellspacing="2" cellpadding="4" id="dataTable">
              <thead>
                  <tr>
                     <th><b>Title</b></th>
                      <th><b>Authors</b></th>
                  </tr>
              </thead>
              <tbody>
                  <?php foreach($pubmed_entries as $pubmed_entry) { ?>
                      <tr>
                          <td><a href= <?php print '"http://dx.doi.org/'.$pubmed_entry['doi'].'"';?> rel="noopener noreferrer" target="_blank">
                            <h6><?php print $pubmed_entry['title'];?></h6></a></td>
                          <td><?php foreach ($pubmed_entry['authors'] as $author) {
                            print $author.', ';
                         }; ?></td>
                      </tr>
                  <?php }; ?>
              </tbody>
            </table>
          <?php }; ?>

            <a href="index.php?new=1">
              <button type="button" name="Login_btn" class="btn btn-primary" style="text-align:center;">New Search</button>
            </a>
          </div>
        </div>
      </div>
    </div>
     <script type="text/javascript">
       <!-- this activates the DataTable element when page is loaded-->
            $(document).ready(function () {
                $('#dataTable').DataTable();
            });
    </script>
  </body>
</html>