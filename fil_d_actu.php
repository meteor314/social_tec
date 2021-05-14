<?php

session_start();
require("db.php");
function securisation ($input) { //XML ATTACK, SQL injection  
    $input = htmlspecialchars($input);
    return $input;

}


//random string for file file char
function randomName () {
    $rand ="azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN1234567890";
    $randStringToReturn ='';
    for($ii=0; $ii < 7; ++$ii){
        $index = rand(0, 51); // strlen $rand-1
        $randStringToReturn .= $rand[$index];

    }


    return $randStringToReturn;
}





if(!empty($_GET['id'])) {
    $id = $_GET['id'];
    settype($id, "integer"); 





    $current_timestamp = date('Y-m-d H:i:s');
    if($_SESSION['id'] == $id) {

        $req = $conn->prepare("SELECT * FROM member WHERE id = ?");
        $req->execute(array($id));
        
        $user_info = $req->fetch();

    } else {
        echo "compte inexistant";
        header("Location:erreur404.html");
        die();
    }
} else {
    die();
}


if(isset($_POST['submit_btn'])) {

    if(!empty ($_POST['publication']) &&  ($_FILES['fileToUpload']["tmp_name"]!="")  ){//if user uploaded an image 

        if(strlen  ($_POST['publication']) > 360 ) {
            echo"360 caractèrs autorisé";
        } else {

            $publication = securisation (($_POST['publication'])   );
            $publication = nl2br($publication);
            $target_dir = "uploads_img/";
            $randomNameFile = randomName();



            //====================== upload image ===================



                $target_dir = "upload_img/";
                $ext = pathinfo($_FILES["fileToUpload"]["name"], PATHINFO_EXTENSION);
                $randomNameFile .=".".$ext;

                $target_file = $target_dir . basename($randomNameFile);
                echo $target_file;
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
                
                
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    echo "OK - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "Uniquement les fichiers au format, jpeg,jpg, png, gif.";
                    $uploadOk = 0;
                }
                
                
                // Check if file already exists
                if (file_exists($target_file)) {
                    echo "Désolé le fichier existe déjà.";
                    $uploadOk = 0;
                }
                
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    echo "Fichier trop volumineux";
                    $uploadOk = 0;
                }
                if ($uploadOk == 0) {
                    echo "Désolé une erreur inconnue est survenue.";
                } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir . $randomNameFile)) {
                    // insert image name on the database

                    $insert_db =  $conn->prepare("INSERT INTO publication (contenu, date_de_publication, admin_id, nom, postFileName) VALUES ( ?, ?, ?, ?, ?)");
                    $insert_db->execute(array($publication, $current_timestamp, $id, $user_info['nom'], $randomNameFile ));
                } else {
                    echo "Désolé, une erreur inconnue est survenue, veuillez réassyer.";
                }
                }
            
            }



            //===================== upload image =====================
     

    }

       // echo 'Envoyé';
        
         
       
    else if(!empty ($_POST['publication'])   ){ //if user doesn't upload any image
    
            if(strlen  ($_POST['publication']) > 360 ) {
                echo"360 caractèrs autorisé";
            } else {
    
                $publication = securisation (($_POST['publication'])   );
                $publication = nl2br($publication);
                $target_dir = "uploads_img/";
                $randomNameFile = randomName();
                $insert_db =  $conn->prepare("INSERT INTO publication (contenu, date_de_publication, admin_id, nom, postFileName) VALUES ( ?, ?, ?, ?, ?)");
                $insert_db->execute(array($publication, $current_timestamp, $id, $user_info['nom'], "NULL" ));

                echo "option 2";
            }
        }
    
    
    
    
    else  {
        echo " une erreur est survenue, veuillez rafraichir la page"; die();
    }
}

        // ==================== paginaton system

        $count = 2; //per page
        $page = "";
        if(isset ($_GET['page'] )&&  !empty($_GET['page'] )) {
            $page = $_GET['page'];
            settype($page, "integer");            

        } else 
            $page = 0;

        $start = $page++;

        $publication_affichage =  $conn->prepare("SELECT * FROM publication INNER JOIN  follow_tb  ON  publication.admin_id = follow_tb.following_id ORDER BY publication.id DESC LIMIT " . $start . "," . $count);
        $publication_affichage->execute(array());

        $publication_affichage1 =  $conn->prepare("SELECT * FROM publication INNER JOIN  follow_tb  ON  publication.admin_id = follow_tb.following_id ORDER BY publication.id  " );
        $publication_affichage1->execute(array());
        $nb_totale = $publication_affichage1->rowCount();

        //count the number of follower, following, number of article etc ...


    function follow_info($tab, $n) { // table and column
      GLOBAL $conn, $id;
      $follow = $conn->prepare("SELECT * FROM " .  $tab ." WHERE " . $n . " = ?");
      $follow->execute(array($id)); 
      return  $follow->rowCount();

    }
    



       







