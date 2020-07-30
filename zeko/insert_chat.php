<?php

    include('database_connect.php');

    session_start();

    $donnee = array(
    ':to_user_id'  => $_POST['to_user_id'],
    ':from_user_id'  => $_SESSION['user_id'],
    ':chat_message'  => $_POST['chat_message'],
    ':statut'   => '1'
    );

    $requette = "
    INSERT INTO chat_message 
    (to_user_id, from_user_id, chat_message, statut) 
    VALUES (:to_user_id, :from_user_id, :chat_message, :statut)
    ";

    $etat = $connection->prepare($requette);

    if($etat->execute($donnee))
    {
        echo fetch_user_chat_history($_SESSION['user_id'], $_POST['to_user_id'], $connection);
    }

?>