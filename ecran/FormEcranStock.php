<?php require 'navc.php' ; ?>
<!DOCTYPE html>
<html>
<head>
  <title>Add New ecran Stock</title>
  <style>
    form {
  width: 50%;
  margin: auto;
  font-family: Arial, sans-serif;
  background-color: #f2f2f2;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
}

h1 {
  text-align: center;
}

label {
  display: block;
  margin-bottom: 10px;
  font-weight: bold;
}

input[type="text"],
input[type="date"],
select {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 5px;
  margin-bottom: 20px;
  box-sizing: border-box;
}

input[type="submit"] {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

input[type="submit"]:hover {
  background-color: #3e8e41;
}

  </style>
</head>
<body>
  <h1>Add New Ram Stock</h1>
  <form action="FormEcranStock.php" method="POST">
    <label for="num_serie">num_serie:</label>
    <input type="text" name="rnum_serie" required><br><br>
    <label for="modele">modele:</label>
    <input type="text" name="modele" required><br><br>
    <label for="etat">Etat:</label>
    <select name='etat'>
        <option>in stock</option>
    </select><br><br>
    <label for="marque">marque:</label>
    <input type="text" name="marque" required><br><br>
    <label for="caracteristique">caracteristique:</label>
    <input type="text" name="caracteristique" required><br><br>
    <label for="date_added">Date added:</label>
    <input type="date" name="date_added"><br><br>
    <input type="submit" value="Add PC Stock">
  </form>
</body>
</html>
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "circet1";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
error_reporting(0);
			ini_set('display_errors', 0);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO ecran_stock (rnum_serie,modele,etat,marque,date_added , caracteristique) VALUES (?, ?, ?, ?, NOW(),?)");

// Bind paecraneters to statement
$stmt->bind_param("sssss" ,$rnum_serie,$modele,$etat,$marque,$caracteristique);

// Set variables with form input values
$rnum_serie = $_POST["rnum_serie"];
$modele = $_POST["modele"];
$etat = $_POST["etat"];
$marque = $_POST["marque"];
$date_added = $_POST["date_added"];
$caracteristique = $_POST['caracteristique'];

// Check if code bar already exists in pcstock table
$check_pcstock_stmt = $conn->prepare("SELECT rnum_serie FROM ecran_stock WHERE rnum_serie = ?");
$check_pcstock_stmt->bind_param("s", $rnum_serie);
$check_pcstock_stmt->execute();
$check_pcstock_result = $check_pcstock_stmt->get_result();

// Check if code bar already exists in pcfermerstock table
$check_pcfermerstock_stmt = $conn->prepare("SELECT rnum_serie FROM ecran_stock_fermer WHERE rnum_serie = ?");
$check_pcfermerstock_stmt->bind_param("s", $rnum_serie);
$check_pcfermerstock_stmt->execute();
$check_pcfermerstock_result = $check_pcfermerstock_stmt->get_result();

if ($check_pcstock_result->num_rows > 0) {
  // Code bar already exists in pcstock table, display error message
  echo "Error: code bar already exists in ecran stock.";
} elseif ($check_pcfermerstock_result->num_rows > 0) {
  // Code bar already exists in pcfermerstock table, display error message
  echo "Error: code bar already exists in ecran fermer stock.";
} else {
  // Code bar does not exist in any table, execute insert query
  if ($stmt->execute()) {
    header("Location: liste_ecran.php");
  } else {
    echo "Error: " . $stmt->error;
  }
}

// Close prepared statements and database connection
$stmt->close();
$check_pcstock_stmt->close();
$check_pcfermerstock_stmt->close();
$conn->close();

?>

    
