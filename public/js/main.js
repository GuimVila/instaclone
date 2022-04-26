var url = 'http://127.0.0.1:8000/'; 
window.addEventListener("load", function(){

    $(".btn-like").css('cursor', 'pointer'); 
    $(".btn-dislike").css('cursor', 'pointer'); 

    function like() { 
        //Like button
        $(".like-img").off("click").on( "click", function() {
            console.log('liked!'); 
            $(this).addClass("btn-dislike").removeClass("btn-like"); 
            $(this).attr("src", "img/hearts-red.png"); 

            $.ajax({
                url: url+'/like/'+$(this).data("id"), 
                type: "GET", 
                success: function(response) {
                    console.log(response); 
                }
            });
            
            dislike();
        }); 
    }
    like(); 

    //Dislike button
    function  dislike() {
        $(".btn-dislike").off("click").on( "click", function() {
            console.log('disliked!'); 
            $(this).addClass("btn-like").removeClass("btn-dislike"); 
            $(this).attr("src", "img/hearts-grey.png");
            like();  
        }); 
    }
    dislike(); 


}); 

