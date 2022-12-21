<?php

session_start();

require '../db.php';

/* Reprise de la correction, car mon ancien code était confu
   ce travail n'a PAS été réalisé par mes soins
*/

// Vérification du formulaire
 $ClassLogin='ok';
 $ClassMdp='ok';
 $ChampsIncorrects='';

// Vérification du login
if((isset($_POST['login']))) 
{ 
    $login = trim($_POST['login']);

    if (strlen($login) > 100 || strlen($login) < 2 ||  !preg_match("/^[a-zA-Z0-9àâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñÿý \-\_]+$/i", $login)) // lettres, chiffres, tirets, accents, espaces
    {
        $ChampsIncorrects=$ChampsIncorrects.'<li>login</li>';
        $ClassLogin='error';
    }
}

// Vérification du password
if((isset($_POST['password'])))
{ 
    $password = trim($_POST['password']);

    if (strlen($password) > 100 || strlen($password) < 8 || !preg_match("/^[a-zA-Z0-9àâáçéèèêëìîíïôòóùûüÂÊÎÔúÛÄËÏÖÜÀÆæÇÉÈŒœÙñÿý \-\_!#$\*%{}\^&?\. ]+$/i", $password)) // lettres, chiffres, tirets, accents, points et caractères dans l'ensemble {!#$*%^&?.} (8 caractères mini)
    {
        $ChampsIncorrects=$ChampsIncorrects.'<li>mdp (8 caractères minimum composé de lettres, chiffres, tirets, accents, points et caractères dans l\'ensemble {!#$*%^&?.})</li>';
        $ClassLogin='error';
    }
}

// Login dans la bdd
if($ChampsIncorrects=='')
{ 
    if(tentativeConnexion($login, $password)){

        $_SESSION['login'] = $login;

        echo 'OK';

    }else{
        echo '
            <div class="retourFormulaire">
            <br />
            Le login ou le mot de passe est incorrect
            </div>';
    } 
}else{
    echo '
        <div class="retourFormulaire">
        <br />
        Le login ou le mot de passe est incorrect
        </div>';
}

 ?>