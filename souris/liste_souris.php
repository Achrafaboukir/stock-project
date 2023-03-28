<?php require 'navs.php';?><br><br>
<nav class=nav>
<ul>
<li><a href="http://localhost/circet/souris/list_all.php" class="all">All</a></li>
    <li><a href="http://localhost/circet/souris/list_use_souris.php" class="in-use">In Use</a></li>
    <li><a href="http://localhost/circet/souris/list_retour_souris.php" class="in-maintenance">retour</a></li>
    <li><a href="http://localhost/circet/souris/liste_souris.php" class="in-maintenance">stock</a></li>
    <li><a href="http://localhost/circet/souris/liste_souris_deleted.php" class="in-maintenance">ENDOMAGER</a></li>
 </ul>
</nav>
<!DOCTYPE html>
<html>
<head>
	<title>SOURIS Stock List</title>
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
.alert{
  color:white ;
  background-color:red ;
}
</style>
</head>
<body>
	<form method="post" action="liste_souris.php">
		<div class="form__group">
      <label class="form__label" for="codebar">Serial Number:</label>
      <input class="form__input" type="text" id="NSerie" name="NSerie">
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
	<h1>SOURIS Stock List</h1>
	<table>
		<thead>
			<tr>
				<th> serial number : </th>
				<th>modele </th>
				<th>marque</th>
				<th>etat</th>
				<th>Date added</th>
        <th>RETURN VALUE</th>
				<th>action</th>
			</tr>
		</thead>
		<tbody>
			<?php
      error_reporting(0);
      ini_set('display_errors', 0);
			include 'connexion.php'; // Include the database connection file
			$NSerie=$_POST['NSerie'];
      $modele=$_POST['modele'];
      $marque=$_POST['marque'];

			$query = "SELECT * FROM souris_stock where etat='in stock'"; // Select all data from pcstock table
			
      if (!empty($NSerie)) {
        $query .= " AND NSerie LIKE '%{$NSerie}%'";
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
      $rows = mysqli_num_rows($result);

      if ($rows < 6) {
        echo "<h2 class='alert'> There are only $rows rows in the stock </h2>";
      }
      echo "<h4> $rows item";
			while ($row = mysqli_fetch_assoc($result)) { // Loop through the result and output the data
				echo "<tr>";
				echo "<td>".$row['NSerie']."</td>";
				echo "<td>".$row['Modele']."</td>";
				echo "<td>".$row['Marque']."</td>";
				echo "<td>".$row['etat']."</td>";
				echo "<td>".$row['Date_added']."</td>";
        echo "<td>".$row['return_value']."</td>";
                echo "<td>";
                echo "<a href='update_souris.php?NSerie=".$row['NSerie']."&Modele=".$row['Modele']."&Marque=".$row['Marque']."&etat=".$row['etat']."&Date_added=".$row['Date_added']."'>Update</a>";
                echo "<a href='delete_souris.php?NSerie=".$row['NSerie']."'onclick='return confirmDelete()''>ENDOMAGER</a>";
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
