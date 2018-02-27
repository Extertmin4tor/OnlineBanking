$(function(){
    $( "#accordion" ).accordion({
        heightStyle: "fill"
    });
    $('#create-account').button();
    $('#create-account').click(function(event){
        event.preventDefault();
        $.post('create_account.php', {},
            function (returnedData) {
                if(returnedData['code'] == "ok"){
                    $('#accordion').html.append("<h3>"+returnedData['id']+"</h3>" +
                        "<div>" +
                        "Value: 0"+
                        "</div>"

                    )
                }
        })

    })
});

