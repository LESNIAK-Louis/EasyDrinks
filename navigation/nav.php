<?php

require '../Donnees.inc.php';

try{
    $res = $Hierarchie[$_POST['current']]['sous-categorie'];
    echo json_encode($res);
}catch(Exception $e){
    echo json_encode(array(
        'error' => array(
            'msg' => $e->getMessage(),
            'code' => $e->getCode(),
        ),));
}
?>