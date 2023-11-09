<?php

require_once('db_connection.php');

class Json {

}

$json = new Json();

$date = date("Y-m-d");

if (isset($_REQUEST['email']) && isset($_REQUEST['codice']) && isset($_REQUEST['quantita']) && isset($_REQUEST['immagine']) && isset($_REQUEST['nome'])){


  $email = $_REQUEST['email'];
  $codice = $_REQUEST['codice'];
  $quantita = $_REQUEST['quantita'];
  $immagine = $_REQUEST['immagine'];
  $nome = $_REQUEST['nome'];

  $stmt = $conn->prepare('SELECT * FROM novelProdotto WHERE codice = ?');
  $stmt->bind_param('s', $codice);

  $stmt->execute();
  $stmt->store_result();
  $num = $stmt->num_rows;

  if ($num == 0) {
    $qu = "INSERT into novelProdotto (codice, nome, immagine) VALUES(?, ?, ?)";
    $stmt = $conn->prepare($qu);
    $stmt->bind_param("sss", $codice, $nome, $immagine);
    $stmt->execute();
  }

  $stmt = $conn->prepare('SELECT quantita FROM novelProdottoListaSpesa WHERE codiceProdotto = ? AND emailUtente = ?');
  $stmt->bind_param('ss', $codice, $email); // 's' specifies the variable type => 'string'

  $stmt->execute();
  $stmt->bind_result($quantitaDB);
  $stmt->store_result();
  $num = $stmt->num_rows;

  if ($num > 0) {
    while ($stmt->fetch()) {
      $quantita = $quantitaDB + $quantita;
      $qu = "UPDATE novelProdottoListaSpesa SET quantita = ? WHERE emailUtente = ? AND codiceProdotto = ?";
      $stmt = $conn->prepare($qu);
      $stmt->bind_param("sss", $quantita, $email, $codice);
      $stmt->execute();
      $json->risultato = 0;
      $json->messaggio = 'Quantità prodotto aggiornata';
    }
  }else{
    $qu = "INSERT into novelProdottoListaSpesa (quantita, emailUtente, codiceProdotto) VALUES(?, ?, ?)";
    $stmt = $conn->prepare($qu);
    $stmt->bind_param("iss", $quantita, $email, $codice);
    $stmt->execute();
    $json->risultato = 0;
    $json->messaggio = 'Prodotto aggiunto al carrello';
  }

  $qu = "INSERT into novelProdottoRilevante (data, codiceProdotto) VALUES(?, ?)";
  $stmt = $conn->prepare($qu);
  $stmt->bind_param("ss", $date, $codice);
  $stmt->execute();

}else{
  $json->risultato = -1;
  $json->messaggio = 'Errore nel passaggio dei parametri';
}

echo json_encode($json);
