<?php
require 'connexion.php';
error_reporting(0);
ini_set('display_errors', 0);

    if (isset($_GET['NSerie'])) {
        $NSerie = $_GET['NSerie'];
       // Select data from pcstock table
$sql = "SELECT * FROM souris_stock WHERE NSerie='$NSerie'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Insert data into pcfermerstock table
    $stmt = $conn->prepare( "INSERT INTO souris_fermer_stock (NSerie, Modele, Marque, etat, Date_delete) VALUES ('$row[NSerie]', '$row[Modele]', '$row[Marque]', 'in stock', now());");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM souris where NSerie='$NSerie';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM suivi_maintenance_souris where Nserie='$NSerie';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM retour_souris where NSerie='$NSerie';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM souris_stock where NSerie='$NSerie';");
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