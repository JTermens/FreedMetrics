<?php


function load_article_database($article_dict,$conn) {

#First check that an article is not already in the database

  $check = $conn->query("SELECT article_id FROM Article WHERE source_id=".$article_dict['source_id']);

  if($check->num_rows >0){
    $article_id = $check->fetch_assoc();
    $article_id = $article_id['article_id'];
    return $article_id;
  }

#SECOND UPLOAD SOURCE AND JOURNAL TO KNOW THEIR FOREIGN KEYS AND INSERT THEM INTO ARTICLE TABLE

    //////////// SOURCE UPLOAD  ////////////
    $source = $article_dict['source'];
    $sql = "INSERT IGNORE INTO source (source)
    VALUES ('$source')";
    $conn->query($sql);
    $source_id = $conn->insert_id; //gets the last id inserted. Id of the journal


    //////////// JOURNAL UPLOAD  ////////////
    $journal = $article_dict['journal'];
    $sql = "INSERT IGNORE INTO Journal (Name)
    VALUES ('$journal')";
    $conn->query($sql);
    $journal_id = $conn->insert_id; //gets the last id inserted. Id of the journal


    #SELECT SOURCE FOREIGN KEY FROM SOURCE TABLE
    $sql = "SELECT idsource FROM source WHERE source='$source'";
    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();
    $id_source = $row['idsource'];


    #SELECT JOURNAL FOREIGN KEY FROM JOURNAL TABLE
    $sql = "SELECT automatic_id_journal FROM Journal WHERE Name='$journal'";
    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();
    $id_journal = $row['automatic_id_journal'];


  /////////// ARTICLE UPLOAD  ////////////

  $source_id = $article_dict['source_id'];
  $title = $article_dict['title'];
  $abstract = $article_dict['abstract'];
  $article_date = $article_dict['publish_date'];
  $url = $article_dict['link'];
  $doi = $article_dict['doi'];

  $sql = "INSERT IGNORE INTO Article (source_id, title, abstract, article_date, url, doi, visits, source_idsource, Journal_automatic_id_journal)
  VALUES ('$source_id', '$title', '$abstract', '$article_date', '$url', '$doi','1', '$id_source', '$id_journal')";
  $conn->query($sql);
  $article_id = $conn->insert_id; //gets the last id inserted. Id of the article



  //////////// KEYWORDS AND ARTICLE_HAS KEYWORDS UPLOAD  ////////////
  /// KEYWORDS ///
  $keywords = $article_dict['keywords'];
  foreach ($keywords as $keyword) {
    $sql = "INSERT IGNORE INTO Keywords (keyword)
    VALUES ('$keyword')";
    $conn->query($sql);
    $keyword_id = $conn->insert_id; //gets the last id inserted. Id of keywords

    /// ARTICLE_HAS_KEYWORDS ///
    if ($keyword_id) {
      $sql = "INSERT INTO Article_has_Keywords (Article_article_id, Keywords_idKeywords)
      VALUES ('$article_id', '$keyword_id')";
      }
    else {
      $sql = "SELECT idKeywords FROM Keywords WHERE keyword='$keyword'";
      $result = $conn->query($sql) or die($conn->error);
      $row = $result->fetch_assoc();
      $keyword_id = $row['idKeywords'];

      $sql = "INSERT INTO Article_has_Keywords (Article_article_id, Keywords_idKeywords)
      VALUES ('$article_id', '$keyword_id')";
      }
      $conn->query($sql);
  }



  //////////// AUTHORS AND ARTICLE_HAS_AUTHORS UPLOAD  ////////////
  /// AUTHORS ///
  $authors = $article_dict['authors'];
  foreach ($authors as $author) {
    $sql = "SELECT * FROM Persons WHERE name = '$author'";
    $result = $conn->query($sql) or die($conn->error);
    if (!mysqli_num_rows($result)) {
      $sql = "INSERT IGNORE INTO Persons (name) VALUES ('$author')";
      $conn->query($sql);
    }
    /// ARTICLE_HAS_AUTHOR ///
    $sql = "SELECT person_id FROM Persons WHERE name='$author'";
    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();
    $author_id = $row['person_id'];

    $sql = "INSERT INTO Persons_has_Article (Article_article_id, Persons_person_id, is_author)   #notice the is_author is set to TRUE
    VALUES ('$article_id', '$author_id', 1)";
    $conn->query($sql);
  }


  return $article_id;
}

#load_database($article_dict);

// arXiv stores preprints, so when an article is published the author adds its doi.
// This function checks if an unpublished article has been published and stores its doi
function refresh_arxiv_doi($article_id, $conn){
  $base_url = 'http://export.arxiv.org/api/query?';

  # Query construction
  $query = "search_query=id:$article_id";

  $feed = file_get_contents($base_url.$query); # get xml from the api

  preg_match('/<arxiv:doi xmlns:arxiv="http:\/\/arxiv.org\/schemas\/atom">(.+?)<\/arxiv:doi>/is', $entry, $doi); # doi, if any
  
  if(!empty($doi)){
    // Upload to its corresponding article entry
    $doi = $doi[1];
    $conn->query("UPDATE Article SET doi = '$doi' WHERE article_id=$article_id");
  }
}
