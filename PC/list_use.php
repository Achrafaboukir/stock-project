<?php require 'nav.php' ;?><br><br>
<nav class=nav>
  <ul>
    <li><a href="liste_all.php" class="all">All</a></li>
    <li><a href="list_use.php" class="in-use">In Use</a></li>
    <li><a href="list_maintenance.php" class="in-maintenance">In Maintenance</a></li>
    <li><a href="list_stock.php" class="all">stock</a></li>
    <li><a href="list_retour.php" class="all">retour</a></li>
    <li><a href="list_pc_deleted.php" class="in-maintenance">ENDOMAGER</a></li>

  </ul>
</nav><br><br>
<form class="form" method="post" action="list_use.php">
    <div class="form__group">
      <label class="form__label" for="codebar">Serial Number:</label>
      <input class="form__input" type="text" id="codebar" name="codebar">

      <label class="form__label" for="NSerie">codebar:</label>
      <input class="form__input" type="text" id="NSerie" name="NSerie">

      <label class="form__label" for="Nom_de_Machine">Nom de machine:</label>
      <input class="form__input" type="text" id="Nom_de_Machine" name="Nom_de_Machine">

      <label class="form__label" for="Nom">Nom :</label>
      <input class="form__input" type="text" id="Nom" name="Nom">

      <label class="form__label" for="Prénom">Prénom :</label>
      <input class="form__input" type="text" id="Prénom" name="Prénom">

    </div>
    <button class="form__submit" type="submit">Filter</button>

</form>

<style>
     .tab{
    width:100%;
  }   
  table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 1rem;
  }
  
  th, td {
    height:60px ;
    text-align: center;
    border: 1px solid black;
    padding: 4px;

  }
  
  th {
    background-color: #f2f2f2;
  }
  
  tr:nth-child(even) {
    background-color: #f2f2f2;
  }
  
  a {
    color: blue;
    text-decoration: none;
    margin-right: 1rem;
  }
  
  a:hover {
    text-decoration: underline;
  }
  #filter{
    align-items:center;
    text-align:center;
    justify-content:center ;
    width:200px ;
    height:30px ;
    font-size : 20px;
    background-color:#333;
    color:white ;
  }
  
  .nav .all {
  color: black;
}

.nav .in-use {
  color: black;
}

.nav .in-maintenance {
  color: black;
}
.nav{
  background-color:white;
}
.form {
  
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  margin-bottom: 20px;
}

.form__group {
  
  flex-direction: column;
  margin-right: 20px;
}

.form__label {
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 5px;
}

.form__input {
  padding: 8px;
  border-radius: 4px;
  border: 1px solid #ccc;
  margin-bottom: 10px;
  font-size: 14px;
}

.form__submit {
  padding: 8px 20px;
  border-radius: 4px;
  background-color: #007bff;
  color: #fff;
  border: none;
  font-size: 14px;
  cursor: pointer;
}

.form__submit:hover {
  background-color: #0062cc;
}

    </style>
<h1>PC In Use List</h1>
	<table class='tab'>
		<thead>
			<tr>
				<th>N° Série</th>
				<th>Localisation</th>
        <th>Matricule</th>
        <th>Nom</th>
        <th>Prenom</th>
				<th>Etat</th>
				<th>Nom de Machine</th>
				<th>Date de formatage</th>
        <th>Manager</th>
        <th>Pilote</th>
				<th>Type PC</th>
				<th>Marque PC</th>
				<th>codebar</th>
				<th>CPU</th>
				<th>RAM</th>
				<th>DD</th>
				<th>GPU</th>
				<th>Mac ethernet</th>
				<th>Mac WIFI</th>
				<th>Ancien Nom machine</th>
        <th>Using date</th>
        <th>Affictation</th>
				<th>Date added to stock</th>
        <th>action</th>
			</tr>
		</thead>
		<tbody>
			<?php
      error_reporting(0);
      ini_set('display_errors', 0);
			include 'connexion.php'; // Include the database connection file
            $codebar = $_POST['codebar'];
            $NSerie = $_POST['NSerie'];
      $Nom_de_Machine = $_POST['Nom_de_Machine'];
      $Nom = $_POST['Nom'];
      $prenom = $_POST['Prénom'];

			$query = "SELECT * FROM pc where 1=1"; // Select all data from pcstock table
