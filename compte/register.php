<?php session_start(); ?>

<!DOCTYPE html>
 <html>
 <head>
    <title>EasyDrinks - Inscription</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
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
            $.post("registerValidation.php", 
            {
                login: $('#login').val(),
                password: mdp,
                nom: $('#nom').val(),
                prenom: $('#prenom').val(),
                sexe: $('#sexe:checked').val(),
                email: $('#email').val(),
                naissance: $('#ddn').val(),
                postal: $('#postal').val(),
                zip: $('#zip').val(),
                ville: $('#ville').val(),
                telephone: $('#telephone').val()
                
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
            <h1 class="sousTitre">S'enregistrer</h1>

            <div class="parentFormulaire">
                <form id="formRegister" class="formulaire">

                    <div class="itemFormulaire">
                        <span>Login :</span>
                        <input id="login" type="text" required="required" />
                    </div>

                    <div class="itemFormulaire">
                        <span>Mot de passe (8 caractères minimum) :</span>
                        <input type="password" id="pass" minlength="8"  required="required" />
                    </div>

                    <div class="itemFormulaire">
                        <span>Sexe :</span>
                        <span class="radio">
                            <input id="sexe" type="radio" value="f"/>Femme
                            <input id="sexe" type="radio" value="h"/>Homme
                        </span>
                    </div>

                    <div class="itemFormulaire">
                        <span>Nom :</span>
                        <input id="nom" type="text" placeholder="DUPONT">
                    </div>


                    <div class="itemFormulaire">
                        <span>Prénom :</span>
                        <input id="prenom" type="text" placeholder="Jean"/>
                    </div>

                    <div class="itemFormulaire">
                        <span>Adresse Electronique :</span>
                        <input id="email" type="email" placeholder="jean.dupont@email.com"/>
                    </div>

                    <div class="itemFormulaire">
                        <span>Date de naissance :</span>
                        <input id="ddn" type="date"/>
                    </div>

                    <div class="itemFormulaire">
                        <span>Adresse Postale (numéro + rue) :</span>
                        <input id="postal" type="text" placeholder="10 rue Jean Moulin"/>
                    </div>

                    <div class="itemFormulaire">
                        <span>Code postal :</span>
                        <input id="zip" type="text" inputmode="numeric" placeholder="54500"/>
                    </div>

                    <div class="itemFormulaire">
                        <span>Ville :</span>
                        <input id="ville" type="text" placeholder="Vandoeuvre-Lès-Nancy"/>
                    </div>

                    <div class="itemFormulaire">
                        <span>Téléphone :</span>
                        <input id="telephone" type="tel" placeholder="+33000000000"/>
                    </div>
                
                </form>
                <button class='valider'>Valider</button>
            </div>
        </div>

        <div class="right">

        </div>

        <div class="footer">
        </div>
    </div>
</body>
</html>