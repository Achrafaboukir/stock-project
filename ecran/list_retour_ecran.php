<?php require 'navc.php' ;?><br><br>

<nav class=nav>
  <ul>
    <li><a href="http://localhost/circet/ecran/list_all.php" class="all">All</a></li>
    <li><a href="http://localhost/circet/ecran/list_use_ecran.php" class="in-use">In Use</a></li>
    <li><a href="http://localhost/circet/ecran/list_retour_ecran.php" class="retour">retour</a></li>
    <li><a href="http://localhost/circet/ecran/liste_ecran.php" class="retour">stock</a></li>
    <li><a href="http://localhost/circet/ecran/liste_ecran_deleted.php" class="retour">endomager</a></li>

  </ul>
</nav>

<form class="form" method="post" action="list_retour_ecran.php">
    <div class="form__group">
      <label class="form__label" for="num_serie">Serial Number:</label>
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

.nav .retour {
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
<h1>clavie return List</h1>
<table>
    <thead>
        <tr>
            <th>id return</th>
            <th>num_serie </th>
            <th>modele</th>
            <th>marque</th>
            <th>caracteristique</th>
            <th>date return</th>
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
        $rnum_serie = $_POST['rnum_serie'];
        $modele=$_POST['modele'];
        $marque=$_POST['marque'];

        $query = "SELECT * FROM retour_ecran where 1=1"; // Select all data from pcstock table
        if (!empty($rnum_serie)) {
            $query .= " AND rnum_serie = '{$rnum_serie}'";
        }
        if (!empty($modele)) {
          $query .= " AND modele LIKE '%{$modele}%'";
        }
        if (!empty($marque)) {
          $query .= " AND marque LIKE '%{$marque}%'";
        }

        $result = mysqli_query($conn, $query); // Execute the query using the $connection variable
        if (!$result) {
            die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
        }
        while ($row = mysqli_fetch_assoc($result)) { // Loop through the result and output the data
            echo "<tr>";
            echo "<td>".$row['id_return']."</td>";
            echo "<td>".$row['rnum_serie']."</td>";
            echo "<td>".$row['modele']."</td>";
            echo "<td>".$row['marque']."</td>";
            echo "<td>".$row['caracteristique']."</td>";
            echo "<td>".$row['date_return']."</td>";
            echo "<td>".$row['raison_return']."</td>";
            echo "<td>".$row['audit_rapport']."</td>";
            $countQuery = "SELECT COUNT(*) AS count FROM retour_ecran WHERE rnum_serie = '".$row['rnum_serie']."'";
            $countResult = mysqli_query($conn, $countQuery);
            $countRow = mysqli_fetch_assoc($countResult);
            $count = $countRow['count'];

            echo "<td>".$count."</td>";
            
            echo "<td>";
            $queryy = "SELECT * FROM ecran_stock where rnum_serie='".$row['rnum_serie']."'"; // Select all data from pcstock table
        $resultt = mysqli_query($conn, $queryy); // Execute the query using the $connection variable
        if (!$resultt) {
            die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
        }
        while ($roww = mysqli_fetch_assoc($resultt)) {
            echo "<a href='delete_retour_ecran.php?id_return=".$row['id_return']."' onclick='return confirmDelete()'>Delete</a>";
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


        //echo "<a href='update_clavier.php?num_serie=".$row['num_serie']."&modele=".$row['modele']."&id_return=".$row['id_return']."&marque=".$row['marque']."&date_return=".$row['date_return']."&raison_return=".$row['raison_return']."&audit_rapport=".$row['audit_rapport']."&etat=".$row['etat']."'>Update</a>";

        ?>
    </tbody>
</table>