<!DOCTYPE html>
<html>
<head>
  <title>Add New PC Stock</title>
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
button{
  font-style:none;
  width:200px;
  height:30px;
  background-color: #4CAF50;
  color: white;
  border-radius: 5px;
}
.b{
  font-style:none;
  color:black;
}
span{
  color:red;
}

  </style>
</head>
<body>
<?php require 'nav.php' ;?>
  <h1>Add New PC Stock</h1>
  <form action="FormPcStock.php" method="POST">
    <label for="codebar">N°Serie:</label>
    <input type="text" name="codebar" value="<?php echo isset($_POST['codebar']) ? $_POST['codebar'] : '' ?>" required><br><br>

    <?php
    require 'connexion.php';
    error_reporting(0);
ini_set('display_errors', 0);
    $codebar = $_POST["codebar"];
    $check_pcstock_stmt = $conn->prepare("SELECT codebar FROM pcstock WHERE codebar = ? ");
    $check_pcstock_stmt->bind_param("s", $codebar);
    $check_pcstock_stmt->execute();
    $check_pcstock_result = $check_pcstock_stmt->get_result();

    $check_pcfermerstock_stmt = $conn->prepare("SELECT codebar FROM pcfermerstock WHERE codebar = ? ");
    $check_pcfermerstock_stmt->bind_param("s", $codebar );
    $check_pcfermerstock_stmt->execute();
    $check_pcfermerstock_result = $check_pcfermerstock_stmt->get_result();
    if ($check_pcstock_result->num_rows > 0) {
      // Code bar already exists in pcstock table, display error message
      echo "<span> Nserie  already exists in PC stock.</span>";
    } elseif ($check_pcfermerstock_result->num_rows > 0) {
      // Code bar already exists in pcfermerstock table, display error message
      echo "Error: code bar or the NSERIE already exists in PC fermer stock.";
    }


?>
    <label for="localisation">Localisation:</label>
    <input type="text" name="localisation" value="<?php echo isset($_POST['localisation']) ? $_POST['localisation'] : '' ?>" required><br><br>
    <label for="etat">Etat:</label>
    <select name='etat'>
        <option>in stock</option>
    </select><br><br>
    <label for="Nom_de_Machine">Nom de Machine:</label>
    <input type="text" name="Nom_de_Machine" value="<?php echo isset($_POST['Nom_de_Machine']) ? $_POST['Nom_de_Machine'] : '' ?>" required><br><br>
    <label for="Date_de_formatage">Date de formatage:</label>
    <input type="date" name="Date_de_formatage" value="<?php echo isset($_POST['Date_de_formatage']) ? $_POST['Date_de_formatage'] : '' ?>"><br><br>
    <label for="Type_PC">Type PC:</label>
    <input type="text" name="Type_PC" value="<?php echo isset($_POST['Type_PC']) ? $_POST['Type_PC'] : '' ?>" required><br><br>
    <label for="Marque_PC">Marque PC:</label>
    <input type="text" name="Marque_PC" value="<?php echo isset($_POST['Marque_PC']) ? $_POST['Marque_PC'] : '' ?>" required><br><br>
    <label for="NSerie">codebar:</label>
    <input type="text" name="NSerie" value="<?php echo isset($_POST['NSerie']) ? $_POST['NSerie'] : '' ?>" ><br><br>
    <?php
    require 'connexion.php';
    error_reporting(0);
ini_set('display_errors', 0);
    $NSerie = $_POST["NSerie"];
    $check_pcstock_stmt = $conn->prepare("SELECT NSerie FROM pcstock WHERE NSerie = ? ");
    $check_pcstock_stmt->bind_param("s", $NSerie);
    $check_pcstock_stmt->execute();
    $check_pcstock_result = $check_pcstock_stmt->get_result();
    $check_pcfermerstock_stmt = $conn->prepare("SELECT NSerie FROM pcfermerstock WHERE NSerie = ? ");
    $check_pcfermerstock_stmt->bind_param("s", $NSerie );
    $check_pcfermerstock_stmt->execute();
    $check_pcfermerstock_result = $check_pcfermerstock_stmt->get_result();
    if ($check_pcstock_result->num_rows > 0) {
      // Code bar already exists in pcstock table, display error message
      echo "<span> codebar  already exists in PC stock.</span>";
    } elseif ($check_pcfermerstock_result->num_rows > 0) {
      // Code bar already exists in pcfermerstock table, display error message
      echo "Error: code bar or the NSERIE already exists in PC fermer stock.";
    }

