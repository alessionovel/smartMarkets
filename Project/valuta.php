
<?php header('Access-Control-Allow-Origin: *');
session_start();
?>
<link rel="stylesheet" href="css/search.css">
<div id="valuta">
  <div class="overlay" id="pop">
    <div class="popup">
      <h2>Prodotto aggiunto</h2><br>
      <p>Hai valutato il supermercato <br><strong id="nome">nome</strong><br> con un <br><strong id="voto">voto</strong></p>
      <span class="close" id="close">X</span>
    </div>
  </div>
  <h1 class="main-title">Valuta</h1>
  <p class="subtitle">Condividi la tua esperienza nei supermercati in cui hai fatto la spesa!</p>
  <div id="vue-container">
    <div class="supermarkets-container">
      <!-- IL tuo codice Qui -->
      <div class="input-container">
        <input v-model="ricerca" placeholder="Inserisci nome supermercato" /><br><br>
        <label for="provincia" class="subtitle" >Scegli una provincia</label><br><br>
        <select v-model="provincia" id="provincia" class="provincia" placeholder="Scegli provincia" required>
          <option value="ag">Agrigento</option>
          <option value="al">Alessandria</option>
          <option value="an">Ancona</option>
          <option value="ao">Aosta</option>
          <option value="ar">Arezzo</option>
          <option value="ap">Ascoli Piceno</option>
          <option value="at">Asti</option>
          <option value="av">Avellino</option>
          <option value="ba">Bari</option>
          <option value="bt">Barletta-Andria-Trani</option>
          <option value="bl">Belluno</option>
          <option value="bn">Benevento</option>
          <option value="bg">Bergamo</option>
          <option value="bi">Biella</option>
          <option value="bo">Bologna</option>
          <option value="bz">Bolzano</option>
          <option value="bs">Brescia</option>
          <option value="br">Brindisi</option>
          <option value="ca">Cagliari</option>
          <option value="cl">Caltanissetta</option>
          <option value="cb">Campobasso</option>
          <option value="ci">Carbonia-iglesias</option>
          <option value="ce">Caserta</option>
          <option value="ct">Catania</option>
          <option value="cz">Catanzaro</option>
          <option value="ch">Chieti</option>
          <option value="co">Como</option>
          <option value="cs">Cosenza</option>
          <option value="cr">Cremona</option>
          <option value="kr">Crotone</option>
          <option value="cn">Cuneo</option>
          <option value="en">Enna</option>
          <option value="fm">Fermo</option>
          <option value="fe">Ferrara</option>
          <option value="fi">Firenze</option>
          <option value="fg">Foggia</option>
          <option value="fc">Forl&igrave;-Cesena</option>
          <option value="fr">Frosinone</option>
          <option value="ge">Genova</option>
          <option value="go">Gorizia</option>
          <option value="gr">Grosseto</option>
          <option value="im">Imperia</option>
          <option value="is">Isernia</option>
          <option value="sp">La spezia</option>
          <option value="aq">L'aquila</option>
          <option value="lt">Latina</option>
          <option value="le">Lecce</option>
          <option value="lc">Lecco</option>
          <option value="li">Livorno</option>
          <option value="lo">Lodi</option>
          <option value="lu">Lucca</option>
          <option value="mc">Macerata</option>
          <option value="mn">Mantova</option>
          <option value="ms">Massa-Carrara</option>
          <option value="mt">Matera</option>
          <option value="vs">Medio Campidano</option>
          <option value="me">Messina</option>
          <option value="mi">Milano</option>
          <option value="mo">Modena</option>
          <option value="mb">Monza e della Brianza</option>
          <option value="na">Napoli</option>
          <option value="no">Novara</option>
          <option value="nu">Nuoro</option>
          <option value="og">Ogliastra</option>
          <option value="ot">Olbia-Tempio</option>
          <option value="or">Oristano</option>
          <option value="pd">Padova</option>
          <option value="pa">Palermo</option>
          <option value="pr">Parma</option>
          <option value="pv">Pavia</option>
          <option value="pg">Perugia</option>
          <option value="pu">Pesaro e Urbino</option>
          <option value="pe">Pescara</option>
          <option value="pc">Piacenza</option>
          <option value="pi">Pisa</option>
          <option value="pt">Pistoia</option>
          <option value="pn">Pordenone</option>
          <option value="pz">Potenza</option>
          <option value="po">Prato</option>
          <option value="rg">Ragusa</option>
          <option value="ra">Ravenna</option>
          <option value="rc">Reggio di Calabria</option>
          <option value="re">Reggio nell'Emilia</option>
          <option value="ri">Rieti</option>
          <option value="rn">Rimini</option>
          <option value="rm">Roma</option>
          <option value="ro">Rovigo</option>
          <option value="sa">Salerno</option>
          <option value="ss">Sassari</option>
          <option value="sv">Savona</option>
          <option value="si">Siena</option>
          <option value="sr">Siracusa</option>
          <option value="so">Sondrio</option>
          <option value="ta">Taranto</option>
          <option value="te">Teramo</option>
          <option value="tr">Terni</option>
          <option value="to">Torino</option>
          <option value="tp">Trapani</option>
          <option value="tn">Trento</option>
          <option value="tv">Treviso</option>
          <option value="ts">Trieste</option>
          <option value="ud">Udine</option>
          <option value="va">Varese</option>
          <option value="ve">Venezia</option>
          <option value="vb">Verbano-Cusio-Ossola</option>
          <option value="vc">Vercelli</option>
          <option value="vr">Verona</option>
          <option value="vv">Vibo valentia</option>
          <option value="vi">Vicenza</option>
          <option value="vt">Viterbo</option>
        </select>
      </div>
      <button class="button-title" v-on:click="cerca">Cerca</button>
      <h1 class="errore">{{ errore }}</h1>
      <div class="supermarkets">
        <div class="supermarket" v-for="(supermercato,index) in supermercati">
          <div class="supermarket-texts">
            <h3 class="supermarket-name"> {{ supermercato.nome }} </h3>
            <p class="supermarket-text"> {{ supermercato.indirizzo }} </p>
            <a id="portamiQui" :href="'http://www.google.com/maps/place/' + supermercato.lat + ',' + supermercato.lon" target="_blank" rel="noopener noreferrer">Portami Qui</a>
            <br><input class="quantita" :id="'voto-' + index" type="number" min="1" max="10" :value="supermercato.valutazione">
            <button :onclick="'valutaSupermercato(' + index + ')'" class="button-title product-button">
              <i class="fa fa-plus"></i>
            </button>
            <input :id="'id-' + index" type="hidden" :value="supermercato.idUtenteBackOffice">
            <input :id="'email-' + index" type="hidden" value="<?php echo $_SESSION['email'] ?>">
            <input :id="'nome-' + index" type="hidden" :value="supermercato.nome">
          </div>
        </div>
      </div>
    </div>
  </div>
  <img id="loading" src="" width="80px">
