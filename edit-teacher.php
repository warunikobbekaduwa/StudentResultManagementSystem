<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="") {   
    header("Location: index.php"); 
} else {
    $TeachersId = intval($_GET['TeachersId']); // Correcting the variable name here

    if(isset($_POST['submit'])) {
        $TeacherName = $_POST['fullname'];
        $TeacherEmail = $_POST['emailid']; 
        $Gender = $_POST['gender']; 
        $DOB = $_POST['dob']; 
        $Status = $_POST['status'];

        // Update query using correct column names
        $sql = "UPDATE tblteachers SET TeacherName=:TeacherName, TeacherEmail=:TeacherEmail, Gender=:Gender, DOB=:DOB, Status=:Status WHERE TeachersId=:TeachersId";
        $query = $dbh->prepare($sql);
        $query->bindParam(':TeacherName', $TeacherName, PDO::PARAM_STR);
        $query->bindParam(':TeacherEmail', $TeacherEmail, PDO::PARAM_STR);
        $query->bindParam(':Gender', $Gender, PDO::PARAM_STR);
        $query->bindParam(':DOB', $DOB, PDO::PARAM_STR);
        $query->bindParam(':Status', $Status, PDO::PARAM_STR);
        $query->bindParam(':TeachersId', $TeachersId, PDO::PARAM_STR);
        $query->execute();

        $msg = "Teacher info updated successfully";
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SMS Admin| Edit Teacher</title>
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
            <?php include('includes/topbar.php');?> 
            <div class="content-wrapper">
                <div class="content-container">
                    <?php include('includes/leftbar.php');?>  
                    <div class="main-page">
                        <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Teacher Management</h2>
                                </div>
                            </div>
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                        <li class="active">Edit Teacher</li>
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
                                                <h5>Fill the Teacher info</h5>
                                            </div>
                                        </div>
                                        <div class="panel-body">
                                            <?php if($msg){?>
                                                <div class="alert alert-success left-icon-alert" role="alert">
                                                    <strong>Well done!</strong><?php echo htmlentities($msg); ?>
                                                </div><?php } 
                                            else if($error){?>
                                                <div class="alert alert-danger left-icon-alert" role="alert">
                                                    <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                                </div>
                                            <?php } ?>
                                            <form class="form-horizontal" method="post">
                                                <?php 
                                                // Fetch teacher data based on TeacherID
                                                $sql = "SELECT TeacherID, TeacherName, TeacherEmail, Gender, DOB, Status FROM tblteachers WHERE TeachersId=:TeachersId";
                                                $query = $dbh->prepare($sql);
                                                $query->bindParam(':TeachersId', $TeachersId, PDO::PARAM_STR);
                                                $query->execute();
                                                $results = $query->fetchAll(PDO::FETCH_OBJ);
                                                if($query->rowCount() > 0) {
                                                    foreach($results as $result) {  ?>
                                                 
                                                        <div class="form-group">
                                                            <label for="TeacherID" class="col-sm-2 control-label">Teacher ID</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="teacherid" class="form-control" id="teacherid" value="<?php echo htmlentities($result->TeacherID)?>" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="default" class="col-sm-2 control-label">Full Name</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" name="fullname" class="form-control" id="fullname" value="<?php echo htmlentities($result->TeacherName)?>" required="required" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="default" class="col-sm-2 control-label">Email ID</label>
                                                            <div class="col-sm-10">
                                                                <input type="email" name="emailid" class="form-control" id="email" value="<?php echo htmlentities($result->TeacherEmail)?>" required="required" autocomplete="off">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="default" class="col-sm-2 control-label">Gender</label>
                                                            <div class="col-sm-10">
                                                                <?php  
                                                                $gndr = $result->Gender;
                                                                if($gndr == "Male") {
                                                                ?>
                                                                    <input type="radio" name="gender" value="Male" required="required" checked>Male 
                                                                    <input type="radio" name="gender" value="Female" required="required">Female 
                                                                    <input type="radio" name="gender" value="Other" required="required">Other
                                                                <?php } ?>
                                                                <?php  
                                                                if($gndr == "Female") {
                                                                ?>
                                                                    <input type="radio" name="gender" value="Male" required="required">Male 
                                                                    <input type="radio" name="gender" value="Female" required="required" checked>Female 
                                                                    <input type="radio" name="gender" value="Other" required="required">Other
                                                                <?php } ?>
                                                                <?php  
                                                                if($gndr == "Other") {
                                                                ?>
                                                                    <input type="radio" name="gender" value="Male" required="required">Male 
                                                                    <input type="radio" name="gender" value="Female" required="required">Female 
                                                                    <input type="radio" name="gender" value="Other" required="required" checked>Other
                                                                <?php } ?>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="date" class="col-sm-2 control-label">DOB</label>
                                                            <div class="col-sm-10">
                                                                <input type="date" name="dob" class="form-control" value="<?php echo htmlentities($result->DOB)?>" id="date">
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <label for="default" class="col-sm-2 control-label">Status</label>
                                                            <div class="col-sm-10">
                                                                <?php  
                                                                $status = $result->Status;
                                                                if($status == "1") {
                                                                ?>
                                                                    <input type="radio" name="status" value="1" required="required" checked>Active 
                                                                    <input type="radio" name="status" value="0" required="required">Inactive
                                                                <?php } ?>
                                                                <?php  
                                                                if($status == "0") {
                                                                ?>
                                                                    <input type="radio" name="status" value="1" required="required">Active 
                                                                    <input type="radio" name="status" value="0" required="required" checked>Inactive
                                                                <?php } ?>
                                                            </div>
                                                        </div>

                                                <?php }} ?>                                                    

                                                <div class="form-group">
                                                    <div class="col-sm-offset-2 col-sm-10">
                                                        <button type="submit" name="submit" class="btn btn-primary">Update</button>
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
                    $(".js-states-limit").select2({
                        maximumSelectionLength: 2
                    });
                    $(".js-states-hide").select2({
                        minimumResultsForSearch: Infinity
                    });
                });
            </script>
        </body>
    </html>
<?php } ?>
