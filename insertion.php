<?PHP
include('dbconnect.php');
$table = mysqli_real_escape_string($link, stripslashes($_POST['table']));
if (!$table) {
	echo "Error getting POST data.<br>";
	echo '<a href="index.html">Return to home page</a>';
}
else {
	$query = "SELECT COUNT(*) FROM Individual";
	$result = mysqli_query($link, $query);
	$row = mysqli_fetch_row($result);
	if ($row[0] <= 0 && $table != "Individual") {
		echo "Must have at least one entry in Individual TABLE to reference for foreign key.<br>";
		echo '<a href="index.html">Return to home page</a>';
	}
	else {
		echo '<form action="insertion-submit.php" method="post">';
		echo '<input name="table" type="hidden" value="' . $table . '"/>';
		if ($table == "Individual") {
			echo 'id: ';
			echo '<input name="id" type="text"/>';
			echo '<br/>';
			echo 'name: ';
			echo '<input name="name" type="text"/>';
			echo '<br/>';
			echo 'email: ';
			echo '<input name="email" type="text"/>';
			echo '<br/>';
			echo 'bond: ';
			echo '<input name="bond" type="text"/>';
			echo '<br/>';
			echo 'major: ';
			echo '<input name="major" type="text"/>';
			echo '<br/>';
			echo 'graduate: ';
			echo '<input name="graduate" type="date">';
			echo '<br/>';
			echo 'dues: ';
			echo '<input name="dues" type="text"/>';
			echo '<br/>';
			echo 'service: ';
			echo '<input name="service" type="text"/>';
			echo '<br/>';
			echo 'philanthropy: ';
			echo '<input name="philanthropy" type="text"/>';
		}
		elseif ($table == "") {
			
		}	
		echo '<br/>';
		echo '<button type="submit">Insert</button>';
		echo '</form>';
	}
}

?>