$(function(){
    var from = $("#transfer-dialog [name = from]");
    var to = $("#transfer-dialog [name = to]");
    var value = $("#transfer-dialog [name = value]");
    var allFields = $( [] ).add(from).add(to).add(value);

    if ($('.test').length > 0) {
        $("#accordion").accordion({
            heightStyle: "fill"
        });
    }
    var transfer = $('#transfer').button();
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
    form = dialog.find( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        makeTransfer();
    });

    transfer.on( "click", function() {
        dialog.dialog( "open" );
    });

    $('#create-account').button();
    $('#create-account').click(function(event){
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
                                heightStyle: "fill"
                            });
                        }
                        else{
                            $('#accordion').append("<h3 class ='test'>" + returnedData.id + "</h3>" +
                                "<div class ='test'>" +
                                "Value: 1000" +
                                "</div>"
                            );
                            $("#accordion").last().accordion("refresh");

                        }


                    }
                },
                "json"
            );
    });
    $('#logout').button();

    function makeTransfer(){
        allFields.removeClass( "ui-state-error" );
        var valid_from = isNumber(from.val(), from);
        var valid_to = isNumber(to.val(), to);
        var valid_value = isNumber(value.val(), value);

        if(valid_from && valid_to && valid_value){
            $.post("validate.php", {from:from.val(), to:to.val(), value:value.val()},
        function(returnedData){
            if(returnedData.code == "ok"){
               $('#accordion').find("h3:contains('" + from.val() + "')").next().replaceWith(
                "<div class ='test'>" +
                "Value: " + returnedData.value_from +
                "</div>"
               );
               $("#accordion").last().accordion("refresh");
               if(returnedData.value_to !== null){
                $('#accordion').find("h3:contains('" + to.val() + "')").next().replaceWith(
                    "<div class ='test'>" +
                    "Value: " + returnedData.value_to +
                    "</div>"
                   );
                   $("#accordion").last().accordion("refresh");
                }
              
               succ_dialog.dialog("open");
               dialog.dialog("close");
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
        }
    });

    function isNumber(n, elem) {
        test = !isNaN(parseFloat(n)) && isFinite(n);
        if (!test){
           elem.addClass("ui-state-error");
        }
        return test;
     }
  
  

});