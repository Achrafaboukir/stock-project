<!DOCTYPE html>
<html>
<head><?php require 'navc.php' ;?><br><br>
<nav class=nav>
  <ul>
    <li><a href="http://localhost/circet/clavier/list_all.php" class="all">All</a></li>
    <li><a href="http://localhost/circet/clavier/list_use_clavie.php" class="in-use">In Use</a></li>
    <li><a href="http://localhost/circet/clavier/list_retour_clavie.php" class="in-maintenance">ROTEUR</a></li>
    <li><a href="http://localhost/circet/clavier/list_clavie_deleted.php" class="in-maintenance">ENDOMAGER</a></li>
  </ul>
</nav><br><br>
<form method="post" action="list_clavie_deleted.php">
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
    <style>
        
  table {
    border-collapse: collapse;
    width: 100%;
    margin-bottom: 1rem;
  }
  
  th, td {
    padding: 0.75rem;
    text-align: left;
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
    
	<h1>clavie endomager List</h1>
	<table>
		<thead>
			<tr>
				<th>serie num</th>
				<th>modele</th>
				<th>marque</th>
				<th>etat</th>
				<th>Date delete</th>
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
			$query = "SELECT * FROM clavie_stock_fermer where 1=1"; // Select all data from pcstock table

      if (!empty($NSerie)) {
				$query .= " AND num_serie LIKE '%{$NSerie}%'";
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
				echo "<td>".$row['num_serie']."</td>";
				echo "<td>".$row['modele']."</td>";
				echo "<td>".$row['marque']."</td>";
				echo "<td>".$row['etat']."</td>";
				echo "<td>".$row['date_deleted']."</td>";
                echo "<td>";
                echo "<a href='restore_clavie.php?num_serie=".$row['num_serie']."'>RESTORE</a>";
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
