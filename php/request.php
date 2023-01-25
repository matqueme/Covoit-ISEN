<?php

require_once('database.php');

// Database connexion.
$db = dbConnect();
if (!$db) {
    header('HTTP/1.1 503 Service Unavailable');
    exit;
}

//POUR LE CHEMIN GENRE IMAGINE 127.0.0.1/LE CHEMIN
// Check the request.
$requestMethod = $_SERVER['REQUEST_METHOD']; //GET,POST,...
$request = substr($_SERVER['PATH_INFO'], 1); //'api/i'
$request = explode('/', $request); //['api','i','j]
$requestRessource = array_shift($request); // ['api']
$id = array_shift($request); //['i']
$param2 = array_shift($request); //['j']

if ($id == '')
    $id = NULL;
$data = false;

//EN SOIS TU AS BESOIN A PARTIR DE CET ENDROIT
// Requete de l'api
if ($requestRessource == 'api') {
    //--------------------------------------------------------------------------------
    //--------------------------------------------------------------------------------
    if ($requestMethod == "GET") { //GET
        if ($id == 'ville') { //afficher inse/ville 
            if (isset($param2)) { //afficher ville en fonction de inse
                $request = "SELECT ville FROM ville WHERE LOWER(inse = $param2)";
            } else { //afficher inse/ville 
                $request = "SELECT ville,inse FROM ville";
            }
        } elseif ($id == 'user') { // afficher tout les user
            $request = "SELECT * FROM utilisateur";
        } elseif ($id == 'isen') { // afficher tout les resultat
            $request = "SELECT * FROM site";
        } elseif ($id == "rechercher") { // rechercher des trajets
            $date =  $_GET['datedepart']; //recuperer info du get pourla requete
            $partir = $_GET['partir'];
            if ($partir == 'true') {
                $partir = 'ISEN-Lieu';
            } else {
                $partir = 'Lieu-ISEN';
            }
            $etablissement = $_GET['isen'];
            $ville = $_GET['ville'];

            $request = "SELECT * FROM trajet LEFT JOIN ville ON trajet.inse = ville.inse WHERE date_depart ='$date' AND type_de_trajet='$partir' AND etablissement='$etablissement' AND LOWER(ville='$ville')";
        }
        $data = dbRequest($db, $request);
        echo json_encode($data);
        //--------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------
    } else if ($requestMethod == "POST") { //POST
        if (isset($_POST['login'])) { //si login existe -> requete vers connexion
            $data = dbConnexion($db, $_POST['email'], $_POST['password']);
            echo $data;
        } elseif (isset($_POST['telephone'])) { //Ajout d'un user (strip_tag pour Supprime les balises HTML et php) fonction erreur
            if (testincription()) {
                $data = dbAddUser($db, strip_tags($_POST['nom']), strip_tags($_POST['prenom']), strip_tags($_POST['telephone']), strip_tags($_POST['email']), strip_tags($_POST['pseudo']), $_POST['password']);
                echo $data;
            }
        } elseif (isset($_POST['datedepart'])) { //Ajout d'un user (strip_tag pour Supprime les balises HTML et php) fonction erreur
            if (testtrajet()) {
                $data = dbAddTrajet($db, strip_tags($_POST['datedepart']), strip_tags($_POST['datearrive']), strip_tags($_POST['heuredepart']), strip_tags($_POST['heurearrivee']), strip_tags($_POST['partir']), strip_tags($_POST['isen']), strip_tags($_POST['ville']), strip_tags($_POST['adresse']), $_POST['prix'], $_POST['place']);
                echo $data;
            }
        }
        //--------------------------------------------------------------------------------
        //--------------------------------------------------------------------------------
    } else if ($requestMethod == "DELETE") {
        if ($id != '' && isset($_GET['login'])) {
            $data = dbDeleteTweet($db, intval($id), $_GET['login']);
        }
    } else if ($requestMethod == "PUT") {
        parse_str(file_get_contents('php://input'), $_PUT);
        if ($id != '' && isset($_PUT['login']) && isset($_PUT['text'])) {

            $data = dbModifyTweet($db, intval($id), $_PUT['login'], strip_tags($_PUT['text']));
        }
    }
}


