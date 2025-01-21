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
    <link rel="stylesheet" href="../css/subject_list.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/sorttable.js"></script>
    <title>Subjects</title>
    <script type="text/javascript">
        function delete_id(id) //delete confirmatation
        {
            if (confirm('Do you want to delete (' + id + ') id?')) {
                window.location.href = 'deletesubject.php?sid=' + id;
            }
        }
    </script>
</head>
<body>
<div class="maincontaner">
    <center>
        <div class="top">
            <img src="../icons/mareflogo.png" alt="">
            <!-- <h3>Islamic Republic of Afghanistan</h3> -->
            <h2>Khana-e-Noor Private High School</h2>
            <img src="../icons/logo.png" alt="">

        </div>
        <div class="tbldepartments">
            <div class="tablehead">
                <h3 style="text-align: left;">Subject's information</h3>
                <div class="seek">
                    <input id="myInput" onkeyup="myFunction()" class="srch" type="search" minlength="30" name="srch"
                           placeholder="Search">
                    <img src="../icons/srch.png" alt="">
                    <span id="record-count"></span>
                </div>
            </div>
            <div class="data">
                <?php
                require_once("connection.php");
                //
                try {
                    $query = "SELECT * FROM selectsubject ";
                    $result = $connect->query($query);
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                if (isset($result)) {
                    echo '<table id="myTable" class="sortable table table-bordered table-hover table-striped ">';
                    echo '<thead >';
                    echo '<th>Subject Id</th>';
                    echo '<th>Subject Name</th>';
                    echo '<th>Subject Department </th>';
                    echo '<th>Subject Grade </th>';
                    echo '<th>Describtions</th>';
                    echo '<th>Operations</th>';
                    echo '</thead >';
                    while ($row = $result->fetch()) {
                        echo '<tr style="text-transform: capitalize;">';
                        echo '<td>' . $row[0] . '</th>';
                        echo '<td>' . $row[1] . '</th>';
                        echo '<td>' . $row[2] . '</th>';
                        if ($row[3] == 1) {
                            echo '<td>' . $row[3] . 'st Grade</th>';
                        } elseif ($row[3] == 2) {
                            echo '<td>' . $row[3] . 'nd Grade</th>';
                        } elseif ($row[3] == 3) {
                            echo '<td>' . $row[3] . 'rd Grade</th>';
                        } elseif ($row[3] > 3) {
                            echo '<td>' . $row[3] . 'th Grade</th>';
                        } else {
                            echo '<td>' . $row[3] . '</th>';
                        }
                        echo '<td>' . $row[4] . '</th>';
                        echo '<td><center><a class="lbtn update" href="updatesubject.php?subid=' . $row[0] . '&sname=' . $row[1] . '&subdep=' . $row[2] . '&subgradeid=' . $row[3] . '&subremarks=' . $row[4] . '">Update</a>';
                        echo '<a class="lbtn" href="javascript:delete_id(' . $row[0] . ')">Delete</a></center></td>';
                        echo '  </tr>';
                    }
                    echo '</table>';
                }
                ?>
                <!-- style of delete and update btns -->
                <style>
                    .lbtn {
                        margin-right: 10px;
                        border: 1px solid rgba(226, 0, 0, 0.74);
                        color: red;
                        padding: 8px 20px;
                        border-radius: 10px;
                    }

                    .lbtn:hover {
                        background-color: rgba(226, 0, 0, 0.5);
                        border: none;
                        text-decoration: none;
                        color: white;
                    }

                    .update {

                        border: 1px solid #107C41;
                        color: #107C41;
                    }

                    .update:hover {
                        background-color: #107C41;
                        border: none;
                    }
                </style>
                </script>
            </div>
        </div>
        <div class="buttons">
            <a href="creatingsubject.php">
                <button>Add New +</button>
            </a>
            <a href="admindashboard.php">
                <button>Dashboard</button>
            </a>
            <a href="">
                <button>Sample</button>
            </a>
            <a href="login.php">
                <button>Log Out</button>
            </a>
        </div>
    </center>
</div>
<script src="../js/search.js"></script>
</body>
</html>