'use strict';

//Si on appuie sur valider pour la creation de compte
$('#user-add').submit((event) => {
    event.preventDefault();
    ajaxRequest('POST', 'php/request.php/api', displayEtat,
        'nom=' + $('#nom').val() + '&prenom=' + $('#prenom').val() + '&telephone=' + $('#telephone').val() + '&email=' + $('#email').val() + '&pseudo=' + $('#pseudo').val() + '&password=' + $('#password').val() + '&password2=' + $('#password2').val());
});

//connexion a son compte detection du clique
$('#user-connect').submit((event) => {
    event.preventDefault();
    ajaxRequest('POST', 'php/request.php/api/', displayEtat, '&email=' + $('#email').val() + '&password=' + $('#password').val() + '&login=true');
});

//creation de course clique sur le bouton
$('#creationcourse').submit((event) => {
    event.preventDefault();
    ajaxRequest('POST', 'php/request.php/api', displayEtat,
        'datedepart=' + $('#datedepart').val() + '&datearrive=' + $('#datearrive').val() + '&heuredepart=' + $('#heuredepart').val() + '&heurearrivee=' + $('#heurearrivee').val() + '&partir=' + $('#partir').is(":checked") + '&isen=' + $('#isen option:selected').text() + '&ville=' + $('#ville').val() + '&adresse=' + $('#adresse').val() + '&prix=' + $('#prix').val() + '&place=' + $('#place').val());
});

//rechercher une course lors du clique du bouton
$('#rechercher').submit((event) => {
    event.preventDefault();
    ajaxRequest('GET', 'php/request.php/api/rechercher', displayCourse,
        'datedepart=' + $('#datedepart').val() + '&partir=' + $('#partir').is(":checked") + '&isen=' + $('#isen option:selected').text() + '&ville=' + $('#ville').val());
});


function displayCourse(info) {
    let resultats = JSON.parse(info);
    let taille = resultats.length;
    if (taille == 1 || taille == 0) {
        taille = ' résultat'
    } else {
        taille = ' résultats'
    }
    $('#nbresultat').html('<p>' + resultats.length + taille + '</p>') //afficher nbresultat(s)
    $('#listeresultat').html('') //remettre la div vide
    let n = 0;

    for (let resultat of resultats) { //rajouter des info dans la div
        n = n + 1;
        let datearrivee = new Date(resultat.date_arrivee);
        let mois = (datearrivee.getMonth() + 1);
        if (mois < 10) {
            mois = '0' + mois;
        }
        if (n < 10) {
            //partie depart (haut)
            $('#listeresultat').append('<div class="resultat rond" id ="div' + n + '">')
            $('.resultat#div' + n + '').append('<div id=depart' + n + ' style="height:80px"><div class=hdepart> <p>' + resultat.heure_depart.substring(0, 5) /*supprimer :00 a la fin*/ + '</p></div> <div class="design"><div class="pointhaut"></div> <div class="traithaut"> </div> </div>')
            if (resultat.type_de_trajet == 'ISEN-Lieu') {
                $('#depart' + n + '').append('<div class=lieu_depart> <p>' + resultat.etablissement + '</p> </div></div>')
            } else {
                $('.resultat#div' + n + '').append('<div class=lieu_arrivee> <p>' + resultat.ville + '</p> </div></div>')
            }
            $('#depart' + n + '').append('<div class=nb_place_libre> <p>' + resultat.nb_place_libre + ' places</p> </div>')

            //partie arrivee (bas)
            $('.resultat#div' + n + '').append('<div id=arrivee' + n + ' style="height:80px"><div class=harrivee> <p>' + resultat.heure_arrivee.substring(0, 5) + '</p></div> <div class="design"><div class="traitbas"></div><div class="pointbas"></div> </div>')
            if (resultat.type_de_trajet == 'ISEN-Lieu') {
                $('#arrivee' + n + '').append('<div class=lieu_arrivee> <p>' + resultat.ville + '</p> </div>')
            } else {
                $('#arrivee' + n + '').append('<div class=lieu_depart> <p>' + resultat.etablissement + '</p> </div>')
            }
            $('#arrivee' + n + '').append('<div class=prix> <p>Prix : ' + resultat.prix + ' € </p> </div>')

            $('.resultat#div' + n + '').append('<div id=bouton' + n + ' style="height:30px"></div>')
            $('#bouton' + n + '').append('<div class=bouton_reserver> <input class="reserverbouton" type="submit" value="Réserver" id = ' + resultat.identifiant + '> </div>')
                // $('#' + n + 'bouton').append('<div class=date_arrivee> <p>Date d\'arrivee : ' + datearrivee.getDate() + '/' + mois + '/' + datearrivee.getFullYear() + '</p> </div>')

            $('#listeresultat').append('</div>')
        }
    }
    console.log(resultats);
}

function displayInfo(info) {
    console.log(info);
}

function displayEtat(info) {
    // retourne le resultat de la requete (compte creer, erreur, ...)
    $('#info').html('<p>' + info + '</p>');

}