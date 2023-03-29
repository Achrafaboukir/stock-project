<?php
// your database connection code here
require 'connexion.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
$codebar = isset($_POST['codebar']) ? $_POST['codebar'] : '';
$localisation = isset($_POST['localisation']) ? $_POST['localisation'] : '';
$Matricule = isset($_POST['Matricule']) ? $_POST['Matricule'] : '';
$Nom = isset($_POST['Nom']) ? $_POST['Nom'] : '';
$Prenom = isset($_POST['Prénom']) ? $_POST['Prénom'] : '';
$etat = isset($_POST['etat']) ? $_POST['etat'] : '';
$Nom_de_Machine = isset($_POST['Nom_de_Machine']) ? $_POST['Nom_de_Machine'] : '';
$Date_de_formatage = isset($_POST['Date_de_formatage']) ? $_POST['Date_de_formatage'] : '';
$Manager = isset($_POST['Manager']) ? $_POST['Manager'] : '';
$Pilote = isset($_POST['Pilote']) ? $_POST['Pilote'] : '';
$Site = isset($_POST['Site']) ? $_POST['Site'] : '';
$Type_PC = isset($_POST['Type_PC']) ? $_POST['Type_PC'] : '';
$Marque_PC = isset($_POST['Marque_PC']) ? $_POST['Marque_PC'] : '';
$NSerie = isset($_POST['NSerie']) ? $_POST['NSerie'] : '';
$CPU = isset($_POST['CPU']) ? $_POST['CPU'] : '';
$RAM = isset($_POST['RAM']) ? $_POST['RAM'] : '';
$DD = isset($_POST['DD']) ? $_POST['DD'] : '';
$GPU = isset($_POST['GPU']) ? $_POST['GPU'] : '';
$Mac_ethernet = isset($_POST['Mac_ethernet']) ? $_POST['Mac_ethernet'] : '';
$Mac_WIFI = isset($_POST['Mac_WIFI']) ? $_POST['Mac_WIFI'] : '';
$Ancien_Nom_machine = isset($_POST['Ancien_Nom_machine']) ? $_POST['Ancien_Nom_machine'] : '';
$Using_date = isset($_POST['Using_date']) ? $_POST['Using_date'] : '';
$affictaion = isset($_POST['affictaion']) ? $_POST['affictaion'] : '';
$date_added_to_stock = isset($_POST['date_added']) ? $_POST['date_added'] : '';
$Date_added = isset($_POST['date_added']) ? $_POST['date_added'] : '';
$proprietaire = isset($_POST['proprietaire']) ? $_POST['proprietaire'] : '';
$return_value = isset($_POST['return_value']) ? $_POST['return_value'] : '';



