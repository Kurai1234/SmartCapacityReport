
$(function () {
    $('#towers option').hide();
    $('#accesspoints option').hide();
    $("#networks").on("change", function () {
        network = $(this).val();
        $("#towers option").each(function () {
            if (network != $(this).attr("id")) $(this).hide();
            else $(this).show();
            // console.log($(this).attr('id'));
        });
    });
    $("#towers").on("change", function () {
        tower = $(this).val();
        $("#accesspoints option").each(function () {
            if (tower != $(this).attr("id")) $(this).hide();
            else $(this).show();
        });
    });



});
