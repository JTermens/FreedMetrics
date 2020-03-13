
<?php
require 'metrics.php';
require 'twitter_metrics.php';

$keywords = array('hola', 'adios', 'venga');
$authors = array('oscar', 'joan', 'miguel');
$article_dict = array('title' => "Hallmarks of Cancer",
    'link' => 'web',
    'doi' => '10.1016/j.cell.2011.02.013',
    'journal' => 'joniIsmo',
    'publish date' => 'date',
    'abstract' => 'aquí habrá muchísimo texto',
    'authors' => $authors,
    'keywords' => $keywords,
    'source' => 'pubmed',
    'source_id' => '10647931');



function load_database($article_dict) {
$servername = "localhost";
$username = "root";
$password = "root";
$dbname = "freedmetrics";

// Create connection
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";





/////////// ARTICLE UPLOAD  ////////////

$source_id = $article_dict['source_id'];
$title = $article_dict['title'];
$abstract = $article_dict['abstract'];
$article_date = $article_dict['publish date'];
$url = $article_dict['link'];
$doi = $article_dict['doi'];

///  METRICS
$wikipedia_references = wiki_search($title);
$crossref_references = crossref_references($doi);
$readcount_mendeley = readcount_mendeley($doi);
$pubmed_citations = pubmed_citations($source_id);
$total_tweets = total_tweets("\"$title\"");
$original_tweets = original_tweets("\"$title\"");


$sql = "INSERT IGNORE INTO Article (source_id, title, abstract, article_date, url, doi, wikipedia_references, crossref_references, readcount_mendeley, pubmed_citations, total_tweets, original_tweets)
VALUES ('$source_id', '$title', '$abstract', '$article_date', '$url', '$doi', '$wikipedia_references', '$crossref_references', '$readcount_mendeley', '$pubmed_citations', '$total_tweets', '$original_tweets')";
#$conn->query($sql);
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
$article_id = $conn->insert_id; //gets the last id inserted. Id of the article




//////////// JOURNAL UPLOAD  ////////////

$journal = $article_dict['journal'];
$sql = "INSERT IGNORE INTO Journal (Name)
VALUES ('$journal')";
#$conn->query($sql);
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
$journal_id = $conn->insert_id; //gets the last id inserted. Id of the journal


//////////// ARTICLE_HAS_JOURNAL UPLOAD  ////////////

if ($journal_id) {
  $sql = "INSERT INTO Article_has_Journal (Article_article_id, Journal_automatic_id_journal)
  VALUES ('$article_id', '$journal_id')";
}
else {
  $sql = "SELECT automatic_id_journal FROM Journal WHERE Name='$journal'";
  $result = $conn->query($sql) or die($conn->error);
  $row = $result->fetch_assoc();
  $journal_id = $row['automatic_id_journal'];

  $sql = "INSERT INTO Article_has_Journal (Article_article_id, Journal_automatic_id_journal)
  VALUES ('$article_id', '$journal_id')";
}

#$conn->query($sql);
if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
  } else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }




  //////////// SOURCE UPLOAD  ////////////

  $source = $article_dict['source'];
  $sql = "INSERT IGNORE INTO source (source)
  VALUES ('$source')";
  #$conn->query($sql);
  if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";
  } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
  }
  $source_id = $conn->insert_id; //gets the last id inserted. Id of the journal


  //////////// ARTICLE_HAS_SOURCE UPLOAD  ////////////

  if ($source_id) {
    $sql = "INSERT INTO Article_has_source (Article_article_id, source_idsource)
    VALUES ('$article_id', '$source_id')";
  }
  else {
    $sql = "SELECT idsource FROM source WHERE source='$source'";
    $result = $conn->query($sql) or die($conn->error);
    $row = $result->fetch_assoc();
    $source_id = $row['idsource'];

    $sql = "INSERT INTO Article_has_source (Article_article_id, source_idsource)
    VALUES ('$article_id', '$source_id')";
  }

  #$conn->query($sql);
  if (mysqli_query($conn, $sql)) {
      echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }





  //////////// KEYWORDS AND ARTICLE_HAS KEYWORDS UPLOAD  ////////////
  /// KEYWORDS ///
  $keywords = $article_dict['keywords'];
  foreach ($keywords as $keyword) {
    $sql = "INSERT IGNORE INTO Keywords (keyword)
    VALUES ('$keyword')";
    #$conn->query($sql);
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
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
      #$conn->query($sql);
      if (mysqli_query($conn, $sql)) {
          echo "New record created successfully";
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
  }




  //////////// AUTHORS AND ARTICLE_HAS_AUTHORS UPLOAD  ////////////
  /// AUTHORS ///
  $authors = $article_dict['authors'];
  foreach ($authors as $author) {
    $sql = "INSERT IGNORE INTO Persons (name)
    VALUES ('$author')";
    #$conn->query($sql);
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
    $author_id = $conn->insert_id; //gets the last id inserted. Id of keywords

    /// ARTICLE_HAS_KEYWORDS ///
    if ($author_id) {
      $sql = "INSERT INTO Persons_has_Article (Article_article_id, Persons_person_id, is_author)   #notice the is_author is set to TRUE
      VALUES ('$article_id', '$author_id', TRUE)";
      }
    else {
      $sql = "SELECT person_id FROM Persons WHERE name='$author'";
      $result = $conn->query($sql) or die($conn->error);
      $row = $result->fetch_assoc();
      $author_id = $row['person_id'];

      $sql = "INSERT INTO Persons_has_Article (Article_article_id, Persons_person_id, is_author)   #notice the is_author is set to TRUE
      VALUES ('$article_id', '$author_id', TRUE)";
      }
      #$conn->query($sql);
      if (mysqli_query($conn, $sql)) {
          echo "New record created successfully";
        } else {
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
  }




/////  TWEET UPLOAD  /////
  $tweet_array = getArrayTweets("\"$title\"");
  foreach ($tweet_array as $items) {
      $date = $items['created_at'];
      $text = $items['full_text'];
      $author = $items['user']['name'];
      $followers = $items['user']['followers_count'];
      $retweets = $items['retweet_count'];
      $verified = $items['user']['verified'];

      if ($verified == 1) {
        $verified = TRUE;
      } else {
        $verified = FALSE;
      }

      $sql = "INSERT IGNORE INTO Tweet (date, text, author, followers, retweets, is_verified, Article_article_id)
      VALUES ('$date', '$text', '$author', '$followers', '$retweets', '$verified', '$article_id')";     #estar atento a $article_id por si hay problemas
      #$conn->query($sql);
      if (mysqli_query($conn, $sql)) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
  }



mysqli_close($conn);
}

load_database($article_dict);





?>
