$(function(){
    if ($('.test').length > 0) {
        $("#accordion").accordion({
            heightStyle: "fill"
        });
    }
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


});