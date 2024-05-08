$(document).ready(function(){
    $("#overlay").hide();
});

$("#saveBtn").click(function(){
    $("#overlay").show();
    $("#new-client").attr('disabled');
});