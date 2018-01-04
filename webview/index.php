<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8" />
    <meta name="format-detection" content="telephone=no" />
    <meta name="msapplication-tap-highlight" content="no" />
    <meta name="viewport" content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width" />
    <!-- This is a wide open CSP declaration. To lock this down for production, see below. -->
    <meta http-equiv="Content-Security-Policy" content="default-src * 'unsafe-inline'; style-src 'self' 'unsafe-inline'; media-src *" />

    <link rel="stylesheet" type="text/css" href="css/s_index.css" />
    <link rel="stylesheet" type="text/css" href="css/index.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <title>Login</title>
</head>

<body class="mainbody">
    <h1 class="mainheading">Login</h1>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <h1><img src="img/logomain.png" class="logoimage"></h1>
    </div>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <form>
            <div class="form-group">
                <input type="text" class="form-control" id="username" placeholder="Email Address">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" id="password" placeholder="Password">
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
               <button type="button" id="submit" class="btn btn-default loginbtn">LOGIN</button>

            </div>
        </form>
    </div>


    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="cordova.js"></script>
    <script type="text/javascript" src="js/index.js"></script>
    <script type="text/javascript" src="//appdata.static.appdeck.mobi/js/fastclick.js"></script>
    <script type="text/javascript" src="//appdata.static.appdeck.mobi/js/appdeck.js"></script>
    <script type="text/javascript">
        app.initialize();
    </script>
</body>

</html>



<script>
    $("#submit").click(function() {

        $.ajax({
            url: "api/api-login.php",
            type: "POST",

            data: {
                username: $('#username').val(), password: $('#password').val()
            },
            success: function (data) {
                //document.getElementById("total_items").value=response;
                if (data == '1') {
                    window.location.href = "./table.php";
                }
                else {
                    alert("Username or Password Invalid");
                }
            },
            error: function () {
                alert("Server error.");

            }

        });
    });
</script>