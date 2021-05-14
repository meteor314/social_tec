<?php
session_start();
require_once("db.php");
if(!empty($_SESSION['id'])) {



    if(!empty($_GET['following_id']) && !empty ($_GET['follower_id']) && !empty($_GET['return_to'] )) {
        $following = ($_GET['following_id']) ;
        settype($following, "integer");
        echo $following;
        $follower_id = ($_GET['follower_id']);
        settype($follower_id, "integer");
        $req_verify = $conn->prepare("SELECT * FROM follow_tb WHERE following_id=? AND  follower_id=? ");
        $req_verify->execute(array( $following, $_SESSION['id']));
        if($req_verify->rowCount()==0) {

            $req = $conn->prepare("INSERT INTO follow_tb (following_id, follower_id) VALUES ( ?, ?)");
            $req->execute(array( $following, $_SESSION['id']));
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            echo "ok";   
        }

        header('Location: ' . $_SERVER['HTTP_REFERER']);
        

    } 
    else {
        echo "nope";
        header("Location:erreur404.txt");
        die();
    }


}