if (!empty($codebar)) {
  $query .= " AND codebar LIKE '%$codebar%'";
}
if (!empty($NSerie)) {
  $query .= " AND NSerie LIKE '%$NSerie%'";
}
if (!empty($Nom_de_Machine)) {
  $query .= " AND Nom_de_Machine LIKE '%$Nom_de_Machine%'";
}
if (!empty($Nom)) {
  $query .= " AND Nom LIKE '%$Nom%'";
}
if (!empty($prenom)) {
  $query .= " AND Prénom LIKE '%$prenom%'";
}

			$result = mysqli_query($conn, $query); // Execute the query using the $connection variable
			if (!$result) {
				die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
			}
      $nomCounts = array();
			while ($row = mysqli_fetch_assoc($result)) { 
        $nom = $row['Nom_de_Machine'];
        if (!isset($nomCounts[$nom])) {
            $nomCounts[$nom] = 0;
        }
        $nomCounts[$nom]++;
    
        // Add a style attribute to the table row if the count of this Nom_de_Machine is greater than 1
        $style = "";
        if ($nomCounts[$nom] > 1) {
            $style = "style='background-color: red;'";
        }// Loop through the result and output the data
                echo "<tr>";
                echo "<td><a href='http://10.15.17.131/circet/info.php?codebar=".$row['codebar']."'>".$row['codebar']."</a></td>";
                echo "<td>".$row['NSerie']."</td>";
                echo "<td>".$row['localisation']."</td>";
                echo "<td>".$row['Matricule']."</td>";
                echo "<td>".$row['Nom']."</td>";
                echo "<td>".$row['Prénom']."</td>";
				        echo "<td>".$row['etat']."</td>";
                echo "<td $style>".$row['Nom_de_Machine']."</td>";
                echo "<td>".$row['Date_de_formatage']."</td>";
                echo "<td>".$row['Manager']."</td>";
                echo "<td>".$row['Pilote']."</td>";
                echo "<td>".$row['Type_PC']."</td>";
                echo "<td>".$row['Marque_PC']."</td>";
                echo "<td>".$row['CPU']."</td>";
                echo "<td>".$row['RAM']."</td>";
                echo "<td>".$row['DD']."</td>";
                echo "<td>".$row['GPU']."</td>";
                echo "<td>".$row['Mac_ethernet']."</td>";
                echo "<td>".$row['Mac_WIFI']."</td>";
                echo "<td>".$row['Ancien_Nom_machine']."</td>";
                echo "<td>".$row['Using_date']."</td>";
                echo "<td><a href='affictation.php?codebar=".$row['codebar']."'>".$row['affictaion']." affictation"."</a></td>";
				        echo "<td>".$row['date_added_to_stock']."</td>";
                echo "<td>";
                echo "<a href='update_pc.php?etat=".$row['etat']."&localisation=".$row['localisation']."&Matricule=".$row['Matricule']."&Nom=".$row['Nom']."&Prénom=".$row['Prénom']."&codebar=".$row['codebar']."&Nom_de_Machine=".$row['Nom_de_Machine']."&Date_de_formatage=".$row['Date_de_formatage']."&Manager=".$row['Manager']."&Pilote=".$row['Pilote']."&Site=".$row['Site']."&Type_PC=".$row['Type_PC']."&Marque_PC=".$row['Marque_PC']."&NSerie=".$row['NSerie']."&CPU=".$row['CPU']."&RAM=".$row['RAM']."&DD=".$row['DD']."&GPU=".$row['GPU']."&Mac_ethernet=".$row['Mac_ethernet']."&Mac_WIFI=".$row['Mac_WIFI']."&Ancien_Nom_machine=".$row['Ancien_Nom_machine']."&Using_date=".$row['Using_date']."&affictaion=".$row['affictaion']."&date_added=".$row['date_added_to_stock']."'>Update</a>";
                echo "<a href='delete_pc.php?codebar=".$row['codebar']."&localisation=".$row['localisation']."&etat=".$row['etat']."&Nom_de_Machine=".$row['Nom_de_Machine']."&Date_de_formatage=".$row['Date_de_formatage']."&Site=".$row['Site']."&Type_PC=".$row['Type_PC']."&Marque_PC=".$row['Marque_PC']."&NSerie=".$row['NSerie']."&CPU=".$row['CPU']."&RAM=".$row['RAM']."&DD=".$row['DD']."&GPU=".$row['GPU']."&Mac_ethernet=".$row['Mac_ethernet']."&Mac_WIFI=".$row['Mac_WIFI']."&Ancien_Nom_machine=".$row['Ancien_Nom_machine']."&date_added=".$row['date_added_to_stock']."'onclick='return confirmDelete()''>ENDOMAGER</a>";
                echo '<script>
                function confirmDelete() {
                if (confirm("Are you sure you want to delete this record?")) {
                    return true;
                } else {
                    return false;
                }
                }
                </script>';
                echo "</td>";
                echo "</tr>";
			          }
			mysqli_free_result($result); // Free up memory allocated for the result set
			mysqli_close($conn); // Close the database connection
			?>
		</tbody>
	</table>