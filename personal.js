$(function(){
    $('#create-account').button();
    $('#create-account').click(function(event){
        event.preventDefault();
        $.post('create_account.php', {},
            function (returnedData) {
                if(returnedData['code'] == "ok"){

                }
        })

    })
});

function get_accounts_list(){
    $.post('create_account.php', {},
        function (returnedData) {
            if(returnedData['code'] == "ok"){

            }
        })
}