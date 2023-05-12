<?php
session_start();
$_SESSION['servername'] = 'localhost';
$_SESSION['username'] = 'root';
$_SESSION['password'] = '';
$_SESSION['db'] = 'eecs447';
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
    <title>Library - Books</title>
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
        <form id="book_form" name="book_input" method="get" action="book.php">
            <label for="book_input" style="margin: 0 5px">Search Books</label>
            <input class="inputBox" id="book_input" type="text" name="book_search" placeholder="Search">
            <input type="submit" id="book_submit" value="Go"/>
			<label for='search_type' style='margin: 0 10px'>Search By</label>
			<input type='radio' class='radios' name='search_type' value='Title' id='bktitle' checked=true>
			<label for='bktitle'>Title</label>
			<input type='radio' class='radios' name='search_type' value='Author' id='bkauthor'>
			<label for='bkauthor'>Author</label>
			<input type='radio' class='radios' name='search_type' value='Genre' id='bkgenre'>
			<label for='bkgenre'>Genre</label>
			<input type='radio' class='radios' name='search_type' value='ISBN' id='bkisbn'>
			<label for='bkisbn'>ISBN</label>
			<input type='radio' class='radios' name='search_type' value='Branch' id='bkbranch'>
			<label for='bkbranch'>Branch</label>
			</form>
        <div id="results">
            
			<?php
			$counter=0;
			$searchBy='title';
			$book_search = $_GET['book_search'];
			#print('book'.$book_search);
			$sql = "select * from books";
			if(strlen($book_search)>0){
				$counter=1;
				$searchBy=$_GET['search_type'];
				
				if($searchBy == 'Branch'){
					
				$sql="SELECT b.title AS book_title, b.author, b.quantity, br.Name AS branch_name
				FROM Books b
				JOIN Branches br ON b.Branch_ID = br.Branch_ID
				WHERE b.Branch_ID = ". $book_search;}
				else if($searchBy == 'Title'){
				$sql="SELECT b.title AS book_title, b.author, b.quantity, br.Name AS branch_name
				FROM Books b
				JOIN Branches br ON b.Branch_ID = br.Branch_ID
				WHERE b.title ='".$book_search."'";	}
				else if($searchBy=='Genre'){
				$sql="SELECT b.title AS book_title, b.author, b.quantity, br.Name AS branch_name
				FROM Books b
				JOIN Branches br ON b.Branch_ID = br.Branch_ID
				WHERE b.genre = '".$book_search."'";
				}
				else if($searchBy=='ISBN'){
				$sql="SELECT b.title AS book_title, b.author, b.quantity, br.Name AS branch_name
				FROM Books b
				JOIN Branches br ON b.Branch_ID = br.Branch_ID
				WHERE b.ISBN ='".$book_search."'";}
				
					
			}
			echo "<table border='1' >";
			if($counter==0){
				echo " <tr>
                <td>ISBN</td>
                <td>Title</td>
                <td>Author</td>
                <td>Publisher</td>
                <td>Date published</td>
                <td>genre</td>
                <td>Quantity</td>
                <td>Branch</td>
            </tr>";
			}
			else{
				echo " <tr>
                <td>Title</td>
                <td>Author</td>
                <td>Quantity</td>
                <td>Branch</td>
				</tr>";
			}
			
			$result = mysqli_query($conn,$sql);
			#$result = $conn->query($sql);
			#if($result->num_rows > 0){
			if(mysqli_num_rows($result) > 0){
				while($row = $result->fetch_assoc()){
					if($counter==0){
					echo "<tr>".
						"<td>" . $row["ISBN"]."</td>".
						"<td>" . $row["title"]."</td>".
						"<td>" . $row["author"]."</td>".
						"<td>" . $row["publisher"]."</td>".
						"<td>" . $row["publication_date"]."</td>".
						"<td>" . $row["genre"]."</td>".
						"<td>" . $row["quantity"]."</td>".
						"<td>" . $row["Branch_ID"]."</td>".
						"</tr>";
					}
					else{
					echo "<tr>".
						"<td>" . $row["book_title"]."</td>".
						"<td>" . $row["author"]."</td>".
						"<td>" . $row["quantity"]."</td>".
						"<td>" . $row["branch_name"]."</td>".
						"</tr>";
					}
				}
				$counter=0;
			}
			echo "</table>";
				
			?>
  
        </div>
    </div>
</body>
</html>