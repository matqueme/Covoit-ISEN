var con = $(con);

if(con == 1){
          document.getElementById('connexion').href = 'compte.html';
          document.getElementById('connexion').textContent = 'Mon Compte';
          document.getElementById('connexion').id = 'accompt';
}
else{
          document.getElementById('accompt').href = 'connexion.html';
          document.getElementById('accompt').textContent = 'Connexion';
          document.getElementById('accompt').id = 'connexion';
}