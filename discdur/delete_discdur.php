<?php
require 'connexion.php';
    if (isset($_GET['dnum_serie'])) {
        $dnum_serie = $_GET['dnum_serie'];
       // Select data from pcstock table
$sql = "SELECT * FROM disc_dur_stock WHERE dnum_serie='$dnum_serie'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Insert data into pcfermerstock table
    $stmt = $conn->prepare( "INSERT INTO disc_dur_stock_fermer (dnum_serie, modele, marque, etat, date_deleted,caracteristique,return_value) VALUES ('$row[dnum_serie]', '$row[modele]', '$row[marque]', 'in stock', now(),'$row[caracteristique]','$row[return_value]');");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM disc_dur where dnum_serie='$dnum_serie';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM suivi_maintenance_disc_dur where dnum_serie='$dnum_serie';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM retour_disc_dur where dnum_serie='$dnum_serie';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM disc_dur_stock where dnum_serie='$dnum_serie';");
    $stmt->execute();

    if($stmt->execute()){
        header("Location: liste_discdur_stock.php");
        exit();
      }else{
        echo 'the asset must be in use first';
      }
}




          mysqli_close($conn);}
?>