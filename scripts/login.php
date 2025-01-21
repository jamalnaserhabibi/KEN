<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/login.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<img id="picture" class="banner" src="../banners/a (2).jpg" alt=""><!-- jQuery Code -->
<!-- // Jquey Code  -->
<script src="../js/jquery-3.4.1.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".login_container").hover(function () {
            $(".banner").animate({height: '70vh'}, 1)
            $(".first_container").css('background-image', 'linear-gradient(to right, rgba(0, 0, 255, 0.175), rgba(255, 255, 255, 0))')
            $(".first_container").css('backdrop-filter', 'blur(5px)')
            $(".login_container").css('backdrop-filter', 'blur(5px)')
            $(".datetime").css('top', '74%').css('left', '105px')
            //banner changer start
            var images = [
                "../banners/a (1).jpg",
                "../banners/a (2).jpg",
                "../banners/a (3).jpg",
                "../banners/a (4).jpg",
                "../banners/a (5).jpg",
                "../banners/a (6).jpg",
                "../banners/a (7).jpg",
                "../banners/a (8).jpg",
                "../banners/a (9).jpg",
                "../banners/a (10).jpg",
                "../banners/a (11).jpg",
                "../banners/a (12).jpg",
                "../banners/a (13).jpg",
                "../banners/a (14).jpg",
                "../banners/a (15).jpg",
                "../banners/a (16).jpg",
                "../banners/a (17).jpg",
                "../banners/a (18).jpg",
                "../banners/a (19).jpg",
                "../banners/a (20).jpg",
                "../banners/a (21).jpg",
                "../banners/a (22).jpg",
                "../banners/a (23).jpg",
                "../banners/a (24).jpg",
                "../banners/a (25).jpg",
                "../banners/a (26).jpg",
                "../banners/a (27).jpg",
                "../banners/a (28).jpg",
                "../banners/a (29).jpg",
                "../banners/a (30).jpg",
                "../banners/a (31).jpg",
                "../banners/a (32).jpg",
                "../banners/a (33).jpg",
                "../banners/a (34).jpg",
                "../banners/a (35).jpg",
                "../banners/a (36).jpg",
                "../banners/a (37).jpg",
                "../banners/a (38).jpg",
            ];
            var pic = Math.floor((Math.random() * 37) + 1);
            var imgg = document.getElementById("picture");
            imgg.src = images[pic];
            //  alert(pic)
            //banner changer end   
            $(".banner").css('top', '40px').css('left', '80px')
        }, function () {
            $(".first_container").css('background-image', 'linear-gradient(to right, rgba(255, 0, 0, 0.0), rgba(255, 255, 255, 0))')
            $(".first_container").css('backdrop-filter', 'blur(0px)')
            $(".login_container").css('backdrop-filter', 'blur(0px)')
            $(".datetime").css('top', '40px').css('left', '50px')
            $(".banner").animate({height: '0px'}, 1)
        }, function () {
        });
    });

    function forgetbtn() {
        alert("Please contact with the Admin or the System analyst!")
    }
</script>

<div class="datetime" id="dateandtime"></div>
<script src="../js/dateAndtime.js"></script>
<div class="first_container">
    <div class="login_container">
        <h1>Login To the System</h1>
        <img src="../icons/logo.png" alt="">
        <center>
            <form method="post">
                <input name="uname" maxlength="25" class="data" type="text" placeholder="Username"> <br>
                <input name="upass" class="data" type="password" placeholder="Password"><br>
                <?php
                require_once("loginPHP.php");
                ?>
                <input class="loginbtn" type="submit" value="Login"><br>
                <input onclick="forgetbtn()" class="forgotbtn" type="button" value="Forgot Username or Password">
            </form>

        </center>
    </div>
</div>
<script> function loadXMLDoc() { //time interval
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("dateandtime").innerHTML =
                    this.responseText;
            }
        };
        xhttp.open("GET", "dateandtime.php", true);
        xhttp.send();
    }

    setInterval(function () {
        loadXMLDoc();
    }, 1000);
    window.onload = loadXMLDoc();
</script>

</body>
</html>
