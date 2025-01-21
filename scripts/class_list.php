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
    <link rel="stylesheet" href="../css/class_list.css">
    <link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class List</title>
    <script src="../js/sorttable.js"></script>
    <script type="text/javascript">
        function delete_id(id) //delete confirmatation
        {

            if (confirm('Do you want to delete This Class ID:  (' + id + ')?')) {
                window.location.href = 'deleteclass.php?cid=' + id;
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
                <h3 style="text-align: left;">Class's information</h3>
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
                //
                try {
                    $query = "SELECT selectclass.*, coalesce(stdcount.count, 0) count FROM selectclass left join (select classid, count(*) count from tblstdclass group by classid) stdcount
                   on stdcount.classid = selectclass.cid where gname !='0' ";
                    $result = $connect->query($query);
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                if (isset($result)) {
                    echo '<table id="myTable" class="sortable table  table-bordered table-hover table-striped ">';
                    echo '<thead >';
                    echo '<th class="btnprint"></th>';
                    echo '<th>Class Id</th>';
                    echo '<th>Class Name</th>';
                    echo '<th>Class Gender </th>';
                    echo '<th>Class Location </th>';
                    echo '<th>Capacity</th>';
                    echo '<th>Class Year</th>';
                    echo '<th>Std COunt</th>';
                    echo '<th class="oper">Operations</th>';
                    echo '</thead >';
                    while ($row = $result->fetch()) {
                        echo '<tr style="text-transform: capitalize;">';
                        echo '<td class="btnprint"><a href="stdclass_list.php?cname=' . $row[1] . '&&stdname=' . '&&cyear=' . $row[6] . '&&gname=' . $row[3] . '&&cgender=' . $row[2] . '&&rootid=' . '"><img class="btnprint" src="../icons/view.png"></a></td>';
                        echo '<td>' . $row[0] . '</td>';
                        if ($row[3] === '1') {
                            echo '<td>' . $row[3] . 'st ' . $row[1] . '</td>';
                        } elseif ($row[3] === '2') {
                            echo '<td>' . $row[3] . 'nd ' . $row[1] . '</td>';
                        } elseif ($row[3] === '3') {
                            echo '<td>' . $row[3] . 'rd ' . $row[1] . '</td>';
                        } elseif ($row[3] > 3) {
                            echo '<td>' . $row[3] . 'th ' . $row[1] . '</td>';
                        } else {
                            echo '<td>' . $row[3] . ' (' . $row[1] . ')</td>';
                        }
                        echo '<td>' . $row[2] . '</td>';
                        echo '<td>' . $row[4] . '</td>';
                        echo '<td>' . $row[5] . '</td>';
                        echo '<td>' . $row[6] . '</td>';
                        $cname = $row['cname'];
                        $cgender = $row['cgender'];
                        $gname = $row['gname'];
                        $cyear = $row['ccreatedate'];
                        $label = ($row[9] > 1) ? "Students" : "Student";
                        $disabled = ($row[9] > 0) ? "" : "disabled = '' ";

                        echo '<td class="seekbtns" >' . $row[9] . ' ' . $label . ' <a href="stdclass_list.php?stdname=&&rootid=&&cname=' . $cname . '&&cgender=' . $cgender . '&&gname=' . $gname . '&&cyear=' . $cyear . '"><label class="tphoto">Seek</label></a></td>';
                        echo '<td class="oper"><center><a class="lbtn update" href="updateclass.php?cid=' . $row[0] . '&&cname=' . $row[1] . '&&cgender=' . $row[2] . '&&cgradeid=' . $row[3] . '&&clocation=' . $row[4] . '&&ccapacity=' . $row[5] . '&&ccreateyear=' . $row[6] . '">Update</a>';
                        echo '<a class="lbtn" href="javascript:delete_id(' . $row[0] . ')">Delete</a></center></td>';
                        echo '  </tr>';
                    }
                    echo '</table>';
                }
                ?>
                <!-- style of delete and update btns -->
                <style>
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

                    @media print {
                        .btnprint, .oper {
                            display: none;
                        }

                        .buttons, srch {
                            display: none;
                        }

                        html {
                            zoom: 80%;

                        }


                        .tablehead input, .srch {
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

                    .btnprint {
                        height: 40px;
                        margin: -20px;
                    }

                    .btnprint:hover {
                        cursor: pointer;
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
            <a href="createclass.php">
                <button>Add New +</button>
            </a>
            <a href="admindashboard.php">
                <button>Dashboard</button>
            </a>
            <a href="grade_list.php">
                <button>Grade</button>
            </a>
            <a href="">
                <button onclick="window.print()">Print</button>
            </a>
        </div>
    </center>
</div>
<script src="../js/search.js"></script>
</body>
</html>