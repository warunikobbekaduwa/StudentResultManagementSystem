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
        <title>Result Management System</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" media="screen" >
        <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" >
        <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen" >
        <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen" >
        <link rel="stylesheet" href="css/prism/prism.css" media="screen" >
        <link rel="stylesheet" href="css/main.css" media="screen" >
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
                                    <h2 class="title" align="center">Result Management System</h2>
                                </div>
                            </div>
                        </div>

                        <section class="section" id="exampl">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-2">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h3 align="center">Student Result Details</h3>
                                                    <hr />
<?php
// Fetch Student Data
$rollid = $_POST['rollid'];
$classid = $_POST['class'];
$_SESSION['rollid'] = $rollid;
$_SESSION['classid'] = $classid;

$qery = "SELECT tblstudents.StudentName, tblstudents.RollId, tblstudents.RegDate, tblstudents.StudentId, tblstudents.Status, tblclasses.ClassName, tblclasses.Section 
         FROM tblstudents 
         JOIN tblclasses ON tblclasses.id = tblstudents.ClassId 
         WHERE tblstudents.RollId = :rollid AND tblstudents.ClassId = :classid";

$stmt = $dbh->prepare($qery);
$stmt->bindParam(':rollid', $rollid, PDO::PARAM_STR);
$stmt->bindParam(':classid', $classid, PDO::PARAM_STR);
$stmt->execute();
$resultss = $stmt->fetchAll(PDO::FETCH_OBJ);

if ($stmt->rowCount() > 0) {
    foreach ($resultss as $row) { ?>
        <p><b>Student Name :</b> <?php echo htmlentities($row->StudentName); ?></p>
        <p><b>Student Id :</b> <?php echo htmlentities($row->RollId); ?></p>
        <p><b>Student Class:</b> <?php echo htmlentities($row->ClassName); ?> (<?php echo htmlentities($row->Section); ?>)</p>
    <?php }
}
?>
                                            </div>
                                            <div class="panel-body p-20">
                                                <table class="table table-hover table-bordered" border="1" width="100%">
                                                    <thead>
                                                        <tr style="text-align: center">
                                                            <th style="text-align: center">#</th>
                                                            <th style="text-align: center">Subject</th>    
                                                            <th style="text-align: center">Marks</th>
                                                            <th style="text-align: center">Grade</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
<?php
// Fetch Result Data
$query = "SELECT t.StudentName, t.RollId, t.ClassId, t.marks, SubjectId, tblsubjects.SubjectName 
          FROM (SELECT sts.StudentName, sts.RollId, sts.ClassId, tr.marks, SubjectId 
                FROM tblstudents AS sts 
                JOIN tblresult AS tr ON tr.StudentId = sts.StudentId) AS t 
          JOIN tblsubjects ON tblsubjects.id = t.SubjectId 
          WHERE (t.RollId = :rollid AND t.ClassId = :classid)";

$query = $dbh->prepare($query);
$query->bindParam(':rollid', $rollid, PDO::PARAM_STR);
$query->bindParam(':classid', $classid, PDO::PARAM_STR);
$query->execute();
$results = $query->fetchAll(PDO::FETCH_OBJ);

$cnt = 1;
$totlcount = 0;

if ($query->rowCount() > 0) {
    foreach ($results as $result) {
        $marks = $result->marks;

        // Grading logic
        if ($marks >= 75) {
            $grade = "A";
        } elseif ($marks >= 65) {
            $grade = "B";
        } elseif ($marks >= 45) {
            $grade = "C";
        } elseif ($marks >= 35) {
            $grade = "S";
        } else {
            $grade = "F";
        }
?>
        <tr>
            <th scope="row" style="text-align: center"><?php echo htmlentities($cnt); ?></th>
            <td style="text-align: center"><?php echo htmlentities($result->SubjectName); ?></td>
            <td style="text-align: center"><?php echo htmlentities($marks); ?></td>
            <td style="text-align: center"><?php echo htmlentities($grade); ?></td>
        </tr>
<?php
        $totlcount += $marks;
        $cnt++;
    }
?>
        <tr>
            <th scope="row" colspan="2" style="text-align: center">Total Marks</th>
            <td style="text-align: center"><b><?php echo htmlentities($totlcount); ?></b> out of <b><?php echo htmlentities(($cnt - 1) * 100); ?></b></td>
        </tr>
        <tr>
            <th scope="row" colspan="2" style="text-align: center">Percentage</th>           
            <td style="text-align: center"><b><?php echo htmlentities($totlcount * 100 / (($cnt - 1) * 100)); ?> %</b></td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <i class="fa fa-print fa-2x" aria-hidden="true" style="cursor:pointer" onClick="CallPrint()"></i>
            </td>
        </tr>
<?php
} else { ?>
        <div class="alert alert-warning left-icon-alert" role="alert">
            <strong>Notice!</strong> Your result has not been declared yet.
        </div>
<?php } ?>
                                                    </tbody>
                                                </table>
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
        <script>
            function CallPrint() {
                var prtContent = document.getElementById("exampl");
                var WinPrint = window.open('', '', 'left=0,top=0,width=800,height=900,toolbar=0,scrollbars=0,status=0');
                WinPrint.document.write(prtContent.innerHTML);
                WinPrint.document.close();
                WinPrint.focus();
                WinPrint.print();
            }
        </script>
    </body>
</html>
