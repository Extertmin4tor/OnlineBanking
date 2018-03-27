function signin() {
    $( ".widget input[type=submit]" ).button(); 
    var errorWindow = $("#access-denied-reg-text").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        modal: true,
        open: function () {
                $('.ui-widget-overlay').addClass('custom-overlay');
        }
    });
    var name = $( "#sign-in [name = login]" ),
        password = $( "#sign-in [name = password]"  );

    $( ".widget input[type=submit]" ).click( function( event ) {
        event.preventDefault();
        $.post('signin.php', { login:name.val(),  password:password.val()},
            function(returnedData){
                if(returnedData == "ok"){
                    window.location.replace("personal.php");
                }else{
                    name.val('');
                    password.val('');
                    errorWindow.dialog('open');
                }
            });
    } );
};

