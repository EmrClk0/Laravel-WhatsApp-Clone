
@extends("layout.appLayout")
@section("css")
<style>
    .chat-sent:hover a i{
        display: inline-block !important;
    }

</style>
@endsection

@section("chat-tittle")
<div class="avatar">
        <img src="{{asset('')}}userDocuments/userpp/{{$user->photo}}" alt="">
</div>
<div class="message-header-content">
        <h4>{{$user->ip}}</h4>
        @php 
            $todayDate = time();
            $lastSeenDate = $user->getLastSeenDetails->updated_at;
            $diffAsSecond = $todayDate - strtotime($lastSeenDate);
            $diffAsMinute = $diffAsSecond/(60);
            $diffAsHour = $diffAsMinute/60;
            $diffAsDay = $diffAsHour/24;
        @endphp

        @if($diffAsMinute < 3)
            <p>Online</p>
        @elseif($diffAsMinute> 3 and $diffAsMinute < 60)
            <p>{{floor($diffAsMinute)}} minutes Ago</p>
        @elseif($diffAsHour>1 and $diffAsHour<24)
            <p>{{floor($diffAsHour)}} Hour Ago </p>
        @elseif($diffAsDay>1 and $diffAsDay<30)
            <p>{{floor($diffAsDay)}} Day Ago </p>
        @else
            <p>Uzun zaman önce</p>



        @endif
</div>
@endsection


@section("message-content")

<div id="fileMenu" style="padding:50px;margin-left:100px;width:900px;height:500px;background-color:gray;position:absolute;border:3px solid red;display:none;z-index:3;">
    <br><br><h2>Lutfen Gondermek Istediğiniz Dosyayı Secin</h2>
    <form action="{{route('sendFileMessage')}}" method="post" enctype="multipart/form-data">
        @csrf 
        <input type="hidden" value="{{base64_encode($chatid)}}" name="chatId">
        <div class="mb-3">
        <input class="form-control" type="file" name="file" accept=".xlm,.xlsx,.zip,.rar,.pdf,.doc,.docx" id="formFile" required>
        </div>
        <button type="submit" class="btn btn-primary">Gönder</button>


    </form>


</div>

<div id="imageMenu" style="padding:50px;margin-left:100px;width:900px;height:500px;background-color:gray;position:absolute;border:3px solid red;display:none;z-index:3;">
    <br><br><h2>Lutfen Gondermek Istediğiniz Görseli Secin</h2>
    <form action="{{route('sendImageMessage')}}" method="post" enctype="multipart/form-data">
        @csrf 
        <input type="hidden" value="{{base64_encode($chatid)}}" name="chatId">
        <div class="mb-3">
        <input class="form-control" type="file" name="image" accept=".jpg,.jpeg,.gif,.png," id="formFile" required>
        </div>
        <button type="submit" class="btn btn-primary">Gönder</button>


    </form>


