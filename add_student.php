<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';    

?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h4 class="page-title">Add Students</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Add Student</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- From Start -->
                <div class="from-wrapper">
                    <div class="row">

                        <div class="col">
                            <div class="card">
                                <div class="col">
                                    <!-- feedback message -->
                                    <?php include 'includes/feedbackmsg.php'; ?>
                                </div>
                                <div class="card-body">
                                    <form class="separate-form" action="assets/insert.php?type=biodata" method="POST" enctype="multipart/form-data">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="studImage">Image</label>
                                                        <div class="custom-file">
                                                            <input type="file" class="" name="studImage" id="studImage" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="arTitle" class="col-form-label">Student Name</label>
                                                        <input class="form-control" type="text" value="<?= (!empty($_SESSION["studentname"])) ? $_SESSION["studentname"] : ''; ?>" placeholder="Enter Student Full Name" name="studentname" id="studentname" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="arContent">Matric No.</label>
                                                        <input class="form-control" type="text" value="<?= (!empty($_SESSION["matricno"])) ? $_SESSION["matricno"] : ''; ?>" placeholder="Enter Student Matric No. Max 10" name="matricno" id="matricno" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="arContent">Department</label>
                                                        <input class="form-control" type="text" value="<?= (!empty($_SESSION["department"])) ? $_SESSION["department"] : ''; ?>" placeholder="Enter Student Department" name="department" id="department" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="arContent">Faculty</label>
                                                        <input class="form-control" type="text" value="<?= (!empty($_SESSION["faculty"])) ? $_SESSION["faculty"] : ''; ?>" placeholder="Enter Student Faculty" name="faculty" id="faculty" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group mb-0">
                                                <button class="btn btn-secondary" type="button" onclick="goback()">Back</button>
                                                <input class="btn btn-primary" type="submit" name="submit">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>


                    </div>

                </div>
<?php
    include 'includes/footer.php';
?>
    <script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>
    <!-- Text Editor Script -->
    <script>
        CKEDITOR.replace('arContent');
    </script>
<?php
    include 'includes/scripts.php';
?>