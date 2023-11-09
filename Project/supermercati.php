<?php
session_start();
?>
<button onclick="prezzo()" class="button-title"> Prezzo </button>
<button onclick="distanza()" class="button-title"> Distanza </button>
<button onclick="valutazione()" class="button-title"> Valutazione </button>
<div id="supermarkets" class="supermarkets">
    <h1 class="errore">{{ errore }}</h1>
  <div class="supermarket" v-for="(supermercato,index) in supermercati">
    <div class="supermarket-texts">
      <h3 class="supermarket-name"> {{ supermercato.nome }} </h3>
      <p class="supermarket-text"> {{ supermercato.indirizzo }} </p>
      <p class="supermarket-text"> {{ supermercato.prezzo }} € </p>
      <p class="supermarket-text"> {{ supermercato.distanza }} Km </p>
      <p class="supermarket-text"> Valutazione: {{ supermercato.valutazione }}/10 </p>
      <a id="portamiQui" :href="'http://www.google.com/maps/place/' + supermercato.lat + ',' + supermercato.lon" target="_blank" rel="noopener noreferrer">Portami Qui</a>
    </div>
  </div>
</div>
<img id="loading" src="images/loading.gif" width="80px">
<script>
var app = new Vue({
  el: '#supermarkets',
  data: {
    errore: '',
    supermercati: [],
    lat: 0,
    lon: 0,
    email: '<?php echo $_SESSION['email']?>'
  },
  methods: {
    caricaSupermercati() {
      axios.get('https://www.appalo.it/5E/GruppoC/smartMarkets/webServices/getSupermercati.php', {
        params: {
          email: this.email,
          latitudine: this.lat,
          longitudine: this.lon
        }
      }
    ).then(function(risultato) {
      if(risultato.data.risultato !=0){
        app.errore = risultato.data.messaggio;
      }else{
        risultato.data.supermercati.sort(function(a, b){
          return a.prezzo - b.prezzo;
        });
        app.supermercati = risultato.data.supermercati;
        console.log(risultato.data.messaggio);
      }
      $('#loading').attr('src',"");
    });
  }
}
});

$(document).ready(function() {
  var x = document.getElementById("errore");

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);

  } else {
    app.errore = "Geolocation is not supported by this browser.";
  }

  function showPosition(position) {
    $('#loading').attr('src',"");
    app.lat=position.coords.latitude;
    app.lon=position.coords.longitude;
    app.caricaSupermercati();
  }

  function showError(error) {
    $('#loading').attr('src',"");
  switch(error.code) {
    case error.PERMISSION_DENIED:
      app.errore = "Errore, accettare la condivisione della posizione"
      break;
    case error.POSITION_UNAVAILABLE:
      app.errore = "Location information is unavailable."
      break;
    case error.TIMEOUT:
      app.errore = "The request to get user location timed out."
      break;
    case error.UNKNOWN_ERROR:
      app.errore = "An unknown error occurred."
      break;
  }
}

});

function prezzo(){
  app.supermercati.sort(function(a, b){
    return a.prezzo - b.prezzo;
  });
}

function distanza(){
  app.supermercati.sort(function(a, b){
    return a.distanza - b.distanza;
  });
}

function valutazione(){
  app.supermercati.sort(function(a, b){
    return b.valutazione - a.valutazione;
  });
}
</script>
