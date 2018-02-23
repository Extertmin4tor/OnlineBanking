<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
        <link rel="stylesheet" href="/resources/demos/style.css">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    </head>
    <body>

    <title>Markov bank</title>
    <button id="sign-in" >Войти</button>
    <div id="dialog" title="Basic dialog">

    </div>
    <script>
        $("#sign-in").click(function() {

            $("#dialog").html("<p>This is the default dialog which is useful for displaying information. \T" +
                "he dialog window can be moved, resized and closed with the 'x' icon.</p>").dialog();
        });
    </script>
    </body>
</html>

