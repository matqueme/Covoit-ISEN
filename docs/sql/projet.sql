#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: utilisateur
#------------------------------------------------------------

CREATE TABLE utilisateur(
        mail         Varchar (255) NOT NULL ,
        pseudo       Varchar (100) NOT NULL ,
        nom          Varchar (255) NOT NULL ,
        prenom       Varchar (255) NOT NULL ,
        telephone    Varchar (20) NOT NULL ,
        mot_de_passe Varchar (255) NOT NULL
	,CONSTRAINT utilisateur_PK PRIMARY KEY (mail)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: ville
#------------------------------------------------------------

CREATE TABLE ville(
        inse        Varchar (255) NOT NULL ,
        code_postal Int NOT NULL ,
        ville       Varchar (255) NOT NULL
	,CONSTRAINT ville_PK PRIMARY KEY (inse)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: site
#------------------------------------------------------------

CREATE TABLE site(
        etablissement Varchar (255) NOT NULL ,
        inse          Varchar (255) NOT NULL
	,CONSTRAINT site_PK PRIMARY KEY (etablissement)

	,CONSTRAINT site_ville_FK FOREIGN KEY (inse) REFERENCES ville(inse)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: association
#------------------------------------------------------------

CREATE TABLE association(
        type_de_trajet Varchar (255) NOT NULL
	,CONSTRAINT association_PK PRIMARY KEY (type_de_trajet)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: trajet
#------------------------------------------------------------

CREATE TABLE trajet(
        identifiant    Int  Auto_increment  NOT NULL ,
        prix           Float NOT NULL ,
        nb_place       Int NOT NULL ,
        nb_place_libre Int NOT NULL ,
        adresse        Varchar (255) NOT NULL ,
        heure_depart   Time NOT NULL ,
        heure_arrivee  Time NOT NULL ,
        date_depart    Date NOT NULL ,
        date_arrivee   Date NOT NULL ,
        mail           Varchar (255) NOT NULL ,
        etablissement  Varchar (255) NOT NULL ,
        inse           Varchar (255) NOT NULL ,
        type_de_trajet Varchar (255) NOT NULL
	,CONSTRAINT trajet_PK PRIMARY KEY (identifiant)

	,CONSTRAINT trajet_utilisateur_FK FOREIGN KEY (mail) REFERENCES utilisateur(mail)
	,CONSTRAINT trajet_site0_FK FOREIGN KEY (etablissement) REFERENCES site(etablissement)
	,CONSTRAINT trajet_ville1_FK FOREIGN KEY (inse) REFERENCES ville(inse)
	,CONSTRAINT trajet_association2_FK FOREIGN KEY (type_de_trajet) REFERENCES association(type_de_trajet)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: est_inscrit
#------------------------------------------------------------

CREATE TABLE est_inscrit(
        identifiant Int NOT NULL ,
        mail        Varchar (255) NOT NULL
	,CONSTRAINT est_inscrit_PK PRIMARY KEY (identifiant,mail)

	,CONSTRAINT est_inscrit_trajet_FK FOREIGN KEY (identifiant) REFERENCES trajet(identifiant)
	,CONSTRAINT est_inscrit_utilisateur0_FK FOREIGN KEY (mail) REFERENCES utilisateur(mail)
)ENGINE=InnoDB;