?>

<html>
<head>
<script src="https://code.getmdl.io/1.1.3/material.min.js"
                    asp-fallback-src="lib/material-design-lite/material.min.js"
                    asp-fallback-test="window.componentHandler"> </script>

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
</head>
<body class="w3-theme-l5">
<?php include_once("assets/navbar.html")?>

<h3 class="text-center"><p>Bonjour <?php echo $user_info[1] ?></p></h3>



<!-- Button trigger modal  publish-->

<div class="woof" id="woof">
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal2" style="background-color:#6f42c1; position:fixed; bottom:20;right : 10; z-index:1">
    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 0 24 24" width="24px" fill="#FFFFFF"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M13 11h-2v3H8v2h3v3h2v-3h3v-2h-3zm1-9H6c-1.1 0-2 .9-2 2v16c0 1.1.89 2 1.99 2H18c1.1 0 2-.9 2-2V8l-6-6zm4 18H6V4h7v5h5v11z"/>  Poster un woof

    </svg>

</button>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Poster un woof.</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <!-- Middle Column -->
       <div class="container" style="width:600px; overflow:auto;">

        
        <form action="#" method="POST"enctype="multipart/form-data" >

                    <!-- text area -->
            <label class="mdc-text-field mdc-text-field--filled mdc-text-field--textarea mdc-text-field--no-label">
            <span class="mdc-text-field__ripple"></span>
            <span class="mdc-text-field__resizer"  style="border:2px solid #6200ee">
                <textarea class="mdc-text-field__input" rows="20" cols="40" aria-label="Label" name="publication" id="publication"></textarea>

            <img src="#"  alt="" class="viewer img-thumbnail img-fluid " id="viewer">
            </span>

            <span class="mdc-line-ripple"></span>
            </label> <br>
            <div class="mdc-card__actions">
                    <!-- upload file icon -->
            <label class="material-icons mdc-icon-button mdc-card__action mdc-card__action--icon" title="Ajouter une image">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-image" viewBox="0 0 16 16">
                <path d="M6.002 5.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0z"/>
                <path d="M2.002 1a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V3a2 2 0 0 0-2-2h-12zm12 1a1 1 0 0 1 1 1v6.5l-3.777-1.947a.5.5 0 0 0-.577.093l-3.71 3.71-2.66-1.772a.5.5 0 0 0-.63.062L1.002 12V3a1 1 0 0 1 1-1h12z"/>
                </svg>
                <input type="file" name="fileToUpload" id="fileToUpload"style="display:none">
            </label>


            

            <button class="material-icons mdc-icon-button mdc-card__action mdc-card__action--icon" title="image">share</button>
            <button class="material-icons mdc-icon-button mdc-card__action mdc-card__action--icon" title="More options">more_vert</button>
            </div>
                    <!-- submit button -->


            <button class="mdc-button mdc-button--raised mdc-button__label" id="btn" name="submit_btn">
                Envoyer
            </button>
            

        </form>
        <h6 class="w3-opacity">Poster ce que vous voulez</h6>
        </div>
        </div>
        </div>
        </div>
      </div>
    </div>
  </div>
</div>
       

             
            <div id="main-post">   

                    <?php
                    // afficher les publications !
                    
                    while($row =  $publication_affichage->fetch(PDO::FETCH_ASSOC)){
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
                                 <a  href="comment.php?id=<?=$row['id'];?>">Aimer</a> 
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

                


                    <?php 
                    }
                    $page_t = ceil($nb_totale/$count) ;//totale page
                    $start+= 1;
                    if($start < $page_t -1) {

                   
                    
                ?>                    

                                                      
                        
                <?php 
                    }                    
                ?>

                        <div class="container" align="center">
                            <button class="mdc-button mdc-button--raised mdc-button__label"> 
                                <a  href="fil_d_actu.php?id=<?=$id ?>&page=<?=$start ?>"> Suivant</a>                             
                            </button>
                                                    
                        </div>



         

            <!-- End Middle Column -->
        </div>

<footer class="w3-container w3-theme-d5"></footer>

<script>
    // Accordion
    function myFunction(id) {
        var x = document.getElementById(id);
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
            x.previousElementSibling.className += " w3-theme-d1";
        } else {
            x.className = x.className.replace("w3-show", "");
            x.previousElementSibling.className =
                x.previousElementSibling.className.replace(" w3-theme-d1", "");
        }
    }

    // Used to toggle the menu on smaller screens when clicking on the menu button
    function openNav() {
        var x = document.getElementById("navDemo");
        if (x.className.indexOf("w3-show") == -1) {
            x.className += " w3-show";
        } else {
            x.className = x.className.replace(" w3-show", "");
        }
    }


// stop form resubmission on page refresh?
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>

<script src="js/like.js"></script>
<script src="js/viewer.js"></script>
<script src="../js/search.js"></script>
<script src="js/modal.js"></script>


</body>
</html>
