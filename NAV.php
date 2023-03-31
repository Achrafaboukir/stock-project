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
.dropdown li{
  margin-bottom:10px;
}
</style>

<?php 
   
    if (isset($_GET['etat'])) { 
        $etat=$_GET['etat'];
        if($etat=='all'){
        ?>
<nav>
  <ul>
    <li><a class='a' href="PC/liste_all.php">PC</a></li>
    <li><a class='a' href="souris/list_all.php">SOURIS</a></li>
    <li class="dropdown">
    <a href="#" class="dropdown-toggle a" data-toggle="dropdown">Composante<span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a class='a' href="ram/list_all.php">RAM</a></li>
          <li><a class='a' href="discdur/list_all.php">DISQUE DUR</a></li>
          <li><a class='a' href="clavier/list_all.php">CLAVIE</a></li>
          <li><a class='a' href="cable/list_all.php">CABLE</a></li>
          <li><a class='a' href="adaptateur/list_all.php">ADAPTATEUR</a></li>

        </ul>
      </li>
    <li><a class='a' href="ecran/list_all.php">ECRAN</a></li>
    <li><a class='a' href="adaptateur/list_all.php">ADAPTATEUR</a></li>


  </ul>
</nav>
<style>
  .dropdown-menu {
  display: none;
  position: absolute;
  z-index: 1;
  background-color : #333;
  padding: 20px 20px;
  margin-bottom:5px;
}

.dropdown:hover .dropdown-menu {
  display: block;
}
</style>
<?php    }}
?>

<?php 
   
    if (isset($_GET['etat'])) { 
        $etat=$_GET['etat'];
        if($etat=='stock'){
        ?>
<nav>
  <ul>
    <li><a class='a' href="PC/list_stock.php">PC</a></li>
    <li><a class='a' href="souris/liste_souris.php">SOURIS</a></li>
    <li class="dropdown">
    <a href="#" class="dropdown-toggle a" data-toggle="dropdown">Composante<span class="caret"></span></a>
        <ul class="dropdown-menu">

    <li><a class='a' href="ram/liste_ram.php">RAM</a></li>
    <li><a class='a' href="discdur/liste_discdur.php">DISCDUR</a></li>
    <li><a class='a' href="clavier/liste_clavier.php">CLAVIE</a></li>
    <li><a class='a' href="cable/liste_cable.php">CABLE</a></li>
    <li><a class='a' href="adaptateur/liste_adaptateur.php">ADAPTATEUR</a></li>

    </ul>
      </li>
    <li><a class='a' href="ecran/liste_ecran.php">ECRAN</a></li>
  </ul>
</nav>
<style>
  .dropdown-menu {
  display: none;
  position: absolute;
  z-index: 1;
  background-color : #333;
  padding: 20px 20px;
  margin-bottom:5px;
}

.dropdown:hover .dropdown-menu {
  display: block;
}
</style>
<?php    }}
?>

<?php 
   
    if (isset($_GET['etat'])) { 
        $etat=$_GET['etat'];
        if($etat=='maintenance'){
        ?>
<nav>
  <ul>
    <li><a class='a' href="PC/list_maintenance.php">PC</a></li>

  </ul>
</nav>
<?php    }}
?>

<?php 
   
    if (isset($_GET['etat'])) { 
        $etat=$_GET['etat'];
        if($etat=='return'){
        ?>
<nav>
  <ul>
    <li><a class='a' href="PC/list_retour.php">PC</a></li>
    <li><a class='a' href="souris/list_retour_souris.php">SOURIS</a></li>
    <li class="dropdown">
    <a href="#" class="dropdown-toggle a" data-toggle="dropdown">Composante<span class="caret"></span></a>
        <ul class="dropdown-menu">
    <li><a class='a' href="ram/list_retour_ram.php">RAM</a></li>
    <li><a class='a' href="discdur/list_retour_discdur.php">DISCDUR</a></li>
    <li><a class='a' href="clavier/list_retour_clavie.php">CLAVIE</a></li>
    <li><a class='a' href="cable/list_retour_cable.php">CABLE</a></li>
    <li><a class='a' href="adaptateur/list_retour_adaptateur.php">ADAPTATEUR</a></li>

    </ul>
      </li>
    <li><a class='a' href="ecran/list_retour_ecran.php">ECRAN</a></li>
  </ul>
</nav>
<style>
  .dropdown-menu {
  display: none;
  position: absolute;
  z-index: 1;
  background-color : #333;
  padding: 20px 20px;
  margin-bottom:5px;
}

.dropdown:hover .dropdown-menu {
  display: block;
}
</style>
<?php    }}
?>

<?php 
   
    if (isset($_GET['etat'])) { 
        $etat=$_GET['etat'];
        if($etat=='endomage'){
        ?>
<nav>
  <ul>
    <li><a class='a' href="PC/list_pc_deleted.php">PC</a></li>
    <li><a class='a' href="souris/liste_souris_deleted.php">SOURIS</a></li>
    <li class="dropdown">
    <a href="#" class="dropdown-toggle a" data-toggle="dropdown">Composante<span class="caret"></span></a>
        <ul class="dropdown-menu">
    <li><a class='a' href="ram/liste_ram_deleted.php">RAM</a></li>
    <li><a class='a' href="discdur/liste_discdur_deleted.php">DISCDUR</a></li>
    <li><a class='a' href="clavier/list_clavie_deleted.php">CLAVIE</a></li>
    <li><a class='a' href="cable/liste_cable_deleted.php">CABLE</a></li>
        <li><a class='a' href="adaptateur/liste_adaptateur_deleted.php">ADAPTATEUR</a></li>

    </ul>
      </li>
    <li><a class='a' href="ecran/liste_ecran_deleted.php">ECRAN</a></li>
  </ul>
</nav>
<style>
  .dropdown-menu {
  display: none;
  position: absolute;
  z-index: 1;
  background-color : #333;
  padding: 20px 20px;
  margin-bottom:5px;
}

.dropdown:hover .dropdown-menu {
  display: block;
}
</style>
<?php    }}
?>