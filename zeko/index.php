<?php
    include("database_connect.php");
    session_start();
    if (!isset($_SESSION['user_id']))
    {
        header('location:login.php');
    }
?>
<html>
    <header>
        <meta charset="utf-8">
        <title>Py-Chat</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <!-- JS, Popper.js, and jQuery -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </header>
    <body>
    <div class="navbar navbar-expand-lg navbar-dark bg-info">
        <a class="navbar-brand" href="#">Py-chat application</a>
    </div><br><br>
        <div class="table-responsive">
            <h4 align="center"><U>Utilisateur(s) connecté(s)</U></h4>
            <p align="right">Bienvenue <b><?php echo $_SESSION['username'];?></b>- <a href="logout.php">Se deconnecter</a></p>
            <div id="user_details"></div>
            <div id="user_model_details">
            </div>
        </div>
    </body>
</html>
<script>
    $(document).ready(function(){

        fetch_user();
        setInterval(function()
        {
            mise_a_jour();
            fetch_user();
            update_chat_history();
            
        },2000);

        function fetch_user()
        {
            $.ajax({
                url:"fetch_user.php",
                method:"POST",
                success:function(data){
                    $('#user_details').html(data);
                }
            })
        }

        function mise_a_jour()
        {
            $.ajax({
                url:"last_activity.php",
                success:function()
                {

                }
            })
        }

    function make_chat_dialog_box(to_user_id, to_user_name)
        {
        var modal_content = '<br><br><br><div id="user_dialog_'+to_user_id+'" class="user_dialog" title="You have chat with '+to_user_name+'">';
        modal_content += '<div style="height:400px; border:1px solid #ccc; overflow-y: scroll; margin-bottom:24px; padding:16px;" class="chat_history" data-touserid="'+to_user_id+'" id="chat_history_'+to_user_id+'">';
        modal_content += fetch_user_chat_history(to_user_id);
        modal_content += '</div>';
        modal_content += '<div class="form-group">';
        modal_content += '<textarea name="chat_message_'+to_user_id+'" id="chat_message_'+to_user_id+'" class="form-control"></textarea>';
        modal_content += '</div><div class="form-group" align="right">';
        modal_content+= '<button type="button" name="send_chat" id="'+to_user_id+'" class="btn btn-info send_chat">Send</button></div>';
        $('#user_model_details').html(modal_content);
        }

        $(document).on('click', '.start_chat', function(){
        var to_user_id = $(this).data('touserid');
        var to_user_name = $(this).data('tousername');
        make_chat_dialog_box(to_user_id, to_user_name);
        $("#user_dialog_"+to_user_id).dialog({
        autoOpen:false,
        width:400
        });
        $('#user_dialog_'+to_user_id).dialog('open');
        });

        $(document).on('click', '.send_chat', function(){
        var to_user_id = $(this).attr('id');
        var chat_message = $('#chat_message_'+to_user_id).val();
        $.ajax({
        url:"insert_chat.php",
        method:"POST",
        data:{to_user_id:to_user_id, chat_message:chat_message},
        success:function(data)
        {
            $('#chat_message_'+to_user_id).val('');
            $('#chat_history_'+to_user_id).html(data);
        }
        });
        })

    function fetch_user_chat_history(to_user_id)
    {
        $.ajax({
            url:"fetch_user_chat.php",
            method:"POST",
            data:{to_user_id:to_user_id},
            success:function(data){
                $('#chat_history_'+to_user_id).html(data)
            }
        });
    }

    function update_chat_history(){
        $('.chat_history').each(function(){
            var to_user_id=$(this).data('touserid');
            fetch_user_chat_history(to_user_id);
        });
    }






    })
        
</script>