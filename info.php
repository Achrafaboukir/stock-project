
<nav>
  <ul>
  <li><a class='a' onclick="history.go(-1)">Return</a></li>

  <li><a class='a' href="http://localhost/circet/navv.php">home</a></li>
  </ul>
</nav>

<style>
nav {
  background-color: #333;
  display: flex;
  justify-content: center;
  height : 50px ;
  align-items : center ;
}

ul {
  display: flex;
  list-style: none;
  margin: 0;
  padding: 0;
}

li {
  margin: 0 10px;
}

.a {
  color: #fff;
  text-decoration: none;
  text-transform: uppercase;
  padding: 10px;
  transition: background-color 0.2s ease;
}

.a:hover {
  background-color: #555;
}
</style>

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
  </style>

  <?php
   include 'connexion.php';
    if (isset($_GET['codebar'])) {
        $codebar = $_GET['codebar'];

        ?>

<table>
		<thead>
            <h1>LIST PC</h1>
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
			</tr>
		</thead>
		<tbody>
<?php 
     
        $query = "SELECT * FROM pcstock where codebar='$codebar' ";
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
                echo "</tr>";
            }

    
?>
</table><br><br>



<?php 
if (!empty($codebar)) {
    include 'connexion.php'; // Include the database connection file
    $query = "SELECT * FROM souris where codebar='$codebar'"; // Select all data from souris table
    $result = mysqli_query($conn, $query); // Execute the query using the $conn variable
    if (!$result) {
        die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
    }
    $num_rows = mysqli_num_rows($result); // Get the number of rows returned by the query
    if ($num_rows > 0) { // Show the table only if there is at least one row returned by the query
?>
<br><br>
    <table>
        
        <thead>
            <h1>SOURIS List</h1>
            <tr>
                <th> serial number : </th>
                <th>modele </th>
                <th>marque</th>
                <th>etat</th>
                <th>Date use</th>
                <th>N°Serie</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) { // Loop through the result and output the data
                echo "<tr>";
                echo "<td>".$row['NSerie']."</td>";
                echo "<td>".$row['Modele']."</td>";
                echo "<td>".$row['Marque']."</td>";
                echo "<td>".$row['etat']."</td>";
                echo "<td>".$row['Date_use']."</td>";
                echo "<td>".$row['codebar']."</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    
<?php
    } else { // No data found, so hide the table
        
    }
}
?>


<br><br>


<?php 
if (!empty($codebar)) {
    include 'connexion.php'; // Include the database connection file
    $query = "SELECT * FROM ram WHERE codebar='$codebar'"; // Select all data from ram table
    $result = mysqli_query($conn, $query); // Execute the query using the $connection variable
    
    if (!$result) {
        die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
    }
    
    if (mysqli_num_rows($result) > 0) { // Check if the codebar is found in the table
?>
    <table>
        <thead>
            <h1> ram list </h1>
            <tr>
                <th> serial number : </th>
                <th>modele </th>
                <th>marque</th>
                <th>caracteristique</th>
                <th>etat</th>
                <th>Date use</th>
                <th>N°Serie</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) { // Loop through the result and output the data
                echo "<tr>";
                echo "<td>".$row['rnum_serie']."</td>";
                echo "<td>".$row['modele']."</td>";
                echo "<td>".$row['marque']."</td>";
                echo "<td>".$row['caracteristique']."</td>";
                echo "<td>".$row['etat']."</td>";
                echo "<td>".$row['date_use']."</td>";
                echo "<td>".$row['codebar']."</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
<?php
    } else {
        
    }
}
?>


<br><br>
<?php 
if (!empty($codebar)) {

	include 'connexion.php'; // Include the database connection file
	$query = "SELECT * FROM ecran where codebar='$codebar'"; // Select all data from ecran table
	  
	$result = mysqli_query($conn, $query); // Execute the query using the $connection variable
	if (!$result) {
		die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
	}
	if (mysqli_num_rows($result) > 0) { // Check if any rows are returned
?>

	<table>
		<h1>ecran Stock List</h1>
		<thead>
			<tr>
				<th> serial number : </th>
				<th>modele </th>
				<th>marque</th>
				<th>caracteristique</th>
				<th>etat</th>
				<th>Date use</th>
        		<th>pc N°serie</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($row = mysqli_fetch_assoc($result)) { // Loop through the result and output the data
				echo "<tr>";
				echo "<td>".$row['rnum_serie']."</td>";
				echo "<td>".$row['modele']."</td>";
				echo "<td>".$row['marque']."</td>";
				echo "<td>".$row['caracteristique']."</td>";
				echo "<td>".$row['etat']."</td>";
				echo "<td>".$row['date_use']."</td>";
                echo "<td>".$row['codebar']."</td>";
				echo "</tr>";
            }
         ?>
		</tbody>
	</table>
<?php
	} else {
		
	}
}
?>


<br><br>


