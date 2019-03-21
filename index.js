var express=require('express');
var socket=require('socket.io');
var http = require( 'http' );
//App setup

var app=express();
// var server = http.createServer( app );
// install server to a variable
var server=app.listen(4000,function(){
  console.log('listen to request to port 4000');
});

users=[];
 connections=[];
 var rid,sname;

//static files
// public is a folder name in which rest of the  thing are saved
//when server is active it will look in public folder what to do n serve it to the browser
app.use(express.static('public'));

//socket setup
//argument is the server name on which to insatll socket.io
//invoking socket method and passing the server variable we created
var io=socket(server);
//listening for connection to client

io.sockets.on('connection',function(socket)
{
       console.log('made socket connection',socket.id);
       connections.push(socket);//pushing each connection in an connection array
       console.log("%s sockets connected",connections.length);

       socket.on('disconnect',function(data)
       {
             console.log(socket.id);
             var l=0;
             // it deletes users who go offline
             // below code is made bczeverythoing is stored as array of objects
              for(var i=0;i<users.length; i++)
              {
                var obj=users[i];
                if(obj.id === socket.id)
                {
                   users.splice(i,1);
                   l=l+1;
                }
              }
              // users.splice(users.indexOf(socket.id),1);
              console.log(users);
              //delete users[socket.username];
              updateUsernames();
              connections.splice(connections.indexOf(socket),1);
              console.log("%s socket disconnected",connections.length);
              console.log("%s sockets remained",connections.length);
              l=0;
        });

       socket.on('new user',function(data,callback)
       {
         callback(true);
         //console.log(data);
         socket.username=data;
          //username=socket.username;
         // we store the username in the socket session for this client
    		// add the client's username to the global list
        users.push({id:socket.id,username:data.username});
    		//users[socket.username]= socket.id;

         console.log(users);
         //console.log(users[id]);
         //console.log(users[username]);
         updateUsernames();
       });
          /*****************************************************************************/
         function check_key(v)//gives id
         {
           var val;

           for(var i=0;i<users.length;i++)
           {
               if(users[i].username ==v)
               {
                   val = users[i].id;
                   break;
               }

           }
           return val;
         }

         function check_keyname(v)//gives username
         {
           var val="";

           for(var i=0;i<users.length ;i++)
           {
               if(users[i].id==v)
               {
                   val = users[i].username;
                   break;
               }
           }
          //console.log("check"+val);
           return val;
         }

          /*************************************************************************/
         function updateUsernames(){
           io.sockets.emit('get users',users);
         }

          /***************************************************************************/

          socket.on('msg_user', function(data)
          {
              //console.log("From user: "+data.userid);
              //var k=data.usr
              console.log("To user: "+data.usr);
              var k,j;
              k=data.userid;
              j=data.usr;
              sname=check_keyname(k);
              rid=check_key(j);
            		console.log("From user: "+sname);
                //var k=data.usr
            	//	console.log("To user: "+rid);
          		//console.log(usernames);
              // to send to particular socketid use below line of code
              console.log("msg :"+data.msg);
              io.to(rid).emit('msg_user_handle', {username:sname, msg:data.msg});

               // below code is to send message to sender itself
              io.to(k).emit('msg_user_handle', {username:sname, msg:data.msg});
          	//	io.sockets.socket(users[usr]).emit('msg_user_handle', username, msg);
          	});


             //listening message named "chat" by server  from clients
            socket.on('chat',function(data)
            {
             //io.socket emits message to all clients connected
             var s=socket.username;
              io.sockets.emit('chat',{
                    username:s,
                    message:data.message
                       });
                    // console.log(s);
                });

            //listening to typing message from client and then broadcast it to remaining clients
             socket.on('typing',function(){
             //console.log(socket.username);
             socket.broadcast.emit('typing',socket.username);
                });
});
