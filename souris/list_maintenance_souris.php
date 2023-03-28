<?php require 'navs.php' ;?><br><br>
<nav class=nav>
<ul>
<li><a href="http://localhost/circet/souris/list_all.php" class="all">All</a></li>
    <li><a href="http://localhost/circet/souris/list_use_souris.php" class="in-use">In Use</a></li>
    <li><a href="http://localhost/circet/souris/list_retour_souris.php" class="in-maintenance">retour</a></li>
    <li><a href="http://localhost/circet/souris/liste_souris.php" class="in-maintenance">stock</a></li>
    <li><a href="http://localhost/circet/souris/liste_souris_deleted.php" class="in-maintenance">ENDOMAGER</a></li>

 </ul>
</nav>
<h1>clavie maintenance List</h1>
<form method="post" action="list_maintenance_souris.php">
    <div class="form__group">
      <label class="form__label" for="num_serie">Serial Number:</label>
      <input class="form__input" type="text" id="NSerie" name="NSerie">
    </div>
    <div class="form__group">
      <label class="form__label" for="start_date">Start Date:</label>
      <input class="form__input" type="date" id="start_date" name="start_date">
    </div>
    <div class="form__group">
      <label class="form__label" for="end_date">End Date:</label>
      <input class="form__input" type="date" id="end_date" name="end_date">
    </div>
    <div class="form__group">
      <label class="form__label" for="technicien">technicien:</label>
      <input class="form__input" type="text" id="technicien" name="technicien">
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

    </style> 
    <table>
        <thead>
            <tr>
                <th>id maintenance</th>
                <th>num serie </th>
                <th>date maintenance </th>
                <th>technicien</th>
                <th>audit rapport</th>
                <th>number maintenance</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            error_reporting(0);
            ini_set('display_errors', 0);
            
            include 'connexion.php'; 
            $NSerie = $_POST['NSerie'];
            $start_date=$_POST['start_date'];
            $end_date=$_POST['end_date'];
            $technicien=$_POST['technicien'];

        $query = "SELECT * FROM suivi_maintenance_souris";
        if (!empty($codebar)) {
                $query .= " WHERE NSerie LIKE '%$NSerie%'";
                if (!empty($start_date)) {
                    $query .= " AND date_maintenance >= '$start_date'";
                }
                if (!empty($end_date)) {
                    $query .= " AND date_maintenance <= '$end_date'";
                }
                if (!empty($technicien)) {
                    $query .= " AND technicien LIKE '%$technicien%'";
                }
            } elseif (!empty($start_date)) {
                $query .= " WHERE date_maintenance >= '$start_date'";
                if (!empty($end_date)) {
                    $query .= " AND date_maintenance <= '$end_date'";
                }
                if (!empty($technicien)) {
                    $query .= " AND technicien  LIKE '%$technicien%'";
                }
            } elseif (!empty($end_date)) {
                $query .= " WHERE date_maintenance <= '$end_date'";
                if (!empty($technicien)) {
                    $query .= " AND technicien LIKE '%$technicien%'";
                }
            } elseif (!empty($technicien)) {
                $query .= " WHERE technicien LIKE '%$technicien%'";
            }

        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }
        while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['idmaintenance']."</td>";
                echo "<td>".$row['Nserie']."</td>";
                echo "<td>".$row['date_maintenance']."</td>";
                echo "<td>".$row['technicien']."</td>";
                echo "<td>".$row['audit_rapport']."</td>";
                $countQuery = "SELECT COUNT(*) AS count FROM suivi_maintenance_souris WHERE Nserie = '".$row['Nserie']."'";
                $countResult = mysqli_query($conn, $countQuery);
                $countRow = mysqli_fetch_assoc($countResult);
                $count = $countRow['count'];
                echo "<td>".$count."</td>";
                
                echo "<td>";
                
                echo "<a href='delete_souris_maintenance.php?idmaintenance=".$row['idmaintenance']."&Nserie=".$row['Nserie']."' onclick='return confirmDelete()'>Delete</a>";
                echo '<script>
    function confirmDelete() {
        if (confirm("Are you sure you want to delete this record?")) {
            return true;
        } else {
            return false;
        }
    }
</script>';
            }
                echo "</td>";
				echo "</tr>";
			
			mysqli_free_result($result); // Free up memory allocated for the result set
			mysqli_close($conn); // Close the database connection
			?>
		</tbody>
	</table>
<?php //  echo "<a href='update_clavier.php?num_serie=".$row['num_serie']."&idmaintenance=".$row['idmaintenance']."&date_maintenance=".$row['date_maintenance']."&etat=".'in maintenance'."&technicien=".$row['technicien']."&audit_rapport=".$row['audit_rapport']."'>Update</a>";
?>