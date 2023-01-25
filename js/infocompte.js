ajaxRequest('GET', 'php/request.php/api/mestrajets', chercher_mail);

function chercher_mail(trajets) {
    trajets = JSON.parse(trajets);
    console.log(trajets)
    for (trajet of trajets) {
        $('#mestrajets').append("Je vous propose d'aller à cette addresse : " + trajet.adresse + '<br>');
        $('#mestrajets').append("Vous arriverez à cette date : " + trajet.date_arrivee + '<br>');
        $('#mestrajets').append("Vous partirez à cette date : " + trajet.date_depart + '<br>');
        $('#mestrajets').append("Vous partirez de : " + trajet.etablissement + '<br>');
        $('#mestrajets').append("Vous arriverez à cette heure : " + trajet.heure_arrivee + '<br>');
        $('#mestrajets').append("Vous partirez à cette heure : " + trajet.heure_depart + '<br>');
        $('#mestrajets').append("Numéro du trajet : " + trajet.identifiant + '<br>');
        $('#mestrajets').append("Nombre de place : " + trajet.nb_place + '<br>');
        $('#mestrajets').append("Nombre de place restantes : " + trajet.nb_place_libre + '<br>');
        $('#mestrajets').append("Prix : " + trajet.prix + '<br>');
        $('#mestrajets').append("Mon mail : " + trajet.mail + '<br>');
        $('#mestrajets').append("Le trajet : " + trajet.type_de_trajet + '<br><br>');
    }

    mail = trajets[0].mail;
    ajaxRequest('GET', 'php/request.php/api/inscrit/' + mail, affichage_inscrit);
}

function affichage_inscrit(trajets) {
    trajets = JSON.parse(trajets);
    console.log(trajets)

    for (trajet of trajets) {
        $('#mesinscription').append("addresse d'arrivée : " + trajet.adresse + '<br>');
        $('#mesinscription').append("J'arrverais à cette date : " + trajet.date_arrivee + '<br>');
        $('#mesinscription').append("Je partirais à cette date : " + trajet.date_depart + '<br>');
        $('#mesinscription').append("Départ : " + trajet.etablissement + '<br>');
        $('#mesinscription').append("J'arriverais à cette heure : " + trajet.heure_arrivee + '<br>');
        $('#mesinscription').append("Je partirais à cette heure : " + trajet.heure_depart + '<br>');
        $('#mesinscription').append("Numéro du trajet : " + trajet.identifiant + '<br>');
        $('#mesinscription').append("Nombre de place : " + trajet.nb_place + '<br>');
        $('#mesinscription').append("Nombre de place restantes : " + trajet.nb_place_libre + '<br>');
        $('#mesinscription').append("Prix : " + trajet.prix + '<br>');
        $('#mesinscription').append("Le mail de conducteur : " + trajet.mail + '<br>');
        $('#mesinscription').append("Le trajet : " + trajet.type_de_trajet + '<br><br>');
    }
}