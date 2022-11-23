<?Php 
$serverName = "localhost";
$username = "root";
$password = "";
$dbName = "memories";

$conn = new mysqli($serverName, $username, $password, $dbName);

if($conn->connect_error){
  die('<div class="alert alert-warning mt-3" role="alert"><h4>Connection Failed<h4>' . $conn->connect_error . '</div>');
} else {
  echo('<div class="alert alert-success mt-3" role="alert" id="connectionSuccess">Connection Successful</div>');
}
?>