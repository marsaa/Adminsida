<?php
require_once "../database.php";
if(!empty($_POST['eventID'])){
    $id = $_POST['eventID'];

    $db = DB::getInstance();
    $sql = $db->dbh->prepare("DELETE FROM events WHERE id = :id");
    $sql->bindValue("id",$id);
    $sql->execute();
    echo json_encode("Got it");
};
