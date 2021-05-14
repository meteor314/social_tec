
var likeBtn =$("#like-btn");
console.group(likeBtn)
likeBtn.addEventListener("click", function() {
    alert(post_id);
    e.preventDefault();


    $(document).ready(function() {



        $.ajax({
            url: "like.php",
            type: "GET",
            data: {
            post_id: post_id,
                    
            },
            cache: false,
            success: function(dataResult){
            var dataResult = JSON.parse(dataResult);
            if(dataResult.statusCode==200){
                console.log("ok");			
            }
            else if(dataResult.statusCode==201){
                alert("Erreur, veuillez réassyer ultérieurement !");
            }
            
            }
        });




});