if ($etat == "in use") {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM pc WHERE codebar = ?");
    $stmt->bind_param("s", $codebar);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_row();
    $count = $row[0];

    if ($count > 0) {
        // if the record exists, update all fields
        $stmt = $conn->prepare( "UPDATE pc SET localisation='$localisation', Matricule='$Matricule', Nom='$Nom', Prénom='$Prenom', etat='$etat', 
        Nom_de_Machine='$Nom_de_Machine', Date_de_formatage='$Date_de_formatage', Manager='$Manager', Pilote='$Pilote', Site='$Site', Type_PC='$Type_PC', Marque_PC='$Marque_PC',
         NSerie='$NSerie', CPU='$CPU', RAM='$RAM', DD='$DD', GPU='$GPU', Mac_ethernet='$Mac_ethernet', Mac_WIFI='$Mac_WIFI', Ancien_Nom_machine='$Ancien_Nom_machine',
         Using_date=now(),affictaion=(SELECT COUNT(*) + 1 FROM retour_pc WHERE codebar = $codebar), date_added_to_stock='$date_added_to_stock' WHERE codebar='$codebar' or NSerie='$NSerie';");
        $stmt->execute();
        $stmt = $conn->prepare("UPDATE pcstock SET localisation='$localisation', etat='$etat', Nom_de_Machine='$Nom_de_Machine', Date_de_formatage='$Date_de_formatage', Site='$Site', Type_PC='$Type_PC', Marque_PC='$Marque_PC', NSerie='$NSerie', CPU='$CPU', RAM='$RAM', DD='$DD', GPU='$GPU', Mac_ethernet='$Mac_ethernet', Mac_WIFI='$Mac_WIFI', Ancien_Nom_machine='$Ancien_Nom_machine', date_added='$date_added_to_stock',proprietaire='$Nom $Prenom' WHERE codebar='$codebar' or NSerie='$NSerie';");
        $stmt->execute();
        if($stmt->execute()){
          header("Location: list_use.php");
          exit();
        }else{
          echo 'the asset must be in use first';
        }
    } else {
        // Insert into pc table
        $stmt = $conn->prepare("INSERT INTO pc (codebar, localisation, Matricule, Nom, Prénom, etat, Nom_de_Machine, Date_de_formatage, Manager, Pilote, Site, Type_PC, Marque_PC, NSerie, CPU, RAM, DD, GPU, Mac_ethernet, Mac_WIFI, Ancien_Nom_machine, Using_date, affictaion, date_added_to_stock) VALUES ( '$codebar', '$localisation', '$Matricule', '$Nom', '$Prenom', '$etat', '$Nom_de_Machine', '$Date_de_formatage',' $Manager', '$Pilote', '$Site', '$Type_PC', '$Marque_PC', '$NSerie', '$CPU', '$RAM', '$DD', '$GPU', '$Mac_ethernet', '$Mac_WIFI', '$Ancien_Nom_machine', now(),(SELECT COUNT(*) + 1 FROM retour_pc WHERE codebar = '$codebar'), '$date_added_to_stock');");
        $stmt->execute();
        $stmt = $conn->prepare("UPDATE pcstock SET localisation='$localisation', etat='$etat', Nom_de_Machine='$Nom_de_Machine', Date_de_formatage='$Date_de_formatage', Site='$Site', Type_PC='$Type_PC', Marque_PC='$Marque_PC', NSerie='$NSerie', CPU='$CPU', RAM='$RAM', DD='$DD', GPU='$GPU', Mac_ethernet='$Mac_ethernet', Mac_WIFI='$Mac_WIFI', Ancien_Nom_machine='$Ancien_Nom_machine', date_added='$date_added_to_stock', proprietaire='$Nom $Prenom' WHERE codebar='$codebar' or NSerie='$NSerie';");
        $stmt->execute();
    // execute the statement
    if($stmt->execute()){
      header("Location: list_use.php");
      exit();
    }else{
      echo 'the asset must be in use first';
    }
  
    // Close statement and connection
    $stmt->close();
    $conn->close();
}
}
$date_maintenance=$_POST['date_maintenance'];
$technicien=$_POST['technicien'];
$audit = $_POST['audit'];
if ($etat == "in maintenance") {
  $stmt = $conn->prepare("SELECT COUNT(*) FROM pc WHERE codebar = '$codebar' OR NSerie = '$NSerie' ");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_row();
    $count = $row[0];

    if ($count > 0) {
        $stmt = $conn->prepare("INSERT INTO suivi_maintenance_pc (codebar,date_maintenance,technicien,audit_rapport,NSerie)VALUES('$codebar','$date_maintenance','$technicien','$audit','$NSerie'); ");
        $stmt->execute();
        $stmt = $conn->prepare("UPDATE pc SET etat='$etat' where codebar='$codebar' or NSerie='$NSerie';");
        $stmt->execute();
        $stmt = $conn->prepare("UPDATE pcstock SET etat='$etat' where codebar='$codebar' or NSerie='$NSerie';");
        $stmt->execute();
        header("Location: list_maintenance.php");
        }else{
          $stmt = $conn->prepare("INSERT INTO suivi_maintenance_pc (codebar,date_maintenance,technicien,audit_rapport,NSerie)VALUES('$codebar','$date_maintenance','$technicien','$audit','$NSerie'); ");
          $stmt->execute();
          $stmt = $conn->prepare("UPDATE pcstock SET etat='$etat' where codebar='$codebar' or NSerie='$NSerie';");
          $stmt->execute();
          header("Location: list_maintenance.php");
        }
}

$date_retour=isset($_POST['date_return']) ? $_POST['date_return'] : '';
$raison_return=isset($_POST['raison_return']) ? $_POST['raison_return'] : '';
$return_audit=isset($_POST['return_rapport']) ? $_POST['return_rapport'] : '';
//in case return
if ($etat == "return") {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM pc WHERE codebar = '$codebar' OR NSerie = '$NSerie' ");
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_row();
    $count = $row[0];

    if ($count > 0) {
      $stmt = $conn->prepare("SELECT Nom, Prénom FROM pc WHERE codebar = '$codebar' OR NSerie = '$NSerie'");
      $stmt->execute();
      $result = $stmt->get_result();
      $row = $result->fetch_assoc();
      $Nom = $row['Nom'];
      $Prenom = $row['Prénom'];

      $stmt = $conn->prepare("INSERT INTO retour_pc (codebar, name_owner, last_name, date_return, raison_return, audit_rapport,NSerie ) VALUES (?, ?, ?, ?, ?, ?,?)");
      $stmt->bind_param("sssssss", $codebar, $Nom, $Prenom, $date_retour, $raison_return, $return_audit,$NSerie);
      $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM pc where codebar='$codebar' or NSerie='$NSerie';");
        $stmt->execute();
        $stmt = $conn->prepare("UPDATE pcstock SET etat='in stock' ,proprietaire='$Nom $Prenom' , return_value='returned'  where codebar='$codebar' or NSerie='$NSerie';");
        $stmt->execute();
        header("Location: list_stock.php");
        
    }else{
        echo 'the asset must be in use first ';
    }
}
if($etat == "in stock"){
    $stmt = $conn->prepare("UPDATE pcstock SET localisation='$localisation', etat='in stock', Nom_de_Machine='$Nom_de_Machine', Date_de_formatage='$Date_de_formatage', Site='$Site', Type_PC='$Type_PC', Marque_PC='$Marque_PC', NSerie='$NSerie', CPU='$CPU', RAM='$RAM', DD='$DD', GPU='$GPU', Mac_ethernet='$Mac_ethernet', Mac_WIFI='$Mac_WIFI', Ancien_Nom_machine='$Ancien_Nom_machine', date_added='$date_added_to_stock',proprietaire='stock' WHERE codebar='$codebar' or NSerie='$NSerie';");
        $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM pc where codebar='$codebar' or NSerie='$NSerie';");
        $stmt->execute();
        if($stmt->execute()){
          header("Location: list_stock.php");
          exit();
        }else{
          echo 'there is an error';
        }
    
}
}
if (isset($_GET['etat'])) {
    $codebar = $_GET['codebar'];
    $etat = $_GET['etat'];
    $NSerie = $_GET['NSerie'];
    if($etat=='in use' ){
    $sql = "SELECT * from pc where codebar='$codebar' or NSerie='$NSerie' ";


    $result = $conn->query($sql);
  
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();

    
// close database connection

?>
<form action="update_pc.php" method="post">
<label for="codebar">N°Serie:</label>
    <input type="text" name="codebar" value="<?php echo $row['codebar']; ?>">

    <label for="localisation">Localisation:</label>
    <input type="text" name="localisation" value="<?php echo $row['localisation']; ?>">

    <label for="etat">Etat:</label>
    <select name="etat" id='etat'>
    <option value="in stock" <?php if ($etat == 'in stock') echo 'selected'; ?>>in stock</option>
    <option value="in use" <?php if ($etat == 'in use') echo 'selected'; ?>>in use</option>
    <option value="return" <?php if ($etat == 'return') echo 'selected'; ?>>return</option>
    <option value="in maintenance" <?php if ($etat == 'in maintenance') echo 'selected'; ?>>in maintenance</option>
  </select>

  <div id="divInput" style="<?php if ($row['etat'] != 'in use') echo 'display: none;'; ?>">
          <label for="Matricule">Matricule:</label>
      <input type="text" id="Matricule" name="Matricule" value="<?php if ($row['etat']=='in use')  echo $row['Matricule']; ?>"><br>

      <label for="Nom">Nom:</label>
      <input type="text" id="Nom" name="Nom" value="<?php  echo $row['Nom']; ?>"><br>

      <label for="Prénom">Prénom:</label>
      <input type="text" id="Prénom" name="Prénom" value="<?php if ($row['etat']=='in use')  echo $row['Prénom']; ?>" ><br>

          <label for="Manager">Manager:</label>
      <input type="text" id="Manager" name="Manager" value="<?php if ($row['etat']=='in use')  echo $row['Manager']; ?>"><br>

      <label for="Pilote">Pilote:</label>
      <input type="text" id="Pilote" name="Pilote" value="<?php if ($row['etat']=='in use')  echo $row['Pilote']; ?>"><br>
    </div>
    <div id="main" style="<?php if ($row['etat'] != 'in maintenance') echo 'display: none;'; ?>" >
          <label for="Matricule">Date maintenance:</label>
      <input type="date" id="date_maintenance" name="date_maintenance" ><br>

      <label for="Nom">technicien:</label>
      <input type="text" id="technicien" name="technicien" ><br>

      <label for="Prénom">audit rapport:</label>
      <input type="text" id="audit" name="audit" ><br>

    </div>
    <div id="return" style="<?php if ($row['etat'] != 'return') echo 'display: none;'; ?>">
          <label for="Matricule">Date return:</label>
      <input type="date" id="date_return" name="date_return" ><br>

      <label for="Nom">raison return:</label>
      <input type="text" id="raison_return" name="raison_return" ><br>

      <label for="Prénom">audit rapport:</label>
      <input type="text" id="return_audit" name="return_rapport" ><br>

    </div>

    <label for="Nom_de_Machine">Nom de Machine:</label>
    <input type="text" name="Nom_de_Machine" value="<?php echo $row['Nom_de_Machine']; ?>">

    <label for="Date_de_formatage">Date de formatage:</label>
    <input type="text" name="Date_de_formatage" value="<?php echo $row['Date_de_formatage']; ?>">

    <label for="Site">Site:</label>
    <input type="text" name="Site" value="<?php echo $row['Site']; ?>">

    <label for="Type_PC">Type PC:</label>
    <input type="text" name="Type_PC" value="<?php echo $row['Type_PC']; ?>">

    <label for="Marque_PC">Marque PC:</label>
    <input type="text" name="Marque_PC" value="<?php echo $row['Marque_PC']; ?>">

    <label for="NSerie">codebar:</label>
    <input type="text" name="NSerie" value="<?php echo $row['NSerie']; ?>">

    <label for="CPU">CPU:</label>
    <input type="text" name="CPU" value="<?php echo $row['CPU']; ?>">

    <label for="RAM">RAM:</label>
    <input type="text" name="RAM" value="<?php echo $row['RAM']; ?>">

    <label for="DD">DD:</label>
    <input type="text" name="DD" value="<?php echo $row['DD']; ?>">

    <label for="GPU">GPU:</label>
    <input type="text" name="GPU" value="<?php echo $row['GPU']; ?>">

    <label for="Mac_ethernet">Mac Ethernet:</label>
    <input type="text" name="Mac_ethernet" value="<?php echo $row['Mac_ethernet']; ?>">

    <label for="Mac_WIFI">Mac WIFI:</label>
    <input type="text" name="Mac_WIFI" value="<?php echo $row['Mac_WIFI']; ?>">

    <label for="Ancien_Nom_machine">Ancien Nom machine:</label>
    <input type="text" name="Ancien_Nom_machine" value="<?php echo $row['Ancien_Nom_machine']; ?>">

    <label for="date_added">Date added to stock:</label>
    <input type="text" name="date_added" value="<?php echo $row['date_added_to_stock']; ?>">

    <input type="submit" name="submit" value="Update">
</form>

<?php mysqli_close($conn);}}} ?>
<?php
if (isset($_GET['codebar'])) {
    $codebar = $_GET['codebar'];
    $etat = $_GET['etat'];
    $NSerie = $_GET['NSerie'];
    if($etat=='in stock'){
    $sql = "SELECT * from pcstock where codebar='$codebar' and NSerie='$NSerie' ";


    $result = $conn->query($sql);
  
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();

    
// close database connection

?>
<form action="update_pc.php" method="post">
<label for="codebar">N°serie:</label>
    <input type="text" name="codebar" value="<?php echo $row['codebar']; ?>">

    <label for="localisation">Localisation:</label>
    <input type="text" name="localisation" value="<?php echo $row['localisation']; ?>">

    <label for="etat">Etat:</label>
    <select name="etat" id='etat'>
    <option value="in stock" <?php if ($etat == 'in stock') echo 'selected'; ?>>in stock</option>
    <option value="in use" <?php if ($etat == 'in use') echo 'selected'; ?>>in use</option>
    <option value="return" <?php if ($etat == 'return') echo 'selected'; ?>>return</option>
    <option value="in maintenance" <?php if ($etat == 'in maintenance') echo 'selected'; ?>>in maintenance</option>
  </select>

  <div id="divInput" style="<?php if ($row['etat'] != 'in use') echo 'display: none;'; ?>">
          <label for="Matricule">Matricule:</label>
      <input type="text" id="Matricule" name="Matricule"><br>

      <label for="Nom">Nom:</label>
      <input type="text" id="Nom" name="Nom" ><br>

      <label for="Prénom">Prénom:</label>
      <input type="text" id="Prénom" name="Prénom"  ><br>

          <label for="Manager">Manager:</label>
      <input type="text" id="Manager" name="Manager" ><br>

      <label for="Pilote">Pilote:</label>
      <input type="text" id="Pilote" name="Pilote" ><br>
    </div>
    <div id="main" style="<?php if ($row['etat'] != 'in maintenance') echo 'display: none;'; ?>" >
          <label for="Matricule">Date maintenance:</label>
      <input type="date" id="date_maintenance" name="date_maintenance" ><br>

      <label for="Nom">technicien:</label>
      <input type="text" id="technicien" name="technicien" ><br>

      <label for="Prénom">audit rapport:</label>
      <input type="text" id="audit" name="audit"><br>

    </div>
    <div id="return" style="<?php if ($row['etat'] != 'return') echo 'display: none;'; ?>">
          <label for="Matricule">Date return:</label>
      <input type="date" id="date_return" name="date_return"  ><br>

      <label for="Nom">raison return:</label>
      <input type="text" id="raison_return" name="raison_return" ><br>

      <label for="Prénom">audit rapport:</label>
      <input type="text" id="return_audit" name="return_rapport" ><br>

    </div>

    <label for="Nom_de_Machine">Nom de Machine:</label>
    <input type="text" name="Nom_de_Machine" value="<?php echo $row['Nom_de_Machine']; ?>">

    <label for="Date_de_formatage">Date de formatage:</label>
    <input type="text" name="Date_de_formatage" value="<?php echo $row['Date_de_formatage']; ?>">

    <label for="Site">Site:</label>
    <input type="text" name="Site" value="<?php echo $row['Site']; ?>">

    <label for="Type_PC">Type PC:</label>
    <input type="text" name="Type_PC" value="<?php echo $row['Type_PC']; ?>">

    <label for="Marque_PC">Marque PC:</label>
    <input type="text" name="Marque_PC" value="<?php echo $row['Marque_PC']; ?>">

    <label for="NSerie">codebar:</label>
    <input type="text" name="NSerie" value="<?php echo $row['NSerie']; ?>">

    <label for="CPU">CPU:</label>
    <input type="text" name="CPU" value="<?php echo $row['CPU']; ?>">

    <label for="RAM">RAM:</label>
    <input type="text" name="RAM" value="<?php echo $row['RAM']; ?>">

    <label for="DD">DD:</label>
    <input type="text" name="DD" value="<?php echo $row['DD']; ?>">

    <label for="GPU">GPU:</label>
    <input type="text" name="GPU" value="<?php echo $row['GPU']; ?>">

    <label for="Mac_ethernet">Mac Ethernet:</label>
    <input type="text" name="Mac_ethernet" value="<?php echo $row['Mac_ethernet']; ?>">

    <label for="Mac_WIFI">Mac WIFI:</label>
    <input type="text" name="Mac_WIFI" value="<?php echo $row['Mac_WIFI']; ?>">

    <label for="Ancien_Nom_machine">Ancien Nom machine:</label>
    <input type="text" name="Ancien_Nom_machine" value="<?php echo $row['Ancien_Nom_machine']; ?>">

    <label for="date_added">Date added to stock:</label>
    <input type="text" name="date_added" value="<?php echo $row['date_added']; ?>">

    <input type="submit" name="submit" value="Update">
</form>
<?php mysqli_close($conn);}}} ?>
<?php
require 'connexion.php';
if (isset($_GET['codebar'])) {
    $codebar = $_GET['codebar'];
    $etat = $_GET['etat'];
    $NSerie = $_GET['NSerie'];
    if($etat=='return'){
    $sql = "SELECT pcstock.*, retour_pc.*
    FROM pcstock
    INNER JOIN retour_pc ON pcstock.codebar = retour_pc.codebar
    WHERE pcstock.codebar = '$codebar'  or pcstock.NSerie='$NSerie';
    ";


    $result = $conn->query($sql);
  
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();

    
// close database connection

?>
<form action="update_pc.php" method="post">
<label for="codebar">N°SERIE:</label>
    <input type="text" name="codebar" value="<?php echo $row['codebar']; ?>">

    <label for="localisation">Localisation:</label>
    <input type="text" name="localisation" value="<?php echo $row['localisation']; ?>">

    <label for="etat">Etat:</label>
  <select name="etat" id='etat'>
    <option value="in stock" <?php if ($etat == 'in stock') echo 'selected'; ?>>in stock</option>
    <option value="in use" <?php if ($etat == 'in use') echo 'selected'; ?>>in use</option>
    <option value="return" <?php if ($etat == 'return') echo 'selected'; ?>>return</option>
    <option value="in maintenance" <?php if ($etat == 'in maintenance') echo 'selected'; ?>>in maintenance</option>
  </select>

  <div id="divInput" style="<?php if ($row['etat'] != 'in use') echo 'display: none;'; ?>">
          <label for="Matricule">Matricule:</label>
      <input type="text" id="Matricule" name="Matricule" ><br>

      <label for="Nom">Nom:</label>
      <input type="text" id="Nom" name="Nom"><br>

      <label for="Prénom">Prénom:</label>
      <input type="text" id="Prénom" name="Prénom"  ><br>

          <label for="Manager">Manager:</label>
      <input type="text" id="Manager" name="Manager" ><br>

      <label for="Pilote">Pilote:</label>
      <input type="text" id="Pilote" name="Pilote" ><br>
    </div>
    <div id="main" style="<?php if ($row['etat'] != 'in maintenance') echo 'display: none;'; ?>" >
          <label for="Matricule">Date maintenance:</label>
      <input type="date" id="date_maintenance" name="date_maintenance" ><br>

      <label for="Nom">technicien:</label>
      <input type="text" id="technicien" name="technicien" ><br>

      <label for="Prénom">audit rapport:</label>
      <input type="text" id="audit" name="audit"><br>

    </div>
    <div id="return" style="<?php if ($row['etat'] != 'return') echo 'display: none;'; ?>">
          <label for="Matricule">Date return:</label>
      <input type="date" id="date_return" name="date_return" value="<?php echo $row['date_return'] ?>" ><br>

      <label for="Nom">raison return:</label>
      <input type="text" id="raison_return" name="raison_return" value="<?php echo $row['raison_return'] ?>"><br>

      <label for="Prénom">audit rapport:</label>
      <input type="text" id="return_audit" name="return_rapport" value="<?php echo $row['audit_rapport'] ?>"><br>

    </div>

    <label for="Nom_de_Machine">Nom de Machine:</label>
    <input type="text" name="Nom_de_Machine" value="<?php echo $row['Nom_de_Machine']; ?>">

    <label for="Date_de_formatage">Date de formatage:</label>
    <input type="text" name="Date_de_formatage" value="<?php echo $row['Date_de_formatage']; ?>">

    <label for="Site">Site:</label>
    <input type="text" name="Site" value="<?php echo $row['Site']; ?>">

    <label for="Type_PC">Type PC:</label>
    <input type="text" name="Type_PC" value="<?php echo $row['Type_PC']; ?>">

    <label for="Marque_PC">Marque PC:</label>
    <input type="text" name="Marque_PC" value="<?php echo $row['Marque_PC']; ?>">

    <label for="NSerie">codebar:</label>
    <input type="text" name="NSerie" value="<?php echo $row['NSerie']; ?>">

    <label for="CPU">CPU:</label>
    <input type="text" name="CPU" value="<?php echo $row['CPU']; ?>">

    <label for="RAM">RAM:</label>
    <input type="text" name="RAM" value="<?php echo $row['RAM']; ?>">

    <label for="DD">DD:</label>
    <input type="text" name="DD" value="<?php echo $row['DD']; ?>">

    <label for="GPU">GPU:</label>
    <input type="text" name="GPU" value="<?php echo $row['GPU']; ?>">

    <label for="Mac_ethernet">Mac Ethernet:</label>
    <input type="text" name="Mac_ethernet" value="<?php echo $row['Mac_ethernet']; ?>">

    <label for="Mac_WIFI">Mac WIFI:</label>
    <input type="text" name="Mac_WIFI" value="<?php echo $row['Mac_WIFI']; ?>">

    <label for="Ancien_Nom_machine">Ancien Nom machine:</label>
    <input type="text" name="Ancien_Nom_machine" value="<?php echo $row['Ancien_Nom_machine']; ?>">

    <label for="date_added">Date added to stock:</label>
    <input type="text" name="date_added" value="<?php echo $row['date_added']; ?>">

    <input type="submit" name="submit" value="Update">
</form>
<?php mysqli_close($conn);}}} ?>




