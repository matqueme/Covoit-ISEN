$('#user-connect').html('<h3>' + currentTitle + '</h3>');
for (let tweet of tweets)
    $('#tweets').append('<div class="card"><div class="card-body">' +
        tweet.login + ' : ' + tweet.text +
        '<div class="btn-group float-right" role="group">' +
        '<button type="button" class="btn btn-light float-right mod"' +
        ' value="' + tweet.id + '"><i class="fa fa-edit"></i></button>' +
        '<button type="button" class="btn btn-light float-right del"' +
        ' value="' + tweet.id + '"><i class="fa fa-trash"></i></button>' +
        '<div></div></div>');