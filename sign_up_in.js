    $( function() {
        var dialog, form,
            emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
            name = $( "#sign-up  [name = login]" ),
            email = $( "#sign-up [name = email]"  ),
            password = $( "#sign-up  [name = password]"  ),
            repassword = $( "#sign-up  [name = repassword]" ),
            allFields = $( [] ).add( name ).add( email ).add( password ).add(repassword),
            tips = $( ".validateTips" );


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

            console.dir(name);
            var valid = true;
            allFields.removeClass( "ui-state-error" );
            valid = valid && checkLength( name, "login", 3, 16 );
            valid = valid && checkLength( email, "email", 6, 80 );
            valid = valid && checkLength( password, "password", 5, 16 );
            valid = valid && checkLength( repassword, "password", 5, 16 );
            valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter." );
            valid = valid && checkRegexp( email, emailRegex, "eg. ui@jquery.com" );
            valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );
            valid = valid && checkCompare(password, repassword, "Passwords must match");

            if(valid){
                $.post('signup.php', { login:name.val() , email :email.val(), password:password.val()},
                    function(returnedData){
                        if(returnedData == "ok"){
                            $( function() {
                                dialog.dialog("close");
                                succ_dialog.dialog("open");
                            } );
                        }
                    });
            }
            return valid;
        }

        succ_dialog = $("#success-reg-text").dialog({
            resizable: false,
            draggable: false,
            autoOpen: false,
            buttons: {
                "Accept": function(){
                    succ_dialog.dialog("close");
                }
            }
        });

        dialog = $( "#sign-up").dialog({
            autoOpen: false,
            height: 400,
            width: 350,
            modal: true,
            resizable: false,
            draggable: false,
            buttons: {
                "Create an account": addUser,
                Cancel: function() {
                    dialog.dialog( "close" );
                }
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

        $( "#create-user" ).button().on( "click", function() {
            dialog.dialog( "open" );
        });
    } );
