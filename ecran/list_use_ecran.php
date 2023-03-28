<?php require 'navc.php';?>
<nav class=nav>
  <ul>
    <li><a href="http://localhost/circet/ecran/list_all.php" class="all">All</a></li>
    <li><a href="http://localhost/circet/ecran/list_use_ecran.php" class="in-use">In Use</a></li>
    <li><a href="http://localhost/circet/ecran/list_retour_ecran.php" class="retour">retour</a></li>
	<li><a href="http://localhost/circet/ecran/liste_ecran.php" class="retour">stock</a></li>
    <li><a href="http://localhost/circet/ecran/liste_ecran_deleted.php" class="retour">endomager</a></li>

  </ul>
</nav>
<!DOCTYPE html>
<html>
<head>
	<title>ecran Stock List</title>
    <style>
  table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 1rem;
  }
  
  th, td {
    padding: 0.75rem;
    text-align: left;
    border: 1px solid #ddd;
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
  
  a:hover {list_use_ecran
    text-decoration: underline;
  }
  .nav .all {
  color: black;
}

.nav .in-use {
  color: black;
}

.nav .retour {
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
	<form method="post" action="list_use_ecran.php">
		<div class="form__group">
      <label class="form__label" for="codebar">Serial Number:</label>
      <input class="form__input" type="text" id="rnum_serie" name="rnum_serie">
    </div>
	<div class="form__group">
      <label class="form__label" for="modele">modele:</label>
      <input class="form__input" type="text" id="modele" name="modele">
    </div>

    <div class="form__group">
      <label class="form__label" for="marque">marque:</label>
      <input class="form__input" type="text" id="marque" name="marque">
    </div>

    <div class="form__group">
      <label class="form__label" for="nserie">pc n°serie:</label>
      <input class="form__input" type="text" id="nnserie" name="nnserie">
    </div>

    <button class="form__submit" type="submit">Filter</button>
	</form>
	<h1>ecran Stock List</h1>
	<table>
		<thead>
			<tr>
				<th> serial number : </th>
				<th>modele </th>
				<th>marque</th>
				<th>caracteristique</th>
				<th>etat</th>
				<th>Date use</th>
        		<th>pc N°serie</th>
				<th>action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			error_reporting(0);
			ini_set('display_errors', 0);
			include 'connexion.php'; // Include the database connection file
			$rnum_serie=$_POST['rnum_serie'];
			$modele=$_POST['modele'];
			$marque=$_POST['marque'];
			$nserie=$_POST['nnserie'];
			$query = "SELECT * FROM ecran where 1=1"; // Select all data from pcstock table
			if (!empty($rnum_serie)) {
                $query .= " AND rnum_serie = '{$rnum_serie}'";
            }
			if (!empty($marque)) {
				$query .= " AND marque LIKE '%{$marque}%'";
			  }
		
			  if (!empty($modele)) {
				$query .= " AND modele LIKE '%{$modele}%'";
			  }
		
			  if (!empty($nserie)) {
				$query .= " AND codebar LIKE '%{$nserie}%'";
			  }
			  
			$result = mysqli_query($conn, $query); // Execute the query using the $connection variable
			if (!$result) {
				die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
			}
			while ($row = mysqli_fetch_assoc($result)) { // Loop through the result and output the data
				echo "<tr>";
				echo "<td>".$row['rnum_serie']."</td>";
				echo "<td>".$row['modele']."</td>";
				echo "<td>".$row['marque']."</td>";
				echo "<td>".$row['caracteristique']."</td>";
				echo "<td>".$row['etat']."</td>";
				echo "<td>".$row['date_use']."</td>";
        echo "<td><a href='http://localhost/circet/info.php?codebar=".$row['codebar']."'>".$row['codebar']."</a></td>";
                echo "<td>";
                echo "<a href='update_ecran.php?rnum_serie=".$row['rnum_serie']."&modele=".$row['modele']."&marque=".$row['marque']."&caracteristique=".$row['caracteristique']."&etat=".$row['etat']."&date_use=".$row['date_use']."'>Update</a>";
                echo "<a href='delete_ecran.php?rnum_serie=".$row['rnum_serie']."'onclick='return confirmDelete()''>Delete</a>";
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
</body>
</html>
