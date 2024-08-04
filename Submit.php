<!DOCTYPE html>
<html>
<head>
  <style>
    body {
      background-color: lightgrey;
      background-image: linear-gradient(#ffff99, #f1e68c);
      padding: 20px;
      text-align: justify;
      font-size: 20px;
      color: blue;
      overflow-y: scroll;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      font-size: 24px;
      padding: 15px;
      text-align: left;
    }
    th {
      background-color: #4CAF50;
      color: white;
    }
    tr:nth-child(even) {
      background-color: lightblue;
    }
    tr:nth-child(odd) {
      background-color: silver;
    }
    tr:hover {
      background-color: #4aae66;
      color: white;
    }
    button {
      font-size: 30px;
      background-color: green;
      color: black;
      padding: 10px 20px;
      border: none;
      cursor: pointer;
    }
    button:hover {
      background-color: darkgreen;
      color: white;
    }
  </style>
</head>
<body>
  <?php
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "userinput";

  // Create connection
  $con = mysqli_connect($servername, $username, $password);

  // Check connection
  if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
  }

  // Create database if not exists
  $createdb = "CREATE DATABASE IF NOT EXISTS userinput";
  mysqli_query($con, $createdb);

  // Select database
  mysqli_select_db($con, $dbname);

  // Create table if not exists
  $createtb = "CREATE TABLE IF NOT EXISTS userdata (
    name VARCHAR(30),
    email VARCHAR(100),
    text1 LONGTEXT
  )";
  mysqli_query($con, $createtb);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'], $_POST['email'], $_POST['text1'])) {
    // Process form submission
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $text1 = mysqli_real_escape_string($con, $_POST['text1']);

    // Insert data into database
    $insertquery = "INSERT INTO userdata (name, email, text1) VALUES ('$name', '$email', '$text1')";
    if (mysqli_query($con, $insertquery)) {
        echo "<p>Welcome <big>$name</big></p>";
        echo "<p>Dear Sir/Madam, Greetings! Thank you for your feedback. We appreciate your input and look forward to serving you again. For any assistance, feel free to contact us.</p>";
    } else {
        echo "<p>Error inserting data: " . mysqli_error($con) . "</p>";
    }
}


  // Display stored data in table
  $result = mysqli_query($con, "SELECT DISTINCT * FROM userdata");
  $rowcount = mysqli_num_rows($result);

  if ($rowcount > 0) {
    echo "<table border='1'>
            <tr>
              <th>Name</th>
              <th>Comment</th>
            </tr>";
    while ($row = mysqli_fetch_array($result)) {
      echo "<tr>
              <td>".$row['name']."</td>
              <td>".$row['text1']."</td>
            </tr>";
    }
    echo "</table>";
  } else {
    echo "<p>No comments yet.</p>";
  }

  mysqli_close($con);
  ?>

  <hr>

  <form action="try.html" method="get">
    <p style="text-align: center; margin: 20px;">
      <button><b>Go Back</b></button>
    </p>
  </form>
</body>
</html>
