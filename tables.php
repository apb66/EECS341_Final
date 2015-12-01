<a href="index.html">Return Home</a>
<?PHP
include('dbconnect.php');

$tables = array(
	"0" => "Individual",
	"1" => "Attendance",
	"2" => "Service",
	"3" => "Philanthropy",
	"4" => "Officer",
);
foreach ($tables as $table) {
	echo "<h2>$table:</h2>";
	echo "<table>";
	$query = "SELECT * FROM $table";
	$result = mysqli_query($link, $query);
	if ($result) {
		while ($row = mysqli_fetch_assoc($result)) {
			echo "<tr>";
			foreach ($row as $cell) {
				echo "<td>$cell</td>";
			}
			echo "</tr>";
		}
	}
	echo "</table>";
}
?>