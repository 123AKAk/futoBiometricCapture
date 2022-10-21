<?php
    include 'includes/header.php';
    include 'includes/navbar.php';
    include 'includes/sidebar.php';

    // Get all Articles Data
    $stmt = $conn->prepare("SELECT * FROM biodata ORDER BY id DESC");
    $stmt->execute();
    $data = $stmt->fetchAll();

?>
        <!-- Container Start -->
        <div class="page-wrapper">
            <div class="main-content">
                <!-- Page Title Start -->
                <div class="row">
                    <div class="colxl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="page-title-wrapper">
                            <div class="page-title-box">
                                <h2 class="page-title bold">All Students</h2>
                            </div>
                            <div class="breadcrumb-list">
                                <ul>
                                    <li class="breadcrumb-link">
                                        <a href="index.php"><i class="fas fa-home mr-2"></i>Home</a>
                                    </li>
                                    <li class="breadcrumb-link active">All Students</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Table Start -->
                <div class="row">
                    <!-- Advance Table Card-->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card table-card">
                            <div class="col">
                                <!-- feedback message -->
                                <?php include 'includes/feedbackmsg.php'; ?>
                            </div>
                            <div class="card-body">
                                <div class="chart-holder">
                                    <div class="table-responsive">
                                        <table id="myTable" class="table table-styled" style="padding-bottom: 20px;  border:none">
                                            <thead>  
                                                <tr>  
                                                    <th>
                                                        <div class="checkbox">
                                                            <input id="checkbox0" type="checkbox">
                                                            <label for="checkbox0"></label>
                                                        </div>
                                                    </th>
                                                    <th>S/N</th>
                                                    <th>Image</th>
                                                    <th>Fullname</th>
                                                    <th>Matric No.</th>
                                                    <th>Department</th>
                                                    <th>Faculty</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>  
                                                </thead>  
                                                <tbody>  
                                                <?php
                                                $countnum = 0;
                                                foreach ($data as $row) :                                                    
                                                echo $row['status'] == 0 ? "<tr style='background:#f1f2f6; '>" : "<tr>";
                                                $date=date_create($row['createdtime']);
                                                $countnum++
                                                ?>
                                                    <td>
														<div class="checkbox">
															<input id="checkbox<?= $countnum ?>" type="checkbox" name="<?php echo $row['id'] ?>">
															<label for="checkbox<?= $countnum ?>"></label>
														</div>
													</td>
                                                    <td><?php echo $countnum ?></td>
                                                    <td>
                                                        <span>
                                                            <img src="assets/images/<?= $row['studImage'] == "" ? "user.jpg" : $row['studImage'] ?>" style="width: 100px; height: auto;">
                                                        </span>
                                                    </td>
                                                    <td style="font-weight: bold;">
                                                        <?php echo strip_tags(substr($row['studentname'], 0, 15)) . "..." ?>
                                                        <?php //echo $row['article_title'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['matricno'] ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $row['department'] ?>
                                                    </td>
                                                    <td><?php echo $row['faculty'] ?></td>
                                                    <td><?php echo date_format($date, "D, M Y H:i:s") ?></td>
                                                    <td class="relative">
                                                        <a class="action-btn " href="javascript:void(0); ">
                                                            <svg class="default-size "  viewBox="0 0 341.333 341.333 ">
                                                                <g>
                                                                    <g>
                                                                        <g>
                                                                            <path d="M170.667,85.333c23.573,0,42.667-19.093,42.667-42.667C213.333,19.093,194.24,0,170.667,0S128,19.093,128,42.667 C128,66.24,147.093,85.333,170.667,85.333z "></path>
                                                                            <path d="M170.667,128C147.093,128,128,147.093,128,170.667s19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 S194.24,128,170.667,128z "></path>
                                                                            <path d="M170.667,256C147.093,256,128,275.093,128,298.667c0,23.573,19.093,42.667,42.667,42.667s42.667-19.093,42.667-42.667 C213.333,275.093,194.24,256,170.667,256z "></path>
                                                                        </g>
                                                                    </g>
                                                                </g>
                                                            </svg>
                                                        </a>
                                                        <div class="action-option ">
                                                            <ul>
                                                                <li>
                                                                    <a href="update_student.php?id=<?php echo $row['id'] ?> ">
                                                                        <i class="far fa-edit mr-2" aria-hidden="true"></i> Edit
                                                                    </a>
                                                                </li>
                                                                
                                                                <li>
                                                                    <a onclick="checkdelete('deleteid<?= $countnum ?>')" id="deleteid<?= $countnum ?>" linkurl="assets/delete.php?type=biodata&id=<?php echo $row['id'] ?> ">
                                                                        <i class="far fa-trash-alt mr-2" aria-hidden="true"></i> Delete
                                                                    </a>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </td>
                                                <?php
                                                    echo "</tr>";
                                                    endforeach;
                                                ?>
                                            </tbody>  
                                        </table> 
                                    </div>
                                    <hr>
                                    <p>Gray color indicates that the student hasn't done his/her biometric </p>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
    <?php
        include 'includes/footer.php';
    ?>

<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/swiper.min.js"></script>
<script src="assets/js/apexchart/apexcharts.min.js"></script>
<script src="assets/js/apexchart/control-chart-apexcharts.js"></script>
<!-- Page Specific -->
<script src="assets/js/nice-select.min.js"></script>
<!-- Custom Script -->
<script src="assets/js/custom.js"></script>
<script src="assets/js/alertify/src/alertify.js"></script>

<script>
      //hides the feedback alert
    function hidealert(idname){
        var fade = document.getElementById(idname);
        var div = fade;
        setTimeout(function(){ div.style.display = "none"; }, 600);
        div.style.opacity = "0";
      }

      function checkdelete(elementid)
      {
          let attributeValue = document.getElementById(elementid).getAttribute("linkurl");
          
          alertify.confirm("Confirm Deletion", function (e) {
				if (e) {
					    alertify.log('Redirecting');
                    window.location.replace(attributeValue);
				} else {
					alertify.error("Canceled");
				}
			});
      }
      
      //shows the feedback alert
    //   function showalert(errortext){
    //     document.getElementById("txt").innerHTML = errortext;
    //     var opacity = 0;
    //     var intervalID = setInterval(function() {
    //       if (opacity < 1) {
    //         opacity = opacity + 0.1
    //         fade.style.opacity = opacity;
    //       } else {
    //         clearInterval(intervalID);
    //       }
    //     }, 10);
    //     fade.style.display = "block";        
    //   }
</script>
<script>
$(document).ready(function(){
    $('#myTable').dataTable();
});
</script>
</html>  