<?php 
error_reporting(0);
ini_set('display_errors', 0);

require 'connexion.php';
if (isset($_GET['id_return'])) {
    // get the id_return value from the URL parameter
    $id_return = $_GET['id_return'];
  
    // prepare a delete statement for the retour_pc table
    $stmt = $conn->prepare("DELETE FROM retour_souris WHERE id_return = ?");
    $stmt->bind_param("i", $id_return);
  
    // execute the delete statement
    $stmt->execute();
  
    // redirect back to the list_pc_stock.php page
    header("Location: liste_souris_stock.php");
    exit();
  }
?>