<?php
    $connection=new PDO("mysql:host=localhost;dbname=tchat","root","");
    date_default_timezone_set('Europe/Paris');
    function derniere_utilisation($user_id,$connection)
    {
        $requette="SELECT * FROM inscrire_details WHERE user_id='$user_id' ORDER BY last_activity DESC LIMIT 1";
        $etat=$connection->prepare($requette);
        $etat->execute();
        $resultat=$etat->fetchAll();
        foreach($resultat as $row)
        {
            return $row['last_activity'];
        }
    }

    function fetch_user_chat_history($from_user_id, $to_user_id, $connection)
    {
        $requette = "SELECT * FROM chat_message WHERE (from_user_id = '".$from_user_id."' AND to_user_id = '".$to_user_id."') OR (from_user_id = '".$to_user_id."' AND to_user_id = '".$from_user_id."') ORDER BY last_activity DESC";
        $etat = $connection->prepare($requette);
        $etat->execute();
        $resultat = $etat->fetchAll();
        $output = '<ul class="list-unstyled">';
        foreach($resultat as $row)
        {
            $user_name = '';
            if($row["from_user_id"] == $from_user_id)
            {
                $user_name = '<b class="text-secondary">Moi</b>';
            }
            else
            {
                $user_name = '<b class="text-info">'.get_user_name($row['from_user_id'],$connection).'</b>';
            }
            $output .= '
            <li style="border-bottom:1px dotted #ccc">
            <p>'.$user_name.' - '.$row["chat_message"].'
                <div align="right">
                - <small><em>'.$row['last_activity'].'</em></small>
                </div>
            </p>
            </li>
            ';
        }
        $output .= '</ul>';
        $requette="
        UPDATE chat_message
        SET statut='0' WHERE
        from_user_id='".$to_user_id."'
        AND to_user_id='".$from_user_id."'
        AND statut='1'
        ";
        $etat=$connection->prepare($requette);
        $etat->execute();
        return $output;
    }

    function get_user_name($user_id, $connection)
    {
        $requette = "SELECT username FROM inscrire WHERE user_id = '$user_id'";
        $etat = $connection->prepare($requette);
        $etat->execute();
        $resultat = $etat->fetchAll();
        foreach($resultat as $row)
        {
            return $row['username'];
        }
    }
?>