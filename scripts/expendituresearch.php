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
    <link rel="stylesheet" href="../css/expendituresearch.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expenditure Search</title>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">
        </div>
        <h4>Search for Expenditure</h4>
        <form method="post" action="" enctype="multipart/form-data">
            <div class="inputs">
                <div>

                    <div class="contain">
                        <label>Item Name</label>
                        <input class="ttt" type="text" name="expname" placeholder="All">
                    </div>

                    <div class="contain">
                        <label>Executed By</label>
                        <input class="ttt" type="text" name="expby" placeholder="All">
                    </div>

                    <div class="contain">
                        <label>Ordered By</label>
                        <input class="ttt" type="text" name="expfor" placeholder="All">
                    </div>


                </div>
                <div>

                    <div class="contain">
                        <label>Price Greater Than</label>
                        <input class="ttt" type="text" name="explargeprice" placeholder="0">
                    </div>

                    <div class="contain">
                        <label>Price Smaller Than</label>
                        <input class="ttt" type="text" name="expsmallprice" placeholder="Unknown">
                    </div>


                    <div class="contain datediv">
                        <label>Expenditure Date</label>
                        <div style="display: flex;flex-direction: row;">
                            <select class="ttt" name="expyearfrom">
                                <?php
                                require_once("connection.php");
                                try {
                                    $query = "select distinct exdate from tblexpenditures order by exdate ";
                                    $result = $connect->query($query);
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                if (isset($result)) {
                                    while ($row = $result->fetch()) {
                                        echo '<option value="' . $row[0] . '">From:   ' . $row[0] . '</option>';
                                    }
                                }
                                ?>
                            </select><span style="width: 20px"></span>
                            <select class="ttt" name="expyearto">
                                <?php
                                require_once("connection.php");
                                try {
                                    $query = "select distinct exdate from tblexpenditures order by exdate desc ";
                                    $result = $connect->query($query);
                                } catch (PDOException $e) {
                                    echo "Error: " . $e->getMessage();
                                }
                                if (isset($result)) {
                                    while ($row = $result->fetch()) {
                                        echo '<option value="' . $row[0] . '">To:   ' . $row[0] . '</option>';
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                </div>
            </div>
            <a class="bbb beside" href="stdpaymebt.php">Students Fees</a>
            <a class="bbb beside" href="create_expenditure.php">+ Add New Expenditure</a>
            <a class="bbb beside" href="admindashboard.php">Dashboard</a>
            <input class="bbb signin" type="submit" name="btn-submit" value="Search">

            <?php
            if (isset($_POST['btn-submit'])) {
                try {
                    $exname = $_POST['expname'];
                    $exby = $_POST['expby'];
                    $exfrom = $_POST['expfor'];
                    $exminprice = $_POST['explargeprice'];
                    $exmaxprice = $_POST['expsmallprice'];
                    $exstartdate = $_POST['expyearfrom'];
                    $exenddate = $_POST['expyearto'];
                    header('Location: expenditure_list.php?exname=' . $exname . '&exby=' . $exby . '&exfrom=' . $exfrom . '&exminprice=' . $exminprice . '&exmaxprice=' . $exmaxprice . '&exstartdate=' . $exstartdate . '&exenddate=' . $exenddate . '');
                } catch (PDOException $e) {
                    $e->getMessage();
                }
            }
            ?>

        </form>
        <!-- </center>               -->
        <!--        <div class="controls">-->
        <!--            <a href="admindashboard.php">-->
        <!--                <button class="bbb">Dashboard</button>-->
        <!--            </a>-->
        <!--            <a href="subject_list.php">-->
        <!--                <button class="bbb">Subject List</button>-->
        <!--            </a>-->
        <!--            <a href="">-->
        <!--                <button class="bbb">Sample</button>-->
        <!--            </a>-->
        <!--            <a href="login.php">-->
        <!--                <button class="bbb">Log Out</button>-->
        <!--            </a>-->
        <!---->
        <!--        </div>-->
        <!--    </center>-->
</div>
</body>
</html>

