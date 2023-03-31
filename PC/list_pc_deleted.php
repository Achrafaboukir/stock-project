<!DOCTYPE html>
<html>
<head><?php require 'nav.php' ;?>
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
<form class="form" method="post" action="list_pc_deleted.php">
<div class="form__group">
      <label class="form__label" for="codebar">Serial Number:</label>
      <input class="form__input" type="text" id="codebar" name="codebar">

      <label class="form__label" for="NSerie">codebar:</label>
      <input class="form__input" type="text" id="NSerie" name="NSerie">

      <label class="form__label" for="Nom_de_Machine">Nom de machine:</label>
      <input class="form__input" type="text" id="Nom_de_Machine" name="Nom_de_Machine">

    </div>
    <button class="form__submit" type="submit">Filter</button>

</form>
	<title>PC deleted List</title>
    <style>
        
		table {
  border-collapse: collapse;
  width: 100%;
  margin-bottom: 1rem;
}

th, td {
  padding: 0.75rem;
  text-align: left;
  border-bottom: 1px solid #ddd;
}

th {
  background-color: #f5f7fa;
  font-weight: bold;
}

tr:nth-child(even) {
  background-color: #fff;
}

tr:hover {
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
</head>
<body>
    
	<h1>PC Deleted List</h1>
	<table>
		<thead>
			<tr>
				<th>N°SERIE</th>
				<th>Localisation</th>
				<th>Etat</th>
				<th>Nom de Machine</th>
				<th>Date de formatage</th>
				<th>Site</th>
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
				<th>Date deleted</th>
                <th>action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			include 'connexion.php'; // Include the database connection file
			error_reporting(0);
ini_set('display_errors', 0);

			$codebar = $_POST['codebar'];
      $NSerie = $_POST['NSerie'];
      $Nom_de_Machine = $_POST['Nom_de_Machine'];

            $query = "SELECT * FROM pcfermerstock where 1=1 ";
            if (!empty($codebar)) {
              $query .= " AND codebar LIKE '%$codebar%'";
            }
            if (!empty($NSerie)) {
              $query .= " AND NSerie LIKE '%$NSerie%'";
          }
          if (!empty($Nom_de_Machine)) {
            $query .= " AND Nom_de_Machine LIKE '%$Nom_de_Machine%'";
        }
			$result = mysqli_query($conn, $query); // Execute the query using the $connection variable
			if (!$result) {
				die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
			}

			while ($row = mysqli_fetch_assoc($result)) { // Loop through the result and output the data
				echo "<tr>";
				echo "<td>".$row['codebar']."</td>";
				echo "<td>".$row['localisation']."</td>";
				echo "<td>".$row['etat']."</td>";
				echo "<td>".$row['Nom_de_Machine']."</td>";
				echo "<td>".$row['Date_de_formatage']."</td>";
				echo "<td>".$row['Site']."</td>";
				echo "<td>".$row['Type_PC']."</td>";
				echo "<td>".$row['Marque_PC']."</td>";
				echo "<td>".$row['NSerie']."</td>";
				echo "<td>".$row['CPU']."</td>";
				echo "<td>".$row['RAM']."</td>";
				echo "<td>".$row['DD']."</td>";
				echo "<td>".$row['GPU']."</td>";
				echo "<td>".$row['Mac_ethernet']."</td>";
				echo "<td>".$row['Mac_WIFI']."</td>";
				echo "<td>".$row['Ancien_Nom_machine']."</td>";
				echo "<td>".$row['date_deleted']."</td>";
                echo "<td>";
                echo "<a href='restore_pc.php?codebar=".$row['codebar']."&localisation=".$row['localisation']."&etat=".$row['etat']."&Nom_de_Machine=".$row['Nom_de_Machine']."&Date_de_formatage=".$row['Date_de_formatage']."&Site=".$row['Site']."&Type_PC=".$row['Type_PC']."&Marque_PC=".$row['Marque_PC']."&NSerie=".$row['NSerie']."&CPU=".$row['CPU']."&RAM=".$row['RAM']."&DD=".$row['DD']."&GPU=".$row['GPU']."&Mac_ethernet=".$row['Mac_ethernet']."&Mac_WIFI=".$row['Mac_WIFI']."&Ancien_Nom_machine=".$row['Ancien_Nom_machine']."&date_deleted=".$row['date_deleted']."'>RESTORE</a>";
                echo "</td>";
				echo "</tr>";
			}
			mysqli_free_result($result); // Free up memory allocated for the result set
			mysqli_close($conn); // Close the database connection
			?>
		</tbody>
	</table>
</body>
</html>
