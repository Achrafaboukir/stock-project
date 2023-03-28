<?php
// your database connection code here
require 'connexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $codebar = isset($_POST['codebar']) ? $_POST['codebar'] : '';
  $caracteristique = isset($_POST['caracteristique']) ? $_POST['caracteristique'] : '';
  $rnum_serie = isset($_POST['rnum_serie']) ? $_POST['rnum_serie'] : '';
  $modele = isset($_POST['modele']) ? $_POST['modele'] : '';
  $marque = isset($_POST['marque']) ? $_POST['marque'] : '';
  $etat = isset($_POST['etat']) ? $_POST['etat'] : '';
  $date_added = isset($_POST['date_added']) ? $_POST['date_added'] : '';
  $date_use = isset($_POST['date_use']) ? $_POST['date_use'] : '';

  if ($etat == "in use") {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM cable WHERE rnum_serie = ?");
    $stmt->bind_param("s", $rnum_serie);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_row();
    $count = $row[0];

    // Check if the codebar already exists in pcstock table
    $stmt = $conn->prepare("SELECT COUNT(*) FROM pcstock WHERE codebar = ?");
    $stmt->bind_param("s", $codebar);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_row();
    $pcstock_count = $row[0];

    if ($count > 0) {
        // if the record exists, update all fields
        $stmt = $conn->prepare( "UPDATE cable SET modele='$modele', marque='$marque',  etat='$etat',date_use=now(),codebar='$codebar',caracteristique='$caracteristique' WHERE rnum_serie='$rnum_serie';");
        $stmt->execute();
        $stmt = $conn->prepare("UPDATE cable_stock SET modele='$modele', marque='$marque',  etat='$etat'  WHERE rnum_serie='$rnum_serie';");
        $stmt->execute();
        if($pcstock_count > 0 && $stmt->execute()){
          header("Location: liste_cable.php");
          exit();
        }else{
          echo 'the asset must be in use first or the codebar does not exist in pcstock';
        }
    } else {
        // Insert into pc table
        if($pcstock_count > 0){
            $stmt = $conn->prepare("INSERT INTO cable (rnum_serie, codebar, modele, marque, etat, date_use ,caracteristique ) VALUES ( '$rnum_serie','$codebar', '$modele', '$marque', '$etat', now(), '$caracteristique' );");
            $stmt->execute();
            $stmt = $conn->prepare("UPDATE cable_stock SET modele='$modele', marque='$marque',  etat='$etat' ,caracteristique='$caracteristique' WHERE rnum_serie='$rnum_serie';");
            $stmt->execute();
            if($stmt->execute()){
              header("Location: liste_cable.php");
              exit();
            }else{
              echo 'the asset must be in use first';
            }
        }else{
            echo 'the codebar does not exist in pcstock';
        }
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
$date_maintenance=$_POST['date_maintenance'];
$technicien=$_POST['technicien'];
$audit = $_POST['audit'];
if ($etat == "in maintenance") {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM cable WHERE rnum_serie = ?");
    $stmt->bind_param("s", $rnum_serie);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_row();
    $count = $row[0];

    if ($count > 0) {
        $stmt = $conn->prepare("INSERT INTO suivi_maintenance_cable (rnum_serie,date_maintenance,technicien,audit_rapport)VALUES('$rnum_serie','$date_maintenance','$technicien','$audit'); ");
        $stmt->execute();
        $stmt = $conn->prepare("UPDATE cable SET etat='$etat' where rnum_serie='$rnum_serie';");
        $stmt->execute();
        header("Location: liste_cable.php");
    }else{
        echo 'the asset must be in use first ';
    }
}

$date_retour=isset($_POST['date_return']) ? $_POST['date_return'] : '';
$raison_return=isset($_POST['raison_return']) ? $_POST['raison_return'] : '';
$return_audit=isset($_POST['return_rapport']) ? $_POST['return_rapport'] : '';
//in case return
if ($etat == "return") {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM cable WHERE rnum_serie = ?");
    $stmt->bind_param("s", $rnum_serie);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_row();
    $count = $row[0];

    if ($count > 0) {
      

      $stmt = $conn->prepare("INSERT INTO retour_cable (rnum_serie, modele, marque, date_return,caracteristique, raison_return, audit_rapport) VALUES ('$rnum_serie', '$modele', '$marque', '$date_retour','$caracteristique', '$raison_return', '$return_audit')");
      $stmt->execute();
        $stmt = $conn->prepare("DELETE FROM cable where rnum_serie='$rnum_serie';");
        $stmt->execute();
        $stmt = $conn->prepare("UPDATE cable_stock SET etat='in stock',return_value='returned' where rnum_serie='$rnum_serie';");
        $stmt->execute();
        header("Location: liste_cable.php");
        
    }else{
        echo 'the asset must be in use first ';
    }
}
if($etat == "in stock"){
  $stmt = $conn->prepare("UPDATE cable_stock SET modele='$modele', marque='$marque',  etat='$etat' ,caracteristique='$caracteristique'  WHERE rnum_serie='$rnum_serie';");
      $stmt->execute();
      $stmt = $conn->prepare("DELETE FROM cable where rnum_serie='$rnum_serie';");
      $stmt->execute();
      $stmt = $conn->prepare("DELETE FROM suivi_maintenance_cable where rnum_serie='$rnum_serie';");
      $stmt->execute();
      $stmt = $conn->prepare("DELETE FROM retour_cable where rnum_serie='$rnum_serie';");
      $stmt->execute();
      if($stmt->execute()){
        header("Location: liste_cable.php");
        exit();
      }else{
        echo 'there is an error';
      }
  
}
}

if (isset($_GET['etat'])) {
  $rnum_serie=$_GET['rnum_serie'];
    $etat = $_GET['etat'];
    if($etat=='in stock' || $etat=='In Stock' ){
    $sql = "SELECT * from cable_stock where rnum_serie='$rnum_serie'";


    $result = $conn->query($sql);
  
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();

    
// close database connection

?>
<form method="post" action="update_cable.php">
        <div class="form__group">
            <label class="form__label" for="num_serie">Serial Number:</label>
            <input class="form__input" type="text" id="rnum_serie" name="rnum_serie" value="<?php echo $row['rnum_serie']; ?>" readonly>
        </div>
        <div class="form__group">
            <label class="form__label" for="modele">Modele:</label>
            <input class="form__input" type="text" id="modele" name="modele" value="<?php echo $row['modele']; ?>">
        </div>
        <div class="form__group">
            <label class="form__label" for="marque">Marque:</label>
            <input class="form__input" type="text" id="marque" name="marque" value="<?php echo $row['marque']; ?>">
        </div>
        <div class="form__group">
            <label class="form__label" for="caracteristique">caracteristique:</label>
            <input class="form__input" type="text" id="caracteristique" name="caracteristique" value="<?php echo $row['caracteristique']; ?>">
        </div>
        <select name="etat" id='etat'>
    <option value="in use" <?php if ($etat == 'in use') echo 'selected'; ?>>in use</option>
    <option value="in stock" <?php if ($etat == 'in stock') echo 'selected'; ?>>in stock</option>
    <option value="return" <?php if ($etat == 'return') echo 'selected'; ?>>return</option>
  </select>
        <div class="form__group">
            <label class="form__label" for="date_added">Date added:</label>
            <input class="form__input" type="date" id="date_added" name="date_added" value="<?php echo $row['date_added']; ?>">
        </div>

        <div id="divInput" style="<?php if ($row['etat'] != 'in use') echo 'display: none;'; ?>">
          <label class="form__label" for="marque">N°Serie:</label>
            <input class="form__input" type="text" id="codebar" name="codebar">
        </div>

        <div id="main" style="<?php if ($row['etat'] != 'in maintenance') echo 'display: none;'; ?>">
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

        <button class="form__submit" type="submit" name="update">Update</button>
</form>

<?php mysqli_close($conn);}}} ?>
<?php
if (isset($_GET['etat'])) {
    $etat = $_GET['etat'];
    $rnum_serie=$_GET['rnum_serie'];
    if($etat=='in use'){
    $sql = "SELECT * from cable where rnum_serie='$rnum_serie'";


    $result = $conn->query($sql);
  
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();

    
// close database connection

?>
<form method="post" action="update_cable.php">
        <div class="form__group">
            <label class="form__label" for="num_serie">Serial Number:</label>
            <input class="form__input" type="text" id="rnum_serie" name="rnum_serie" value="<?php echo $row['rnum_serie']; ?>" readonly>
        </div>
        <div class="form__group">
            <label class="form__label" for="modele">Modele:</label>
            <input class="form__input" type="text" id="modele" name="modele" value="<?php echo $row['modele']; ?>">
        </div>
        <div class="form__group">
            <label class="form__label" for="marque">Marque:</label>
            <input class="form__input" type="text" id="marque" name="marque" value="<?php echo $row['marque']; ?>">
        </div>
        <div class="form__group">
            <label class="form__label" for="caracteristique">caracteristique:</label>
            <input class="form__input" type="text" id="caracteristique" name="caracteristique" value="<?php echo $row['caracteristique']; ?>">
        </div>
        <select name="etat" id='etat'>
    <option value="in use" <?php if ($etat == 'in use') echo 'selected'; ?>>in use</option>
    <option value="in stock" <?php if ($etat == 'in stock') echo 'selected'; ?>>in stock</option>
    <option value="return" <?php if ($etat == 'return') echo 'selected'; ?>>return</option>
  </select>
        <div class="form__group">
            <label class="form__label" for="date_added">Date use:</label>
            <input class="form__input" type="date" id="date_added" name="date_added" value="<?php echo $row['date_use']; ?>">
        </div>

        <div id="divInput" style="<?php if ($row['etat'] != 'in use') echo 'display: none;'; ?>">
          <label class="form__label" for="marque">N°Serie:</label>
            <input class="form__input" type="text" id="codebar" name="codebar" value="<?php echo $row['codebar']; ?>">
        </div>

        <div id="main" style="<?php if ($row['etat'] != 'in maintenance') echo 'display: none;'; ?>">
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

        <button class="form__submit" type="submit" name="update">Update</button>
</form>
<?php mysqli_close($conn);}}} ?>
<?php
require 'connexion.php';
if (isset($_GET['etat'])) {
    $etat = $_GET['etat'];
    $rnum_serie=$_GET['rnum_serie'];
    if($etat=='return'){
    $sql = "SELECT cable_stock.*, retour_cable.*
    FROM cable_stock
    INNER JOIN retour_cable ON cable_stock.rnum_serie = retour_cable.rnum_serie
    WHERE cable_stock.rnum_serie = '$rnum_serie';
    ";


    $result = $conn->query($sql);
  
    if ($result->num_rows == 1) {
      $row = $result->fetch_assoc();

    
// close database connection

?>
<form method="post" action="update_cable.php">
        <div class="form__group">
            <label class="form__label" for="num_serie">Serial Number:</label>
            <input class="form__input" type="text" id="rnum_serie" name="rnum_serie" value="<?php echo $rnum_serie; ?>" readonly>
        </div>
        <div class="form__group">
            <label class="form__label" for="modele">Modele:</label>
            <input class="form__input" type="text" id="modele" name="modele" value="<?php echo $modele; ?>">
        </div>
        <div class="form__group">
            <label class="form__label" for="marque">Marque:</label>
            <input class="form__input" type="text" id="marque" name="marque" value="<?php echo $marque; ?>">
        </div>
        <div class="form__group">
            <label class="form__label" for="caracteristique">caracteristique:</label>
            <input class="form__input" type="text" id="caracteristique" name="caracteristique" value="<?php echo $row['caracteristique']; ?>">
        </div>
        <select name="etat" id='etat'>
    <option value="in stock" <?php if ($etat == 'in stock') echo 'selected'; ?>>in use</option>
    <option value="in use" <?php if ($etat == 'in use') echo 'selected'; ?>>in stock</option>
    <option value="return" <?php if ($etat == 'return') echo 'selected'; ?>>return</option>
  </select>
        <div class="form__group">
            <label class="form__label" for="date_added">Date added:</label>
            <input class="form__input" type="text" id="date_added" name="date_added" value="<?php echo $date_added; ?>">
        </div>
        <div id="divInput" style="<?php if ($row['etat'] != 'in use') echo 'display: none;'; ?>">
          <label class="form__label" for="marque">N°Serie:</label>
            <input class="form__input" type="text" id="codebar" name="codebar" >
        </div>
        <div id="main" style="<?php if ($row['etat'] != 'in maintenance') echo 'display: none;'; ?>">
          <label for="Matricule">Date maintenance:</label>
      <input type="date" id="date_maintenance" name="date_maintenance"  ><br>
      <label for="Nom">technicien:</label>
      <input type="text" id="technicien" name="technicien"   ><br>
      <label for="Prénom">audit rapport:</label>
      <input type="text" id="audit" name="audit"   ><br>
    </div>
    <div id="return" style="<?php if ($row['etat'] != 'return') echo 'display: none;'; ?>">
          <label for="Matricule">Date return:</label>
      <input type="date" id="date_return" name="date_return" ><br>
      <label for="Nom">raison return:</label>
      <input type="text" id="raison_return" name="raison_return" ><br>
      <label for="Prénom">audit rapport:</label>
      <input type="text" id="return_audit" name="return_rapport" ><br>
    </div>
        <button class="form__submit" type="submit" name="update">Update</button>
</form>
<?php mysqli_close($conn);}}} ?>




