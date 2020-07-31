<?php
    include("database_connect.php");
    session_start();
    $message="";
    if (isset($_SESSION['user_id']))
    {
        header('location:index.php');
    }
    if (isset($_POST['login']))
    {
        $requette="SELECT * FROM inscrire WHERE username=:username";
        $etat=$connection->prepare($requette);
        $etat->execute(
            array(
                ':username'=>$_POST['username']
            )
        );
        $count=$etat->rowCount();
        if ($count>0)
        {
            $resultat=$etat->fetchAll();
            foreach($resultat as $row)
            {
                if (password_verify($_POST['password'],$row['code']))
                {
                    $_SESSION['user_id']=$row['user_id'];
                    $_SESSION['username']=$row['username'];
                    $_sous_requette="INSERT INTO inscrire_details (user_id) VALUES ('".$row['user_id']."')";
                    $etat=$connection->prepare($_sous_requette);
                    $etat->execute();
                    $_SESSION['inscrire_details_id']=$connection->lastInsertId();
                    header('location:index.php');
                }
                else
                {
                    $message="<label>Mauvais mot de passe</label>";
                }
            }
        }
        else
        {
            $message="<label>Mauvais nom utilisateur</label>";
        }
    }
?>

<html>
    <header>
        <title>Py-Chat</title>
        <!-- CSS only -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

        <!-- JS, Popper.js, and jQuery -->
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    </header>
    <body>
        <!-- navbar -->
        <div class="navbar navbar-expand-lg navbar-light bg-light">
            <span class="navbar-brand">Py-chat application</span>
            
        </div>


        <div class="modal fade" id="staticBackdrop" data-backdrop="static" data-keyboard="true" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Connexion</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <div class="modal-body">
                <div class="panel panel-dafault">
                    <div class="panel-body">
                        <p class="text-danger"><?php echo $message; ?></p>
                        <form method="post">
                            <div class="form-group">
                                <label>Pseudonyme</label>
                                <input type="text" autocomplete="off" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Mot de passe</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="login" value="Se connecter" class="btn btn-info">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
        <br>
            <img width="100%" src="image/video-conference-5231284_1920.png">
            <h3 style="position:absolute; top:20%; left:20px;">BIENVENUE SUR L'APPLICATION </h3><br><br>
            <h1 style="position:absolute; top:26%; left:30px;">Py-chat application</h1>
            <a style="position:absolute; top:85%; left:16.8%;" href="register.php"><button type="button" class="btn btn-outline-primary btn-lg">S'incrire</button></a>
            <button style="position:absolute; top:110%; left:15%;" type="button" class="btn btn-outline-success btn-lg" data-toggle="modal" data-target="#staticBackdrop">Se connecter</button>
    </body>
</html>

