<?php

function ajouterUtilisateur($pdo, $login, $mdp, $nom, $prenom, $sexe, $email, $ddn, $adresse, $cp, $ville, $noTel){

    $query = "  INSERT INTO utilisateur VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);";
    $result = $pdo->prepare($query);

    $result->execute(array($login, $mdp, $nom, $prenom, $sexe, $email, $ddn, $adresse, $cp, $ville, $noTel));
}

function ajouterAuPanier($pdo, $login, $idRecette){

    $query = "  INSERT INTO panier VALUES (?, ?);";
    $result = $pdo->prepare($query);

    $result->execute(array($login, $idRecette));
}

function supprimerDuPanier($pdo, $login, $idRecette){
    
    $query = "  DELETE FROM panier WHERE login = ? AND idRecette = ?;";
    $result = $pdo->prepare($query);

    $result->execute(array($login, $idRecette));
}

function getPanier($pdo, $login){

    $query = "  SELECT idRecette FROM panier WHERE login = ?;";
    $result = $pdo->prepare($query);

    $result->execute(array($login));

    while($row = $result->fetch()){

        echo "idRecette = ".$row['idRecette']."<br/>";
    }
    $result->closeCursor();
}

try{

    $pdo = new PDO('mysql:host=127.0.0.1; dbname=projet;', 'root', '');

    
    ajouterUtilisateur($pdo, "theo", "theo", "Theo", "Joffroy", "h", "theo@gmail.com", "2022-12-19", "ihfrgf", "54000", "nancy", "0123456789");
    ajouterAuPanier($pdo, "theo", 5);
    ajouterAuPanier($pdo, "theo", 3);
    ajouterAuPanier($pdo, "theo", 7);

    getPanier($pdo, "theo");

    supprimerDuPanier($pdo, 'theo', 3);

    getPanier($pdo, "theo");
    

}catch(Exception $e){
    
    exit($e->getMessage());
}

?>