<?php
include_once("authentication.php");
// check if user is logged in
user_logged_in();

// list of allowed users types
$allowed_users = [
    "Administrator",
    "Head Master",
    "Teacher",
    "Finance",
    "Human Resource",
    "Book Shop",
    "Transportation"
];
// check if users have access
user_type_is($allowed_users);
?>

<?php
/////////cash removal////////////////////
header("Cache-Control: no-stor, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
////////////////////////////////
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/chatting.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="maincontaner">
    <div class="top">
        <img src="../icons/mareflogo.png" alt="">
        <h2>Khana-e-Noor Private High School</h2>
        <img src="../icons/logo.png" alt="">
    </div>
    <div class="middlecontainer">

        <div class="writingarea">
            <form action="" method="post">
                <h6>Write your message here!</h6>
                <textarea class="msg" name="msgcontent" required=true></textarea>
                <input name="btn-submit" style="width: 100%; margin:10px 0px;" class="bbb" type="submit" value="Send">
                <?php
                try {
                    if (isset($_POST['msgcontent'])) {
                        require_once("connection.php");

                        date_default_timezone_set('Asia/kabul');
                        if ($_POST['msgcontent'] != "") {
                            try {
                                $query = "insert into messages(msender,message,mtime,mdate,uphoto)values(:sender,:msgs,:mtime,:mdate,:uphoto)";
                                $stm = $connect->prepare($query);
                                $stm->bindValue(":sender", $_SESSION['thename']);
                                $stm->bindValue(":msgs", $_POST["msgcontent"]);
                                $time = date("h:i A");
                                $stm->bindValue(":mtime", $time);
                                $date = date("Y/m/d");
                                $stm->bindValue(":mdate", $date);
                                $stm->bindValue(":uphoto", $_SESSION['thephoto']);
                                $stm->execute();
                                echo '<h6 style="color: rgb(0, 162, 255);">Message sent!</h6>';
                            } catch (PDOException $e) {
                                $e->getMessage();
                            }
                        } else {
                            $_POST['msgcontent'] == "";
                            echo '<h6 style="color: rgb(0, 0, 0,0.5);">Write Your Message!</h6>';
                        }
                    } else {
                        echo '<h6 style="color: rgb(0, 0, 0,0.5);">Write Your Message!</h6>';
                    }
                } catch (PDOException $e) {
                    echo $e->getMessage();
                }
                ?>
            </form>
        </div>
        <!-- <img class="no_msg" src="userimages/user.png" alt=""> -->
        <div class="chatarea" id="chats">

        </div>
    </div>
    <div class="controls">
        <a href="admindashboard.php">
            <button class="bbb">Dashboard</button>
        </a>
        <a href="user_list.php">
            <button class="bbb">User Accounts</button>
        </a>
        <form action="deletemsgs.php"><input class="bbb" type="submit" value="Delete Chat History"></form>
        <a href="login.php">
            <button class="bbb">Log Out</button>
        </a>
    </div>
</div>
<script src="../ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    //CK editor scripts
    CKEDITOR.replace('msgcontent');
    // CKEDITOR.config.resize_minHeight=400;
    CKEDITOR.config.removePlugins = 'resize';
    CKEDITOR.config.basicEntities = false;
    CKEDITOR.config.autoParagraph = false;
    // CKEDITOR.config.resize_maxHeight=350;
</script>

</body>

</html>
<script>
    function loadXMLDoc() { //ajax for loading msgs
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("chats").innerHTML =
                    this.responseText;
            }
        };
        xhttp.open("GET", "chattingarea.php", true);
        xhttp.send();
    }

    setInterval(function () {
        loadXMLDoc();
    }, 2000);
    window.onload = loadXMLDoc();
</script>