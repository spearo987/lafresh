var app = require('express')();
var express = require('express')
var http = require('http').Server(app);
var io = require('socket.io')(http);

app.get('/', function(req, res){
    res.sendFile(__dirname + '/index.html');
});

var onlineUsers = {};
var messages = [];
var history = 5;

io.on('connection', function(socket){

    var self = false;

    /*************************
     *** Parcours la liste des utilisateurs connectés et la transmet au nouvel utilisateur qui charge le chat
     *************************/
    for(var i in onlineUsers){
        socket.emit('usersList', onlineUsers[i])
    }

    for(var k in messages){
        socket.emit('newmessage', messages[k])
    }

    /*************************
     *** Enregistre les infos du nouvel utilisateur loggué
     *************************/
    socket.on('login', function(user){
        self = user;
        self.pseudo = user.pseudo;
        self.email = user.email;
        io.emit('logged', self);
        onlineUsers[self.email] = self;
        io.emit('usersList', self);
    });

    /*************************
     *** Renvoie le message aux autres utilisateurs
     *************************/
    socket.on('newmessage', function(message){
        message.user = self;
        date = new Date();
        message.hour = date.getHours();
        if (message.hour < 10) {
            message.hour = '0' + message.hour;
        }
        message.min = date.getMinutes();
        if (message.min < 10) {
            message.min = '0' + message.min;
        }
        message.day = date.getDate();
        message.month = date.getMonth();
        message.year = date.getFullYear();
        messages.push(message);
        if (messages.length > history) {
            messages.shift();
        }
        io.emit('newmessage', message);
    });

    /*************************
     *** Déconnexion d'un utilisateur
     *************************/
    socket.on('disconnect', function(){
        if (!self) {
            return false;
        }

        delete onlineUsers[self.email];
        io.emit('disconnected', self);
    });

});

http.listen(3000, function(){
  console.log('listening on *:3000');
});
