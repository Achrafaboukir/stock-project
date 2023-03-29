<?php require 'nav.php' ;?><br><br>
<nav class=nav>
  <ul>
    <li><a href="http://localhost/circet/PC/liste_all.php" class="all">All</a></li>
    <li><a href="http://localhost/circet/PC/list_use.php" class="in-use">In Use</a></li>
    <li><a href="http://localhost/circet/PC/list_maintenance.php" class="in-maintenance">In Maintenance</a></li>
    <li><a href="http://localhost/circet/PC/list_stock.php" class="all">stock</a></li>
    <li><a href="http://localhost/circet/PC/list_retour.php" class="all">retour</a></li>
    <li><a href="http://localhost/circet/PC/list_pc_deleted.php" class="in-maintenance">ENDOMAGER</a></li>
  </ul>
</nav>

<form class="form" method="post" action="liste_all.php">
    <div class="form__group">
      <label class="form__label" for="codebar">Serial Number:</label>
      <input class="form__input" type="text" id="codebar" name="codebar">

      <label class="form__label" for="NSerie">codebar:</label>
      <input class="form__input" type="text" id="NSerie" name="NSerie">

      <label class="form__label" for="Nom_de_Machine">Nom de machine:</label>
      <input class="form__input" type="text" id="Nom_de_Machine" name="Nom_de_Machine">

      <label class="form__label" for="proprietaire">Proprietaire:</label>
      <input class="form__input" type="text" id="proprietaire" name="proprietaire">
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
    background-color: #d4efef;
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
<h1>PC Stock List</h1>
	<table>
		<thead>
			<tr>
				<th>N° Série</th>
        <th>return_value</th>
				<th>Localisation</th>
        <th>proprietaire</th>
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
				<th>Date added</th>
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
      $proprietaire =$_POST['proprietaire'];

            $query = "SELECT * FROM pcstock where etat='in use' or etat='in stock' or etat='in maintenance' ";
            if (!empty($codebar)) {
              $query .= " AND codebar LIKE '%$codebar%'";
            }
            if (!empty($NSerie)) {
              $query .= " AND NSerie LIKE '%$NSerie%'";
          }
          if (!empty($Nom_de_Machine)) {
            $query .= " AND Nom_de_Machine LIKE '%$Nom_de_Machine%'";
        }
        if (!empty($proprietaire)) {
          $query .= " AND proprietaire LIKE '%$proprietaire%'";
      }

			$result = mysqli_query($conn, $query); // Execute the query using the $connection variable
			if (!$result) {
				die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
			}
			while ($row = mysqli_fetch_assoc($result)) { // Loop through the result and output the data
				echo "<tr>";
        echo "<td><a href='http://localhost/circet/info.php?codebar=".$row['codebar']."'>".$row['codebar']."</a></td>";
        echo "<td>".$row['return_value']."</td>";
				echo "<td>".$row['localisation']."</td>";
                echo "<td>".$row['proprietaire']."</td>";
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
				echo "<td>".$row['date_added']."</td>";
                echo "<td>";
                echo "<a href='update_pc.php?codebar=".$row['codebar']."&localisation=".$row['localisation']."&etat=".$row['etat']."&Nom_de_Machine=".$row['Nom_de_Machine']."&Date_de_formatage=".$row['Date_de_formatage']."&Site=".$row['Site']."&Type_PC=".$row['Type_PC']."&Marque_PC=".$row['Marque_PC']."&NSerie=".$row['NSerie']."&CPU=".$row['CPU']."&RAM=".$row['RAM']."&DD=".$row['DD']."&GPU=".$row['GPU']."&Mac_ethernet=".$row['Mac_ethernet']."&Mac_WIFI=".$row['Mac_WIFI']."&Ancien_Nom_machine=".$row['Ancien_Nom_machine']."&date_added=".$row['date_added']."'>Update</a>";
                echo "<a href='delete_pc.php?codebar=".$row['codebar']."&localisation=".$row['localisation']."&etat=".$row['etat']."&Nom_de_Machine=".$row['Nom_de_Machine']."&Date_de_formatage=".$row['Date_de_formatage']."&Site=".$row['Site']."&Type_PC=".$row['Type_PC']."&Marque_PC=".$row['Marque_PC']."&NSerie=".$row['NSerie']."&CPU=".$row['CPU']."&RAM=".$row['RAM']."&DD=".$row['DD']."&GPU=".$row['GPU']."&Mac_ethernet=".$row['Mac_ethernet']."&Mac_WIFI=".$row['Mac_WIFI']."&Ancien_Nom_machine=".$row['Ancien_Nom_machine']."&date_added=".$row['date_added']."' onclick='return confirmDelete()'>ENDOMAGER</a>";
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