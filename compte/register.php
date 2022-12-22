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
    <div class="grid-container">
        <div class="header"> 
            <a href="../index.php?#" class="titre"> <h1> Easy Drinks </h1> </a>
            
        </div>


        <div class="menu">

        </div>


        <div class="main">
            <h1>S'enregistrer</h1>

            <form id="formRegister">
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

                <br/>

                Sexe :
                <span class="<?php echo $ClassSexe; ?>">
                    <input id="sexe" type="radio" value="f"
                    /> femme
                    <input id="sexe" type="radio" value="h"
                    /> homme
                </span>

                <br/>

                Nom :
                <input id="nom" type="text" class="<?php echo $ClassNom; ?>"
                placeholder="DUPONT">

                <br/>

                Prénom :
                <input id="prenom" type="text" class="<?php echo $ClassPrenom; ?>"
                placeholder="Jean"/>

                <br/>
                
                Adresse Electronique :
                <input id="email" type="email" class="<?php echo $ClassEmail; ?>"
                placeholder="jean.dupont@email.com"
                />
                
                <br/>

                Date de naissance :
                <input id="ddn" type="date" class="<?php echo $ClassNaissance; ?>"/>

                <br/>

                Adresse Postale (numéro + rue) :
                <input id="postal" type="text"
                class="<?php echo $ClassPostal; ?>"
                placeholder="10 rue jean moulin"/>
                
                <br/>

                Code postal :
                <input id="zip" type="text" inputmode="numeric" 
                class="<?php echo $ClassZip; ?>"
                placeholder="54500"/>
                
                <br/>

                Ville :
                <input id="ville" type="text"
                class="<?php echo $ClassVille; ?>"
                placeholder="Vandoeuvre-Lès-Nancy"/>
                
                <br/>

                Téléphone :
                <input id="telephone" type="tel"
                class="<?php echo $ClassTel; ?>"
                placeholder="+33000000000"/>

            
            </fieldset>
            <br/>
            
            </form>
            <button id='valider'>Valider</button>
        </div>

        <div class="right">

        </div>

        <div class="footer">
        </div>
    </div>
</body>
</html>