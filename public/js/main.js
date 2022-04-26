var url = 'http://127.0.0.1:8000';
$(function(){

    $(".btn-like").css('cursor', 'pointer'); 
    $(".btn-dislike").css('cursor', 'pointer'); 
	// Al fer click al like img
	$('.like-img').on('click',function(){

        var cor = $(this)

		// Si te class like, fem dislike
		if( $(this).hasClass('btn-like') ){
			$(this).removeClass('btn-like');
			$(this).addClass('btn-dislike');

			// Ajax de dislike aqui
            $.ajax({
                url: url+'/dislike/'+$(this).data("id"), 
                type: "GET", 
                success: function(response) {
                    if(response.like) {
						cor.attr("src", url+"/img/hearts-grey.png");
						console.log('You disliked this post'); 
                    } else {
                        console.log('Error');
                    }
                }
            });
		
		} else {
			// Si no te class like, fem like
			$(this).removeClass('btn-dislike');
			$(this).addClass('btn-like');

			// Ajax de like aqui
            $.ajax({
                url: url+'/like/'+$(this).data("id"), 
                type: "GET", 
                success: function(response) {
                    if(response.like) {
                    cor.attr("src", url+"/img/hearts-red.png");
                    console.log('You liked this post'); 
                    }else{
                        console.log('Error');
                    }
                }
            });   		
		}
	})
})

// var url = 'http://127.0.0.1:8000'; 
// window.addEventListener("load", function(){

//     $(".btn-like").css('cursor', 'pointer'); 
//     $(".btn-dislike").css('cursor', 'pointer'); 

//     function like() { 
//         //Like button
//         $(".like-img").off("click").on( "click", function() {
//             console.log('liked!'); 
//             $(this).addClass("btn-dislike").removeClass("btn-like"); 
//             $(this).attr("src", url+"/img/hearts-red.png"); 

//             $.ajax({
//                 url: url+'/like/'+$(this).data("id"), 
//                 type: "GET", 
//                 success: function(response) {
//                     if(response.like) {
//                     console.log('You liked this post'); 
//                     }else{
//                         console.log('Error');
//                     }
//                 }
//             });
            
//             dislike();
//         }); 
//     }
//     like(); 

//     //Dislike button
//     function  dislike() {
//         $(".btn-dislike").off("click").on( "click", function() {
//             console.log('disliked!'); 
//             $(this).addClass("btn-like").removeClass("btn-dislike"); 
//             $(this).attr("src", url+"/img/hearts-grey.png");

//             $.ajax({
//                 url: url+'/dislike/'+$(this).data("id"), 
//                 type: "GET", 
//                 success: function(response) {
//                     if(response.like) {
//                     console.log('You disliked this post'); 
//                     }else{
//                         console.log('Error');
//                     }
//                 }
//             });

//             like();  
//         }); 
//     }
//     dislike(); 
// }); 

