<?php

require_once('db_connection.php');

class Json {

}

$json = new Json();

if (isset($_REQUEST['email']) && isset($_REQUEST['idUtenteBackOffice']) && isset($_REQUEST['voto'])){

  $email = $_REQUEST['email'];
  $idUtenteBackOffice = $_REQUEST['idUtenteBackOffice'];
  $voto = $_REQUEST['voto'];

  $stmt = $conn->prepare('SELECT voto FROM novelValutazione WHERE idUtenteBackOffice = ? AND emailUtente = ?');
  $stmt->bind_param('ss', $idUtenteBackOffice, $email); // 's' specifies the variable type => 'string'

  $stmt->execute();
  $stmt->store_result();
  $num = $stmt->num_rows;

  if ($num > 0) {
    $qu = "UPDATE novelValutazione SET voto = ? WHERE emailUtente = ? AND idUtenteBackOffice = ?";
    $stmt = $conn->prepare($qu);
    $stmt->bind_param("sss", $voto, $email, $idUtenteBackOffice);
    $stmt->execute();

    $json->risultato = 0;
    $json->messaggio = 'Valutazione aggiornata';
  }else{
    $qu = "INSERT into novelValutazione (voto, emailUtente, idUtenteBackOffice) VALUES(?, ?, ?)";
    $stmt = $conn->prepare($qu);
    $stmt->bind_param("sss", $voto, $email, $idUtenteBackOffice);
    $stmt->execute();

    $json->risultato = 0;
    $json->messaggio = 'Valutazione aggiunta';
  }

}else{
  $json->risultato = -1;
  $json->messaggio = 'Errore nel passaggio dei parametri';
}

echo json_encode($json);
