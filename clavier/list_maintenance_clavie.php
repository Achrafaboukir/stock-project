<?php require 'navc.php' ;?><br><br>
<nav class=nav>
  <ul>
    <li><a href="http://localhost/circet/clavier/list_all.php" class="all">All</a></li>
    <li><a href="http://localhost/circet/clavier/list_use_clavie.php" class="in-use">In Use</a></li>
    <li><a href="http://localhost/circet/clavier/list_maintenance_clavie.php" class="in-maintenance">In Maintenance</a></li>
  </ul>
</nav><br>
<h1>clavie maintenance List</h1>
<form method="post" action="list_maintenance_clavie.php">
    <div class="form__group">
      <label class="form__label" for="num_serie">Serial Number:</label>
      <input class="form__input" type="text" id="num_serie" name="num_serie">
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
            include 'connexion.php'; 
            $num_serie = $_POST['num_serie'];
        $query = "SELECT * FROM suivi_maintenance_clavie";
        if (!empty($num_serie)) {
            $query .= " WHERE num_serie = '".$num_serie."'";
        }
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }
        while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['idmaintenance']."</td>";
                echo "<td>".$row['num_serie']."</td>";
                echo "<td>".$row['date_maintenance']."</td>";
                echo "<td>".$row['technicien']."</td>";
                echo "<td>".$row['audit_rapport']."</td>";
                $countQuery = "SELECT COUNT(*) AS count FROM suivi_maintenance_clavie WHERE num_serie = '".$row['num_serie']."'";
                $countResult = mysqli_query($conn, $countQuery);
                $countRow = mysqli_fetch_assoc($countResult);
                $count = $countRow['count'];
                echo "<td>".$count."</td>";
                
                echo "<td>";
                
                echo "<a href='delete_clavier_maintenance.php?idmaintenance=".$row['idmaintenance']."&num_serie=".$row['num_serie']."' onclick='return confirmDelete()'>Delete</a>";
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