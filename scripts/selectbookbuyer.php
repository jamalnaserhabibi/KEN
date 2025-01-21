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
    <link rel="stylesheet" href="../css/selectbookbuyer.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Sale</title>
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
        <form method="post" action="" enctype="multipart/form-data">
            <div class="inputs">
                <img style="width: 500px" src="../icons/financevet.png" alt="">
                <div class="contain">
                    <label>Select Buyer</label>
                    <select class="ttt" name="buyer">
                        <option>Student</option>
                        <option>Teacher</option>
                        <option>Other</option>
                    </select>
                </div>
            </div>
            <a class="bbb beside" href="admindashboard.php">Dashboard</a>
            <input class="bbb signin" type="submit" name="btn-submit" value="Search For Buyer Info">
            <?php
            if (isset($_POST['btn-submit'])) {
                try {
                    $buyer = $_POST['buyer'];
                    header('Location: stdbookbuyer.php?buyer=' . $buyer . '');
                } catch (PDOException $e) {
                    $e->getMessage();
                }
            }
            ?>
        </form>
</div>
</body>
</html>

