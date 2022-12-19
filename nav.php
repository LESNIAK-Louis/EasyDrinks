<?php

require 'Donnees.inc.php';

$res = $Hierarchie[$_POST['current']]['sous-categorie'];
echo json_encode($res);

?>