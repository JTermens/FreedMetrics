<?php
#include_once("$search_incDir/check_and_search.search.php");

function user_history($user_email){
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	##database connection##

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
	####

	$query = "SELECT Article_source_id FROM Persons_has_Article WHERE Persons_email ='" . $user_email . "'";
	$result = $conn->query($query);

	$articles = array();
	$count = 0;
	
	if ($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$authors_array = array();
			$count_authors = 0;
	        $query = "SELECT * FROM Article WHERE source_id ='" . $row["Article_source_id"] . "'";
	        $authors_query = "SELECT Persons_email FROM Persons_has_Article WHERE is_author = True AND Article_source_id = '" . $row["Article_source_id"] . "'";
	        
	        $authors = $conn->query($authors_query);
	        while($author = $authors->fetch_assoc()) {
	        	$authors_array[$count_authors] = $author['Persons_email'];
	        	$count_authors++;
	        }

			$article = $conn->query($query);
			$article_array = $article->fetch_assoc();
			$article_array['authors'] = $authors_array;
			$articles[$count] =  $article_array;
			$count++;
		}
	}
	return $articles;
}

#user_history("b@b")

?>