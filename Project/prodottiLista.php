<?php
session_start();
?>
<div class="overlay" id="pop">
  <div class="popup">
    <h2>Prodotto aggiornato</h2><br>
    <p>Hai aggiornato la quantità di <br><strong id="nome">nome</strong><br> in <br><strong id="quantita">quantita</strong></p>
    <span class="close" id="close">X</span>
  </div>
</div>
<button onclick="svuotaCarrello()" class="button-title"> Svuota carrello </button>
<div id="products" class="products">
  <h1 class="errore">{{ errore }}</h1>
  <div class="product" v-for="(prodotto,index) in prodotti" :id="'prodotto-' + index">
    <img class="product-image" :src="prodotto.images[0]" alt="">
    <div class="product-texts">
      <h3 class="product-name">{{ prodotto.title }}</h3>
      <input class="quantita" :id="'quantita-' + index" type="number" min="1" :value="prodotto.quantita">
      <button :onclick="'updateProdotto(' + index + ')'" class="button-title product-button">
        <i class="fa fa-check"></i>
      </button><br>
      <button :onclick="'deleteProdotto(' + index + ')'" class="button-title product-button">
        Elimina prodotto
      </button>
      <input :id="'codice-' + index" type="hidden" :value="prodotto.ean">
      <input :id="'email-' + index" type="hidden" value="<?php echo $_SESSION['email'] ?>">
      <input :id="'nome-' + index" type="hidden" :value="prodotto.title">
    </div>
  </div>
</div>
<img id="loading" src="images/loading.gif" width="80px">
<script>

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


var app = new Vue({
  el: '#products',
  data: {
    errore: '',
    prodotti: [],
    email: '<?php echo $_SESSION['email']?>'
  },
  methods: {
    caricaProdotti() {
      app.errore = '';
      app.prodotti = [];
      axios.get('https://www.appalo.it/5E/GruppoC/smartMarkets/webServices/prodottiLista.php', {
        params: {
          email: this.email
        }
      }
    ).then(function(risultato) {
      if(risultato.data.risultato == 0){
        app.prodotti = risultato.data.prodotti;
      }else{
        app.errore = risultato.data.messaggio;
      }
      console.log(risultato.data.messaggio);
      $('#loading').attr('src',"");
    });
  }
}
});

function updateProdotto(i){
  var codice = document.getElementById("codice-" + i).value;
  var quantita = document.getElementById("quantita-" + i).value;
  var email = document.getElementById("email-" + i).value;
  var nome = document.getElementById("nome-" + i).value;
  if(quantita<1){
    alert("Valore quantità non valido");
  }else{
    $.ajax({
      url: 'webServices/updateProdottoLista.php',
      type: "POST",
      data: {
        email: email,
        codice: codice,
        quantita: quantita
      },
      success: function(data) {
        var risultato = JSON.parse(data);
        if (risultato.risultato == 0){
          $("#nome").html(nome);
          $("#quantita").html(quantita);
          document.getElementById('pop').style.display="block";
        }else{
          alert(risultato.messaggio);
        }
        console.log(risultato.messaggio);
      },
      error: function(jXHR, textStatus, errorThrown) {
        alert(errorThrown + "banana 2");
      }
    });
  }
}

function deleteProdotto(i){
  var codice = document.getElementById("codice-" + i).value;
  var email = document.getElementById("email-" + i).value;
  var nome = document.getElementById("nome-" + i).value;
  $.ajax({
    url: 'webServices/deleteProdottoLista.php',
    type: "POST",
    data: {
      email: email,
      codice: codice
    },
    success: function(data) {
      var risultato = JSON.parse(data);
      if (risultato.risultato == 0){
        app.caricaProdotti();
      }else{
        alert(risultato.messaggio);
      }
      console.log(risultato.messaggio);
    },
    error: function(jXHR, textStatus, errorThrown) {
      alert(errorThrown + "banana 2");
    }
  });
}

function svuotaCarrello(){
  var email = '<?php echo $_SESSION['email']; ?>'
  $.ajax({
    url: 'webServices/svuotaCarrello.php',
    type: "POST",
    data: {
      email: email
    },
    success: function(data) {
      var risultato = JSON.parse(data);
      if (risultato.risultato == 0){
        app.caricaProdotti();
      }else if (risultato.risultato == -1){
        app.errore = risultato.messaggio;
      }else{
        alert(risultato.messaggio);
      }
      console.log(risultato.messaggio);
    },
    error: function(jXHR, textStatus, errorThrown) {
      alert(errorThrown + "banana 2");
    }
  });
}

$(document).ready(function() {
  app.caricaProdotti();
});
</script>
