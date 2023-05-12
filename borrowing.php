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
  <title>Library - Borrowing</title>
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
  <form id="borrowing_form" name="borrowing_input" method="get">
    <label for="borrowing_input" style="margin: 0 5px">Search History</label>
    <input class="inputBox" id="borrowing_input" type="text" name="borrowing_search" placeholder="Search">
    <input type="submit" id="borrowing_submit" value="Go"/>
  </form>
    <table border='1'>
	<tr>
      <td>Member Name</td>
      <td>Book Title</td>
      <td>Borrow Date</td>
      <td>Due Date</td>
      <td>Return Date</td>
      
    </tr>
    <?php
    $sql = "SELECT m.name AS member_name, b.title AS book_title, bh.borrow_date, bh.due_date, bh.return_date
			FROM Borrowing_History bh
			JOIN Members m ON bh.member_ID = m.member_ID
			JOIN Books b ON bh.book_ISBN = b.ISBN;";
			
	$result = mysqli_query($conn,$sql);
	#$result = $conn->query($sql);
	#if($result->num_rows > 0){
	if(mysqli_num_rows($result) > 0){
		while($row = $result->fetch_assoc()){
			echo "<tr>".
				"<td>" . $row["member_name"]."</td>".
				"<td>" . $row["book_title"]."</td>".
				"<td>" . $row["borrow_date"]."</td>".
				"<td>" . $row["due_date"]."</td>".
				"<td>" . $row["return_date"]."</td>".
				
				"</tr>";
		}
	}
		
	?>   
</table>	
</div>
</body>
</html>