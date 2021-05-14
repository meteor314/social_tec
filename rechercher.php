
<?php
    session_start();
    require_once('db.php');

    if(isset($_GET['q'])){
        $query = (String) htmlspecialchars(trim(($_GET['q']))); 

        $sql = $conn->prepare("SELECT * FROM member  WHERE nom LIKE ? ORDER BY id DESC LIMIT 0, 7 ");
        $sql->execute(array("$query%"));

        $req = $sql->fetchALL();

        

        foreach($req as $r){
            ?>
            <div style="font-size: 29px;">

                <a href="profile.php?id=<?=$r['id']?>" >  <?= $r['nom'];?> <br /> 
                <img src="https://external-content.duckduckgo.com/iu/?u=https%3A%2F%2Ftse2.mm.bing.net%2Fth%3Fid%3DOIP.3eCy9BuGvuYt9QAb4uLmTgHaHa%26pid%3DApi&f=1" style="width: 100px; height: 100px;">  </a> 
            </div>
        <?php    
       }
    } 
?>