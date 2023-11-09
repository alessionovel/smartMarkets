<?php

require_once('db_connection.php');


class Json {

}


class Supermercato {

}
$json = new Json();

if (isset($_REQUEST['email']) && $_REQUEST['latitudine'] && $_REQUEST['longitudine']){
  $email = $_REQUEST['email'];

  $query = "SELECT codiceProdotto, quantita FROM `novelProdottoListaSpesa` WHERE emailUtente = '".$email."' ORDER BY codiceProdotto";
  $rec = mysqli_query($conn, $query) or die($query . "<br>" . mysqli_error($conn));
  $num = mysqli_num_rows($rec);
  if ($num == 0) {
    $json->risultato = -1;
    $json->messaggio = 'Nessun prodotto nel carrello';
  } else {
    $stringaProdotti = "";
    $iquantita=0;
    while ($array = mysqli_fetch_array($rec)) {
      $quantita[$array['codiceProdotto']] = $array['quantita'];
      if($iquantita==0){
        $stringaProdotti = $stringaProdotti.$array['codiceProdotto'];
      }else{
        $stringaProdotti = $stringaProdotti.",".$array['codiceProdotto'];
      }
      $iquantita++;
    }


    $i = 0;

    $query = "SELECT novelSupermercato.idUtenteBackOffice, nome, indirizzo, provincia, latitudine, longitudine, COUNT(*) FROM `novelProdottoSupermercato`, `novelSupermercato`  WHERE novelProdottoSupermercato.codiceProdotto IN (".$stringaProdotti.") AND novelSupermercato.idUtenteBackOffice = novelProdottoSupermercato.idUtenteBackOffice GROUP BY idUtenteBackOffice HAVING COUNT(*)>='".$iquantita."'";
    $rec = mysqli_query($conn, $query) or die($query . "<br>" . mysqli_error($conn));
    $num = mysqli_num_rows($rec);
    if ($num == 0) {
      $json->risultato = -2;
      $json->messaggio = 'Nessun supermercato possiede tutti i prodotti che hai richiesto';
    } else {

      while ($array = mysqli_fetch_array($rec)) {


        $prezzo = 0;

        $query = "SELECT * FROM `novelProdottoSupermercato`,`novelSupermercato` WHERE novelProdottoSupermercato.codiceProdotto IN (".$stringaProdotti.") AND novelSupermercato.idUtenteBackOffice = novelProdottoSupermercato.idUtenteBackOffice AND novelSupermercato.idUtenteBackOffice = '".$array['idUtenteBackOffice']."' ORDER BY codiceProdotto";
        $rec2 = mysqli_query($conn, $query) or die($query . "<br>" . mysqli_error($conn));
        $num2 = mysqli_num_rows($rec2);
        while ($array2 = mysqli_fetch_array($rec2)) {
          $prezzo = $prezzo + ($array2['prezzo']*$quantita[$array2['codiceProdotto']]);
        }



        $query = "SELECT AVG(voto) as valutazione FROM `novelValutazione` WHERE  novelValutazione.idUtenteBackOffice = '".$array['idUtenteBackOffice']."'";
        $rec2 = mysqli_query($conn, $query) or die($query . "<br>" . mysqli_error($conn));
        $num2 = mysqli_num_rows($rec2);
        while ($array2 = mysqli_fetch_array($rec2)) {
          $valutazione = $array2['valutazione'];
        }

        $earthRadius = 6371;
        $latFrom = deg2rad($_REQUEST['latitudine']);
        $lonFrom = deg2rad($_REQUEST['longitudine']);
        $latTo = deg2rad($array['latitudine']);
        $lonTo = deg2rad($array['longitudine']);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) + cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
        $distance = $angle * $earthRadius;
        $distanza = number_format($distance, 2);


        if ($distanza<30){
          $supermercato[$i] = new Supermercato();

          $supermercato[$i]->nome = $array['nome'];

          $supermercato[$i]->indirizzo = $array['indirizzo'];

          $supermercato[$i]->provincia = $array['provincia'];

          $supermercato[$i]->lat = $array['latitudine'];

          $supermercato[$i]->lon = $array['longitudine'];

          $supermercato[$i]->prezzo = $prezzo;

          $supermercato[$i]->valutazione = number_format($valutazione, 1);

          $supermercato[$i]->distanza = $distanza;

          $i++;
        }

      }
      if ($i==0){
        $json->supermercati = null;
        $json->risultato = -4;
        $json->messaggio = 'Nessun supermercato nell\'arco di 30km';
      }else{
        $json->supermercati = $supermercato;
        $json->risultato = 0;
        $json->messaggio = 'Supermercati trovati correttamente';
      }
    }
  }
}else{
  $json->risultato = -3;
  $json->messaggio = 'Errore nel passaggio dei parametri';
}
echo json_encode($json);
?>
