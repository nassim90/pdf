$(function () {
    var theText = $('#form_title');
    var theOutputText = $('#out_title');
      
    theText.keydown(function () {
        keyReport( );
    });

    theText.keypress(function () {
        keyReport( );
    });


    theText.keyup(function () {
        keyReport( );
    });

   
    function keyReport() {

        var newString = theText.val();
       
 
    
        if(theOutputText.width > 500){
            // replace last characters with '...'
            //newString = newString + '...';
        }
        // show field content
        theOutputText.text(newString);
        

   }
   
});
$(function () {
    var theText = $('#form_url');
    var theOutputText = $('#out_url');
      
    theText.keydown(function () {
        keyReport( );
    });

    theText.keypress(function () {
        keyReport( );
    });


    theText.keyup(function () {
        keyReport( );
    });

   
    function keyReport() {
      
        // show field content
         theOutputText.text(theText.val());
        
   } 
});
$(function () {
    var theText = $('#form_description');
    var theOutputText = $('#out_richsnippet');
      
    theText.keydown(function () {
        keyReport( );
    });

    theText.keypress(function () {
        keyReport( );
    });


    theText.keyup(function () {
        keyReport( );
    });

   
      function keyReport() {
        var newString = theText.val();
        if(newString.length > 156){
            // replace last characters with '...'
            newString = newString.substring(0, 156) + '...';
        }
        // show field content
        theOutputText.text(newString);
        
   }
});

;