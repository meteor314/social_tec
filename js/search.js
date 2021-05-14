var search = document.getElementById('search');
     search.addEventListener('keyup', function(e) {     	
            $('#result').html('');

            var q = $(this).val();

            if(q != ""){
                $.ajax({
                    type: 'GET',
                    url: 'rechercher.php',
                    data: 'q=' + encodeURIComponent(q),
                    beforeSend: function() {
                        $("#loading").show();
                    },
                    success: function(data){
                        if(data !== ""){
                            $('#result').append(data);
                            console.log(data);
                        }else{ 
                            $('#result').html('aucun résultat');
                        }// endIF

                        $("#loading").hide();

                    }
                });
            } //endIF

            
    });