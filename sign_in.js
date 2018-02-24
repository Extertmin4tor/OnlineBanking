$( function() {
    var name = $( "#sign-in [name = login]" ),
        password = $( "#sign-in [name = password]"  );
    $( ".widget input[type=submit]" ).button();
    $( ".widget input[type=submit]" ).click( function( event ) {
        event.preventDefault();
        $.post('signin.php', { login:name.val(),  password:password.val()},
            function(returnedData){
                if(returnedData == "ok"){
                        $("#sign-in").hide();
                        $("#sign-up").hide();
                        $("#create-user").hide();
                }
            });
    } );
} );

