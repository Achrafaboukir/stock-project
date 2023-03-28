<?php 
require 'connexion.php';
if (isset($_GET['idmaintenance'])) {
    // get the id_return value from the URL pacableeter
    $idmaintenance = $_GET['idmaintenance'];
    $rnum_serie = $_GET['rnum_serie'];
    
    // check if this is the last maintenance
    $stmt3 = $conn->prepare("SELECT COUNT(*) as count 
    FROM suivi_maintenance_cable 
    WHERE rnum_serie = ? AND idmaintenance > ?
    ");
    $stmt3->bind_param("si", $rnum_serie, $idmaintenance);
    $stmt3->execute();
    $result = $stmt3->get_result();
    $row = $result->fetch_assoc();
    $count = $row['count'];
    
    // prepare a delete statement for the suivi_maintenance_pc table
    $stmt = $conn->prepare("DELETE FROM suivi_maintenance_cable WHERE idmaintenance = ?");
    $stmt->bind_param("i", $idmaintenance);
  
    // execute the delete statement
    $stmt->execute();
    
    
    // update the pc table if this is the last maintenance
    if ($count == 0) {
        $stmt2 = $conn->prepare("UPDATE cable SET etat='in use' where rnum_serie=?");
        $stmt2->bind_param("s", $rnum_serie);
        $stmt2->execute();
    }
  
    // redirect back to the list_pc_stock.php page
    header("Location: liste_cable_stock.php");
    exit();
}
?>
 