<?php
require 'connexion.php';
    if (isset($_GET['num_serie'])) {
        $num_serie = $_GET['num_serie'];
       // Select data from pcstock table
$sql = "SELECT * FROM clavie_stock WHERE num_serie='$num_serie'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Insert data into pcfermerstock table
    $stmt = $conn->prepare( "INSERT INTO clavie_stock_fermer (num_serie, modele, marque, etat, date_deleted,return_value) VALUES ('$row[num_serie]', '$row[modele]', '$row[marque]', 'in stock', now(),'$row[return_value]');");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM clavie where num_serie='$num_serie';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM suivi_maintenance_clavie where num_serie='$num_serie';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM retour_clavie where num_serie='$num_serie';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM clavie_stock where num_serie='$num_serie';");
    $stmt->execute();

    if($stmt->execute()){
        header("Location: list_all.php");
        exit();
      }else{
        echo 'the asset must be in use first';
      }
}




          mysqli_close($conn);}
?>