<?php
error_reporting(0);
include('includes/config.php'); 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Student Result Management System</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Responsive navbar-->
        <nav class="navbar navbar-expand-lg navbar-dark" style="background-color:rgb(212, 65, 97)">
            <div class="container">
                <a class="navbar-brand" href="index.php">SRMS-(Student Result Management System)</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                        <li class="nav-item"><a class="nav-link active" aria-current="page" href="#!">Home</a></li>
                        <li class="nav-item"><a class="nav-link active" href="find-result.php">Students</a></li>
                        <li class="nav-item"><a class="nav-link active" href="admin-login.php">Admin</a></li>
                    </ul>
                </div>
            </div>
        </nav>
<!-- Header - Image Carousel with Increased Height -->
<header class="py-1 bg-image-full">
    <div id="headerCarousel" class="carousel slide" data-bs-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-bs-target="#headerCarousel" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#headerCarousel" data-bs-slide-to="1"></li>
            <li data-bs-target="#headerCarousel" data-bs-slide-to="2"></li>
            <li data-bs-target="#headerCarousel" data-bs-slide-to="3"></li>
            <li data-bs-target="#headerCarousel" data-bs-slide-to="4"></li>
            <li data-bs-target="#headerCarousel" data-bs-slide-to="5"></li>
            <li data-bs-target="#headerCarousel" data-bs-slide-to="6"></li>
            <li data-bs-target="#headerCarousel" data-bs-slide-to="7"></li>
            <li data-bs-target="#headerCarousel" data-bs-slide-to="8"></li>
            <li data-bs-target="#headerCarousel" data-bs-slide-to="9"></li>
            <li data-bs-target="#headerCarousel" data-bs-slide-to="10"></li>
            <li data-bs-target="#headerCarousel" data-bs-slide-to="11"></li>
        </ol>

        <!-- Carousel Inner -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="images/img-3.jpg" class="d-block w-100 carousel-image" alt="Image 3">
            </div>
            <div class="carousel-item">
                <img src="images/img-2.jpg" class="d-block w-100 carousel-image" alt="Image 2">
            </div>
            <div class="carousel-item">
                <img src="images/img-1.jpg" class="d-block w-100 carousel-image" alt="Image 1">
            </div>
            <div class="carousel-item">
                <img src="images/img-4.jpg" class="d-block w-100 carousel-image" alt="Image 4">
            </div>
            <div class="carousel-item">
                <img src="images/img-5.jpg" class="d-block w-100 carousel-image" alt="Image 5">
            </div>
            <div class="carousel-item">
                <img src="images/img-6.jpg" class="d-block w-100 carousel-image" alt="Image 6">
            </div>
            <div class="carousel-item">
                <img src="images/img-7.jpg" class="d-block w-100 carousel-image" alt="Image 7">
            </div>
            <div class="carousel-item">
                <img src="images/img-8.jpg" class="d-block w-100 carousel-image" alt="Image 8">
            </div>
            <div class="carousel-item">
                <img src="images/img-9.jpg" class="d-block w-100 carousel-image" alt="Image 9">
            </div>
            <div class="carousel-item">
                <img src="images/img-10.jpg" class="d-block w-100 carousel-image" alt="Image 10">
            </div>
            <div class="carousel-item">
                <img src="images/img-5.jpg" class="d-block w-100 carousel-image" alt="Image 5">
            </div>
        </div>

        <!-- Controls -->
        <a class="carousel-control-prev" href="#headerCarousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </a>
        <a class="carousel-control-next" href="#headerCarousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </a>
    </div>
</header>

<!-- Custom CSS -->
<style>
    /* Control the height of the carousel */
    #headerCarousel {
        height: 550px; /* Increased height of the carousel container */
    }

    /* Control the height of the images */
    .carousel-image {
        height: 500px; /* Increased height of the images */
        object-fit: cover; /* Ensure the image covers the container */
    }

    /* Adjust image height on smaller screens */
    @media (max-width: 768px) {
        #headerCarousel {
            height: 500px; /* Increased for smaller screens */
        }

        .carousel-image {
            height: 450px; /* Increased image height for smaller screens */
        }
    }

    @media (max-width: 576px) {
        #headerCarousel {
            height: 450px; /* Adjust for very small screens */
        }

        .carousel-image {
            height: 400px; /* Further increased image height on small screens */
        }
    }
</style>

    
        </header>
        <!-- Content section-->
<section class="py-5">
    <div class="container my-5">
        <div class="row justify-content-center">.
            <div class="col-lg-6">
                <h2>Notice Board</h2>
                <hr color="#000" />
                <marquee direction="up" onmouseover="this.stop();" onmouseout="this.start();">
                    <ul>
                        <?php
                        $sql = "SELECT * from tblnotice";
                        $query = $dbh->prepare($sql);
                        $query->execute();
                        $results = $query->fetchAll(PDO::FETCH_OBJ);
                        $cnt = 1;
                        if ($query->rowCount() > 0) {
                            foreach ($results as $result) { ?>
                                <li><a href="notice-details.php?nid=<?php echo htmlentities($result->id);?>" target="_blank"><?php echo htmlentities($result->noticeTitle);?></a></li>
                        <?php }} ?>
                    </ul>
                </marquee>
            </div>
        </div>
    </div>
</section>


        <!-- Footer-->
        <footer class="py-5" style="background-color:rgb(212, 65, 97)">
            <div class="container"><p class="m-0 text-center text-white"> Student Result Management System</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="js/scripts.js"></script>
    </body>
</html>