</div>






    @if(count($chatMessages)!=0)

        @foreach($chatMessages as $chatMessage)
    
            @switch($chatMessage->message_type)
                
                @case("text")

                    @if($chatMessage->from == Auth::user()->id)
                        

                        
                    
                        <p style="display: block; word-break: break-word; max-width:100%;"class="chat-message chat-sent">{{$chatMessage->message}} <span class='chat-timestamp'>{{date_format($chatMessage->created_at,"H:i")}} 
                        @if($chatMessage->seen==0)
                        <i class="fa-sharp fa-solid fa-check"></i>

                        @else
                        <i class="fa-sharp fa-solid fa-check-double"></i>

                        @endif
                        <a href="{{route('deleteMessage',
                            ['chatId'=>base64_encode($chatMessage->chat_id),
                            'messageId'=>base64_encode($chatMessage->id)])}}"><i style="display:none"class="fa-solid fa-x" id="fa-x"></i></a></span></p>
                        
                    @else
                        <p style="display: block; word-break: break-word; max-width:100%;" class="chat-message">{{$chatMessage->message}}<span class='chat-timestamp'>{{date_format($chatMessage->created_at,"H:i")}} </span></p>
                        
                    @endif

                    @break


                @case("image")


                    @if($chatMessage->from == Auth::user()->id)
                            <p class="chat-message chat-sent"><a href="{{asset('')}}userDocuments/userChatImages/{{$chatMessage->message}}" download><img height="360" width="270" src="{{asset('')}}userDocuments/userChatImages/{{$chatMessage->message}}" alt=""></a> <span class='chat-timestamp'>{{date_format($chatMessage->created_at,"H:i")}} 
                            @if($chatMessage->seen==0)
                            <i class="fa-sharp fa-solid fa-check"></i>

                            @else
                            <i class="fa-sharp fa-solid fa-check-double"></i>

                            @endif
                            
                        
                    @else
                        <p class="chat-message"><a href="{{asset('')}}userDocuments/userChatImages/{{$chatMessage->message}}" download><img height="360" width="270" src="{{asset('')}}userDocuments/userChatImages/{{$chatMessage->message}}" alt=""></a><span class='chat-timestamp'>{{date_format($chatMessage->created_at,"H:i")}} </span></p>
                        
                    @endif
                    @break


                @case("file")


                    @if($chatMessage->from == Auth::user()->id)
                                <p class="chat-message chat-sent"> <a href="{{asset('')}}userDocuments/userFiles/{{$chatMessage->message}}" download><button class="btn"><i class="fa fa-download"></i> Download {{$chatMessage->message}}</button> </a><span class='chat-timestamp'>{{date_format($chatMessage->created_at,"H:i")}} 
                            @if($chatMessage->seen==0)
                                <i class="fa-sharp fa-solid fa-check"></i>

                            @else
                                <i class="fa-sharp fa-solid fa-check-double"></i>

                            @endif
                            
                        
                    @else
                        <p class="chat-message"><a href="{{asset('')}}userDocuments/userFiles/{{$chatMessage->message}}" download><button class="btn"><i class="fa fa-download"></i> Download {{$chatMessage->message}}</button> </a> <span class='chat-timestamp'>{{date_format($chatMessage->created_at,"H:i")}} </span></p>
                        
                    @endif
                    @break


                @default
                
            @endswitch






        @endforeach
        <div class="lastmessagePos" id="lastmessagePos"></div>
        <a href="#lastmessagePos" id="lastmessage"></a>
    @endif

@endsection

@section("message-footer")

<img  src="{{asset('')}}app/svg/smile.svg" alt=" " onclick="openImageUploadMenu()">
<img  src="{{asset('')}}app/svg/paper-clip.svg" alt="" onclick="openFileUploadMenu()">





    
<div style="width:100%">  
<form action="{{route('sendTextMessage')}}" method="post" style="display:flex; flex-direction:row; align-items:center;">
@csrf

    <input style="display:flex;" type="text" placeholder="Type a message" name="chatMessage">
    <input type="hidden" value="{{base64_encode($chatid)}}" name="chatId">
    <button type="submit" class="btn btn-primary">Gönder</button>
    <img src="{{asset('')}}app/svg/microphone.svg" alt="">
</form></div>








@endsection




@section("js")
<script>

    let lastmessagePos = document.getElementById("lastmessage");
    lastmessagePos.click();
    
        
    function openFileUploadMenu(){
        
        let display = document.getElementById("fileMenu").style.display;
        if(display=="none"){
            document.getElementById("fileMenu").style.display="block";

        }else{
            document.getElementById("fileMenu").style.display="none";
        }
        
    }


    function openImageUploadMenu(){
        let display = document.getElementById("imageMenu").style.display;
        if(display=="none"){
            document.getElementById("imageMenu").style.display="block";

        }else{
            document.getElementById("imageMenu").style.display="none";
        }

    }



</script>

@endsection

           
      