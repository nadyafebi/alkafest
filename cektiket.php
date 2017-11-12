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

  // Get information from ticket number.
  $sql = "SELECT * FROM  `user` WHERE `NoTiket`=$tiket;";
  $result = $mysqli->query($sql);

  // Output information.
  if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
      echo "<p><b>Nomor Tiket:</b> $row[NoTiket]</p><p><b>Nama:</b> $row[Nama]</p><p><b>Email:</b> $row[Email]</p><p><b>Status:</b> ";
      if ($row[Status] == 0)
      {
        echo "Belum Masuk</p>";
      } else {
        echo "Sudah Masuk</p>";
      }
    }
  } else {
    echo "NORESULT";
  }

  $result->free();

  // Close database connection.
  $mysqli->close();
?>
