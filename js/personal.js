$(document).ready(function(){
    var form, form1, form2;

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
        },
        close: function() {
            form[ 0 ].reset();
            allFields.removeClass( "ui-state-error" );
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
        },
        close: function() {
            form2[ 0 ].reset();
            allFields2.removeClass( "ui-state-error" );
            $('.mobile-li').show();
            $('.utility-li').show();
        }
    });

    var filter_dialog = $( "#filter-history").dialog({
        autoOpen: false,
        height: 600,
        width: 300,
        modal: true,
        resizable: false,
        draggable: false,
        buttons: {
            "Show": showHistory,
            Cancel: function() {
                filter_dialog.dialog( "close" );
            }
        },
        open: function() {
            $('.ui-widget-overlay').addClass('custom-overlay');
        },
        close: function() {
            allFields3.removeClass( "ui-state-error" );
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



    $(function() {
        $('.transfer-li').click(function(e)
        {
            dialog.dialog( "open" );
        });
      });

      $(function() {
        $('.history-li').click(function(e)
        {
            filter_dialog.dialog( "open" );
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
                event.preventDefault();
                    $.post("create_account.php",
                        function (returnedData) {
                            if (returnedData.code == "ok") {
                                if ($('.test').length == 0) {
                                    $('.test2').detach();
                                    $('#accordion').append("<h3 class ='test'>" + returnedData.id + "</h3>" +
                                        "<div class ='test'>" +
                                        "Value: 1000" +
                                        "</div>"
                                    );
                                    $("#accordion").accordion({
                                        heightStyle: "content"
                                    });
                                }
                                else{
                                    $('#accordion').append("<h3 class ='test'>" + returnedData.id + "</h3>" +
                                        "<div class ='test'>" +
                                        "Value: 1000" +
                                        "</div>"
                                    );
                                    
                                    $("#accordion").accordion("refresh");
                                    
        
                                }
                            }
                        },
                        "json"
                    );
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

        if(valid_from && valid_to && valid_value){
            $.post("acc_operations.php", {from:from.val(), to:to.val(), value:value.val()},
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

        if(valid_from && valid_to && valid_value){
            $.post("payments.php", {code: "mobile", from:from1.val(), to:to1.val(), value:value1.val()},
            function(returnedData){
                if(returnedData.code = "ok"){
                    location.reload();
                    // $('#accordion').find("h3:contains('" + from1.val() + "')").next().replaceWith(
                    //     "<div class ='test'>" +
                    //     "Value: " + returnedData.value_from +
                    //     "</div>"
                    //    );
                    // $("#accordion").accordion("refresh");
                    // mobile_dialog.dialog("close");
                    // succ_dialog.dialog("open");
                    
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

        if(valid_from && valid_to && valid_value){
            $.post("payments.php", {code: "utility", from:from2.val(), to:to2.val(), value:value2.val()},
            function(returnedData){
                if(returnedData.code = "ok"){
                    // $('#accordion').find("h3:contains('" + from2.val() + "')").next().replaceWith(
                    //     "<div class ='test'>" +
                    //     "Value: " + returnedData.value_from +
                    //     "</div>"
                    //    );
                    // $("#accordion").accordion("refresh");
                    // utility_dialog.dialog("close");
                    // succ_dialog.dialog("open");
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

    wrong_dialog = $("#wrong-dialog").dialog({
        resizable: false,
        draggable: false,
        autoOpen: false,
        modal: true,
        open: function() {
            $('.ui-widget-overlay').addClass('custom-overlay');
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