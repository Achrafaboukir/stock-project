
<nav>
  <ul>
   <li><a class='a' onclick="history.go(-1)">Return</a></li>
  <li><a class='a' href="http://localhost/circet/navv.php">home</a></li>
    <li><a class='a' href="FormEcranStock.php">Add ecran</a></li>
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
