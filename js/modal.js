$('#show-info').click(function () {
    showDialog({
        title: 'Information',
        text: lorem
    })
});


var woof = document.getElementById("woof");

woof.style.visibility="visible";
var screenTop = $(document).scrollTop();
document.addEventListener("scroll", function() {

    var currentTop = $(document).scrollTop();

    console.log(screenTop )
    if(screenTop <  currentTop) {
        woof.style.display="none";
    } else {
        woof.style.display="block";
    }

    screenTop = currentTop;




})

