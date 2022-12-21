<?php

function ajouterUtilisateur($utilisateur){

    $pdo = new PDO('mysql:host=127.0.0.1; dbname=projet;', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "  INSERT INTO utilisateur VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $result = $pdo->prepare($query);

    try{
        $result->execute(array($utilisateur['login'], $utilisateur['mdp'], $utilisateur['nom'], $utilisateur['prenom'], $utilisateur['sexe'], $utilisateur['email'], $utilisateur['ddn'], $utilisateur['adresse'], $utilisateur['cp'], $utilisateur['ville'], $utilisateur['noTel']));
    }catch(PDOException $e){
        throw new Exception($e->errorInfo[1]);
    }
}

function tentativeConnexion($login, $mdp){

    $pdo = new PDO('mysql:host=127.0.0.1; dbname=projet;', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "  SELECT * FROM utilisateur WHERE login = ? AND mdp = ?;";
    $result = $pdo->prepare($query);

    $result->execute(array($login, $mdp));
    return ($result->rowCount() == 1);
}

function getUtilisateur($login){

    $pdo = new PDO('mysql:host=127.0.0.1; dbname=projet;', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = "  SELECT * FROM utilisateur WHERE login = ?;";
    $result = $pdo->prepare($query);

    $result->execute(array($login));

    $utilisateur = array();
    while($row = $result->fetch()){

        $utilisateur = array('login' => $row['login'],
                         'mdp' => $row['mdp'], 
                         'prenom' => $row['prenom'],
                         'nom' => $row['nom'],
                         'sexe' => $row['sexe'],
                         'email' => $row['email'],
                         'ddn' => $row['ddn'],
                         'adresse' => $row['adresse'],
                         'cp' => $row['cp'],
                         'ville' => $row['ville'],
                         'noTel' => $row['noTel']);
    }
    $result->closeCursor();

    return $utilisateur;
}

function modifierUtilisateur($utilisateur){

    $pdo = new PDO('mysql:host=127.0.0.1; dbname=projet;', 'root', '');

    $query = "  UPDATE utilisateur SET nom=?, prenom=?, sexe=?, email=?, ddn=?, adresse=?, cp=?, ville=?, noTel=? WHERE login=?;";
    $result = $pdo->prepare($query);

    $result->execute(array($utilisateur['nom'], $utilisateur['prenom'], $utilisateur['sexe'], $utilisateur['email'], $utilisateur['ddn'], $utilisateur['adresse'], $utilisateur['cp'], $utilisateur['ville'], $utilisateur['noTel'], $utilisateur['login']));
}

function ajouterAuPanier($login, $idRecette){

    $pdo = new PDO('mysql:host=127.0.0.1; dbname=projet;', 'root', '');

    $query = "  INSERT INTO panier VALUES (?, ?);";
    $result = $pdo->prepare($query);

    $result->execute(array($login, $idRecette));
}

function supprimerDuPanier($login, $idRecette){
    
    $pdo = new PDO('mysql:host=127.0.0.1; dbname=projet;', 'root', '');

    $query = "  DELETE FROM panier WHERE login = ? AND idRecette = ?;";
    $result = $pdo->prepare($query);

    $result->execute(array($login, $idRecette));
}

function getPanier($login){

    $pdo = new PDO('mysql:host=127.0.0.1; dbname=projet;', 'root', '');

    $query = "  SELECT idRecette FROM panier WHERE login = ?;";
    $result = $pdo->prepare($query);

    $result->execute(array($login));

    $panier = array();
    while($row = $result->fetch()){

        $panier[] = $row['idRecette'];
    }
    $result->closeCursor();

    return $panier;
}

try{

    /*
    $utilisateur = array('login' => 'theo',
                         'mdp' => 'theo', 
                         'prenom' => 'Theo',
                         'nom' => 'Joffroy',
                         'sexe' => 'h',
                         'email' => 'theo@gmail.com',
                         'ddn' => '2022-12-19',
                         'adresse' => 'ihfrgf',
                         'cp' => '54000',
                         'ville' => 'nancy',
                         'noTel' => '0123456789');

    ajouterUtilisateur($pdo, $utilisateur);
    ajouterAuPanier($pdo, "theo", 5);
    ajouterAuPanier($pdo, "theo", 3);
    ajouterAuPanier($pdo, "theo", 7);

    getPanier($pdo, "theo");

    supprimerDuPanier($pdo, 'theo', 3);

    getPanier($pdo, "theo");

    $utilisateur['ddn'] = '2022-12-20';
    $utilisateur['adresse'] = 'abcdef';

    modifierUtilisateur($pdo, $utilisateur);
    */

}catch(Exception $e){
    
    exit($e->getMessage());
}

?>