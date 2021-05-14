<?php
    session_start();
    require_once ("db.php");



    if(!empty($_GET['post_id'])) {
        $post_id =  ($_GET['post_id']);
        settype($like, "integer");
        $sql = $conn->prepare("INSERT INTO like_tb (post_id, liker_id) VALUES( ?, ?)");
        $sql->execute(array($post_id, $_SESSION['id']));
        echo json_encode(array("statusCode"=>200));
    }
	
?>