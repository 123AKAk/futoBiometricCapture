<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';

    $student_id = $_GET["id"];

    // Get article Data to display
    $stmt = $conn->prepare("SELECT * FROM biodata WHERE id = ?");
    $stmt->execute([$student_id]);
    $data = $stmt->fetch();
?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h4 class="page-title"> Edit Student - <?= $data["studentname"] ?></h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Edit Student</li>
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
                                    <form class="separate-form" action="assets/update.php?type=biodata&id=<?=$student_id?>&img=<?= $data["studImage"] ?>" method="POST" enctype="multipart/form-data">
                                        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                                            <div class="row">
                                                <center>
                                                <?php
                                                if($data["status"] == 0)
                                                {
                                                    echo "<p style='color:red;'> Student <b>".$data['studentname']."</b> has not completed Biometric</p>";
                                                }
                                                else
                                                {
                                                    echo "<p style='color:dodgerblue;'> Student <b>".$data['studentname']."</b> has completed Biometric</p>";
                                                }
                                                ?>
                                                </center>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="form-group">
                                                        <label for="studImage">Image</label>
                                                        <div class="custom-file">
                                                            <input type="file" class="" name="studImage" id="studImage">
                                                            <label for="studImage"> <?= $data['studImage'] ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="my-2" style="width: 200px;">
                                                        <img class="w-100 h-auto" src="assets/images/<?= $data["studImage"] ?>" alt="">
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="arTitle" class="col-form-label">Student Name</label>
                                                        <input class="form-control" type="text" value="<?= $data["studentname"] ?>" placeholder="Enter Student Full Name" name="studentname" id="studentname" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="arContent">Matric No.</label>
                                                        <input class="form-control" type="text" value="<?= $data["matricno"] ?>" placeholder="Enter Student Matric No. Max 10" name="matricno" id="matricno" required readonly>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="arContent">Department</label>
                                                        <input class="form-control" type="text" value="<?= $data["department"] ?>" placeholder="Enter Student Department" name="department" id="department" required>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="arContent">Faculty</label>
                                                        <input class="form-control" type="text" value="<?= $data["department"] ?>" placeholder="Enter Student Faculty" name="faculty" id="faculty" required>
                                                    </div>
                                                </div>

                                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                                    <div class="my-2" style="width: 150px;">
                                                        <img class="w-100 h-auto" src="assets/images/<?= (!empty($data["biometric"])) ? $data["biometric"] : 'fingerprint.jpg'; ?>" alt="Default Biometric" title="<?= (!empty($data["biometric"])) ? "Biometric Data" : 'Default Biometric'; ?>">
                                                    </div>
                                                    <p>Biometric Data</p>
                                                </div>
                                            </div>
                                            <hr>
                                            <div class="form-group mb-0">
                                                <button class="btn btn-secondary" type="button" onclick="goback()">Back</button>
                                                <input class="btn btn-primary" type="submit" name="update" value="Update">
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