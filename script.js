////formの開閉

//document.getElementById("toggleDataForm").style.display = "none";

//let isToggleDataForm = false;

//toggleDataFormBtn.addEventListener("click", function () {
//    isToggleDataForm = !isToggleDataForm;
//    if (isToggleDataForm) {
//        document.getElementById("toggleDataForm").style.display = "block";
//    } else {
//        document.getElementById("toggleDataForm").style.display = "none";
//    }
//});

$(function () {

    console.log("aaa");

    //$('button').click(function () {

    $('#toggleDataFormBtn').click(function () {
        
        //$('#toggleDataForm').toggle();
        $('#toggleDataForm').slideToggle();

        //alert("");
        //console.log("bbb");

    })

    let dataTitles = $('.data-title');

    dataTitles.each(function () {
        $(this).click(function () {
            $(this).parent().next().slideToggle();
        });
    });

});//jquery終了


//-----------------------------------------------------------

function myEvent(e) {
    let range = document.createRange();
    let span = e.parentNode.previousElementSibling;
    range.selectNodeContents(span);

    let selection = document.getSelection();
    selection.removeAllRanges();
    selection.addRange(range);
    document.execCommand('copy');
    //alert("copied!");
}

