<!DOCTYPE html>

<html>

<head>
    <meta charset="utf-8"/>
    <meta name="format-detection" content="telephone=no"/>
    <meta name="msapplication-tap-highlight" content="no"/>
    <meta name="viewport"
          content="user-scalable=no, initial-scale=1, maximum-scale=1, minimum-scale=1, width=device-width"/>
    <!-- This is a wide open CSP declaration. To lock this down for production, see below. -->
    <meta http-equiv="Content-Security-Policy"
          content="default-src * 'unsafe-inline'; style-src 'self' 'unsafe-inline'; media-src *"/>


    <link rel="stylesheet" type="text/css" href="css/s_index.css"/>
    <link rel="stylesheet" type="text/css" href="css/index.css"/>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
    <title>Table</title>
</head>

<body class="mainbody">

<h1 class="mainheading">Feedback</h1>

<div class="col-md-12 col-sm-12 col-xs-12">
    <h1><img src="img/logomain.png" class="logoimage"></h1>

</div>

<!--fileds-->
<div class="col-md-12 col-sm-12 col-xs-12">

    <form>
        <div class="form-group">

            <input type="text" class="form-control" id="name" placeholder="Customer Name">
        </div>
        <div class="form-group">

            <input type="text" class="form-control" id="number" placeholder="Contact Number">
        </div>

    </form>
</div>

<!--rating star-->
<div class="col-md-12">
    <div class="form-group">
<textarea placeholder="Feedback"></textarea>
    </div>

</div>

<!--feedback textarea-->
<div class="col-md-12"></div>

<!--Buttons-->
<div class="col-md-12"></div>


<!-- Modal -->


<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="cordova.js"></script>
<script type="text/javascript" src="js/index.js"></script>
<script type="text/javascript">
    app.initialize();
</script>
</body>

</html>