//Pour afficher dynamiquement les liste deroulantes


ajaxRequest('GET', 'php/request.php/api/isen/', displayISEN);

function displayISEN(isen) {
    const namejson = JSON.parse(isen);
    for (let isen of namejson) {
        $('#isen').append('<option value="' + isen.inse + '">' + isen.etablissement + '</option>')
    }
}