<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';

    // Get all ACTIVE users 
    $stmt = $conn->prepare("SELECT * FROM admin ORDER BY id DESC");
    $stmt->execute();
    $data = $stmt->fetchAll();
    $userscount = $stmt->rowCount();

    // Get all POST
    $stmt = $conn->prepare("SELECT * FROM biodata WHERE status = 1");
    $stmt->execute();
    $data = $stmt->fetchAll();
    $postcount = $stmt->rowCount();

    // Get all AUTHOR Data
    $stmt = $conn->prepare("SELECT * FROM biodata");
    $stmt->execute();
    $authors = $stmt->fetchAll();
    $authorcount = $stmt->rowCount();
    
?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h4 class="page-title bold">Dashboard</h4>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-link active">Admin</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Dashboard Start -->
                <div class="row">
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <!-- Start Card-->
                        <div class="card ad-info-card">
                            <div class="card-body dd-flex align-items-center">
                                <h3>Active Users</h3>
                                <div class="icon-info-text">
                                    <h5 class="ad-title"></h5>
                                    <h4 class="ad-card-title"><?= $userscount ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Card-->
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card ad-info-card">
                            <div class="card-body dd-flex align-items-center">
                                <h3>Completed </h3>
                                <div class="icon-info-text">
                                    <h5 class="ad-title"></h5>
                                    <h4 class="ad-card-title"><?= $postcount ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Card-->
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card ad-info-card">
                            <div class="card-body dd-flex align-items-center">
                                <h3>All Students</h3>
                                <div class="icon-info-text">
                                    <h4 class="ad-card-title"><?= $authorcount ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Start Card-->
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="card ad-info-card">
                            <div class="card-body dd-flex align-items-center">
                                <h3></h3>
                                <div class="icon-info-text">
                                    <h5 class="ad-title"></h5>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    
                </div>
				
<?php
    include 'includes/footer.php';
    include 'includes/scripts.php';
?>