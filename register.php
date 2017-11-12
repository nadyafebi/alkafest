<?php
  require_once 'lib/swift_required.php';

  // Variables.
  $host = "";
  $username = "";
  $password = "";
  $dbname = "";
  $mailhost = "";
  $mailaddress = "";
  $maillpassword = "";
  $name = $_POST["userName"];
  $email = $_POST["userEmail"];
  $maximumTicket = 370;

  // Connect to database.
  $mysqli = new mysqli($host, $username, $password, $dbname);

  if ($mysqli->connect_errno) {
    echo "Errno: " . $mysqli->connect_errno . "\n";
    echo "Error: " . $mysqli->connect_error . "\n";
  }

  // Check maximum ticket number.
  $sql = "SELECT MAX(`ID`) AS maxID FROM `user`;";
  $result = $mysqli->query($sql);
  $row = $result->fetch_assoc();

  if ($row[maxID] < $maximumTicket) {
    $result->free();

    // Generate random ticket number.
    do {
      $ticketNum = mt_rand(10000000, 100000000);
      $sql = "SELECT *  FROM `user` WHERE `NoTiket` = '$ticketNum'";
      $checker = 0;

      $result = $mysqli->query($sql);

      if ($result->num_rows > 0) {
        $checker = 1;
      }

      $result->free();

    } while ($checker == 1);

    // Insert data to database.
    $sql = "INSERT INTO $dbname.`user` (`ID`, `NoTiket`, `Nama`, `Email`, `Status`) VALUES (NULL, '$ticketNum', '$name', '$email', '0');";

    if (!$result = $mysqli->query($sql)) {
      echo "Sorry, the website is experiencing problems.";

      echo "Error: Our query failed to execute and here is why: \n";
      echo "Query: " . $sql . "\n";
      echo "Errno: " . $mysqli->errno . "\n";
      echo "Error: " . $mysqli->error . "\n";
    }

    // EMAIL SYSTEM

    // Create the SMTP configuration.
    $transport = Swift_SmtpTransport::newInstance($mailhost, 465, "ssl");
    $transport->setUsername($mailaddress);
    $transport->setPassword($mailpassword);

    // Create the message.
    $message = Swift_Message::newInstance();
    $message->setTo(array(
      "$email" => "$name"
    ));
    $message->setSubject("Tiket Alkafest");
    $message->setBody("<p>Halo $name!</p><p>Nomor tiket anda adalah <b>$ticketNum</b>.</p><p>Tunjukkan email ini ke loket Pre-Sale di hari H.</p>", "text/html");
    $message->setFrom($mailaddress, "Alkafest");

    // Send the email.
    $mailer = Swift_Mailer::newInstance($transport);
    $mailer->send($message);
  }
  else {
    echo "SOLDOUT";
  }

  // Close database connection.
  $mysqli->close();
?>
