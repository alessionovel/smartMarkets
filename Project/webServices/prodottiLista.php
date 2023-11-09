<?php

require_once('db_connection.php');

if (isset($_REQUEST['email'])){
  $email = $_REQUEST['email'];


  class Json {

  }


  class Prodotto {

  }
  $json = new Json();
  $query = "SELECT codiceProdotto, quantita, nome, immagine FROM `novelProdottoListaSpesa`, `novelProdotto` WHERE emailUtente = '".$email."' AND codice = codiceProdotto";
  $rec = mysqli_query($conn, $query) or die($query . "<br>" . mysqli_error($conn));
  $num = mysqli_num_rows($rec);
  if ($num == 0) {
    $json->risultato = -1;
    $json->messaggio = 'Nessun prodotto nel carrello';
  } else {
    $i = 0;

    while ($array = mysqli_fetch_array($rec)) {
      $prodotti[$i] = new Prodotto();

      $prodotti[$i]->ean = $array['codiceProdotto'];

      $prodotti[$i]->quantita = (int)$array['quantita'];

      $prodotti[$i]->title = $array['nome'];

      $prodotti[$i]->images[] = $array['immagine'];

      $i++;
    }
    $json->prodotti = $prodotti;
    $json->risultato = 0;
    $json->messaggio = 'Prodotti trovati correttamente';
  }
}else{
  $json->risultato = -2;
  $json->messaggio = 'Errore nel passaggio dei parametri';
}
echo json_encode($json);

?>
