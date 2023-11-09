<?php

require_once('db_connection.php');

class Json {

}

$json = new Json();

if (isset($_REQUEST['email'])){

  $email = $_REQUEST['email'];

  $stmt = $conn->prepare('SELECT * FROM novelProdottoListaSpesa WHERE emailUtente = ?');
  $stmt->bind_param('s', $email); // 's' specifies the variable type => 'string'

  $stmt->execute();
  $stmt->store_result();
  $num = $stmt->num_rows;

  if ($num > 0) {
    $qu = "DELETE FROM novelProdottoListaSpesa WHERE emailUtente = ?";
    $stmt = $conn->prepare($qu);
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $risultato = 0;
    $messaggio = 'Carrello svuotato';
  }else{
    $risultato = -1;
    $messaggio = 'Nessun prodotto nel carrello';
  }

}else{
  $risultato = -2;
  $messaggio = 'Errore nel passaggio dei parametri';
}

$json->risultato = $risultato;
$json->messaggio = $messaggio;

echo json_encode($json);
