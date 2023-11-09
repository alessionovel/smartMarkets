<?php

require_once('db_connection.php');

class Json {

}

$json = new Json();

if (isset($_REQUEST['email']) && isset($_REQUEST['codice']) && isset($_REQUEST['quantita'])){

  $email = $_REQUEST['email'];
  $codice = $_REQUEST['codice'];
  $quantita = $_REQUEST['quantita'];

  $stmt = $conn->prepare('SELECT quantita FROM novelProdottoListaSpesa WHERE codiceProdotto = ? AND emailUtente = ?');
  $stmt->bind_param('ss', $codice, $email); // 's' specifies the variable type => 'string'

  $stmt->execute();
  $stmt->store_result();
  $num = $stmt->num_rows;

  if ($num > 0) {
    $qu = "UPDATE novelProdottoListaSpesa SET quantita = ? WHERE emailUtente = ? AND codiceProdotto = ?";
    $stmt = $conn->prepare($qu);
    $stmt->bind_param("sss", $quantita, $email, $codice);
    $stmt->execute();

    $risultato = 0;
    $messaggio = 'Prodotto aggiornato';
  }else{
    $risultato = -1;
    $messaggio = 'Prodotto non trovato';
  }

}else{
  $risultato = -2;
  $messaggio = 'Errore nel passaggio dei parametri';
}

$json->risultato = $risultato;
$json->messaggio = $messaggio;

echo json_encode($json);
