<?php

require_once('constants.php');

//Connecter a la bdd
function dbConnect()
{
  try {
    $db = new PDO(
      'mysql:host=' . DB_SERVER . ';dbname=' . DB_NAME . ';charset=utf8',
      DB_USER,
      DB_PASSWORD
    );
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  } catch (PDOException $exception) {
    error_log('Connection error: ' . $exception->getMessage());
    return false;
  }
  return $db;
}


// Requete api avec $request definis dans request.php
//return sur une certaine page les valeur en JSON
function dbRequest($db, $request)
{
  try {
    //requete sur la bdd
    $statement = $db->prepare($request);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    //au cas ou une erreur
  } catch (PDOException $exception) {
    error_log('Request error: ' . $exception->getMessage());
    return false;
  }
  //retourne le resultat
  return $result;
}


// Rajouter un user.
// db parametre de la base de donnee
// return true si fait utilisateur ajouter sinon false
function dbAddUser($db, $nom, $prenom, $telephone, $mail, $pseudo, $mot_de_passe)
{
  try {
    $mot_de_passe = password_hash($mot_de_passe, PASSWORD_DEFAULT);
    $request = "INSERT INTO utilisateur(nom, prenom, telephone, mail, mot_de_passe, pseudo) VALUES(:nom, :prenom, :telephone, :mail, :mot_de_passe, :pseudo)";
    $statement = $db->prepare($request);
    $statement->bindParam(':nom', $nom, PDO::PARAM_STR);
    $statement->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $statement->bindParam(':telephone', $telephone, PDO::PARAM_STR);
    $statement->bindParam(':mail', $mail, PDO::PARAM_STR);
    $statement->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
    $statement->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
    $statement->execute();
  } catch (PDOException $exception) {
    error_log('Request error: ' . $exception->getMessage());
    return false;
  }
  return 'Compte créé';
}
//INSERT INTO `trajet` (`prix`, `nb_place`, `nb_place_libre`, `adresse`, `heure_depart`, `heure_arrivee`, `date_depart`, `date_arrivee`, `mail`, `etablissement`, `inse`, `type_de_trajet`) VALUES ('50', '6', '6', '5 rue', '22:49:00', '23:49:36', '2021-06-02', '2021-06-16', 'mathis.quemener@gmail.com', 'ISEN Brest', '29081', 'ISEN-Lieu');
//Creation d'un trajet
function dbAddTrajet($db, $datedepart, $datearrivee, $heuredepart, $heurearrivee, $partir, $isen, $ville, $adresse, $prix, $place)
{
  try {

    //Recuper inse de ville et tester erreur
    $request = "SELECT inse FROM ville WHERE LOWER(ville='$ville')";
    $ville = dbRequest($db, $request);
    if ($ville == null) { //si ville n'existe pas
      return 'Ville inexistante';
    } else {
      $ville = $ville[0]['inse']; //array[Array[ inse => 20202]] -> 20202
    }

    if ($partir == 'true') {
      $partir = 'ISEN-Lieu';
    } else {
      $partir = 'Lieu-ISEN';
    }

    $request = "INSERT INTO `trajet` (`prix`, `nb_place`, `nb_place_libre`, `adresse`, `heure_depart`, `heure_arrivee`, `date_depart`, `date_arrivee`, `mail`, `etablissement`, `inse`, `type_de_trajet`) VALUES (:prix, :place, :place, :adresse, :heuredepart, :heurearrivee, :datedepart, :datearrivee, 'mathis.quemener@gmail.com', :isen, :ville, :partir);    ";
    $statement = $db->prepare($request);
    $statement->bindParam(':prix', $prix, PDO::PARAM_STR);
    $statement->bindParam(':place', $place, PDO::PARAM_STR);
    $statement->bindParam(':adresse', $adresse, PDO::PARAM_STR);
    $statement->bindParam(':ville', $ville, PDO::PARAM_STR);
    $statement->bindParam(':isen', $isen, PDO::PARAM_STR);
    $statement->bindParam(':partir', $partir, PDO::PARAM_STR);
    $statement->bindParam(':heuredepart', $heuredepart, PDO::PARAM_STR);
    $statement->bindParam(':heurearrivee', $heurearrivee, PDO::PARAM_STR);
    $statement->bindParam(':datedepart', $datedepart, PDO::PARAM_STR);
    $statement->bindParam(':datearrivee', $datearrivee, PDO::PARAM_STR);
    $statement->execute();
  } catch (PDOException $exception) {
    error_log('Request error: ' . $exception->getMessage());
    return false;
  }
  return 'Trajet ajouté';
}

//se connecter a notre compte
function dbConnexion($db, $mail, $mot_de_passe)
{
  try {
    $request = 'SELECT mail, mot_de_passe FROM utilisateur ';
    if ($mail != '')
      $request .= ' WHERE mail=:mail';
    $statement = $db->prepare($request);
    if ($mail != '')
      $statement->bindParam(':mail', $mail, PDO::PARAM_STR, 20);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    if (!empty($result)) {
      $result1 = $result[0];    //tableau avec juste mail et mot_de_passe
      $isPasswordCorrect = password_verify($mot_de_passe, $result1['mot_de_passe']);    // Comparaison du pass envoyé via le formulaire avec la base
    } else {
      $result1 = false;
    }

    if (!$result1) {
      return 'Mauvais identifiant ou mot de passe !';
    } else {
      if ($isPasswordCorrect) {
        session_start();
        $_SESSION['mail'] = $result1['mail'];
        $con = 1;
        return 'Vous êtes connecté !';
      } else {
        return 'Mauvais identifiant ou mot de passe !';
      }
    }
  } catch (PDOException $exception) {
    error_log('Request error: ' . $exception->getMessage());
    return false;
  }
  return true;
}


//----------------------------------------------------------------------------
//--- dbModifyTweet ----------------------------------------------------------
//----------------------------------------------------------------------------
// Function to modify a tweet.
// \param db The connected database.
// \param id The id of the tweet to update.
// \param login The login of the user.
// \param text The new tweet.
// \return True on success, false otherwise.
function dbModifyTweet($db, $id, $login, $text)
{
  try {
    $request = 'UPDATE tweets SET text=:text WHERE id=:id AND login=:login ';
    $statement = $db->prepare($request);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':login', $login, PDO::PARAM_STR, 20);
    $statement->bindParam(':text', $text, PDO::PARAM_STR, 80);
    $statement->execute();
  } catch (PDOException $exception) {
    error_log('Request error: ' . $exception->getMessage());
    return false;
  }
  return true;
}

//----------------------------------------------------------------------------
//--- dbDeleteTweet ----------------------------------------------------------
//----------------------------------------------------------------------------
// Delete a tweet.
// \param db The connected database.
// \param id The id of the tweet.
// \param login The login of the user.
// \return True on success, false otherwise.
function dbDeleteTweet($db, $id, $login)
{
  try {
    $request = 'DELETE FROM tweets WHERE id=:id AND login=:login';
    $statement = $db->prepare($request);
    $statement->bindParam(':id', $id, PDO::PARAM_INT);
    $statement->bindParam(':login', $login, PDO::PARAM_STR, 20);
    $statement->execute();
  } catch (PDOException $exception) {
    error_log('Request error: ' . $exception->getMessage());
    return false;
  }
  return true;
}
