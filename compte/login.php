<!DOCTYPE html>
 <html>
 <head>
    <title>EasyDrinks - Connexion</title>
    <meta charset="utf-8" />

    <link rel="stylesheet" type="text/css" href="../style.css" media="screen" />
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
    
        function retourAccueil(){

            $(location).prop('href', '../index.php?#');
        }

        function sendData() {
            $.post("loginValidation.php", 
            {
                login: $('#login').val(),
                password: mdp
                
            }, function(data, status){
                if(data == "OK"){
                    $(location).prop('href', '../index.php?#');
                }else{
                    $('.retourFormulaire').remove();
                    $('.main').append(data);
                }
            });
        }

        $(document).ready(function(){
            $(document).on('click', '.valider', function(){
                sendData();
            });

            $(document).on('keyup', '#pass', function(){
                mdp = $(this).val();
            });
        });
        
    </script>

 </head>
 <body>
    <div class="grid-container">
        <div class="header" onClick="retourAccueil()"> 
            
        </div>


        <div class="menu">

        </div>


        <div class="main">
            <h1 class="sousTitre">S'identifier</h1>

            <div class="parentFormulaire">
                <form id="formLogin" class="formulaire">

                    <div class="itemFormulaire">
                        <span>Login :</span>
                        <input id="login" type="text" required="required" />
                    </div>

                    
                    <div class="itemFormulaire">
                        <span>Mot de passe (8 caractères minimum) :</span>
                        <input type="password" id="pass" minlength="8"  required="required" />
                    </div>
                </form>
                <button class='valider'>Valider</button>
                <p>Pas de compte ?</p>
                <a href="register.php">S'enregistrer</a>
            </div>
        </div>

        <div class="right">

        </div>

        <div class="footer">
        </div>
    </div>
</body>
</html>