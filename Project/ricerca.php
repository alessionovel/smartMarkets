
<?php header('Access-Control-Allow-Origin: *');
session_start();
?>
<link rel="stylesheet" href="css/search.css">
<div id="cerca">
  <div class="overlay" id="pop">
	<div class="popup">
		<h2>Prodotto aggiunto</h2><br>
		<p>Hai aggiunto al tuo carrello <br><strong id="nome">nome</strong><br> in una quantità di <br><strong id="quantita">nome</strong><br></p>
		<span class="close" id="close">X</span>
	</div>
</div>
<h1 class="main-title">Ricerca</h1>
<p class="subtitle">Aggiungi i prodotti alla tua lista della spesa</p>
  <div id="vue-container">
    <div class="products-container">
        <!-- IL tuo codice Qui -->
        <div class="input-container">
          <input v-model="ricerca" placeholder="Cerca prodotto" @keyup.enter="esegui_ricerca" />
        </div>
        <button class="button-title" v-on:click="rilevanti">Mostra più rilevanti</button>
        <h1 class="errore">{{ errore }}</h1>
        <div class="products">
            <div class="product" v-for="(prodotto,index) in prodotti">
                <img class="product-image" :src="prodotto.images[0]" alt="">

                <div class="product-texts">
                    <h3 class="product-name">{{ prodotto.title }}</h3>
                        <i class="fa fa-fire" style="color:white;font-size: 25px"> {{ prodotto.quantita }}</i><br>
                        <input class="quantita" :id="'quantita-' + index" type="number" min="1" :value="1">
                    <button :onclick="'addProdotto(' + index + ')'" class="button-title product-button">
                        <i class="fa fa-plus"></i>
                    </button>
                    <input :id="'codice-' + index" type="hidden" :value="prodotto.ean">
                    <input :id="'email-' + index" type="hidden" value="<?php echo $_SESSION['email'] ?>">
                    <input :id="'immagine-' + index" type="hidden" :value="prodotto.images[0]">
                    <input :id="'nome-' + index" type="hidden" :value="prodotto.title">
                </div>
            </div>
        </div>
    </div>
  </div>
  <img id="loading" src="images/loading.gif" width="80px">
</div>
<script src="script/search.js"></script>
<script>
$(document).ready(function() {
  app.rilevanti();
});

document.getElementById("close").onclick = function(e){
    document.getElementById('pop').style.display="none";
}

// chiudi il popup quando clicchi sullo sfondo nero
document.getElementById("pop").onclick = function(e){
	document.getElementById('pop').style.display="none";
}
document.getElementById("pop").onclick = function(e){
    document.getElementById('pop').style.display="none";
}
function addProdotto(i){

    var codice = document.getElementById("codice-" + i).value;
    var quantita = document.getElementById("quantita-" + i).value;
    var email = document.getElementById("email-" + i).value;
    var immagine = document.getElementById("immagine-" + i).value;
    var nome = document.getElementById("nome-" + i).value;
    if(quantita<1){
      alert("Valore quantità non valido");
  }else{
    $.ajax({
      url: 'webServices/addProdottoLista.php',
      type: "POST",
      data: {
        email: email,
        codice: codice,
        immagine: immagine,
        quantita: quantita,
        nome: nome
      },
      success: function(data) {
        var risultato = JSON.parse(data);
        if (risultato.risultato == 0) {
          console.log(risultato.messaggio);
          $("#nome").html(nome);
          $("#quantita").html(quantita);
          document.getElementById('pop').style.display="block";
          app.prodotti[i].quantita = app.prodotti[i].quantita + 1;
        } else {
          alert(risultato.messaggio);
        }
      },
      error: function(jXHR, textStatus, errorThrown) {
        alert(errorThrown + "banana 2");
      }
    });
  }
}
</script>
