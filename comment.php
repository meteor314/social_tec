<?php
session_start();
require_once("db.php");

function securisation ($input) { //XML ATTACK, SQL injection  
    $input = htmlspecialchars($input);
    return $input;

}

if(!empty($_GET['id']) && !empty($_SESSION['id'])){
    $id=$_GET['id'];
    settype($id, "integer");
    echo $id;

    $req = $conn->prepare(" SELECT * FROM publication WHERE id=?");
    $req->execute(array($id));
    if($req->rowCount() == 0) {
        echo "cas A";
        header("Location:erreur404.txt"); //if the post doesn't exist
    }

    if(isset($_POST["submit_btn"])){
        if(!empty($_POST['post_content']) ) {
            $post_content =securisation($_POST['post_content']);
            //INSERT DATA 
            $ins = $conn->prepare("INSERT INTO comment (content, publish_date, publisher_id, post_id, nom) VALUES(?, NOW(), ?, ?, ?)");

            $ins->execute(array($post_content,  $_SESSION['id'], $id, $_SESSION['nom'] ));
            echo "succes";

        }
    }

    $fetch_comment=$conn->prepare("SELECT * FROM comment WHERE post_id = ?");
    $fetch_comment->execute(array($id));


    $publication_affichage1 =  $conn->prepare("SELECT * FROM publication WHERE id=?" );
    $publication_affichage1->execute(array($id));





} else {
    echo "ca B";
    header("Location:erreur404.txt");
}

?>

<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="css/comment.css">

</head>
<body>

<link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
  <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/@webcreate/infinite-ajax-scroll@^3.0.0-beta.6/dist/infinite-ajax-scroll.min.js"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/publication.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://www.w3schools.com/lib/w3-theme-blue-grey.css">
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/fil.css">
    <link rel="stylesheet" href="css/dark-theme.css">
    <style>
 img {
    width: 100%;
    height: 100%;    
}.container-grid {
    padding: 13px;
    height: auto;
    font-size: large;
    font-size:23px;

}

</style>

  
<div id="main-post">   

<?php
// afficher les publications !

while($row =  $publication_affichage1->fetch(PDO::FETCH_ASSOC)){
    $postID =$row['id'];
        
?>
<div id="posts-container">
<div class="mdc-card container container-grid " style="width:600px;margin-bottom:12px;">
    <div class="mdc-card__primary-action">
        <div class="mdc-card__media mdc-card__media--square">
            <div class="mdc-card__media-content"> 
                <p>  <?= ($row['contenu']); ?></p> <!-- //publish content  --->
                <?php if($row["postFileName"] !="NULL") { ?>
                    <img src="upload_img/<?=$row["postFileName"]?>" alt="" class="viewer img-thumbnail img-fluid " id="viewer">
                <?php
                    }
                ?>
                
                
            </div>
        </div> 
        <p>Publié le :<?= htmlspecialchars($row['date_de_publication']); ?> par    <?= ($row['nom']); ?></p> <!-- //nom et date -->
    
    </div>
    <div class="mdc-card__actions">
        <div class="mdc-card__action-buttons">
        <button class="mdc-button mdc-card__action mdc-card__action--button">
            <div class="mdc-button__ripple"></div>
            <?php if($row["admin_id"] ==$_SESSION['id']) { //if this is the user post ?>
            <!-- trash file option -->
            <label class="material-icons mdc-icon-button mdc-card__action mdc-card__action--icon" title="Ajouter une image" onClick="window.location.href='delete.php?id=<?= ($postID); ?>'">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                    <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                    <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                    </svg> 
                </label>
                <?php
                    }
                ?>
                
        </button>
        <button class="mdc-button mdc-card__action mdc-card__action--button">
            <div class="mdc-button__ripple"></div>
            <span class="mdc-button__label">Action 2</span>
        </button>
        </div>
        <div class="mdc-card__action-icons">
        <button class="material-icons mdc-icon-button mdc-card__action mdc-card__action--icon" title="Share">share</button>
        <button class="material-icons mdc-icon-button mdc-card__action mdc-card__action--icon" title="More options">more_vert</button>
        </div>
    </div>
</div>
</div>
</div>







        


        <div class="comments">
            <div class="comment-wrap">
                    <div class="comment-block">
                            <form action="#" method="post">
                                <textarea  id="textarea" name="post_content" placeholder="Add comment..." ></textarea>
                                <input type="submit" name="submit_btn" id="submit_btn" value="Soumettre">        
                        
                            </form>
                                            
                    </div>
            </div>

            <?php


                  }

                while($row =  $fetch_comment->fetch(PDO::FETCH_ASSOC)){
                
                     ?>
                    
                
                        <div class="comment-wrap">
                                <div class="photo">
                                        <div class="avatar" style="background-image: url('https://s3.amazonaws.com/uifaces/faces/twitter/jsa/128.jpg')"></div>
                                </div>
                                <div class="comment-block">
                                        <p class="comment-text">

                                        <a href="profile.php?id=<?=$row['publisher_id']?>">  <?=$row['nom'] ?> :  </a>
                                        <?=$row['content']?> <br>
                                    
                                                            
                                        </p>
                                        <div class="bottom-comment">
                                                <div class="comment-date"><?=$row['publish_date']?></div>
                                                <ul class="comment-actions">
                                                </ul>
                                        </div>
                                </div>
                        </div>
                    </div>

               <?php } ?>



</body>
</html>

