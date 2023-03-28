<nav>
  <ul>
    <li><a class='a' href="NAV.php?etat=all">ACTIVE</a></li>
    <li><a class='a' href="NAV.php?etat=stock">STOCK</a></li>
    <li><a class='a' href="NAV.php?etat=maintenance">MAINTENANCE</a></li>
    <li><a class='a' href="NAV.php?etat=endomage">Endomagé</a></li>
    <li><a class='a' href="NAV.php?etat=return">retour</a></li>

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
