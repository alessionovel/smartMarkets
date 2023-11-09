<?php
session_start();
ob_start();
?>
<div id="home">
  <h1 class="main-title">Home</h1>
  <div class="corpo-testo">
    <p> Bentornato/a <?php echo $_SESSION['nome'] ?></p><br>
    <img id="supermarket-image" src="images/supermercato.jpeg" width="500px"><br>

    <i class="fa fa-home" style="color:#e93b81"></i><i class="fa"> Home</i><br>
    <i class="fa fa-search" style="color:#e93b81"></i><i class="fa"> Cerca e aggiungi prodotti al carrello</i><br>
    <i class="fa fa-shopping-cart" style="color:#e93b81"></i><i class="fa"> Gestisci il carrello e confronta supermercati</i><br>
    <i class="fa fa-star" style="color:#e93b81"></i><i class="fa"> Cerca e valuta supermercato</i><br>
    <i class="fa fa-sign-out" style="color:#e93b81"></i><i class="fa"> Logout</i><br>
    </div>
  </div>
