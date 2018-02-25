$( function() {
    var errorWindow = $("#access-denied-reg-text").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        modal: true,
    });
    var name = $( "#sign-in [name = login]" ),
        password = $( "#sign-in [name = password]"  );
    $( ".widget input[type=submit]" ).button();
    $( ".widget input[type=submit]" ).click( function( event ) {
        event.preventDefault();
        $.post('signin.php', { login:name.val(),  password:password.val()},
            function(returnedData){
                if(returnedData == "ok"){
                        //$(this).unbind('click').click();
                       // $("#sign-in").hide();
                      //  $("#sign-up").hide();
                      //  $("#create-user").hide();
                    window.location.replace("personal.php");
                }else{
                    name.val('');
                    password.val('');
                    errorWindow.dialog('open');
                }
            });
    } );
} );

