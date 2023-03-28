<?php
require 'connexion.php';
    if (isset($_GET['codebar'])) {
        $codebar = $_GET['codebar'];
       // Select data from pcstock table
$sql = "SELECT * FROM pcfermerstock WHERE codebar='$codebar'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Insert data into pcfermerstock table
    
    $stmt = $conn->prepare("DELETE FROM pcfermerstock where codebar='$codebar';");
    $stmt->execute();
    $stmt = $conn->prepare("UPDATE pcstock SET etat='in stock' where codebar='$codebar' or NSerie='$NSerie';");
    $stmt->execute();

    if($stmt->execute()){
        header("Location: list_pc_deleted.php");
        exit();
      }else{
        echo 'the asset must be in use first';
      }
}




          mysqli_close($conn);}
?>