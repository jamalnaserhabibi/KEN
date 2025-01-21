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
    <link rel="stylesheet" href="../css/dep_list.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/sorttable.js"></script>
    <title>Department list</title>
    <script type="text/javascript">
        function delete_id(id) //delete confirmatation
        {

            if (confirm('Do you want to delete (' + id + ') id?')) {
                window.location.href = 'deletedepartment.php?id=' + id;
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
                <h3>Departments</h3>
                <div class="seek">
                    <input id="myInput" onkeyup="myFunction()" class="srch" type="search" minlength="30" name="srch"
                           placeholder="Search">
                    <img class="srch" src="../icons/srch.png" alt="">
                    <span id="record-count"></span>
                </div>
            </div>
            <div class="data">
                <?php
                require_once("connection.php");

                try {
                    $query = "select * from selectdepartment";
                    $result = $connect->query($query);
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                if (isset($result)) {
                    echo '<table id="myTable" class="sortable table table-bordered table-hover table-striped">';

                    echo '<thead>';
                    echo '<th>Department Name</th>';
                    echo '<th>Total Subject</th>';
                    echo '<th>Curriculum </th>';
                    echo '<th>Total Teacher</th>';
                    echo '<th>Describtions</th>';
                    echo '<th>Operations</th>';
                    echo '</thead>';
                    while ($row = $result->fetch()) {
                        echo '<tr style="text-transform: capitalize;">';
                        echo '<td>' . $row[0] . '</td>';
                        if ($row[2] <= 1) {
                            echo '<td  class="seekbtns">' . $row[2] . ' Subject <a href="searchsubject.php?depname=' . $row[0] . '"><label class="tphoto">Seek</label></a></td>';
                        } else {
                            echo '<td class="seekbtns">' . $row[2] . ' Subjects <a href="searchsubject.php?depname=' . $row[0] . '"><label class="tphoto">Seek</label></a></td>';
                        }

                        echo '<td>' . $row[1] . '</td>';

                        if ($row[3] <= 1) {
                            echo '<td class="seekbtns" >' . $row[3] . ' Teacher  <a href="searchteacher.php?depname=' . $row[0] . '"><label class="tphoto">Seek</label></a></td>';
                        } else {
                            echo '<td class="seekbtns" >' . $row[3] . ' Teachers   <a href="searchteacher.php?depname=' . $row[0] . '"><label class="tphoto">Seek</label></a></td>';
                        }

                        echo '<td>' . $row[4] . '</td>';
                        echo '<td><center><a class="lbtn update" href="updatedepartment.php?depid=' . $row[0] . '&&depname=' . $row[1] . '&&depcurri=' . $row[2] . '&&depremarks=' . $row[3] . '">Update</a>';
                        echo '</a> <a class="lbtn" href="javascript:delete_id(' . $row[0] . ')">Delete</a></center></th>';
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
                        transition: 0.9s cubic-bezier(0.075, 0.82, 0.165, 1);
                    }

                    .lbtn:hover {
                        background-color: rgba(226, 0, 0, 0.5);
                        border: none;
                        text-decoration: none;
                        color: white;
                    }

                    .seekbtns {
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        transition: 0.9s cubic-bezier(0.075, 0.82, 0.165, 1);
                    }

                    .tphoto {
                        margin: -10px 0px;
                        color: #D93935;
                        padding: 2px 10px;
                        border-radius: 4px;
                        border: 1px solid #D93935;
                        transition: 0.9s cubic-bezier(0.075, 0.82, 0.165, 1);
                    }

                    .tphoto:hover {
                        color: white;
                        cursor: pointer;
                        background-color: #D93935;
                    }

                    .update {
                        border: 1px solid #107C41;
                        color: #107C41;
                    }

                    .update:hover {
                        background-color: #107C41;
                        border: none;
                    }

                    @media print {
                        body {
                            background-image: url(../backgrounds/bg3p.png);
                        }

                        .tphoto {
                            display: none;
                        }

                        .buttons, .input {
                            display: none;
                        }

                        .srch {
                            display: none;
                        }


                        /*@page {*/
                        /*    size: landscape;*/
                        /*}*/
                        .maincontaner {
                            text-align: center;
                        }

                        .tablehead {
                            width: 100%;
                        }
                    }
                </style>
                </script>
            </div>
        </div>
        <div class="buttons">
            <a href="createdepartment.php">
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