<?php
if (isset($_GET['etat'])) {
    $codebar = $_GET['codebar'];
    $etat = $_GET['etat'];
    $NSerie = $_GET['NSerie'];
    if($etat=='in maintenance'){
    $sql = "SELECT * from pc where codebar='$codebar'  or NSerie='$NSerie';";
    $result = $conn->query($sql);
  
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();
    
// close database connection

?>
<form action="update_pc.php" method="post">
<label for="codebar">N°Serie:</label>
    <input type="text" name="codebar" value="<?php echo $row['codebar']; ?>">

    <label for="localisation">Localisation:</label>
    <input type="text" name="localisation" value="<?php echo $row['localisation']; ?>">

    <label for="etat">Etat:</label>
  <select name="etat" id='etat'>
    <option value="in stock" <?php if ($etat == 'in stock') echo 'selected'; ?>>in stock</option>
    <option value="in use" <?php if ($etat == 'in use') echo 'selected'; ?>>in use</option>
    <option value="return" <?php if ($etat == 'return') echo 'selected'; ?>>return</option>
    <option value="in maintenance" <?php if ($etat == 'in maintenance') echo 'selected'; ?>>in maintenance</option>
  </select>

  <div id="divInput" style="<?php if ($row['etat'] != 'in use') echo 'display: none;'; ?>">
          <label for="Matricule">Matricule:</label>
      <input type="text" id="Matricule" name="Matricule" value="<?php  echo $row['Matricule']; ?>"><br>

      <label for="Nom">Nom:</label>
      <input type="text" id="Nom" name="Nom"  value="<?php echo $row['Nom']; ?>" ><br>

      <label for="Prénom">Prénom:</label>
      <input type="text" id="Prénom" name="Prénom" value="<?php echo $row['Prénom']; ?>" ><br>

          <label for="Manager">Manager:</label>
      <input type="text" id="Manager" name="Manager" value="<?php echo $row['Manager']; ?>" ><br>

      <label for="Pilote">Pilote:</label>
      <input type="text" id="Pilote" name="Pilote" value="<?php echo $row['Pilote']; ?>"><br>
    </div>
    <div id="main" style="<?php if ($row['etat'] != 'in maintenance') echo 'display: none;'; ?>" >
    <?php 
    $sqll = "SELECT * FROM suivi_maintenance_pc where codebar='$codebar'  or NSerie='$NSerie' ;";
    $resultt = $conn->query($sqll);

    // Check if any records were returned
    if ($resultt->num_rows > 0) {
      // Loop through each record and output it
      while ($roww = $resultt->fetch_assoc()) {
        ?>
          <label for="Matricule">Date maintenance:</label>
      <input type="date" id="date_maintenance" name="date_maintenance" value="<?php echo $roww['date_maintenance']; ?>"><br>

      <label for="Nom">technicien:</label>
      <input type="text" id="technicien" name="technicien" value="<?php echo $roww['technicien']; ?>"><br>

      <label for="Prénom">audit rapport:</label>
      <input type="text" id="audit" name="audit" value="<?php echo $roww['audit_rapport']; ?>" ><br>
<?php }} ?>
    </div>
    <div id="return" style="<?php if ($row['etat'] != 'return') echo 'display: none;'; ?>">
          <label for="Matricule">Date return:</label>
      <input type="date" id="date_return" name="date_return"  ><br>

      <label for="Nom">raison return:</label>
      <input type="text" id="raison_return" name="raison_return" ><br>

      <label for="Prénom">audit rapport:</label>
      <input type="text" id="return_audit" name="return_rapport" ><br>

    </div>

    <label for="Nom_de_Machine">Nom de Machine:</label>
    <input type="text" name="Nom_de_Machine" value="<?php echo $row['Nom_de_Machine']; ?>">

    <label for="Date_de_formatage">Date de formatage:</label>
    <input type="text" name="Date_de_formatage" value="<?php echo $row['Date_de_formatage']; ?>">

    <label for="Site">Site:</label>
    <input type="text" name="Site" value="<?php echo $row['Site']; ?>">

    <label for="Type_PC">Type PC:</label>
    <input type="text" name="Type_PC" value="<?php echo $row['Type_PC']; ?>">

    <label for="Marque_PC">Marque PC:</label>
    <input type="text" name="Marque_PC" value="<?php echo $row['Marque_PC']; ?>">

    <label for="NSerie">codebar:</label>
    <input type="text" name="NSerie" value="<?php echo $row['NSerie']; ?>">

    <label for="CPU">CPU:</label>
    <input type="text" name="CPU" value="<?php echo $row['CPU']; ?>">

    <label for="RAM">RAM:</label>
    <input type="text" name="RAM" value="<?php echo $row['RAM']; ?>">

    <label for="DD">DD:</label>
    <input type="text" name="DD" value="<?php echo $row['DD']; ?>">

    <label for="GPU">GPU:</label>
    <input type="text" name="GPU" value="<?php echo $row['GPU']; ?>">

    <label for="Mac_ethernet">Mac Ethernet:</label>
    <input type="text" name="Mac_ethernet" value="<?php echo $row['Mac_ethernet']; ?>">

    <label for="Mac_WIFI">Mac WIFI:</label>
    <input type="text" name="Mac_WIFI" value="<?php echo $row['Mac_WIFI']; ?>">

    <label for="Ancien_Nom_machine">Ancien Nom machine:</label>
    <input type="text" name="Ancien_Nom_machine" value="<?php echo $row['Ancien_Nom_machine']; ?>">

    <label for="date_added">Date added to stock:</label>
    <input type="text" name="date_added" value="<?php echo $row['date_added_to_stock']; ?>">

    <input type="submit" name="submit" value="Update">
</form>
<?php mysqli_close($conn);}}} ?>
<style>
    form {
  max-width: 500px;
  margin: 0 auto;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: bold;
}

input[type="text"] {
  display: block;
  width: 100%;
  padding: 8px;
  margin-bottom: 10px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input[type="submit"] {
  background-color: #4CAF50;
  color: #fff;
  padding: 10px 20px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

</style>

<script>
function showHideDiv() {
  var etatSelect = document.getElementById("etat");
  var divInput = document.getElementById("divInput");
  var main = document.getElementById("main");
  var returnDiv = document.getElementById("return"); // get the div element with id "return"
  if (etatSelect.value == "in use") {
    divInput.style.display = "block";
    main.style.display = "none";
    returnDiv.style.display = "none"; // hide the return div
  } else if (etatSelect.value == "in maintenance") {
    divInput.style.display = "none";
    main.style.display = "block";
    returnDiv.style.display = "none"; // hide the return div
  } else if (etatSelect.value == "return") {
    divInput.style.display = "none";
    main.style.display = "none";
    returnDiv.style.display = "block"; // show the return div
  } else {
    divInput.style.display = "none";
    main.style.display = "none";
    returnDiv.style.display = "none"; // hide the return div for other cases
  }
}


// call the function on page load to initialize the visibility of the div
showHideDiv();

// call the function on change of the etat select element
document.getElementById("etat").addEventListener("change", showHideDiv);


</script>
