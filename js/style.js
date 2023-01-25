//Pour redimensionner a chaque recharge ou changement de largeur
//window.onload = resize;
//window.onresize = resize;

//boucle pour savoir la valeur de scroll
setInterval(scroll, 10);
//lorsque l'on scrolle la barre
function scroll() {
    var y = window.scrollY;
    var elmt = document.getElementsByTagName("ul")[0];
    if (y === 0) {
        elmt.style.transition = "background-color 0.8s";
        elmt.style.backgroundColor = "rgba(238,238,238,1)";
        elmt.style.boxShadow = "0px 0px 0px rgba(255, 255, 255, 0)";
        elmt.style.transition = "box-shadow 0.8s";
        barrenav(y);
    } else {
        elmt.style.transition = "background-color 0.8s";
        elmt.style.transition = "box-shadow 0.8s";
        elmt.style.backgroundColor = "rgba(240,240,240,0.85)";
        elmt.style.boxShadow = "1px 1px 12px #555";
        barrenav(y);
    }
}


//Mettre la barre de navigation en fonction de la largeur de la page et si on est tt en haut
function barrenav(y) {
    var texta;
    var textb;
    var largeurfenetre = window.innerWidth;
    if (y == 0 && largeurfenetre > 530) {
        for (var i = 0; i < 3; i++) {
            texta = document.getElementsByTagName("a")[i];
            texta.style.transition = "font-size 0.8s";
            texta.style.fontSize = "22px";
        }
        textb = document.getElementById("centernav");
        textb.style.transition = "font-size 0.8s";
        textb.style.fontSize = "22px";
    } else {
        for (var i = 0; i < 3; i++) {
            texta = document.getElementsByTagName("a")[i];
            texta.style.transition = "font-size 0.8s";
            texta.style.fontSize = "16px";
        }
        textb = document.getElementById("centernav");
        textb.style.transition = "font-size 0.8s";
        textb.style.fontSize = "16px";
    }
}


//Lorsque l'on resize la fenetre pour la largeur des texte et des img
/*function resize() {
    var largeurfenetre = window.innerWidth;
    var fp = document.getElementById("fp");
    var y = window.scrollY;

    if (largeurfenetre < 915) {
        fp.style.fontSize = "40px";
        barrenav(y);
    }
    if (largeurfenetre < 410) {
        fp.style.fontSize = "30px";
        barrenav(y);
    }
    if (largeurfenetre >= 915) {
        fp.style.fontSize = "60px";
        barrenav(y);
    }
}*/