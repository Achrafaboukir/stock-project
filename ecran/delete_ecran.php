<?php
require 'connexion.php';
    if (isset($_GET['rnum_serie'])) {
        $rnum_serie = $_GET['rnum_serie'];
       // Select data from pcstock table
$sql = "SELECT * FROM ecran_stock WHERE rnum_serie='$rnum_serie'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Insert data into pcfermerstock table
    $stmt = $conn->prepare( "INSERT INTO ecran_stock_fermer (rnum_serie, modele, marque, etat, date_deleted,caracteristique,return_value) VALUES ('$row[rnum_serie]', '$row[modele]', '$row[marque]', 'in stock', now(),'$row[caracteristique]','$row[return_value]');");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM ecran where rnum_serie='$rnum_serie';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM suivi_maintenance_ecran where rnum_serie='$rnum_serie';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM retour_ecran where rnum_serie='$rnum_serie';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM ecran_stock where rnum_serie='$rnum_serie';");
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