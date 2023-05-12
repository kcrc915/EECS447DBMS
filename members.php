<!DOCTYPE html>
<?php
session_start();

error_reporting(0);
//$servername = "localhost";
//$username = "root";
//$password = "";
//$db='eecs447';
// Create connection
$conn = new mysqli($_SESSION['servername'], $_SESSION['username'], $_SESSION['password'],$_SESSION['db']);
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>

<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Library - Members</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="mainframe">
  <div id="header">
    <label id="title">Library Management System</label>
  </div>
  <div id="links_row">
    <a id="books_link" class="links" href="book.php">Books</a>
    <a id="members_link" class="links" href="members.php">Members</a>
    <a id="borrowing_link" class="links" href="borrowing.php">Borrowing history</a>
	<a id="branches_link" class="links" href="branch.php">Branch</a>
	
  </div>
  <form id="members_form" name="members_input" method="get" action="">
    <label for="members_input" style="margin: 0 5px">Search Member</label>
    <input class="inputBox" id="members_input" type="text" name="members_search" placeholder="Search">
    <input type="submit" id="members_submit" value="Go"/>
  </form>
  <div id="results">
    <table border='1'>
	<tr>
      <td>Member ID</td>
      <td>Name</td>
      <td>Address</td>
      <td>Email</td>
      <td>Phone Number</td>
      
    </tr>
    <?php
    $sql = "select * from members;";
			
	$result = mysqli_query($conn,$sql);
	#$result = $conn->query($sql);
	#if($result->num_rows > 0){
	if(mysqli_num_rows($result) > 0){
		while($row = $result->fetch_assoc()){
			echo "<tr>".
				"<td>" . $row["member_ID"]."</td>".
				"<td>" . $row["name"]."</td>".
				"<td>" . $row["address"]."</td>".
				"<td>" . $row["email"]."</td>".
				"<td>" . $row["phone_number"]."</td>".
				
				
				"</tr>";
		}
	}
		
	?> 
  </table>
</div>
</body>
</html>