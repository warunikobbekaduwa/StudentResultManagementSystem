<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
include('includes/config.php');

if (strlen($_SESSION['alogin']) == "") {
    header("Location: index.php");
    exit;
} else {
    if (isset($_POST['submit'])) {
        $teachername = $_POST['fullname']; // Corrected 'fullanme' to 'fullname'
        $teacherid = $_POST['teacherid'];
        $teacheremail = $_POST['emailid'];
        $gender = $_POST['gender'];
        $dob = $_POST['dob'];
        $status = 1;

        $sql = "INSERT INTO tblteachers (TeacherName, TeacherID, TeacherEmail, Gender, DOB, Status) 
                VALUES (:teachername, :teacherid, :teacheremail, :gender, :dob, :status)";
        $query = $dbh->prepare($sql);

        // Bind parameters
        $query->bindParam(':teachername', $teachername, PDO::PARAM_STR);
        $query->bindParam(':teacherid', $teacherid, PDO::PARAM_STR);
        $query->bindParam(':teacheremail', $teacheremail, PDO::PARAM_STR);
        $query->bindParam(':gender', $gender, PDO::PARAM_STR);
        $query->bindParam(':dob', $dob, PDO::PARAM_STR);
        $query->bindParam(':status', $status, PDO::PARAM_STR);

        try {
            $query->execute();
            $lastInsertId = $dbh->lastInsertId();
            if ($lastInsertId) {
                $msg = "Teacher info added successfully.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        } catch (PDOException $e) {
            $error = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS Admin | Teacher Admission</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" media="screen">
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen">
    <link rel="stylesheet" href="css/animate-css/animate.min.css" media="screen">
    <link rel="stylesheet" href="css/lobipanel/lobipanel.min.css" media="screen">
    <link rel="stylesheet" href="css/prism/prism.css" media="screen">
    <link rel="stylesheet" href="css/select2/select2.min.css">
    <link rel="stylesheet" href="css/main.css" media="screen">
    <script src="js/modernizr/modernizr.min.js"></script>
</head>
<body class="top-navbar-fixed">
    <div class="main-wrapper">

        <!-- Top Navbar -->
        <?php include('includes/topbar.php'); ?>

        <div class="content-wrapper">
            <div class="content-container">
                <!-- Left Sidebar -->
                <?php include('includes/leftbar.php'); ?>

                <div class="main-page">
                    <div class="container-fluid">
                        <div class="row page-title-div">
                            <div class="col-md-6">
                                <h2 class="title">Teacher Admission</h2>
                            </div>
                        </div>
                        <div class="row breadcrumb-div">
                            <div class="col-md-6">
                                <ul class="breadcrumb">
                                    <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                    <li class="active">Teacher Admission</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="panel">
                                    <div class="panel-heading">
                                        <div class="panel-title">
                                            <h5>Fill the Teacher Info</h5>
                                        </div>
                                    </div>
                                    <div class="panel-body">
                                        <?php if (isset($msg)) { ?>
                                            <div class="alert alert-success left-icon-alert" role="alert">
                                                <strong>Well done!</strong> <?php echo htmlentities($msg); ?>
                                            </div>
                                        <?php } else if (isset($error)) { ?>
                                            <div class="alert alert-danger left-icon-alert" role="alert">
                                                <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                            </div>
                                        <?php } ?>

                                        <form class="form-horizontal" method="post">
                                            <div class="form-group">
                                                <label for="fullname" class="col-sm-2 control-label">Full Name</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="fullname" class="form-control" id="fullname" required="required" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="teacherid" class="col-sm-2 control-label">Teacher ID</label>
                                                <div class="col-sm-10">
                                                    <input type="text" name="teacherid" class="form-control" id="teacherid" maxlength="5" required="required" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="emailid" class="col-sm-2 control-label">Email ID</label>
                                                <div class="col-sm-10">
                                                    <input type="email" name="emailid" class="form-control" id="emailid" required="required" autocomplete="off">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="gender" class="col-sm-2 control-label">Gender</label>
                                                <div class="col-sm-10">
                                                    <input type="radio" name="gender" value="Male" required="required" checked> Male
                                                    <input type="radio" name="gender" value="Female" required="required"> Female
                                                    <input type="radio" name="gender" value="Other" required="required"> Other
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="dob" class="col-sm-2 control-label">DOB</label>
                                                <div class="col-sm-10">
                                                    <input type="date" name="dob" class="form-control" id="dob" required="required">
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button type="submit" name="submit" class="btn btn-primary">Add</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    <script src="js/select2/select2.min.js"></script>
    <script src="js/main.js"></script>
    <script>
        $(function($) {
            $(".js-states").select2();
        });
    </script>
</body>
</html>
