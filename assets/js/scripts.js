M.AutoInit();

//Parallax
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.parallax');
    var instances = M.Parallax.init(elems);
});

//Sidenav
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);
});

//Carousel
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.carousel');
    var options = {
        'dist' : 0,
        'numVisible' : 3,
        'padding' : 20,
        'indicators' : true,
        //'fullWidth' : true
    };

    var instances = M.Carousel.init(elems, options);
});

