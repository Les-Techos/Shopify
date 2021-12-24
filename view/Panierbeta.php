<!--Fichier de test du panier-->
<ul class="list-group">
<?php for ($i = 1; $i <= 15; $i++) { 
    echo'
    <li class="list-group-item">
        <input type="checkbox" value="" id="product A">
        <img src="..\assets\image\assortimentBiscuitsSec.jpg">
        Product name
        <input type="number" style="min-width:25px; max-width:50px"/>
    </li>
    ';}
?>
</ul>