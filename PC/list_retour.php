<?php require 'nav.php' ;?><br><br>
<nav class=nav>
  <ul>
    <li><a href="liste_all.php" class="all">All</a></li>
    <li><a href="list_use.php" class="in-use">In Use</a></li>
    <li><a href="list_maintenance.php" class="in-maintenance">In Maintenance</a></li>
    <li><a href="list_stock.php" class="all">stock</a></li>
    <li><a href="list_retour.php" class="all">retour</a></li>
    <li><a href="list_pc_deleted.php" class="in-maintenance">ENDOMAGER</a></li>
  </ul>
</nav>
<form class="form" method="post" action="list_retour.php">
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
<h1>PC return List</h1>
<table>
    <thead>
        <tr>
            <th>N°Serie</th>
            <th> name </th>
            <th>return date</th>
            <th>raison return</th>
            <th>audit return</th>
            <th>number return</th>
            <th>action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        error_reporting(0);
        ini_set('display_errors', 0);
        include 'connexion.php'; // Include the database connection file
        $codebar = $_POST['codebar'];
        $start_date=$_POST['start_date'];
        $end_date=$_POST['end_date'];

        $query = "SELECT * FROM retour_pc group by codebar"; // Select all data from pcstock table
        if (!empty($codebar)) {
          $query .= " WHERE codebar LIKE '%$codebar%'";
          if (!empty($start_date)) {
              $query .= " AND date_return >= '$start_date'";
          }
          if (!empty($end_date)) {
              $query .= " AND date_return <= '$end_date'";
          }
          
      } elseif (!empty($start_date)) {
          $query .= " WHERE date_return >= '$start_date'";
          if (!empty($end_date)) {
              $query .= " AND date_return <= '$end_date'";
          } 
      } elseif (!empty($end_date)) {
          $query .= " WHERE date_return <= '$end_date'";
          
      } 

        $result = mysqli_query($conn, $query); // Execute the query using the $connection variable
        if (!$result) {
            die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
        }
        while ($row = mysqli_fetch_assoc($result)) { // Loop through the result and output the data
            echo "<tr>";
            echo "<td>".$row['codebar']."</td>";
            echo "<td>".$row['name_owner']." ".$row['last_name']."</td>";
            echo "<td>".$row['date_return']."</td>";
            echo "<td>".$row['raison_return']."</td>";
            echo "<td>".$row['audit_rapport']."</td>";
            $countQuery = "SELECT COUNT(*) AS count FROM retour_pc WHERE codebar = '".$row['codebar']."'";
            $countResult = mysqli_query($conn, $countQuery);
            $countRow = mysqli_fetch_assoc($countResult);
            $count = $countRow['count'];

            echo "<td><a href='http://10.15.17.131/circet/retour.php?codebar=".$row['codebar']."'>".$count."</a></td>";
            
            echo "<td>";
            $queryy = "SELECT * FROM pcstock where codebar='".$row['codebar']."'"; // Select all data from pcstock table
        $resultt = mysqli_query($conn, $queryy); // Execute the query using the $connection variable
        if (!$resultt) {
            die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
        }
        while ($roww = mysqli_fetch_assoc($resultt)) {
            echo "<a href='delete_pc_return.php?codebar=".$row['codebar']."&name_owner=".$row['name_owner']."&NSerie=".$row['NSerie']."&id_return=".$row['id_return']."&last_name=".$row['last_name']."&date_return=".$row['date_return']."&raison_return=".$row['raison_return']."&audit_rapport=".$row['audit_rapport']."&etat=".'return'."' onclick='return confirmDelete()'>Delete</a>";
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
        }
        mysqli_free_result($result); // Free up memory allocated for the result set
        mysqli_close($conn); // Close the database connection
        //            echo "<a href='update_pc.php?codebar=".$row['codebar']."&name_owner=".$row['name_owner']."&id_return=".$row['id_return']."&last_name=".$row['last_name']."&date_return=".$row['date_return']."&raison_return=".$row['raison_return']."&audit_rapport=".$row['audit_rapport']."&etat=".'return'."'>Update</a>";

        ?>
    </tbody>
</table>