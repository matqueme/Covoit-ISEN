'use strict';

// Ajax request
// param type pour(GET, DELETE, POST, PUT).
// param url est l'url avec les donnee
// param callback appller la requete lorsque elle et bonne
// param data est les donnee associé au requete
function ajaxRequest(type, url, callback, data = null) {
    let xhr;
    // Create XML HTTP request.
    xhr = new XMLHttpRequest();
    if (type == 'GET' && data != null)
        url += '?' + data;
    xhr.open(type, url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    // Add the onload function.
    xhr.onload = () => {
        switch (xhr.status) {
            case 200:
            case 201:
                //console.log(xhr.responseText);
                callback(xhr.responseText);
                break;
            default:
                httpErrors(xhr.status);
        }
    };

    // Send XML HTTP request.
    xhr.send(data);
}


//Affiche les erreurs
function httpErrors(errorCode) {
    let messages = {
        400: 'Requête incorrecte',
        401: 'Authentifiez vous',
        403: 'Accès refusé',
        404: 'Page non trouvée',
        500: 'Erreur interne du serveur',
        503: 'Service indisponible'
    };

    // Display error.
    if (errorCode in messages) {
        console.log(errorCode);
    }
}