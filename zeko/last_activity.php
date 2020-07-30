<?php
    include("database_connect.php");
    session_start();
    $requette="UPDATE inscrire_details SET last_activity=now() WHERE inscrire_details_id='".$_SESSION['inscrire_details_id']."'";
    $etat=$connection->prepare($requette);
    $etat->execute();
?>