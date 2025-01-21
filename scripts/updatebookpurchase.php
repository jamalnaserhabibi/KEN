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
if (isset($_GET['bpid'])) {
    $bpid = $_GET['bpid'];
    $bname = $_GET['bname'];
    try {
        $query = "select * from tblbookpurchase where bpid='$bpid'";
        $result = $connect->query($query);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    while ($row = $result->fetch()) {
        $bid = $row[1];
        $buniteprice = $row[2];
        $bquantity = $row[3];
        $bpfrom = $row[4];
        $bpto = $row[5];
        $bpdate = $row[6];
        $bpremark = $row[7];
    }
} else {
    echo 'Cant get data';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/updatebookpurchase.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update <?php echo $bname ?> Book</title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4>Update <?php echo $bname ?> Book</h4>
        <div class="inputs">
            <form method="post" action="" enctype="multipart/form-data">
                <select name="bname">
                    <?php
                    try {
                        $query = "select * from tblbook";
                        $result = $connect->query($query);
                    } catch (PDOException $e) {
                        echo "Error: " . $e->getMessage();
                    }
                    while ($row = $result->fetch()) {
                        echo '<option value="' . $row[0] . '"';
                        if ($row[0] == $bid) echo ' selected';
                        echo '>' . $row[1] . '</option>';
                    }
                    ?>
                </select><br>
                <input value="<?php echo $buniteprice ?>" class="ttt small" step="10" type="number" max="10000" min="10"
                       name="bpuniteprice" placeholder="Unite Price" required="">
                <input value="<?php echo $bquantity ?>" class="ttt small" step="1" type="number" max="10000" min="1"
                       name="bpquantity" placeholder="Quantity" required=""><br>
                <input value="<?php echo $bpfrom ?>" class="ttt small" type="text" name="bpfrom"
                       placeholder="Purchase Address" required="">
                <input value="<?php echo $bpto ?>" class="ttt small" type="text" name="bpto" placeholder="Purchased By"
                       required=""><br>
                <input value="<?php echo $bpdate ?>" class="ttt" type="date" name="bpdate" placeholder="Purchase Date"
                       onfocus="(this.type='date')" required="">
                <input value="<?php echo $bpremark ?>" class="ttt" type="text" maxlength="50" name="bpremark"
                       placeholder="Remarks"><br>
                <?php
                if (isset($_POST['btn-submit'])) {
                    require("connection.php");
                    try {
                        $query = "UPDATE `tblbookpurchase` SET `bid`=:bname, `bunitprice`=:bpuniteprice ,`bquantity`=:bpquantity, `bpfrom`=:bpfrom,`bpto`=:bpto,`bpdate`=:bpdate,`bpremark`=:bpremark  WHERE bpid=:bid";
                        $stm = $connect->prepare($query);
                        $stm->bindValue(":bid", $bpid);
                        $stm->bindValue(":bname", $_POST['bname']);
                        $stm->bindValue(":bpuniteprice", $_POST['bpuniteprice']);
                        $stm->bindValue(":bpquantity", $_POST['bpquantity']);
                        $stm->bindValue(":bpfrom", $_POST['bpfrom']);
                        $stm->bindValue(":bpto", $_POST['bpto']);
                        $stm->bindValue(":bpdate", $_POST['bpdate']);
                        $stm->bindValue(":bpremark", $_POST['bpremark']);
                        $stm->execute();
                        header("location: book_list.php");
                    } catch (PDOException $e) {
                        $e->getMessage();
                    }
                }

                ?>
        </div>
        <input style="width:500px;" class="bbb signin" type="submit" name="btn-submit" value="Update !"><br>
        </form>
        <div class="controls">
            <a href="book_purchase_list.php">
                <button class="bbb">< Back</button>
            </a>
            <a href="admindashboard.php">
                <button class="bbb">Dashboard</button>
            </a>
            <a href="booksales.php">
                <button class="bbb">Sales List</button>
            </a>
            <a href="bookpurchase">
                <button class="bbb">Purchase List</button>
            </a>

        </div>
    </center>
</div>
</body>
</html>