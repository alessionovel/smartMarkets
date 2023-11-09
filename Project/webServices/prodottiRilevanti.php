<?php
ob_start(); ?>
<?php

require_once('db_connection.php');

$date = date("Y-m-d", strtotime("-14 days"));


class Json {

}


class Prodotto {

}
$json = new Json();

$query = "SELECT codiceProdotto, COUNT(*) as quantita, nome, immagine FROM `novelProdottoRilevante`, `novelProdotto` WHERE data >= '".$date."' AND codice = codiceProdotto GROUP BY codiceProdotto ORDER BY COUNT(*) DESC";
$result = mysqli_query($conn, $query) or die($query . "<br>" . mysqli_error($conn));
$num = mysqli_num_rows($result);
if ($num == 0) {
  $json->risultato = -1;
  $json->messaggio = 'Nessun prodotto rilevante trovato';
} else {
  $i = 0;

  while ($array = mysqli_fetch_array($result)) {
    $prodotti[$i] = new Prodotto();

    $prodotti[$i]->ean = $array['codiceProdotto'];

    $prodotti[$i]->quantita = (int)$array['quantita'];

    $prodotti[$i]->title = $array['nome'];

    $prodotti[$i]->images[] = $array['immagine'];

    $i++;
  }
  $json->prodotti = $prodotti;
  $json->risultato = 0;
  $json->messaggio = 'Prodotti rilevanti trovati';
}
echo json_encode($json);
?>
