<!DOCTYPE html>
 <html>
 <head>
    <title>EasyDrinks - Connexion</title>
    <meta charset="utf-8" />

    <link rel="stylesheet" type="text/css" href="style.css" media="screen" />
    <style type="text/css">
    .ok {
    }
    .error
    { 
        background-color: red;
    }
    </style>

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
    <script type="text/javascript">
        
        let mdp = '';
    
        function sendData() {
            $.post("loginValidation.php", 
            {
                login: $('#login').val(),
                password: mdp
                
            }, function(data, status){
                if(data == "OK"){
                    $(location).prop('href', './index.php?#');
                }else{
                    $('.retourFormulaire').remove();
                    $('.main').append(data);
                }
            });
        }

        $(document).ready(function(){
            $(document).on('click', '#valider', function(){
                sendData();
            });

            $(document).on('keyup', '#pass', function(){
                mdp = $(this).val();
            });
        });
        
    </script>

 </head>
 <body>
    <div class="header"> 
        <a href="./index.php?#" class="titre"> <h1> Easy Drinks </h1> </a>
        
    </div>


    <div class="menu">

    </div>


    <div class="main">
        <h1>S'identifier</h1>

        <form id="formLogin" >
            <fieldset>
            <legend>Informations personnelles</legend>

            Login : 
            <input id="login" type="text" class="<?php echo $ClassLogin; ?>"
            required="required" />

            <br/>

            Mot de passe (8 caractères minimum) :
            <input type="password" id="pass"
            class="<?php echo $ClassMdp; ?>"
            value=""
            minlength="8" 
            required="required" />

        </fieldset>
        <br/>
        </form>
        <button id='valider'>Valider</button>
        <a href="register.php">S'enregistrer</a>
    </div>

    <div class="right">

    </div>

    <div class="footer">
    </div>
</body>
</html>