<?php
require 'connexion.php';
    if (isset($_GET['dnum_serie'])) {
        $dnum_serie = $_GET['dnum_serie'];
       // Select data from pcstock table
$sql = "SELECT * FROM disc_dur_stock_fermer WHERE dnum_serie='$dnum_serie'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Insert data into pcfermerstock table
    $stmt = $conn->prepare( "INSERT INTO disc_dur_stock (dnum_serie,modele,etat,marque,caracteristique ,date_added,return_value) VALUES ('$row[dnum_serie]', '$row[modele]', 'in stock', '$row[marque]','$row[caracteristique]',now(),'$row[return_value]');");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM disc_dur_stock_fermer where dnum_serie='$dnum_serie';");
    $stmt->execute();

    if($stmt->execute()){
        header("Location: liste_discdur_deleted.php");
        exit();
      }else{
        echo 'the asset must be in use first';
      }
}




          mysqli_close($conn);}
?>