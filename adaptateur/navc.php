
<nav>
  <ul>
  <li><a class='a' onclick="history.go(-1)" href="#">Return</a></li>

  <li><a class='a' href="http://10.15.17.131/circet/navv.php"><img src="http://10.15.17.131/circet/hhom.png" ></img> </a></li>

    <li><a class='a' href="FormAdaptateurStock.php">Add adaptateur</a></li>
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
img {
  width:25px;
  height:25px;
}
.a:hover {
  background-color: #555;
}
</style>