</div>
<script>
var app = new Vue({
  el: '#vue-container',
  data: {
    ricerca: '',
    provincia: '',
    errore: '',
    supermercati: []
  },
  methods: {
    cerca() {
      if (this.provincia != ''){
        $('#loading').attr('src',"images/loading.gif");
        app.supermercati = [];
        app.errore = '';
        axios.get('https://www.appalo.it/5E/GruppoC/smartMarkets/webServices/cercaSupermercati.php', {
          params: {
            cerca: this.ricerca,
            provincia: this.provincia,
            email: '<?php echo $_SESSION['email'] ?>'
          }
        }
      ).then(function(risultato) {
        if(risultato.data.risultato == 0){
          app.supermercati = risultato.data.supermercati;
        }else{
          app.errore = risultato.data.messaggio;
        }
        console.log(risultato.data.messaggio);
        $('#loading').attr('src',"");
      });
    }else{
      app.errore = 'Scegli una provincia'
    }
  }
}
});

function valutaSupermercato(i){
  var id = document.getElementById("id-" + i).value;
  var voto = document.getElementById("voto-" + i).value;
  var email = document.getElementById("email-" + i).value;
  var nome = document.getElementById("nome-" + i).value;
  if(voto<1 || voto>10){
    alert("Valore quantità non valido");
  }else{
    $.ajax({
      url: 'webServices/votaSupermercato.php',
      type: "POST",
      data: {
        email: email,
        idUtenteBackOffice: id,
        voto: voto
      },
      success: function(data) {
        var risultato = JSON.parse(data);
        if(risultato.risultato == 0){
          $("#nome").html(nome);
          $("#voto").html(voto);
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
</script>
