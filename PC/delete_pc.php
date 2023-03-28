<?php
require 'connexion.php';
    if (isset($_GET['codebar'])) {
        $codebar = $_GET['codebar'];
       // Select data from pcstock table
$sql = "SELECT * FROM pcstock WHERE codebar='$codebar'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $row = $result->fetch_assoc();
    // Insert data into pcfermerstock table
    $stmt = $conn->prepare( "INSERT INTO pcfermerstock (codebar, localisation, etat, Nom_de_Machine, Date_de_formatage, Site, Type_PC, Marque_PC, NSerie, CPU, RAM, DD, GPU, Mac_ethernet, Mac_WIFI, Ancien_Nom_machine, date_deleted) VALUES ('$row[codebar]', '$row[localisation]', 'in stock', '$row[Nom_de_Machine]', '$row[Date_de_formatage]', '$row[Site]', '$row[Type_PC]', '$row[Marque_PC]', '$row[NSerie]', '$row[CPU]', '$row[RAM]', '$row[DD]', '$row[GPU]', '$row[Mac_ethernet]', '$row[Mac_WIFI]', '$row[Ancien_Nom_machine]', now());");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM pc where codebar='$codebar';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM suivi_maintenance_pc where codebar='$codebar';");
    $stmt->execute();
    $stmt = $conn->prepare("DELETE FROM retour_pc where codebar='$codebar';");
    $stmt->execute();
    $stmt = $conn->prepare("UPDATE pcstock SET etat='endomager' where codebar='$codebar' or NSerie='$NSerie';");
        $stmt->execute();

    if($stmt->execute()){
        header("Location: liste_all.php");
        exit();
      }else{
        echo 'the asset must be in use first';
      }
}




          mysqli_close($conn);}
?>