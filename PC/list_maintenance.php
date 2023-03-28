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
<h1>PC maintenance List</h1>
<form class="form" method="post" action="list_maintenance.php">
    <div class="form__group">
      <label class="form__label" for="codebar">Serial Number:</label>
      <input class="form__input" type="text" id="codebar" name="codebar">
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
    <table>
        <thead>
            <tr>
                <th>N°SERIE</th>
                <th>date mantenance </th>
                <th>technicien</th>
                <th>audit rapport</th>
                <th>codebar</th>
                <th>number maintenance</th>
                <th>action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            error_reporting(0);
            ini_set('display_errors', 0);
            include 'connexion.php'; 
            $codebar = $_POST['codebar'];
            $start_date=$_POST['start_date'];
            $end_date=$_POST['end_date'];
            $technicien=$_POST['technicien'];

            $query = "SELECT * FROM suivi_maintenance_pc";
            if (!empty($codebar)) {
                $query .= " WHERE codebar LIKE '%$codebar%'";
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
                echo "<td>".$row['codebar']."</td>";
                echo "<td>".$row['date_maintenance']."</td>";
                echo "<td>".$row['technicien']."</td>";
                echo "<td>".$row['audit_rapport']."</td>";
                echo "<td>".$row['NSerie']."</td>";
                $countQuery = "SELECT COUNT(*) AS count FROM suivi_maintenance_pc WHERE codebar = '".$row['codebar']."' OR NSerie = '".$row['NSerie']."'";
                $countResult = mysqli_query($conn, $countQuery);
                $countRow = mysqli_fetch_assoc($countResult);
                $count = $countRow['count'];
                echo "<td>".$count."</td>";
                
                echo "<td>";
                
                echo "<a href='delete_pc_maintenance.php?codebar=".$row['codebar']."&idmaintenance=".$row['idmaintenance']."&NSerie=".$row['NSerie']."&date_maintenance=".$row['date_maintenance']."&technicien=".$row['technicien']."&audit_rapport=".$row['audit_rapport']."&etat=".'in maintenance'."' onclick='return confirmDelete()'>Delete</a>";
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
      //      echo "<a href='update_pc.php?idmaintenance=".$row['idmaintenance']."&codebar=".$row['codebar']."&date_maintenance=".$row['date_maintenance']."&technicien=".$row['technicien']."&audit_rapport=".$row['audit_rapport']."&etat=".'in maintenance'."'>Update</a>";

			?>
		</tbody>
	</table>
   