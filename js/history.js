function loadChunk(page_number, from="", to="", value="", date_bot="", date_top="", type=""){
    $.post("history-data.php", {page:page_number, from:from, to:to, value:value, date_bot:date_bot, date_top:date_top, type:type},
    function(returnedData){
        var main = $('#main');
        if(returnedData.code == "ok"){
            var data = returnedData.data;
            var pages_count = returnedData.pages_count;
            
            main.empty();
            main.append("<div id='hisotry-table-div'></div>");
            main = main.find('div');
            main.append("<table class='history'></table>");
            main = main.find('table');
            main.append("<thead> \
                            <th>From</th> \
                            <th>Value</th> \
                            <th>To</th> \
                            <th>Date</th> \
                            <th>Type</th> \
                        </thead>");
            data.forEach(element => {
                main.append("<tr> \
                <td>" + element.account_id + "</td> \
                <td>" + "$"+element.value + "</td> \
                <td>" + element.reciever+ "</td> \
                <td>" + element.date + "</td> \
                <td>" + element.type + "</td> \
                </tr>");
            })
            main.append("</table> \
                         </div>");
            main = $('#main');

            var last_page = Math.ceil(pages_count / 15);
            //alert(current_page+" "+last_page);
            if(current_page == 1 && last_page!= 1){
                main.append("<div style='display:none' id='prev'>&#8249;</div>");
                main.append("<div id='next'>&#8250;</div>");
               
            }
            else{
                if(current_page == last_page && last_page!= 1){
                    main.append("<div  id='prev'>&#8249;</div>");
                    main.append("<div style='display:none' id='next'>&#8250;</div>");
                    
                }
                else{
                    if( last_page != 1){
                        main.append("<div  id='prev'>&#8249;</div>");
                        main.append("<div id='next'>&#8250;</div>");
                    }
                    else{
                        main.append("<div style='display:none' id='prev'>&#8249;</div>");
                        main.append("<div style='display:none' id='next'>&#8250;</div>");
                    }
                    
                }
            }
            $('#next').click(function(event){
                event.preventDefault();
                current_page++;
                loadChunk(current_page, from, to, value, date_bot, date_top, type);
            });
            $('#prev').click(function(event){
                event.preventDefault();
                current_page--;
                loadChunk(current_page, from, to, value, date_bot, date_top, type);
            });
            

        }
        else{
            main.empty();
            $('#main').append("<div class=\"nothing-to-show\">Nothing to show!</div>");
     
            
        }
    }, "json");
};
var current_page = 1;


$(function() {
    var maxHeight = 400;
    var from="", to="", value="", date_bot="", date_top="", type="";
    loadChunk(current_page);
    
    $('#submit-filter').click(function(event){
        event.preventDefault();
        from = $('#filter-history-form [name=from]').val();
        to = $('#filter-history-form [name=personal-account]').val();
        value = $('#filter-history-form [name=value]').val();
        date_bot = $('#filter-history-form [name=date-bot]').val();
        date_top = $('#filter-history-form [name=date-top]').val();
        type = $('#filter-history-form [name=operation]').val();
        loadChunk(current_page,from, to, value, date_bot, date_top, type);
    });

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

$(function() {
   
    $('.filter-li').click(function(e)
    {
        if ($('#filter-history').css('display') == 'none'){
            $('#filter-history').css('display', 'block');
        }
        else{
            $('#filter-history').css('display', 'none');
        }
    });
  });


  $(function() {
    $('.back-li').click(function(e)
    {
        window.location.replace("/personal.php");
    });
  });

$('#logout').button();
$('#submit-filter').button();

$('html').show();


});



