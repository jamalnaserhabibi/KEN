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
    <link rel="stylesheet" href="../css/financesearch.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finance</title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4>Financial Management Board</h4>
        <div class="main">

            <div class="inputs">
                <div>
                    <label class="head">Select your dealing</label>
                    <button class="btn" onclick="window.location.href='expendituresearch.php'"><label> Expenditure
                            Records </label></button>
                    <button class="btn" onclick="window.location.href='feepayment_list.php'"><label> Student Payment
                            Records </label></button>
                    <button class="btn" onclick="window.location.href='searchfortarofa.php'"><label> Payment Tarofa
                            (bale) </label></button>
                    <button class="btn" onclick="window.location.href='unpaidstudentsearch.php'"><label>Unpaid Students </label></button>
                </div>
                <div class="vector" style="background-color: transparent;width: 40%"><img class="vector"
                                                                                          src="../icons/financevet.png"
                                                                                          alt=""></div>

            </div>
            <button class="bbb" onclick="window.location.href='admindashboard.php'">Dashboard</button>
        </div>

    </center>
</div>
</body>
</html>

