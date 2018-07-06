/* sidenav fix */
$(function(){
    $('#layout-sidenav ul li a').click(function(){
        window.location.href = $(this).attr('href');
    });
});