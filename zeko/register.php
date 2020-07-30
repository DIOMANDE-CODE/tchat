<?php
    include("database_connect.php");
    session_start();
    $message="";
    if (isset($_SESSION['user_id']))
    {
        header("location:index.php");
    }
    if (isset($_POST['login']))
    {
        $username=trim($_POST['username']);
        $password=trim($_POST['password']);
        $verification="SELECT * FROM inscrire WHERE username=:username";
        $etat=$connection->prepare($verification);
        $verif_donnee=array(
            ':username'=>$username
        );
        if ($etat->execute($verif_donnee))
        {
            if ($etat->rowCount()>0)
            {
                $message="<label>L'utilisateur entrée existe dejà</label>";
            }
            else
            {
                if (empty($username))
                {
                    $message="<label>Le champs utilisateur est obligé</label>";
                }
                if (empty($password))
                {
                    $message="<label>Le champs mot de passe est obligé<label>";
                }
                else
                {
                    if ($password!=$_POST['confirm_password'])
                    {
                        $message="<label>Les mots de passe doivent être identiques</label>";
                    }
                }
                if ($message=="")
                {
                    $donnee=array(
                        ':username'=>$username,
                        ':code'=>password_hash($password,PASSWORD_DEFAULT)
                    );
                    $query="INSERT INTO inscrire (username,code) VALUES (:username,:code)";
                    $etat=$connection->prepare($query);
                    if ($etat->execute($donnee))
                    {
                        header('location:index.php');
                    }
                }
            }
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
        <script>
        $(window).on('load',function(){
            $('#myModal').modal('show');
        })
    </script>
    </header>
    <body>
        <div class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="login.php">Py-chat application</a>
        </div><br><br>
        <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="staticBackdropLabel">Inscription</h5>
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
                                <label>Entrez votre pseudonyme</label>
                                <input type="text" autocomplete="off" name="username" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Entrez votre mot de passe </label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Confirmer le mot de passe </label>
                                <input type="password" name="confirm_password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="login" value="S'inscrire" class="btn btn-info">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
  </div>
</div>

    <img width="100%" src="image/video-conference-5231284_1920.png">
    <h3 style="position:absolute; top:20%; left:20px;">BIENVENUE SUR L'APPLICATION </h3><br><br>
        <h1 style="position:absolute; top:26%; left:30px;">Py Tchat application</h1>
   
    </body>
</html>