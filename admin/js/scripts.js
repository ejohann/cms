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
    
    //
    
}); 

