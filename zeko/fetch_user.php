<?php
    include("database_connect.php");
    session_start();
    $requette="SELECT * FROM inscrire WHERE user_id!='".$_SESSION['user_id']."'";
    $etat=$connection->prepare($requette);
    $etat->execute();
    $resultat=$etat->fetchAll();
    $sortie='
        <br><div class="card">
    ';
    foreach($resultat as $row)
    {
        
        $status='';
        $temps_actuel=strtotime(date('Y-m-d H:i:s'). '-10 seconde');
        $temps_actuel=date('Y-m-d H:i:s',$temps_actuel);
        $user_activity=derniere_utilisation($row['user_id'],$connection);
        if ($user_activity>$temps_actuel)
        {
            $status='<span class="btn btn-success disabled">En ligne</span>';
        }
        else
        {
            $status='<span class="btn btn-danger disabled">Hors ligne</span>';
        }
        $sortie .='
                <div class="card-header"><h2>'.$row['username'].'</h2></div>
                <div class="card-body">
                    <blockquote class="blockquote mb-0">
                        <p>Veuillez cliquez sur le bouton ci-dessous pour discuter avec '.$row['username'].'</p>
                        <button class="btn btn-info btn-xs start_chat" data-toogle="modal" data-target="#dialogue" data-touserid="'.$row['user_id'].'" data-tousername="'.$row['username'].'">Discuter</button>
                    </blockquote>
                </div>
        ';
    }
    $sortie .='</div><br><br>';
    echo $sortie;
?>