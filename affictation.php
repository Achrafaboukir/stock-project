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
            <h1>LIST AFFICTATION</h1>
			<tr>
				<th>N° Série</th>
                <th>name</th>
				<th>LastName</th>
        <th>DATE </th>
        </tr>
    </thead>
    <tbody>
    <?php 
     
     $query = "SELECT * FROM retour_pc where codebar='$codebar' ";
     $result = mysqli_query($conn, $query); // Execute the query using the $connection variable
         if (!$result) {
             die("Query failed: " . mysqli_error($conn)); // Print error message and stop execution if the query fails
         }
         while ($row = mysqli_fetch_assoc($result)) { // Loop through the result and output the data
             echo "<tr>";
     echo "<td><a href='http://localhost/circet/info.php?codebar=".$row['codebar']."'>".$row['codebar']."</a></td>";
     echo "<td>".$row['name_owner']."</td>";
             echo "<td>".$row['last_name']."</td>";
             echo "<td>".$row['date_return']."</td>";
             echo "</tr>";
         }
        }
    ?>