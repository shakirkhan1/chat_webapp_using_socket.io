  <?php
          require 'database.php';
          // making connection to server
          // to make connection we use io.connect(server address or url)
          var socket=io.connect('http://localhost:4000');

          //creating references

          // variables for login
          var userformarea =document.getElementById('userformarea'),
              userform     =document.getElementById('userform'),
              username     =document.getElementById('username'),
              btn1         =document.getElementById('btn1');

          // variables for online user info.
          var onlineusersnum =document.getElementById('onlineusersnum'),
              users          =document.getElementById('users'),
              users1         =document.getElementsByClassName('users1'),
              numuser        =document.getElementById('numuser');


          // variables for group chat
          var message     =document.getElementById('message'),
              btn         =document.getElementById('send'),
              output      =document.getElementById('output'),
              feedback    =document.getElementById('feedback'),
              messagearea =document.getElementById('messagearea');

          // variables for pruvate chat
          var   message1 =document.getElementById('message1'),
               btn11     =document.getElementById('send1'),
               output1   =document.getElementById('output1'),
               feedback1 =document.getElementById('feedback1'),
               cancel    =document.getElementById('cancel'),
               prichat   =document.getElementById('prichat');


          var receiverid,sendername,receiver;
          /*=============================================================================
          ============================COMMUNITY CHAT ZONE===============================*/
          btn1.addEventListener('click',function(e){
                 // emitting message to server name "chat"
                 //SENDING CHAT MESSAGE
                 e.preventDefault();
                 if(username.value)
                 {
                   socket.emit('new user',{username:username.value},function(data){
                     //console.log("hello");
                                    if(data){
                                           $("#userformarea").hide();
                                           $("#messagearea").show();
                                           //userformarea.style.display = "none";
                                       //messagearea.show();
                                            }

                    });


                    username.value="";
                   }
                   else {
                     alert("please enter your username");
                   }
                });

            /******************* community chat zone ******************************/
            // Emit events to server using below method for particular event
            //emit('nameofmessage','actualmessage')

            btn.addEventListener('click',function(){
               // emitting message to server name "chat"
               //SENDING CHAT MESSAGE
               if(message.value)
               {
                 socket.emit('chat',{
                  message:message.value
                  //username:socket.username
                });
                message.value="";
               }
               else
                 alert("plz enter some text");
            });


            /*************************listening for community chat*************************/
            // function used to show  others that clientX is typing
            message.addEventListener('keypress',function(){
                //console.log(username);
                socket.emit('typing');
            });


            // RECEIVING  chatting MESSAGE
            // listening for message named "chat" ,by clients ,emitted from server
            socket.on('chat',function(data){
              feedback.innerHTML="";
              output.innerHTML +='<p><strong>'+ data.username.username+':</strong>'+data.message+'</p>';
            });

            /******************************************************************************/
            //listening to typiung events :message name"Typing
            socket.on('typing',function(data){
              feedback.innerHTML='<p><em>'+ data.username +' is typing message....</em></p>';
            });
            /************************ printing no. of online users ************************/
               socket.on('get users',function(data){
                 var k=data.length;
                // users.innerHTML="";
                $("ul").empty();
                 var l=0;
                 for(i=0;i<k;i++)
                 {
                   //k=data[i].username;
                   $("ul").append("<li class='users'>"+ data[i].username + "</li>"+"<br>");
                   //users.innerHTML+=data[i].username+'<br>';
                   l=l+1;
                   //console.log(ht[i].username);
                 }
                 onlineusersnum.innerHTML="Online Users ("+l+")";
                // users.innerHTML=ht;
                 //console.log(users.value);
               });

            /******************************************************************************/
                                   /* PRIVATE CHAR ZONE */
                                   //SENDING private CHAT MESSAGE
            $("ul").on("click","li",function(){
              //  console.log(socket.id);
                receiver=$(this).text();
              console.log(receiver);
              $("#mario-chat").hide();
              $("#mario-chat1").show();
            });
            btn11.addEventListener('click',function(){
              console.log(receiver);
               if(message1.value)
               {
                 console.log("msg :"+message1.value);
                 socket.emit('msg_user',{
                   usr:receiver,//whom to send
                  userid:socket.id,//sender
                  msg:message1.value//message
                   });
                message1.value="";
                receiver="";
              //  priwhom.value="";
              }
               else
                 alert("plz enter some text");
            });

            /********************************* privatechat zone**  2nd method  *********************/
            // btn11.addEventListener('click',function(){
            //    if(message1.value)
            //    {
            //      console.log("msg :"+message1.value);
            //      socket.emit('msg_user',{
            //        usr:priwhom.value,//whom to send
            //       userid:socket.id,//sender
            //       msg:message1.value//message
            //        });
            //     message1.value="";
            //     priwhom.value="";
            //   }
            //    else
            //      alert("plz enter some text");
            // });

              // privatechat.addEventListener('click',function(){
              //   $("#mario-chat").hide();
              //   $("#mario-chat1").show();
              // });

            /*=============================================================================*/
            socket.on('msg_user_handle',function(data){
              console.log("received msg: "+data.msg);
              feedback1.innerHTML="";
              output1.innerHTML +='<p><strong>'+ data.username+':</strong>'+data.msg+'</p>';
            });

            cancel.addEventListener('click',function(){
                        $("#mario-chat1").hide();
                        $("#mario-chat").show();
            });



                    $username=mysqli_real_escape_string($con,$_POST['username']);

                        $query = "INSERT INTO logininfo VALUES ('','$username')";
                        $query_run=mysqli_query($con,$query);
                        if(!$query_run)
                        {
                         echo '<script type="text/javascript"> alert("Error")</script>';
                         // header("location:registerpage.php");
                         }
                        else
                         {
                           echo '<script type="text/javascript"> alert("Succesfull")</script>';
                           // header("location:loginpage.php");
                          }
           ?>