?>
    <label for="CPU">CPU:</label>
    <input type="text" name="CPU" value="<?php echo isset($_POST['CPU']) ? $_POST['CPU'] : '' ?>" required><br><br>
    <label for="RAM">RAM:</label>
    <input type="text" name="RAM" value="<?php echo isset($_POST['RAM']) ? $_POST['RAM'] : '' ?>" required><br><br>
    <label for="DD">DD:</label>
    <input type="text" name="DD" value="<?php echo isset($_POST['DD']) ? $_POST['DD'] : '' ?>" required><br><br>
    <label for="GPU">GPU:</label>
    <input type="text" name="GPU" value="<?php echo isset($_POST['GPU']) ? $_POST['GPU'] : '' ?>"><br><br>
    <label for="Mac_ethernet">Mac Ethernet:</label>
    <input type="text" name="Mac_ethernet" value="<?php echo isset($_POST['Mac_ethernet']) ? $_POST['Mac_ethernet'] : '' ?>" required><br><br>
    <label for="Mac_WIFI">Mac WIFI:</label>
    <input type="text" name="Mac_WIFI" value="<?php echo isset($_POST['Mac_WIFI']) ? $_POST['Mac_WIFI'] : '' ?>" required><br><br>
    <label for="Ancien_Nom_machine">Ancien Nom de Machine:</label>
    <input type="text" name="Ancien_Nom_machine" value="<?php echo isset($_POST['Ancien_Nom_machine']) ? $_POST['Ancien_Nom_machine'] : '' ?>"><br><br>
    <input type="submit" value="Add PC Stock"> <a class='b' href='http://10.15.17.131/circet/PC/list_stock.php'>List Stock</a>
  </form>
</body>
</html>
<?php
require 'connexion.php';
error_reporting(0);
ini_set('display_errors', 0);
        

// Prepare SQL statement
$stmt = $conn->prepare("INSERT INTO pcstock (codebar, localisation, etat, Nom_de_Machine, Date_de_formatage,  Type_PC, Marque_PC, NSerie, CPU, RAM, DD, GPU, Mac_ethernet, Mac_WIFI, Ancien_Nom_machine, date_added, proprietaire,return_value) VALUES (?, ?, ?, ?, ?,  ?,?, ?, ?, ?, ?, ?,  ?, ?, ?, NOW(),?,?)");

// Assign a variable to the 18th parameter
$proprietaire = 'STOCK';
$return_value='NEW';

// Bind parameters to statement
$stmt->bind_param("sssssssssssssssss", $codebar, $localisation, $etat, $Nom_de_Machine, $Date_de_formatage,  $Type_PC, $Marque_PC, $NSerie, $CPU, $RAM, $DD, $GPU, $Mac_ethernet, $Mac_WIFI, $Ancien_Nom_machine, $proprietaire,$return_value);

// Set variables with form input values
$codebar = $_POST["codebar"];
$localisation = $_POST["localisation"];
$etat = $_POST["etat"];
$Nom_de_Machine = $_POST["Nom_de_Machine"];
$Date_de_formatage = $_POST["Date_de_formatage"];
$Site = $_POST["Site"];
$Type_PC = $_POST["Type_PC"];
$Marque_PC = $_POST["Marque_PC"];
$NSerie = $_POST["NSerie"];
$CPU = $_POST["CPU"];
$RAM = $_POST["RAM"];
$DD = $_POST["DD"];
$GPU = $_POST["GPU"];
$Mac_ethernet = $_POST["Mac_ethernet"];
$Mac_WIFI = $_POST["Mac_WIFI"];
$Ancien_Nom_machine = $_POST["Ancien_Nom_machine"];

// Check if code bar already exists in pcstock table
$check_pcstock_stmt = $conn->prepare("SELECT codebar FROM pcstock WHERE codebar = ? ");
$check_pcstock_stmt->bind_param("s", $codebar);
$check_pcstock_stmt->execute();
$check_pcstock_result = $check_pcstock_stmt->get_result();

// Check if code bar already exists in pcfermerstock table
$check_pcfermerstock_stmt = $conn->prepare("SELECT codebar FROM pcfermerstock WHERE codebar = ? or NSerie = ?");
$check_pcfermerstock_stmt->bind_param("ss", $codebar , $NSerie);
$check_pcfermerstock_stmt->execute();
$check_pcfermerstock_result = $check_pcfermerstock_stmt->get_result();

if ($check_pcstock_result->num_rows > 0) {
  // Code bar already exists in pcstock table, display error message
  echo "Error: code bar or the Nserie already exists in PC stock.";
} elseif ($check_pcfermerstock_result->num_rows > 0) {
  // Code bar already exists in pcfermerstock table, display error message
  echo "Error: code bar or the NSERIE already exists in PC fermer stock.";
} else {
  // Code bar does not exist in any table, execute insert query
  if ($stmt->execute()) {
    echo "PC stock added successfully.";
  } else {
    echo "Error: " ;
  }
}

// Close prepared statements and database connection
$stmt->close();
$check_pcstock_stmt->close();
$check_pcfermerstock_stmt->close();
$conn->close();

?>

    
