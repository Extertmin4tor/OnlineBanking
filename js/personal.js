$(document).ready(function(){
    var form, form1, form2, form3;
    
    var from = $("#transfer-dialog [name = from]");
    var to = $("#transfer-dialog [name = to]");
    var value = $("#transfer-dialog [name = value]");
    var allFields = $( [] ).add(from).add(to).add(value);

    var from1 = $("#mobile-payment-dialog [name = from]");
    var to1 = $("#mobile-payment-dialog [name = number]");
    var value1 = $("#mobile-payment-dialog [name = value]");
    var allFields1 = $( [] ).add(from1).add(to1).add(value1);

    var from2 = $("#utility-payment-dialog [name = from]");
    var to2 = $("#utility-payment-dialog [name = personal-account]");
    var value2 = $("#utility-payment-dialog [name = value]");
    var allFields2 = $( [] ).add(from2).add(to2).add(value2);

    var from3 = $("#filter-history [name = from]");
    var to3 = $("#filter-history [name = personal-account]");
    var value3 = $("#filter-history [name = value]");
    var date_bot = $("#filter-history [name = date_bot]");
    var date_top = $("#filter-history [name = date_top]");
    var operation = $("#filter-history [name = operation]");
    var allFields3 = $( [] ).add(from2).add(to2).add(value2).add(date_bot).add(date_top).add(operation);

    var card_type_1 = $('#add-acc [name = payment-system-choose]');
    var card_type_2 = $('#add-acc [name = card-type-2]')
    var allFields4 = $( [] ).add(card_type_1).add(card_type_2);

    var maxHeight = 400;


    if ($('.test').length > 0) {
        $("#accordion").accordion({
            heightStyle: "content",
            autoHeight: false,
            clearStyle: true,   
        });
    }
    var dialog = $( "#transfer-dialog").dialog({
        autoOpen: false,
        height: 400,
        width: 300,
        modal: true,
        resizable: false,
        draggable: false,
        buttons: {
            "Transfer": makeTransfer,
            Cancel: function() {
                dialog.dialog( "close" );
            }
        },
        open: function() {
            $('.ui-widget-overlay').addClass('custom-overlay');
            $('.ui-widget-overlay').bind('click',function(){
                dialog.dialog('close');
            });
        },
        close: function() {
            form[ 0 ].reset();
            allFields.removeClass( "ui-state-error" );
        }
    });

    var create_account_dialog = $( "#add-acc-form").dialog({
        autoOpen: false,
        height: 350,
        width: 300,
        modal: true,
        resizable: false,
        draggable: false,
        buttons: {
            "Create": AddAccount,
            Cancel: function() {
                create_account_dialog.dialog( "close" );
            }
        },
        open: function() {
            $('#payment-system-choose').selectmenu({
                width: '100%'
            });
            $('#card-type-2').selectmenu({
                width: '100%'
            });
            $('.ui-widget-overlay').addClass('custom-overlay');
            $('.ui-widget-overlay').bind('click',function(){
                create_account_dialog .dialog('close');
            });
        },
        close: function() {
            form3[ 0 ].reset();
            allFields4.removeClass( "ui-state-error" );
        }
    });


    var mobile_dialog = $("#mobile-payment-dialog").dialog({
        autoOpen: false,
        height: 400,
        width: 300,
        modal: true,
        resizable: false,
        draggable: false,
        buttons: {
            "Pay": makeMobilePayment,
            Cancel: function() {
                mobile_dialog.dialog( "close" );
            }
        },
        open: function() {
            $('.ui-widget-overlay').addClass('custom-overlay');
            $('.ui-widget-overlay').bind('click',function(){
                mobile_dialog .dialog('close');
            });
        },
        close: function() {
            form1[ 0 ].reset();
            allFields1.removeClass( "ui-state-error" );
            $('.mobile-li').show();
            $('.utility-li').show();
        }
    });

    var utility_dialog = $( "#utility-payment-dialog").dialog({
        autoOpen: false,
        height: 400,
        width: 300,
        modal: true,
        resizable: false,
        draggable: false,
        buttons: {
            "Pay": makeUtilityPayment,
            Cancel: function() {
                utility_dialog.dialog( "close" );
            }
        },
        open: function() {
            $('.ui-widget-overlay').addClass('custom-overlay');
            $('.ui-widget-overlay').bind('click',function(){
                utility_dialog .dialog('close');
            });
        },
        close: function() {
            form2[ 0 ].reset();
            allFields2.removeClass( "ui-state-error" );
            $('.mobile-li').show();
            $('.utility-li').show();
        }
    });



    
    form = dialog.find( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        makeTransfer();
    });

    form1 = mobile_dialog.find( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        makeMobilePayment();
    });

    form2 = utility_dialog.find( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        makeUtilityPayment();
    });

    form3 = create_account_dialog.find( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        AddAccount();

    });


    $(function() {
        $('.transfer-li').click(function(e)
        {
            dialog.dialog( "open" );
        });
      });

      $(function() {
        $('.history-li').click(function(e)
        {
            window.location.replace("/history.php");
        });
      });

      $(function() {
        $('.mobile-li').click(function(e)
        {
            $(this).hide();
            $('.utility-li').hide();
            mobile_dialog.dialog( "open" );
        });
      });

      $(function() {
        $('.utility-li').click(function(e)
        {
            $(this).hide();
            $('.mobile-li').hide();
            utility_dialog.dialog( "open" );
        });
      });


      $(function() {
        $('.create-li').click(function(event)
        {
            create_account_dialog.dialog("open");

        });
      });

    $(function(){

        $(".dropdown > li").hover(function() {
    
         var $container = $(this),
             $list = $container.find("ul"),
             $anchor = $container.find("a"),
             height = $list.height() * 1.1,       // make sure there is enough room at the bottom
             multiplier = height / maxHeight;     // needs to move faster if list is taller
        
        // need to save height here so it can revert on mouseout            
        $container.data("origHeight", $container.height());
        
        // so it can retain it's rollover color all the while the dropdown is open
        $anchor.addClass("hover");
        
        // make sure dropdown appears directly below parent list item    
        $list
            .show()
            .css({
                paddingTop: $container.data("origHeight")
            });
        
        // don't do any animation if list shorter than max
        if (multiplier > 1) {
            $container
                .css({
                    height: maxHeight,
                })
                .mousemove(function(e) {
                    var offset = $container.offset();
                    var relativeY = ((e.pageY - offset.top) * multiplier) - ($container.data("origHeight") * multiplier);
                    if (relativeY > $container.data("origHeight")) {
                        $list.css("top", -relativeY + $container.data("origHeight"));
                    };
                });
        }
        
    }, function() {
    
        var $el = $(this);
        
        // put things back to normal
        $el
            .height($(this).data("origHeight"))
            .find("ul")
            .css({ top: 0 })
            .hide()
            .end()
            .find("a")
            .removeClass("hover");
    
    });  
    
});



    $('#logout').button();

    function showHistory(){
        $("#filter-histor-form").submit();
    }
    function makeTransfer(){
        allFields.removeClass( "ui-state-error" );
        var valid_from = ispNumber(from.val(), from);
        var valid_to = ispNumber(to.val(), to);
        var valid_value = ispNumber(value.val(), value);
        var csrf_token = $("#transfer-dialog").find("input:first");
        if(valid_from && valid_to && valid_value){
            $.post("acc_operations.php", {csrf_token: csrf_token.val(), csrf_id: csrf_token.attr('name'), from:from.val(), to:to.val(), value:value.val()},
        function(returnedData){
            if(returnedData.code == "ok"){
                location.reload();
            //    
            }
            else{
                from.val('');
                to.val('');
                value.val('');
                wrong_dialog.dialog("open");
            }
        }, "json")
        }
        else{
            wrong_dialog.dialog('open');
        }
        
    }


    function makeMobilePayment(){
        allFields1.removeClass( "ui-state-error" );
        var valid_from = ispNumber(from1.val(), from1);
        var valid_to = isPhoneNumber(to1.val(), to1);
        var valid_value = ispNumber(value1.val(), value1);
        var csrf_token = $("#mobile-payment-dialog").find("input:first");
        if(valid_from && valid_to && valid_value){
            $.post("payments.php", {code: "mobile", csrf_token: csrf_token.val(), csrf_id: csrf_token.attr('name'),  from:from1.val(), to:to1.val(), value:value1.val()},
            function(returnedData){
                if(returnedData.code == "ok"){
                    location.reload();                 
                }
                else{
                    from1.val('');
                    to1.val('');
                    value1.val('');
                    wrong_dialog.dialog("open");
                }
            }, "json");
        }

    }

    function makeUtilityPayment(){
        allFields1.removeClass( "ui-state-error" );
        var valid_from = ispNumber(from2.val(), from2);
        var valid_to = ispNumber(to2.val(), to2);
        var valid_value = ispNumber(value2.val(), value2);
        var csrf_token = $("#utility-payment-dialog").find("input:first");
        if(valid_from && valid_to && valid_value){
            $.post("payments.php", {code: "utility", csrf_token: csrf_token.val(), csrf_id: csrf_token.attr('name'), from:from2.val(), to:to2.val(), value:value2.val()},
            function(returnedData){
                if(returnedData.code == "ok"){
                    location.reload();
                }
                else{
                    from1.val('');
                    to1.val('');
                    value1.val('');
                    wrong_dialog.dialog("open");
                }
            }, "json");
        }

    }

    function AddAccount(){
        allFields4.removeClass( "ui-state-error" );
        var csrf_token = $("#utility-payment-dialog").find("input:first");
        $.post("create_account.php", {csrf_token: csrf_token.val(), csrf_id: csrf_token.attr('name'), card_type_1:card_type_1.val(), card_type_2:card_type_2.val()},
            function(returnedData){
                if(returnedData.code == "ok"){
                    location.reload();
                }
                else{
                    from1.val('');
                    to1.val('');
                    value1.val('');
                    wrong_dialog.dialog("open");
                }
            }, "json");
    }
    wrong_dialog = $("#wrong-dialog").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        modal: true,
        open: function() {
            $('.ui-widget-overlay').addClass('custom-overlay');
            $('.ui-widget-overlay').bind('click',function(){
                wrong_dialog.dialog('close');
            });
        }
    });

    succ_dialog = $("#success-text").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        modal: true,
        buttons: {
            "Accept": function(){
                succ_dialog.dialog("close");
            }
        },
        open: function() {
            $('.ui-widget-overlay').addClass('custom-overlay');
            $("#accordion-resizer").height(100);
        }
    });

    function ispNumber(n, elem) {
        test = !isNaN(parseFloat(n)) && isFinite(n) && n > 0;
        if (!test){
           elem.addClass("ui-state-error");
        }
        return test;
     }
     
     function isPhoneNumber(number, elem){
            var a = number;
            var filter = /^((\+[1-9]{1,4}[ \-]*)|(\([0-9]{2,3}\)[ \-]*)|([0-9]{2,4})[ \-]*)*?[0-9]{3,4}?[ \-]*[0-9]{3,4}?$/;
            if (filter.test(a)) {
                return true;
            }
            else {
                
                    elem.addClass("ui-state-error");
                 
                return false;         
     }
    }
     $('html').show();
});