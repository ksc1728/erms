<?php
session_start();
error_reporting(0);
include('includes/config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Exam and Result Management System</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>
<body>
<div class="main-wrapper">
    <div class="content-wrapper">
        <div class="content-container">
            <div class="main-page">
                <div class="container-fluid">
                    <div class="row page-title-div">
                        <div class="col-md-12">
                            <h2 class="title" align="center">Exam and Result Management System</h2>
                        </div>
                    </div>
                </div>
                <section class="section">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-8 col-md-offset-2">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <?php
                                            // Retrieve student data and display results
                                            if(isset($_POST['rollid']) && isset($_POST['class'])) {
                                                $rollid = $_POST['rollid'];
                                                $classid = $_POST['class'];
                                                $_SESSION['rollid'] = $rollid;
                                                $_SESSION['classid'] = $classid;

                                                // Fetch student data
                                                $query = "SELECT tblstudents.StudentName, tblstudents.RollId, tblclasses.ClassName, tblclasses.Slot 
                                                          FROM tblstudents 
                                                          JOIN tblclasses ON tblclasses.id = tblstudents.ClassId 
                                                          WHERE tblstudents.RollId = :rollid AND tblstudents.ClassId = :classid";
                                                $stmt = $dbh->prepare($query);
                                                $stmt->bindParam(':rollid', $rollid, PDO::PARAM_STR);
                                                $stmt->bindParam(':classid', $classid, PDO::PARAM_STR);
                                                $stmt->execute();
                                                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                                                if($result) {
                                                    // Student details found, display them
                                                    echo "<h5>Student Details</h5>";
                                                    echo "<p><b>Student Name:</b> " . htmlentities($result['StudentName']) . "</p>";
                                                    echo "<p><b>Student Roll Id:</b> " . htmlentities($result['RollId']) . "</p>";
                                                    echo "<p><b>Student Class:</b> " . htmlentities($result['ClassName']) . " (slot " . htmlentities($result['Slot']) . ")</p>";

                                                    // Fetch and display results
                                                    $query = "SELECT tblsubjects.SubjectName, tr.marks ,tr.Grade
                                                              FROM tblstudents AS sts 
                                                              JOIN tblresult AS tr ON tr.StudentId = sts.StudentId 
                                                              JOIN tblsubjects ON tblsubjects.id = tr.SubjectId 
                                                              WHERE sts.RollId = :rollid AND sts.ClassId = :classid";
                                                    $stmt = $dbh->prepare($query);
                                                    $stmt->bindParam(':rollid', $rollid, PDO::PARAM_STR);
                                                    $stmt->bindParam(':classid', $classid, PDO::PARAM_STR);
                                                    $stmt->execute();
                                                    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                    if($results) {
                                                        // Results found, display them in a table
                                                        echo "<h5>Exam Results</h5>";
                                                        echo "<table class='table table-hover table-bordered'>";
                                                        echo "<thead><tr><th>#</th><th>Subject</th><th>Marks</th><th>Grade</th></tr></thead>";
                                                        echo "<tbody>";
                                                        foreach($results as $key => $row) {
                                                            echo "<tr>";
                                                            echo "<th scope='row'>" . ($key + 1) . "</th>";
                                                            echo "<td>" . htmlentities($row['SubjectName']) . "</td>";
                                                            echo "<td>" . htmlentities($row['marks']) . "</td>";
                                                            echo "<td>" . htmlentities($row['Grade']) . "</td>";
                                                            echo "</tr>";
                                                        }
                                                        echo "</tbody>";
                                                        echo "</table>";
                                                    } else {
                                                        echo "<p>No results found for the student.</p>";
                                                    }
                                                } else {
                                                    echo "<p>No student found with the given Roll Id and Class Id.</p>";
                                                }
                                            } else {
                                                echo "<p>Roll Id and Class Id are required.</p>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</div>
<script src="js/jquery/jquery-2.2.4.min.js"></script>
<script src="js/bootstrap/bootstrap.min.js"></script>
<script src="js/pace/pace.min.js"></script>
<script src="js/lobipanel/lobipanel.min.js"></script>
<script src="js/iscroll/iscroll.js"></script>
<script src="js/prism/prism.js"></script>
<script src="js/main.js"></script>
<script>
    $(function($) {

    });
</script>
</body>
</html>
