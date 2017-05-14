<?php
require_once "../database.php";
if(!empty($_POST['user_id'])){
    $id = $_POST['user_id'];

    $db = DB::getInstance();
    $sql = $db->dbh->prepare("DELETE FROM bookings WHERE user_id = :id");
    $sql->bindValue("id",$id);
    $sql->execute();
    echo json_encode("Got it");
};
