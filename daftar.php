<?php
  // Variables.
  $host = "";
  $username = "";
  $password = "";
  $dbname = "";

  // Connect to database.
  $mysqli = new mysqli($host, $username, $password, $dbname);

  if ($mysqli->connect_errno) {
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
  }

  // Get number of tickets in the database.
  $sql = "SELECT MAX(`ID`) AS maxID FROM `user`;";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();

  echo "<p><b>Jumlah yang terdaftar:</b> $row[maxID]</p>";

  $result->free();

  // Create table with tickets information.
  $sql = "SELECT * FROM `user`;";
  $result = $mysqli->query($sql);

  if ($result->num_rows > 0) {
    echo "<table><tr><th>ID</th><th>Nomor Tiket</th><th>Nama</th><th>Email</th><th>Sudah dipakai?</th></tr>";
    // Output data of each row
    while($row = $result->fetch_assoc()) {
      echo "<tr><td>$row[ID]</td><td>$row[NoTiket]</td><td>$row[Nama]</td><td>$row[Email]</td>";
      if ($row["Status"] == 1) {
        echo "<td>Sudah</td></tr>";
      } else {
        echo "<td>Belum</td></tr>";
      }
    }
    echo "</table>";
  } else {
    echo "Not Found";
  }

  $result->free();

  // Close database connection.
  $mysqli->close();
?>
