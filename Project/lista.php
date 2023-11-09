
<?php header('Access-Control-Allow-Origin: *');
session_start();
?>
<link rel="stylesheet" href="css/search.css">
<div id="lista">
  <h1 class="main-title">Lista della spesa</h1>
  <p class="subtitle">Gestisci i prodotti della tua lista della spesa</p>
  <button onclick="visualizzaProdotti()" class="button-title">Visualizza Prodotti</button>
  <button onclick="visualizzaSupermercati()" class="button-title">Visualizza supermercati</button>
  <div id="corpo">

  </div>
</div>
<script>
$(document).ready(function() {
  visualizzaProdotti();
});

function visualizzaProdotti(){
  $.ajax({
    url: 'prodottiLista.php',
    success: function(data) {
        $("#corpo").html(data);
    },
    error: function(jXHR, textStatus, errorThrown) {
      alert(errorThrown + "Errore nella chiamata della pagina");
    }
  });
}

function visualizzaSupermercati(){
  $.ajax({
    url: 'supermercati.php',
    success: function(data) {
        $("#corpo").html(data);
    },
    error: function(jXHR, textStatus, errorThrown) {
      alert(errorThrown + "Errore nella chiamata della pagina");
    }
  });
}
</script>
