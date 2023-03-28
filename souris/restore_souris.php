<?php
require 'connexion.php';
    if (isset($_GET['NSerie'])) {
        $NSerie = $_GET['NSerie'];
       // Select data from pcstock table
$sql = "SELECT * FROM souris_fermer_stock WHERE NSerie='$NSerie'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Insert data into pcfermerstock table
    $stmt = $conn->prepare( "INSERT INTO souris_stock (NSerie,modele,etat,marque,date_added,return_value) VALUES ('$row[NSerie]', '$row[Modele]', 'in stock', '$row[Marque]',now(),'$row[return_value]');");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM souris_fermer_stock where NSerie='$NSerie';");
    $stmt->execute();

    if($stmt->execute()){
        header("Location: liste_souris_deleted.php");
        exit();
      }else{
        echo 'the asset must be in use first';
      }
}




          mysqli_close($conn);}
?>