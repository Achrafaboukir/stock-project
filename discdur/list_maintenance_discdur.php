<?php require 'navc.php' ;?><br><br>
<h1>discdur maintenance List</h1>
<form method="post" action="list_maintenance_discdur.php">
    <div class="form__group">
      <label class="form__label" for="num_serie">Serial Number:</label>
      <input class="form__input" type="text" id="dnum_serie" name="dnum_serie">
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
            $dnum_serie = $_POST['dnum_serie'];
        $query = "SELECT * FROM suivi_maintenance_disc_dur";
        if (!empty($dnum_serie)) {
            $query .= " WHERE dnum_serie = '".$dnum_serie."'";
        }
        $result = mysqli_query($conn, $query);
        if (!$result) {
            die("Query failed: " . mysqli_error($conn));
        }
        while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>".$row['idmaintenance']."</td>";
                echo "<td>".$row['dnum_serie']."</td>";
                echo "<td>".$row['date_maintenance']."</td>";
                echo "<td>".$row['technicien']."</td>";
                echo "<td>".$row['audit_rapport']."</td>";
                $countQuery = "SELECT COUNT(*) AS count FROM suivi_maintenance_disc_dur WHERE dnum_serie = '".$row['dnum_serie']."'";
                $countResult = mysqli_query($conn, $countQuery);
                $countRow = mysqli_fetch_assoc($countResult);
                $count = $countRow['count'];
                echo "<td>".$count."</td>";
                
                echo "<td>";
                
                echo "<a href='delete_discdur_maintenance.php?idmaintenance=".$row['idmaintenance']."&dnum_serie=".$row['dnum_serie']."' onclick='return confirmDelete()'>Delete</a>";
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