<?php 
if (!empty($codebar)) {
	include 'connexion.php';
	$query = "SELECT * FROM disc_dur where codebar='$codebar'";
	$result = mysqli_query($conn, $query);
	if (!$result) {
		die("Query failed: " . mysqli_error($conn));
	}
	if (mysqli_num_rows($result) > 0) { // If there are rows, display the table
?>
	<table class='discdur'>
		<h1>DISCDUR Stock List</h1>
		<thead>
			<tr>
				<th> serial number : </th>
				<th>modele </th>
				<th>marque</th>
				<th>caracteristique</th>
				<th>etat</th>
				<th>Date use</th>
				<th>N°Serie</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($row = mysqli_fetch_assoc($result)) {
				echo "<tr>";
				echo "<td>".$row['dnum_serie']."</td>";
				echo "<td>".$row['modele']."</td>";
				echo "<td>".$row['marque']."</td>";
				echo "<td>".$row['caracteristique']."</td>";
				echo "<td>".$row['etat']."</td>";
				echo "<td>".$row['date_use']."</td>";
				echo "<td>".$row['codebar']."</td>";
				echo "</tr>";
			}
			?>
		</tbody>
	</table>
<?php
	} else { // If there are no rows, display a message or simply hide the table using CSS
?>
	
	<style>
		.discdur { display: none; }
	</style>
<?php
	}
}
?>






   <?php 
if (!empty($codebar)) {

    include 'connexion.php'; // Include the database connection file
    $query = "SELECT * FROM clavie where codebar='$codebar'"; // Select all data from clavie table
    $result = mysqli_query($conn, $query); // Execute the query using the $connection variable
    
    if (!$result) {
        die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
    }
    
    if (mysqli_num_rows($result) > 0) { // Only display the table if there are results
?>

	<table>
        <h1>CLAVIE Stock List</h1>
		<thead>
			<tr>
				<th> serial number : </th>
				<th>modele </th>
				<th>marque</th>
				<th>etat</th>
				<th>Date use</th>
                <th>N°Serie</th>
				<th>action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($row = mysqli_fetch_assoc($result)) { // Loop through the result and output the data
				echo "<tr>";
				echo "<td>".$row['num_serie']."</td>";
				echo "<td>".$row['modele']."</td>";
				echo "<td>".$row['marque']."</td>";
				echo "<td>".$row['etat']."</td>";
				echo "<td>".$row['date_use']."</td>";
                echo "<td>".$row['codebar']."</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
<?php 
    } // end if mysqli_num_rows
} // end if !empty
?>



<br><br>



<?php 
if (!empty($codebar)) {
	$query = "SELECT * FROM cable where codebar='$codebar'";
	$result = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) > 0) { // Check if there are any rows returned by the query
?>

	<table class='cable'>
		<h1>cable Stock List</h1>
		<thead>
			<tr>
				<th> serial number : </th>
				<th>modele </th>
				<th>marque</th>
				<th>caracteristique</th>
				<th>etat</th>
				<th>Date use</th>
				<th>N°Serie</th>
			</tr>
		</thead>
		<tbody>
			<?php
			while ($row = mysqli_fetch_assoc($result)) { // Loop through the result and output the data
				echo "<tr>";
				echo "<td>".$row['rnum_serie']."</td>";
				echo "<td>".$row['modele']."</td>";
				echo "<td>".$row['marque']."</td>";
				echo "<td>".$row['caracteristique']."</td>";
				echo "<td>".$row['etat']."</td>";
				echo "<td>".$row['date_use']."</td>";
				echo "<td>".$row['codebar']."</td>";
				echo "</tr>";
			}
			?>
		</tbody>
	</table>

<?php 
	} else { // If no rows are returned, hide the table
?>
	<style>
		.cable {
			display: none;
		}
	</style>
<?php
	}
}
?>



        <br><br>
        <?php
error_reporting(0);
ini_set('display_errors', 0);
include 'connexion.php';

if (!empty($codebar)) {
	$query = "SELECT * FROM adaptateur WHERE codebar='$codebar'";
	$result = mysqli_query($conn, $query);
?>

	<?php if (mysqli_num_rows($result) > 0) { ?>
		<table>
			<h1>adaptateur Stock List</h1>
			<thead>
				<tr>
					<th> serial number : </th>
					<th>modele </th>
					<th>marque</th>
					<th>caracteristique</th>
					<th>etat</th>
					<th>Date use</th>
					<th>N°Serie</th>
				</tr>
			</thead>
			<tbody>
	
			<?php while ($row = mysqli_fetch_assoc($result)) { ?>
				<tr>
					<td><?= $row['rnum_serie'] ?></td>
					<td><?= $row['modele'] ?></td>
					<td><?= $row['marque'] ?></td>
					<td><?= $row['caracteristique'] ?></td>
					<td><?= $row['etat'] ?></td>
					<td><?= $row['date_use'] ?></td>
					<td><?= $row['codebar'] ?></td>
				</tr>
			<?php } ?>
	
			</tbody>
		</table>
	<?php } ?>
	
<?php }} ?>


        
        