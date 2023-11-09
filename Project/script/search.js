var app = new Vue({
  el: '#vue-container',
  data: {
    ricerca: '',
    errore: '',
    prodotti: []
  },
methods: {
  esegui_ricerca() {
    $('#loading').attr('src',"images/loading.gif");
    app.prodotti = [];
    app.errore = '';
    axios.get('https://api.upcitemdb.com/prod/trial/search', {
      params: {
        s: this.ricerca,
        match_mode: 1,
        offset: 15,
        type: 'product'
      }
    }).then(function(risultato) {
      console.log(risultato);
      app.prodotti = risultato.data.items;
      $('#loading').attr('src',"");
    }).catch(function(error){
      console.log(error.response);
      if (error.response.status == 429){
        app.errore = 'Richieste esaurite';
      }else if (error.response.status == 404){
        app.errore = 'Prodotto non trovato';
      }else if (error.response.status == 400){
        app.errore = 'Ricerca non valida';
      }else if (error.response.status == 'default'){
        alert(error.response);
      }
      $('#loading').attr('src',"");
    });
  },
  rilevanti() {
    $('#loading').attr('src',"images/loading.gif");
    app.prodotti = [];
    app.errore = '';
    axios.get('https://www.appalo.it/5E/GruppoC/smartMarkets/webServices/prodottiRilevanti.php'
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
