<?php
$id=$_GET["id"];
$image=$_GET["image"];

if($_SERVER["REQUEST_METHOD"]=="POST") {
    include $_SERVER["DOCUMENT_ROOT"] . "/connection_database.php";
    if(isset($dbh)) {
        $filePathDelete = $_SERVER["DOCUMENT_ROOT"] . "/uploads/" . $image;
        unlink($filePathDelete);
        $sql = "DELETE FROM `users` WHERE id = ?;";
        $stmt = $dbh->prepare($sql);
        $stmt->execute([$id]);
    }
}