//Fonction erreur pour l'inscription (regex ...)
function testincription()
{
    $prenom = $_POST['prenom'];
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $pseudo = $_POST['pseudo'];
    $telephone = $_POST['telephone'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $regexmail = "/^[-+.\w]{1,64}@[-.\w]{1,64}\.[-.\w]{2,6}$/i";
    $regextel = "/^(0|\+33)[1-9]([-. ]?[0-9]{2}){4}$/i";

    //verification de tout les champs un par un
    if ($prenom == '') {
        echo 'Veuillez remplir votre prénom';
    } else if ($nom == '') {
        echo 'Veuillez remplir votre nom';
    } else if ($email == '') {
        echo 'Veuillez remplir votre mail';
    } else if (!preg_match($regexmail, $email)) {
        echo 'Veuillez remplir un mail correct';
    } else if ($pseudo == '') {
        echo 'Veuillez remplir votre pseudonyme';
    } else if ($telephone == '') {
        echo 'Veuillez remplir votre numéro de téléphone';
    } else if (!preg_match($regextel, $telephone)) {
        echo 'Veuillez remplir un numéro de téléphone correct';
    } else if ($password == '') {
        echo 'Veuillez renseigner un mot de passe';
    } else if ($password2 == '') {
        echo 'Veuillez confirmer votre mot de passe';
    } else if ($password2 != $password) {
        echo 'Les mots de passe ne correspondent pas';
    } else {
        return true;
    }
    return false;
}

//Fonction erreur pour l'ajout de trajet 
function testtrajet()
{
    $datedepart = $_POST['datedepart'];
    $datearrivee = $_POST['datearrive'];
    $heuredepart = $_POST['heuredepart'];
    $heurearrivee = $_POST['heurearrivee'];
    $ville = $_POST['ville'];
    $adresse = $_POST['adresse'];
    $prix = $_POST['prix'];
    $place = $_POST['place'];
    $datedepart2 = new DateTime($_POST['datedepart']);
    $datearrivee2 = new DateTime($_POST['datearrive']);
    $heuredepart2 = new DateTime($_POST['heuredepart']);
    $heurearrivee2 = new DateTime($_POST['heurearrivee']);

    //verification de tout les champs un par un
    if ($datedepart == '') {
        echo 'Veuillez remplir la date de départ';
    } else if ($datearrivee == '') {
        echo 'Veuillez remplir la date d\'arrivée';
    } else if ($heuredepart == '') {
        echo 'Veuillez remplir l\'heure de départ';
    } else if ($heurearrivee == '') {
        echo 'Veuillez remplir l\'heure d\arrivée';
    } else if ($adresse == '') {
        echo 'Veuillez remplir l\'adresse';
    } else if ($prix == '') {
        echo 'Veuillez renseigner le prix';
    } else if ($place == '') {
        echo 'Veuillez renseigner le nombre de place';
    } else if ($datedepart2 > $datearrivee2) {
        echo 'La date de départ indiqué est supérieur a la date d\'arrivée';
    } else if ($heuredepart2 > $heurearrivee2 && $datedepart2 == $datearrivee2) {
        echo 'L\'heure de départ indiqué est supérieur a l\'heure d\'arrivée';
    } else if ($heuredepart2 == $heurearrivee2 && $datedepart2 == $datearrivee2) {
        echo 'L\'heure de départ indiqué est égale a l\'heure d\'arrivée';
    } else {
        return true;
    }
    return false;
}


// Send data to the client.
header('Content-Type: application/json; charset=utf-8');
header('Cache-control: no-store, no-cache, must-revalidate');
header('Pragma: no-cache');
header('HTTP/1.1 200 OK');

exit;
