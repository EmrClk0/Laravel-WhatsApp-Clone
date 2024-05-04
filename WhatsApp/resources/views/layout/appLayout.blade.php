
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('')}}asset/css/styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <link rel="shortcut icon" type="image/jpg" href="{{asset('')}}app/images/icon/whatsapp.png" />
    <title>WhatsApp</title>
    @yield("css")
    <style>
        .formdiv{
            width=100%;
        }
        .sidebar-chat:hover .fa-trash{
            display: inline-block !important;

        }
        .sidebar-chat, .sidebar-chat #firstOne {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            padding: 10px 12px;
            width: 100%;
            flex-flow: nowrap;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="header">
            <div class="avatar">
                <img src="{{asset('')}}userDocuments/userpp/{{Auth::user()->photo}}" alt="">
            </div>
                <h2 style="color:red">{{Auth::user()->ip}}</h2>
            <div class="chat-header-right">
                <img src="{{asset('')}}app/svg/circle-notch-solid.svg" alt="">
                <img onclick="openCloseFriendsMenu()"  src="{{asset('')}}app/svg/chat.svg" alt="">
                <img src="{{asset('')}}app/svg/more.svg" alt="">
            </div>
        </div>
        <div class="sidebar-search">
            <div class="sidebar-search-container">
                
                <form action="{{route('addFriend')}}" method="post">
                    @csrf
                    <input style="width:300px;" name="ip" type="text" placeholder="ADD FRIEND (PHONE NUMBER WITH AREA CODE)">
                    <button type="submit" class="btn btn-primary">Ekle</button>
                </form>
            </div>
        </div>
        <div class="sidebar-chats">

            <div id="friendsMenu" style="padding:50px;margin-top:-50px;width:580px;height:100%;background-color:LightSalmon;position:absolute;display:none;z-index:3;">
                    <div class="sidebar-chat">
                            <div class="chat-avatar">
                                <img src="{{asset('')}}userDocuments/userpp/friends.jpg" alt="">
                            </div>
                            <div class="chat-info">
                                <h1 style="color:red">FRİENDS</h1> 
                            </div>
                        </div>
            
            @php 
                use App\Models\LastSeen;
                LastSeen::where("user_id",Auth::user()->id)->update(["user_id"=>Auth::user()->id]);
            @endphp

            @if(isset($friends))
                        
                    
                    @foreach($friends as $friend)
                        
                        @if(Auth::user()->id != $friend->user1_id)
                            @php
                                $user = $friend->getUser1;
                            @endphp
                        @elseif(Auth::user()->id != $friend->user2_id)
                            @php 
                                $user = $friend->getUser2;
                            @endphp
                        @endif

                        <a href="{{route('newChat',$user->id)}}">
                        <div class="sidebar-chat">
                            <div class="chat-avatar">
                                <img src="{{asset('')}}userDocuments/userpp/{{$user->photo}}" alt="">
                            </div>
                            <div class="chat-info">
                                <h4>{{$user->ip}}</h4> 
                            </div>

                        </div>
                        </a>

                        

                    @endforeach


                @endif
            </div>
            @if(isset($chats))
                @foreach($chats as $chat)
                    @if($chat->user1_id==Auth::user()->id && $chat->user1_active ==1 ) 
                        @php 
                        $user = $chat->getUser2;
                        @endphp
                    @elseif($chat->user2_id==Auth::user()->id && $chat->user2_active ==1 )
                        @php 
                        $user = $chat->getUser1;
                        @endphp
                    @endif

                    @if(isset($user))
                        
                            <div class="sidebar-chat">
                                <a id="firstOne"href="{{route('chatMessages',base64_encode($chat->id))}}">
                                
                                    <div style="width:50px;"class="chat-avatar">
                                        <img src="{{asset('')}}userDocuments/userpp/{{$user->photo}}" alt="">
                                    </div>
                                    <div class="chat-info">
                                        <h4>{{$user->ip}}</h4>
                                        @if(count($chat->getMessages)!=0)
                                        
                                            @if($chat->getMessages[0]->seen==0)
                                            <i class="fa-sharp fa-solid fa-check"></i>

                                            @else
                                            <i class="fa-sharp fa-solid fa-check-double"></i>

                                            @endif
                                            
                                            @if(strlen($chat->getMessages[0]->message)>40)
                                                @php 
                                                    $subtext = substr($chat->getMessages[0]->message,0,40);
                                                    $subtext.="...";
                                                @endphp
                                                {{$subtext}}
                                            @else
                                                {{$chat->getMessages[0]->message}}
                                            @endif


                                            
                                        @endif
                                    </div>

                                    @if(count($chat->getMessages)!=0)
                                        <div class="time">
                                            @php 
                                                $messageDate = $chat->getMessages[0]->created_at;
                                                $todayDate = time();
                                                $diff = $todayDate - strtotime($messageDate);
                                                $days=$diff/86400;

                                                
                                            @endphp

                                            @if($days<1)
                                    
                                                <p>Today {{date_format($messageDate,"H:i")}}</p>
                                            @elseif($days>"1" and $days<"2")
                                                <p>Yesterday {{date_format($messageDate,"H:i")}}</p>
                                            @elseif($days>2 and $days<7)
                                                <p> {{date('l', strtotime($messageDate))}} {{date_format($messageDate,"H:i")}}</p>
                                            @elseif($days>7 and $days<30)
                                                <p>BU AY {{date_format($messageDate,"m/d")}}</p>
                                            @elseif($days>30)
                                                <p>uzun zaman{{date_format($messageDate,"m/d")}}</p>
                                                
                                            @endif
                                        
                                        
                                        </div>
                                            
                                    @endif 
                                </a><a href="{{route('chatDisactive',base64_encode($chat->id))}}"><i style="display:none" class="fa-sharp fa-solid fa-trash"></i></a>


                                
                            
                                
                            
                            </div>
                        
                        @php 
                        $user = NULL;
                        @endphp
                    @endif




                @endforeach
            @endif
            
        </div>
    </div>
    <div class="message-container">
        <div class="header">
            <div class="chat-title">
                
                @yield("chat-tittle")
            </div>
            <div class="chat-header-right">
               <img src="{{asset('')}}app/svg/search-solid.svg" alt="">
                <img src="{{asset('')}}app/svg/more.svg" alt="">
            </div>
        </div>
        <div class="message-content"> 
                @yield("message-content")
        </div>
        <div class="message-footer">
            @yield("message-footer")
            
        </div>
    </div>
    @yield("js")
    <script>
        function openCloseFriendsMenu(){
            let display = document.getElementById("friendsMenu").style.display;
            if(display == "none"){
                document.getElementById("friendsMenu").style.display="block";
            }else{
                document.getElementById("friendsMenu").style.display="none";
            }

        }

    </script>
</body>

</html>
