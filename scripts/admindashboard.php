<?php
include_once("authentication.php");
// check if user is logged in
user_logged_in();

// list of allowed users types
$allowed_users = [
    "Administrator",
//    "Head Master",
//    "Teacher",
//    "Finance",
//    "Human Resource",
//    "Book Shop",
//    "Transportation"
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
////////block for number data shown on the dashboard
require_once("connection.php");
try {
    //total current teacher
    $query = "select * from tblteacher";
    $result = $connect->query($query);
    $totalteachercount = $result->rowCount();

    //total current student
    $date = date('Y-m-d');
    $currectyear = explode('-', $date);
    $query1 = "select * from tblstdclass where stdclasspromotiondate like '" . $currectyear[0] . "%'";
    $result1 = $connect->query($query1);
    $totalstudentcount = $result1->rowCount();

    //total current staff
    $query2 = "select * from tblstaff";
    $result2 = $connect->query($query2);
    $totalstaffcount = $result2->rowCount();

    //total current class
    $query3 = "select distinct classid from tblstdclass ";
    $result3 = $connect->query($query3);
    $totalclasscount = $result3->rowCount();


    //total current book purchase
    $query4 = "SELECT sum(bquantity) from tblbookpurchase";
    $result4 = $connect->query($query4);
    $totalbookpurchase = $result4->fetch();

    //total current sold book
    $query5 = "SELECT itemid from tblbooksalesitems";
    $result5 = $connect->query($query5);
    $totalsalesitem = $result5->rowCount();

    //book stock
    $bookstock= $totalbookpurchase[0]-$totalsalesitem;

    //total current fee payment
    $query6 = "select sum(payamount) from tblfeepayment WHERE year(paydate)=year(curdate())";
    $result6 = $connect->query($query6);
    $totalfee = $result6->fetch();

    //total current expenditure
    $query7 = "select sum(exprice*exquantity) from tblexpenditures WHERE year(exdate)=year(curdate())";
    $result7 = $connect->query($query7);
    $otalexpindature = $result7->fetch();

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/admindashboard.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
<div class="MainContainer">
    <div class="navbar">
        <div class="userdata">
            <?php
            require_once("loginPHP.php");

            $unamearray = explode(' ', $_SESSION['thename']);
            $lname = count($unamearray) - 1;
            echo "<img src=../userimages/" . $_SESSION['thephoto'] . " alt='Not found!'>";
            echo "<h2>" . $unamearray[$lname] . "</h2>";
            echo "<h5>" . $_SESSION['thetype'] . "</h5>";
            ?>
        </div>

        <div class="navigations">
            <div class="nav student">
                <a href="student_list.php"><img src="../icons/student.png" alt="">
                    <button>   Student             </button>
                </a>
            </div>
            <div class="nav studentClasses">
                <a href="stdclasssearch.php"><img src="../icons/stdclass.png" alt="">
                    <button>  Student Class </button>
                </a>
            </div>

            <div class="nav teacher">
                <a href="teacher_list.php"><img src="../icons/teacher.png" alt="">
                    <button>  Teacher        </button>
                </a>
            </div>

            <div class="nav department">
                <a href="dep_list.php"> <img src="../icons/department.png" alt="">
                    <button>  Department   </button>
                </a>
            </div>

            <div class="nav subject">
                <a href="subject_list.php"><img src="../icons/subject.png" alt="">
                    <button>  Subject              </button>
                </a>
            </div>

            <div class="nav subject">
                <a href="Book_list.php"><img src="../icons/book2.png" alt="">
                    <button>  Book Shop      </button>
                </a>
            </div>

            <div class="nav exam">
                <a href="examination.php"><img src="../icons/exam.png" alt="">
                    <button>  Examination              </button>
                </a>
            </div>

            <div class="nav result">
                <a href="resultsearch.php"><img src="../icons/result.png" alt="">
                    <button>  Results              </button>
                </a>
            </div>

            <div class="nav staff">
                <a href="staff_list.php"><img src="../icons/staff.png" alt="">
                    <button>  Staff              </button>
                </a>
            </div>

            <div class="nav class">
                <a href="class_list.php"><img src="../icons/class.png" alt="">
                    <button> Teaching Class</button>
                </a>
            </div>

            <div class="nav finance">
                <a href="financesearch.php"><img src="../icons/finance.png" alt="">
                    <button>  Finance       </button>
                </a>
            </div>


            <div class="nav Messages">
                <a href="chatting.php"><img src="../icons/chat.png" alt="">
                    <button>  Messages       </button>
                </a>
            </div>

        </div>
    </div>

    <img class="pointer" src="../icons/arrow.png" alt="">

    <div class="rightpane">
        <div class="mainnavbar">
            <div class="topnavbar">

                <h2><?php echo $_SESSION['thetype'] ?></h2>
                <span>●</span>
                <h3> Dashboard</h3>
                <span>●</span>
                <h3> Khana-e-Noor</h3>
                <span>●</span>
                <?php
                require_once("loginPHP.php");
                echo "<h3 style='margin: 0px 15px  text-transform: uppercase;'>   " . strtoupper($unamearray[$lname]) . "</h3>";
                ?>
                <a href="logout.php">
                    <button>Log out</button>
                </a>
                <a href="user_list.php">
                    <button>Accounts</button>
                </a>
                <h2 class="top_time">TheTime</h2>
                <script src="../js/dateAndtime.js"></script>
                <!-- <img class="kenlogo" src=logo.png alt="user.png"> -->
            </div>
            <div style="text-align: center" class="totals">
                <div>
                    <h1>Classes</h1>
                    <h4><?php echo $totalclasscount ?></h4>
                </div>
                <span>|</span>
                <div>
                    <h1>Teachers</h1>
                    <h4><?php echo $totalteachercount ?></h4>
                </div>
                <span>|</span>
                <div>
                    <h1>Students</h1>
                    <h4><?php echo $totalstudentcount ?></h4>
                </div>
                <span>|</span>

                <div>
                    <h1>Employees</h1>
                    <h4><?php echo $totalstaffcount ?></h4>
                </div>
                <span>|</span>
                <div>
                    <h1>Book Shop Stock</h1>
                    <h4><?php echo $bookstock ?></h4>
                </div>
                <span>|</span>
                <div>
                    <h1>Payed Fee</h1>
                    <h4><?php echo $totalfee[0] ?></h4>
                </div>
                <span>|</span>
                <div>
                    <h1>Consumptions</h1>
                    <h4><?php echo $otalexpindature[0] ?></h4>
                </div>


            </div>
            <div class="graphs">
                <div class="first">
                    <img class="charts" src="../icons/chart%20(1).png" alt="">
                </div>
                <span> </span>
                <div class="second">
                    <img class="charts" src="../icons/chart%20(2).png" alt="">
                </div>
            </div>

            <div class="buttom">
                <div id="mess" style="display: flex; flex-direction: row; justify-content:left; ">

                </div>
                <h3 style="padding: 0px 0px 0px 0px;margin: 0px 10px">Messages:</h3>

                </script>
            </div>
        </div>
    </div>
</div>

<script src="../js/jquery-3.4.1.js" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
            $(".navbar").hover(function () {
                $(".pointer").css('left', '-105px')
                $(".pointer").css('transform', 'rotate(-180deg)')
            }, function () {
                $(".pointer").css('left', '-275px')
                $(".pointer").css('transform', 'rotate(0deg)')

            });
        }
    );
</script>

</body>
</html>

<script>
    function loadXMLDoc() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("mess").innerHTML =
                    this.responseText;
            }
        };
        xhttp.open("GET", "messagePHP.php", true);
        xhttp.send();
    }

    setInterval(function () {
        loadXMLDoc();
        var time = document.querySelector(".top_time");
        time.innerHTML = thetime();
    }, 1000);
    window.onload = loadXMLDoc();
</script>