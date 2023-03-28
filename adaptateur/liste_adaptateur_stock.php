<!DOCTYPE html>
<html>
<head>
	<title>adaptateur Stock List</title>
   
</head>
<body>
    
   
    <select name='filter' id='filter' >
        <option>stock</option>
        <option>return</option>
        <option>use</option>
        <option>maintenance</option>
    </select>

    <div id='stock' style="display: none;">
	 <?php 
     require 'connexion.php';
     require 'liste_ecran.php' ;
     ?>
    </div>

    <div id='use' style="display: none;">
    <?php 
     require 'connexion.php';
     require 'list_use_ecran.php' ;
     ?>
    </div>
    
    <div id='return' style="display: none;">
    <?php 
     require 'connexion.php';
     require 'list_retour_ecran.php' ;
     ?>
    </div>
    <div id='maintenance' style="display: none;">
    <?php 
     require 'connexion.php';
     require 'list_maintenance_ecran.php' ;
     ?>
    </div>
   <script>
    function showHideDiv() {
        var etatSelect = document.getElementById("filter");
        var stock = document.getElementById("stock");
        var use = document.getElementById("use");
        var retour = document.getElementById("return");
        var maintenance = document.getElementById("maintenance");
        
        if (etatSelect.value == "use") {
            use.style.display = "block";
            stock.style.display = "none";
            retour.style.display = "none";
            maintenance.style.display = "none";
        } else if (etatSelect.value == "stock") {
            use.style.display = "none";
            stock.style.display = "block";
            retour.style.display = "none";
            maintenance.style.display = "none";
        } else if (etatSelect.value == "return") {
            use.style.display = "none";
            stock.style.display = "none";
            retour.style.display = "block";
            maintenance.style.display = "none";
        }else if (etatSelect.value == "maintenance") {
            use.style.display = "none";
            stock.style.display = "none";
            retour.style.display = "none";
            maintenance.style.display = "block";
        }
    }

    // call the function on page load to initialize the visibility of the div
    showHideDiv();

    // call the function on change of the etat select element
    document.getElementById("filter").addEventListener("change", showHideDiv);
</script>

</body>
</html>
