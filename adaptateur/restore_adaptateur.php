<?php
require 'connexion.php';
    if (isset($_GET['rnum_serie'])) {
        $rnum_serie = $_GET['rnum_serie'];
       // Select data from pcstock table
$sql = "SELECT * FROM adaptateur_stock_ferme WHERE rnum_serie='$rnum_serie'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Insert data into pcfermerstock table
    $stmt = $conn->prepare( "INSERT INTO adaptateur_stock (rnum_serie,modele,etat,marque,caracteristique ,date_added,return_value) VALUES ('$row[rnum_serie]', '$row[modele]', 'in stock', '$row[marque]','$row[caracteristique]',now(),'$row[return_value]');");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM adaptateur_stock_ferme where rnum_serie='$rnum_serie';");
    $stmt->execute();

    if($stmt->execute()){
        header("Location: liste_adaptateur_deleted.php");
        exit();
      }else{
        echo 'the asset must be in use first';
      }
}




          mysqli_close($conn);}
?>