<?php
if (isset($_GET['etat'])) {
    $etat = $_GET['etat'];
    $rnum_serie=$_GET['rnum_serie'];
    
    if($etat=='in maintenance'){
    $sql = "SELECT * FROM cable where rnum_serie = '$rnum_serie';";
    $result = $conn->query($sql);
  
    if ($result->num_rows == 1 ) {
      $row = $result->fetch_assoc();
    
// close database connection

?>
<form method="post" action="update_cable.php">
        <div class="form__group">
            <label class="form__label" for="num_serie">Serial Number:</label>
            <input class="form__input" type="text" id="rnum_serie" name="rnum_serie" value="<?php echo $row['rnum_serie']; ?>" readonly>
        </div>
        
        <div class="form__group">
            <label class="form__label" for="modele">Modele:</label>
            <input class="form__input" type="text" id="modele" name="modele" value="<?php echo $row['modele']; ?>">
        </div>
        <div class="form__group">
            <label class="form__label" for="marque">Marque:</label>
            <input class="form__input" type="text" id="marque" name="marque" value="<?php echo $row['marque']; ?>">
        </div>
        <div class="form__group">
            <label class="form__label" for="caracteristique">caracteristique:</label>
            <input class="form__input" type="text" id="caracteristique" name="caracteristique" value="<?php echo $row['caracteristique']; ?>">
        </div>
        <select name="etat" id='etat'>
    <option value="in use" <?php if ($etat == 'in use') echo 'selected'; ?>>in use</option>
    <option value="in stock" <?php if ($etat == 'in stock') echo 'selected'; ?>>in stock</option>
    <option value="return" <?php if ($etat == 'return') echo 'selected'; ?>>return</option>
  </select>
  
        <div class="form__group">
            <label class="form__label" for="date_added">Date use:</label>
            <input class="form__input" type="date" id="date_added" name="date_added" value="<?php echo $row['date_use']; ?>">
        </div>

        <div id="divInput" style="<?php if ($row['etat'] != 'in use') echo 'display: none;'; ?>">
          <label class="form__label" for="marque">N°Serie:</label>
            <input class="form__input" type="text" id="codebar" name="codebar" value="<?php echo $row['codebar']; ?>">
        </div>
        <?php 
    $sqll = "SELECT * FROM suivi_maintenance_cable WHERE rnum_serie = $rnum_serie ORDER BY idmaintenance DESC LIMIT 1;";
    $resultt = $conn->query($sqll);

    // Check if any records were returned
    if ($resultt->num_rows > 0 ) {
      // Loop through each record and output it
      while ($roww = $resultt->fetch_assoc()) {
        ?>
        <div id="main" style="<?php if ($row['etat'] != 'in maintenance') echo 'display: none;'; ?>">
          <label for="Matricule">Date maintenance:</label>
      <input type="date" id="date_maintenance" name="date_maintenance" value="<?php echo $roww['date_maintenance']; ?>" ><br>
      <label for="Nom">technicien:</label>
      <input type="text" id="technicien" name="technicien"  value="<?php echo $roww['technicien']; ?>" ><br>
      <label for="Prénom">audit rapport:</label>
      <input type="text" id="audit" name="audit"  value="<?php echo $roww['audit_rapport']; ?>" ><br>
    </div>

    <div id="return" style="<?php if ($row['etat'] != 'return') echo 'display: none;'; ?>">
          <label for="Matricule">Date return:</label>
      <input type="date" id="date_return" name="date_return" ><br>
      <label for="Nom">raison return:</label>
      <input type="text" id="raison_return" name="raison_return" ><br>
      <label for="Prénom">audit rapport:</label>
      <input type="text" id="return_audit" name="return_rapport" ><br>
    </div>
<?php } }?>
        <button class="form__submit" type="submit" name="update">Update</button>
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



