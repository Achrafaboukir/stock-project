<?php require 'navc.php';?><br><br>
<nav class=nav>
  <ul>
    <li><a href="list_all.php" class="all">All</a></li>
    <li><a href="list_use_adaptateur.php" class="in-use">In Use</a></li>
    <li><a href="list_retour_adaptateur.php" class="in-maintenance">Roteur</a></li>
    <li><a href="liste_adaptateur_deleted.php" class="in-maintenance">ENDEMAGER</a></li>

  </ul>
</nav>
<!DOCTYPE html>
<html>
<head>

	<title>adaptateur all  List</title>
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
	<form method="post" action="list_all.php">
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
    <button class="form__submit" type="submit">Filter</button>
	</form>
	<h1>CLAVIE Stock List</h1>
	<table>
		<thead>
			<tr>
				<th> serial number : </th>
				<th>modele </th>
        <th>return value </th>
				<th>marque</th>
				<th>etat</th>
				<th>Date added</th>
        <th>return value</th>
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
			$query = "SELECT * FROM adaptateur_stock where 1=1 "; // Select all data from pcstock table
			if (!empty($rnum_serie)) {
                $query .= " AND rnum_serie = '{$rnum_serie}'";
            }
            if (!empty($marque)) {
              $query .= " AND marque LIKE '%{$marque}%'";
            }
      
            if (!empty($modele)) {
              $query .= " AND modele LIKE '%{$modele}%'";
            }

			$result = mysqli_query($conn, $query); // Execute the query using the $connection variable
			if (!$result) {
				die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
			}
			while ($row = mysqli_fetch_assoc($result)) { // Loop through the result and output the data
				echo "<tr>";
				echo "<td>".$row['rnum_serie']."</td>";
				echo "<td>".$row['modele']."</td>";
        echo "<td>".$row['return_value']."</td>";
				echo "<td>".$row['marque']."</td>";
				echo "<td>".$row['etat']."</td>";
				echo "<td>".$row['date_added']."</td>";
        echo "<td>".$row['return_value']."</td>";
                echo "<td>";
                echo "<a href='update_adaptateur.php?rnum_serie=".$row['rnum_serie']."&modele=".$row['modele']."&marque=".$row['marque']."&etat=".$row['etat']."&date_added=".$row['date_added']."'>Update</a>";
                echo "<a href='delete_adaptateur.php?rnum_serie=".$row['rnum_serie']."'onclick='return confirmDelete()''>ENDOMAGER</a>";
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
