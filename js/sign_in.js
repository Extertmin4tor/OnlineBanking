
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
        $.ajaxSetup({async:false});
        var publicKey;
        event.preventDefault();
        $.post('signin.php', {command:"getpublic"}, function(returnedData){
            publicKey = returnedData
        });
        var crypt = new JSEncrypt();
        crypt.setPublicKey(publicKey);
        $.post('signin.php', { command:"decrypt", login:crypt.encrypt(name.val()),  password:crypt.encrypt(password.val())},
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

