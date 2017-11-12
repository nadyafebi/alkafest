<?php
  // Variables.
  $host = "";
  $username = "";
  $password = "";
  $dbname = "";
  $tiket = $_POST["NoTiket"];

  // Connect to database.
  $mysqli = new mysqli($host, $username, $password, $dbname);

  if ($mysqli->connect_errno) {
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
  }

  // Update ticket.
  $sql = "UPDATE  $dbname.`user` SET  `Status` = '1' WHERE  `user`.`NoTiket` = $tiket;";
  $mysqli->query($sql);

  // Close database connection.
  $mysqli->close();
?>
