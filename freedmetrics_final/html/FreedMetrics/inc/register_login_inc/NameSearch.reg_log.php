<?php

// This variable gets the current value in the Name input on login.php
  $searchTerm = $_GET['term'];

// Database query
  $query = $conn->query("SELECT name FROM Persons WHERE name LIKE '%".$searchTerm."%' ORDER BY name ASC");

// Array of the results and encoding into json in order to pass it to the autocomplete function
  $alldata = array();
  if ($query->num_rows>0){
    while ($row = $query->fetch_assoc()){
      $data['value'] = $row['name'];
      array_push($alldata, $data);
    }
  }
  echo json_encode(array_slice($alldata, 0, 6));
