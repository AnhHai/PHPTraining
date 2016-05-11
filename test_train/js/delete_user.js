$(document).ready(function(){
    $('.delete').click(function(){
        var container = $(this).parent();
        var cid = $(this).attr('id');
        var string = 'user_id='+cid;

        $.ajax({
            type: "POST",
            url: "delete_user.php",
            data: string,
            success: function(){
                container.slideUp('fast', function(){$(this).parent().remove();});
            }
        });
    });
});
