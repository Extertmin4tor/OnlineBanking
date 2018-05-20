function signin() {
    var captcha_dialog = $( "#captcha-sign-up").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        modal: true,
                buttons: {
                    "Enter": function(){
                            SendCaptcha();
                    }
                },
                open: function() {
                    $('.ui-widget-overlay').addClass('custom-overlay');
                },
                close: function() {
                    form[ 0 ].reset();
                }
            });
    
    var form = captcha_dialog.find( "form" ).on( "submit", function( event ) {
                event.preventDefault();
                SendCaptcha();
            });
    
    
    function SendCaptcha(){
        var captcha_value = $( "#captcha-sign-up [name = captcha]" ).val();
        $.post('signin.php', { command: "captcha", captcha: captcha_value},
                function(returnedData){
                    if(returnedData == "ok"){
                        location.reload();
                    }else{
                        if(returnedData == "restrict"){
                            location.reload();
                        }
                    }
                });
    }
    $( ".widget input[type=submit]" ).button({
        
    });
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
        password = $( "#sign-in [name = password]"),
        csrf_token = $("#sign-in").find("input:first");

    $( ".widget input[type=submit]" ).click( function( event ) {
        $.ajaxSetup({async:false});
        var publicKey;
        event.preventDefault();
        $.post('signin.php', {command:"getpublic"}, function(returnedData){
            publicKey = returnedData
        });
        var crypt = new JSEncrypt();
        crypt.setPublicKey(publicKey);
        $.post('signin.php', { command:"decrypt", csrf_token: csrf_token.val(), csrf_id: csrf_token.attr('name'), login:crypt.encrypt(name.val()),  password:crypt.encrypt(password.val())},
            function(returnedData){
                if(returnedData == "ok"){
                    window.location.replace("personal.php");
                }else{
                    name.val('');
                    password.val('');
                    if(returnedData == "restrict"){
                        captcha_dialog.dialog('open');
                    }else{
                        errorWindow.dialog('open');
                    }
                }
            });
    } );
};

