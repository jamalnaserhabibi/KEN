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


<?php
require_once('connection.php');
if (isset($_GET['exid'])) {
    $exid = $_GET['exid'];
    $query = "select * from tblexpenditures where exid='$exid'";
    $result = $connect->query($query);

    while ($row = $result->fetch()) {
        $exname = $row['exname'];
        $exby = $row['exby'];
        $exfor = $row['exfor'];
        $exquantity = $row['exquantity'];
        $exprice = $row['exprice'];
        $exdate = $row['exdate'];
        $exremarks = $row['exremarks'];
    }
} else {
    echo 'Cant get data';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/update_expenditure.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update <?php echo $exname ?> </title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4>Update <?php echo $exname ?></h4>
        <div class="inputs">
            <form method="post" action="" enctype="multipart/form-data">
                <input value="<?php echo $exname ?>" class="ttt" type="text" maxlength="50" name="exname"
                       placeholder="Item Description"><br>
                <input value="<?php echo $exby ?>" class="ttt small" type="text" maxlength="30" name="exby"
                       placeholder="Executed By" required="">
                <input value="<?php echo $exfor ?>" class="ttt small" type="text" maxlength="30" name="exfor"
                       placeholder="Ordered By" required=""><br>
                <input value="<?php echo $exquantity ?>" class="ttt small" type="number" name="exquantity"
                       placeholder="Item Quantity" required="">
                <input value="<?php echo $exprice ?>" class="ttt small" type="number" name="exprice"
                       placeholder="Unite Price" required=""><br>
                <input value="<?php echo $exdate ?>" class="ttt" type="text" name="exdate" placeholder="Execute Date"
                       onfocus="(this.type='date')" required=""><br>
                <input value="<?php echo $exremarks ?>" class="ttt" type="text" maxlength="50" name="exremarks"
                       placeholder="Remarks"><br>
                <?php
                if (isset($_POST['exname'])) {
                    require("connection.php");
                    if (isset($_POST['btn-submit'])) {
                        try {
                            $query = "UPDATE `tblexpenditures` SET `exname`=:exname,`exby`=:exby,`exfor`=:exfor,`exquantity`=:exquantity,`exprice`=:exprice,`exdate`=:exdate,`exremarks`=:exremarks WHERE exid=:exid";
                            $stm = $connect->prepare($query);
                            $stm->bindValue(":exid", $exid);
                            $stm->bindValue(":exname", $_POST['exname']);
                            $stm->bindValue(':exby', $_POST['exby']);
                            $stm->bindValue(':exfor', $_POST['exfor']);
                            $stm->bindValue(':exquantity', $_POST['exquantity']);
                            $stm->bindValue(':exprice', $_POST['exprice']);
                            $stm->bindValue(':exdate', $_POST['exdate']);
                            $stm->bindValue(':exremarks', $_POST['exremarks']);
                            $stm->execute();
                            header("location: expenditure_list.php");
                        } catch (PDOException $e) {
                            $e->getMessage();
                        }
                    }
                }
                ?>
        </div>
        <input style="width:500px;" class="bbb signin" type="submit" name="btn-submit" value="Save !"><br>
        </form>
        <div class="controls">
            <a href="book_purchase_list.php">
                <button class="bbb">< Back</button>
            </a>
            <a href="admindashboard.php">
                <button class="bbb">Dashboard</button>
            </a>
            <a href="expenditure_list.php">
                <button class="bbb">Expenditure List</button>
            </a>
            <a href="booksales.php">
                <button class="bbb">Sales List</button>
            </a>


        </div>
    </center>
</div>
</body>
</html>