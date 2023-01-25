$('#deconnect').click((event) => {
          event.preventDefault();
          ajaxRequest('GET', 'php/request.php/api/deconnecter', deconnexion());
});

function deconnexion(){
          console.log('Deconnxion effectuée');
          alert('Vous avez bien été déconnectée !');
};