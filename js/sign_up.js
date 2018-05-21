
$(document).ready( function() {
    signin();
    $('#create-user').button();
        var dialog, form,
            emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
            name = $( "#sign-up  [name = login]" ),
            email = $( "#sign-up [name = email]"  ),
            password = $( "#sign-up  [name = password]"  ),
            repassword = $( "#sign-up  [name = repassword]" ),
            captcha = $("#sign-up [name = captcha]"),
            allFields = $( [] ).add( name ).add( email ).add( password ).add(repassword),
            tips = $( ".validateTips" );
        var publicKey;

        function updateTips( t ) {
            tips
                .text( t )
                .addClass( "ui-state-highlight" );
            setTimeout(function() {
                tips.removeClass( "ui-state-highlight", 1500 );
            }, 500 );
        }

        function checkLength( o, n, min, max ) {
            if ( o.val().length > max || o.val().length < min ) {
                o.addClass( "ui-state-error" );
                updateTips( "Length of " + n + " must be between " +
                    min + " and " + max + "." );
                return false;
            } else {
                return true;
            }
        }

        function checkRegexp( o, regexp, n ) {
            if ( !( regexp.test( o.val() ) ) ) {
                o.addClass( "ui-state-error" );
                updateTips( n );
                return false;
            } else {
                return true;
            }
        }

        function checkCompare(pass, repass, n){
            if(pass.val() != repass.val()) {
                repass.addClass("ui-state-error");
                updateTips(n);
                return false;
            }else{
                return true;
            }
        }


        function addUser() {

           //console.dir(name);
            var valid = true;
            allFields.removeClass( "ui-state-error" );
            valid = valid && checkLength( name, "login", 3, 16 );
            valid = valid && checkLength( email, "email", 6, 80 );
            valid = valid && checkLength( password, "password", 5, 16 );
            valid = valid && checkLength( repassword, "password", 5, 16 );
            valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores and must begin with a letter." );
            valid = valid && checkRegexp( email, emailRegex, "eg. ui@jquery.com" );
            valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
            valid = valid && checkCompare(password, repassword, "Passwords must match");
            $.ajaxSetup({async:false});
            if(valid){
                $.post('signup.php', {command:"getpublic"}, function(returnedData){
                    publicKey = returnedData
                });
                var crypt = new JSEncrypt();
                crypt.setPublicKey(publicKey);
                $.post('signup.php', { command:"decrypt", login:crypt.encrypt(name.val()) , email :crypt.encrypt(email.val()), password:crypt.encrypt(password.val()), captcha:captcha.val()},
                    function(returnedData){
                        if(returnedData == "ok"){
                                dialog.dialog('close');
                                succ_dialog.dialog("open");
                        }else{
                            name.val('');
                            email.val('');
                            password.val('');
                            repassword.val('');
                            captcha.val('');
                            alreadyuseWindow.dialog('open');
                        }
                    });
            }
            return valid;
        }

        alreadyuseWindow = $("#already-use-reg-text").dialog({
            resizable: false,
            draggable: false,
            autoOpen: false,
            modal: true
        });

        succ_dialog = $("#success-reg-text").dialog({
            resizable: false,
            draggable: false,
            autoOpen: false,
            modal: true,
            buttons: {
                "Accept": function(){
                    succ_dialog.dialog("close");
                    window.location = "/personal.php";
                }
            },
            open: function() {
                $('.ui-widget-overlay').addClass('custom-overlay');
            }
        });

        dialog = $( "#sign-up").dialog({
            autoOpen: false,
            height: 680,
            width: 360,
            modal: true,
            resizable: false,
            draggable: false,

            buttons: {
                "Create an account": addUser,
            },
            open: function() {
                $('.ui-widget-overlay').addClass('custom-overlay');
                $('.ui-widget-overlay').click(function(){
                    dialog.dialog('close');
                });
            },
            close: function() {
                form[ 0 ].reset();
                allFields.removeClass( "ui-state-error" );
            }
        });

        form = dialog.find( "form" ).on( "submit", function( event ) {
            event.preventDefault();
            addUser();
        });

        $( "#create-user" ).on( "click", function(event) {
            event.preventDefault();
            dialog.dialog( "open" );
        });
        $('html').show();
  
    } );
