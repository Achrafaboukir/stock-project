<nav>
  <ul>
  <li><a class='a' onclick="history.go(-1)">Return</a></li>

  <li><a class='a' href="http://localhost/circet/navv.php">home</a></li>
  </ul>
</nav><br><br>

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
           
            

            $query = "SELECT * FROM suivi_maintenance_pc where codebar='$codebar' ;";
            
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
                echo "<td><a href='maintenance.php'>".$count."</a></td>";
                
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
        }
			?>
		</tbody>
	</table>
   