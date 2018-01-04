<?php

include "api/config.php";




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-with,initial-scale=1">
    <title>Kitchen</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/bootstrap-theme.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="kitchenAssets/css/style.css">
    <link rel="stylesheet" href="kitchenAssets/css/responsive.css">
    <link rel="stylesheet" href="kitchenAssets/css/TimeCircles.css">

    <style>
        html, body {
            height: 100%;
            width: 100%;
        }
        html {
            overflow: auto;
        }
    body{

        background-color: black;
        /*background-image: url("1.jpg");*/

        background-size: cover;
    }
    @keyframes flickerAnimation {
        0%   { opacity:1; }
        50%  { opacity:0; }
        100% { opacity:1; }
    }
    @-o-keyframes flickerAnimation{
        0%   { opacity:1; }
        50%  { opacity:0; }
        100% { opacity:1; }
    }
    @-moz-keyframes flickerAnimation{
        0%   { opacity:1; }
        50%  { opacity:0; }
        100% { opacity:1; }
    }
    @-webkit-keyframes flickerAnimation{
        0%   { opacity:1; }
        50%  { opacity:0; }
        100% { opacity:1; }
    }
    .animate-flicker {
        -webkit-animation: flickerAnimation 1s infinite;
        -moz-animation: flickerAnimation 1s infinite;
        -o-animation: flickerAnimation 1s infinite;
        animation: flickerAnimation 1s infinite;
    }
        .border{
            border-style: solid;
            border-width: 2px;
            border-color: white;
        }
    </style>


</head>
<body>
<div class="container-fluid">
    <div class="row" style="color: white;">
    <div id="panelHere">



    </div>
    </div>


</div>
<script type="text/javascript" src="assets/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="assets/js/jquery.countdown.min.js"></script>
<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
<script type="text/javascript">

    // Documentation  http://hilios.github.io/jQuery.countdown/documentation.html
</script>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="kitchenAssets/js/bootstrap.min.js"></script>
<script src="kitchenAssets/js/jquery.ajaxchimp.min.js"></script>
<script src="kitchenAssets/js/TimeCircles.js"></script>
<script src="kitchenAssets/js/jquery.placeholder.js"></script>
<script src="kitchenAssets/js/script.js"></script>
<script>

    $(".count-down").TimeCircles(
        {
            circle_bg_color: "#639094",
            use_background: true,
            bg_width: 1,
            fg_width: 0.02,
            time: {
                Days: { color: "#fefeee", show: false },
                Hours: { color: "#fefeee" },
                Minutes: { color: "#fefeee" },
                Seconds: { color: "#fefeee" }
            }
        }
    );



    $.ajax({
        url:"api/api-updateKitchen.php",
        type:"POST",
        success:function(data) {
            if(data){
                jQuery('#panelHere').html('');
                jQuery('#panelHere').html(data);
                $(".count-down").TimeCircles(
                    {
                        circle_bg_color: "#639094",
                        use_background: true,
                        bg_width: 1,
                        fg_width: 0.045,
                        time: {
                            Days: { color: "#fefeee", show: false },
                            Hours: { color: "#ff4dd2" , show: false},
                            Minutes: { color: "#ffc34d" },
                            Seconds: { color: "#00ffff" }
                        }
                    }
                );
            }
            else{
                alert("No order!");
            }
        },
        error:function(){
            console.log("error");

        }

    });


var refresher = function () {
    $.ajax({
        url:"api/api-updateKitchen.php",
        type:"POST",
        success:function(data) {
            if(data){
                jQuery('#panelHere').html('');
                jQuery('#panelHere').html(data);
                $(".count-down").TimeCircles(
                    {
                        circle_bg_color: "#639094",
                        use_background: true,
                        bg_width: 1,
                        fg_width: 0.045,
                        time: {
                            Days: { color: "#fefeee", show: false },
                            Hours: { color: "#ff4dd2", show: false },
                            Minutes: { color: "#ffc34d" },
                            Seconds: { color: "#00ffff" }
                        }
                    }
                );
            }
            else{
                alert("No order!");
            }
        },
        error:function(){
            console.log("error");

        }

    });
};

var interval = 1000  * 100000; // where X is your every X minutes

    setInterval(refresher, interval);

</script>



</body>
</html>