Dans un premier temps dans la page accueil dans un premier temps on choisit si on veut partir d�un isen ou y aller. Puis on choisit enfin la date, enfin vient la validation. Bien entendu pour pouvoir r�server un trajet il faut se connecter.

Quand on va dans la proposition d�une course, on doit s�lectionner dans un premier temps la date de d�part, puis la date d�arriv�e. En deuxi�me temps on s�lectionne l�heure de d�part et d�arriv�e. Enfin vient de choix du type de trajet, de l�isen, de l�adresse de d�part ou d�arriv�e selon le choix de du type de trajet, puis de la ville et enfin le prix et le nombre de places. La connexion et obligatoire ici pour poster une course.
  
Pour la connexion c�est simple on met son mail et son mot de passe.

Pour l�inscription il faut mettre un nom, le pr�nom, le mail, un pseudonyme, un num�ro de t�l�phone, un mot de passe et une confirmation de ce dernier.

Dans mon compte on voit simplement nos propositions de trajet et ceux auquel on est inscrit.


      GET�:
      
      php/request.php/

	ville => liste des villes
	ville/info => info de une ville
	user => tous les user
	isen => tous les isens
	rechercher => recherche avec parametre 
	trajet => tous les trajets
	trajet/info => tous les info d'un trajet
	inscrit/mail => tous les infos de l'user inscrit.
	inscrit => tous les inscription
	connecter => s'il est connecter true false
	deconnecter => se deconnecter
	mes trajets => les trajets creer

      POST�:

	php/request.php/api/addtrajet
	php/request.php/api/adduser
	php/request.php/api/connect
	php/request.php/api/associationtrajet
      
      PUT�:

	php/request.php/api/



- Dans la partie recherche ('accueille  les r�sultats des pr�c�dentes recherches se suppriment.
- Dans la partie compte les inscriptions et propositions s'affichent correctement.
- Correction de fautes d'orthographe.