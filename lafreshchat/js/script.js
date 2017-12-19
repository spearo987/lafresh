var socket = io('http://localhost:3000');

/*************************
 *** Récupère les infos du form et les transmet au serveur
 *************************/
socket.emit('login', {
    pseudo: username,
    email: emailadress
});

/*************************
 *** Transmet le message au serveur
 *************************/
document.getElementById('send-message').onsubmit = function() {
    var message = document.getElementById('message');
    socket.emit('newmessage', {
        message: message.value
    });
    message.value = "";
    message.focus();
    return false;
};

/*************************
 *** Afficher la liste des utilisateurs présents
 *************************/
socket.on('usersList', function(user) {
    var li = document.createElement("li");
    var text = document.createTextNode(user.pseudo);
    li.append(text);
    li.setAttribute('id', user.email);
    document.getElementById('connected-users').append(li);
});

/*************************
 *** Affiche les nouveaux messages
 *************************/
socket.on('newmessage', function(message) {
    var messages = document.getElementById('messages');

    var messageBlock = document.createElement('div');
    messageBlock.setAttribute('class', 'message-block');

    var authorInfo = document.createElement('div');
    authorInfo.setAttribute('class', 'author-info');

    var title = document.createElement('h3');
    var titleText = document.createTextNode(message.user.pseudo);
    title.append(titleText);

    var date = document.createElement('span');
    var dateText = document.createTextNode(message.hour + ' : ' + message.min);
    date.append(dateText);

    authorInfo.append(title);
    authorInfo.append(date);

    var msg = document.createElement('div');
    msg.setAttribute('class', 'message');

    var messageContent = document.createTextNode(message.message);

    msg.append(messageContent);

    messageBlock.append(authorInfo);
    messageBlock.append(msg);
    messages.append(messageBlock);

});

/*************************
 *** Affiche lorsqu'un utilisateur se déconnecte et le supprime de la liste des utilisateurs connectés
 *************************/
socket.on('disconnected', function(user) {
    var li = document.createElement("li");
    var text = document.createTextNode('On a  perdu : ' + user.pseudo + '... RIP');
    li.append(text);
    li.setAttribute('class', 'is-disconnected');
    document.getElementById('messages').append(li);
    document.getElementById(user.email).remove();
});
