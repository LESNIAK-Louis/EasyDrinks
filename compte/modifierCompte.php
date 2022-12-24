<?php session_start(); ?>

<!DOCTYPE html>
 <html>
 <head>
    <title>EasyDrinks - Modification compte</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    
    <link rel="stylesheet" type="text/css" href="../style.css" media="screen" />

    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>
    <script type="text/javascript">
        
        let mdp = '';
    
        function retourAccueil(){

            $(location).prop('href', '../index.php?#');
        }

        function sendData() {
            $.post("modifierValidation.php", 
            {
                login: $('#login').text(),
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
                    $(location).prop('href', './compte.php?#');
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
            <h1 class="sousTitre">Modifier les informations du compte</h1>

            <div class="parentFormulaire">
                <form id="formModifier" class="formulaire">

                    <?php
                    require '../db.php';

                    if(isset($_SESSION['login'])){

                        $login = $_SESSION['login'];

                        $utilisateur = getUtilisateur($login);

                        $ddn = '';

                        if(isset($utilisateur['ddn'])){
                            list($Annee,$Mois,$Jour) = explode('-',$utilisateur['ddn']);
                            $ddn = $Jour.'/'.$Mois.'/'.$Annee;
                        }

                        echo '
                            <div class="itemFormulaire">
                                <span id="login">'.(isset($utilisateur['login']) ? $utilisateur['login'] : '').'</span>
                            </div>
            
                            <div class="itemFormulaire">
                                <span>Sexe :</span>
                                <span class="radio">
                                    <input id="sexe" type="radio" value="f"'.(isset($utilisateur['sexe']) && $utilisateur['sexe'] == 'f' ? 'checked="checked"' : '').' 
                                    /> femme
                                    <input id="sexe" type="radio" value="h"'.(isset($utilisateur['sexe']) && $utilisateur['sexe'] == 'h' ? 'checked="checked"' : '').' 
                                    /> homme
                                </span>
                            </div>

                            <div class="itemFormulaire">
                                <span>Nom :</span>
                                <input id="nom"
                                value="'.(isset($utilisateur['nom']) ? $utilisateur['nom'] : '').'"/>
                            </div>

                            <div class="itemFormulaire">
                                <span>Prénom :</span>
                                <input id="prenom" type="text"
                                value="'.(isset($utilisateur['prenom']) ? $utilisateur['prenom'] : '').'"/>
                            </div>
     
                            <div class="itemFormulaire">
                                <span>Adresse Electronique :</span>
                                <input id="email" type="email"
                                value="'.(isset($utilisateur['email']) ? $utilisateur['email'] : '').'"/>
                            </div>

                            <div class="itemFormulaire">
                                <span>Date de naissance :</span>
                                <input id="ddn" type="date" value="'.(isset($utilisateur['ddn']) ? $utilisateur['ddn'] : '').'"/>
                            </div>

                            <div class="itemFormulaire">
                                <span>Adresse Postale (numéro + rue) :</span>
                                <input id="postal" type="text"
                                value="'.(isset($utilisateur['adresse']) ? $utilisateur['adresse'] : '').'"/>
                            </div> 

                            <div class="itemFormulaire">
                                <span>Code postal :</span>
                                <input id="zip" type="text" inputmode="numeric"
                                value="'.(isset($utilisateur['cp']) ? $utilisateur['cp'] : '').'"/>
                            </div>    

                            <div class="itemFormulaire">
                                <span>Ville :</span>
                                <input id="ville" type="text"
                                value="'.(isset($utilisateur['ville']) ? $utilisateur['ville'] : '').'"/>
                            </div>

                            <div class="itemFormulaire">
                                <span>Téléphone :</span>
                                <input id="telephone" type="tel"
                                value="'.(isset($utilisateur['noTel']) ? $utilisateur['noTel'] : '').'"/>
                            </div>';
                    }
                    ?>
                
                </fieldset>
                <br/>
                
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