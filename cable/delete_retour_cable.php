<?php 
require 'connexion.php';
if (isset($_GET['id_return'])) {
    // get the id_return value from the URL pacableeter
    $id_return = $_GET['id_return'];
  
    // prepare a delete statement for the retour_pc table
    $stmt = $conn->prepare("DELETE FROM retour_cable WHERE id_return = ?");
    $stmt->bind_param("i", $id_return);
  
    // execute the delete statement
    $stmt->execute();
  
    // redirect back to the list_pc_stock.php page
    header("Location: liste_cable_stock.php");
    exit();
  }
?>