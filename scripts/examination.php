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
    <link rel="stylesheet" href="../css/results.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Results</title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4>What You Need?</h4>
        <div class="main">
            <div class="inputs">
                <div>
                    <label class="head">Get Results</label>
                    <button class="btn"><label> Resultsheet</label><label>شقه</label></button>
                    <button class="btn" onclick="window.location.href='resultsheetsearch.php'"><label> Blank Student
                            Sheet </label> <label>شقه سفید</label></button>
                    <button class="btn"><label> Detailed Mark Sheet (DMC) </label><label>اطلاعنامه</label></button>
                    <button class="btn"><label> Cambridge Results </label><label>نتایج کامبریج</label></button>
                </div>
                <div>
                    <label class="head">Enter Results</label>
                    <button class="btn" onclick="window.location.href='entermedresultselect.php'"><label> Enter Med-Term
                            Marks </label><label>درج نمرات وسط سال (جهارنیم‌ماه)</label></button>
                    <button class="btn"><label> Enter Final-Term Marks </label><label>درج نمرات اخیر سال
                            (سالانه)</label></button>
                    <button class="btn"><label> Enter By Student </label><label>درج نمرات به اساس شاگرد</label></button>
                    <button class="btn"><label> Enter By Grade </label><label>درج نمرات به اساس درجه</label></button>

                </div>

            </div>
            <button class="bbb promotion">Start Students Annual Promotion</button>
            <button class="bbb" onclick="window.location.href='admindashboard.php'">Dashboard</button>
        </div>

    </center>
</div>
</body>
</html>

