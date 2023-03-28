<?php
require 'connexion.php';
    if (isset($_GET['num_serie'])) {
        $num_serie = $_GET['num_serie'];
       // Select data from pcstock table
$sql = "SELECT * FROM clavie_stock_fermer WHERE num_serie='$num_serie'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Insert data into pcfermerstock table
    $stmt = $conn->prepare( "INSERT INTO clavie_stock (num_serie,modele,etat,marque,date_added,return_value) VALUES ('$row[num_serie]', '$row[modele]', 'in stock', '$row[marque]',now(),'$row[return_value]');");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM clavie_stock_fermer where num_serie='$num_serie';");
    $stmt->execute();

    if($stmt->execute()){
        header("Location: liste_clavie_deleted.php");
        exit();
      }else{
        echo 'the asset must be in use first';
      }
}




          mysqli_close($conn);}
?>