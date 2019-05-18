$(document).ready(function(){
    
    //Classic Editor for Post Text Area
    ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
    
    // Select all posts on view all post 
    $('#selectAllBoxes').click(function(event)
      {
       if(this.checked)
        {
          $('.checkBoxes').each(function()
            {
              this.checked = true; 
            });  
         }
       else
         {
           $('.checkBoxes').each(function()
            {
              this.checked = false; 
            });        
         }
     });
    
    // Admin Loader
    var div_box = "<div id='load_screen'><div id='loading'></div></div>";
    
    $('#load-screen').delay(700).fadeOut(600, function()
     {
       $(this).remove(); 
    });
    
    //
    
}); 


function loadUsersOnline()
 {
     
     $.get("functions.php?online_users=result", function(data)
      {
         $(".users_online").text(data);
     });
 }

setInterval(function()
           {
    loadUsersOnline();
}, 500);

