<?php

try{

    $pdo = new PDO('mysql:host=127.0.0.1;', 'root', '');

    $db = "projet";

    $query = "  DROP DATABASE IF EXISTS projet;
                CREATE DATABASE projet CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
                USE projet; 
                CREATE TABLE utilisateur (login VARCHAR(100) PRIMARY KEY, mdp VARCHAR(60) NOT NULL, nom VARCHAR(100), prenom VARCHAR(100), sexe VARCHAR(1), email VARCHAR(100), ddn DATE, adresse VARCHAR(100), cp VARCHAR(100), ville VARCHAR(100), noTel VARCHAR(100));
                CREATE TABLE panier (login VARCHAR(100), idRecette INT, PRIMARY KEY(login, idRecette), FOREIGN KEY(login) REFERENCES utilisateur(login));";

    foreach(explode(';',$query) as $Requete){
        $pdo->exec($Requete.";");
    }

}catch(Exception $e){
    
    exit($e->getMessage());
}

?>