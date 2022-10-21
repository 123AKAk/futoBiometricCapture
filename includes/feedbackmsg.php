<?php 
if(isset($_SESSION["adminerra"]))
{
?>
<div class="container">
    <div class="alert warning " id="alert" style="border-radius: 5px; ">
    <span onclick="hidealert('alert')" class="closebtn">&times;</span>  
    <!-- <strong>Warning!</strong>  -->
    <p style="text-align:center"><?=$_SESSION["adminerra"]?></p>
    </div>
</div>
<?php
    unset($_SESSION['adminerra']); 
}
if(isset($_SESSION["adminsuc"]))
{
    ?>
    <div class="container">
        <div class="alert info " id="alert" style="border-radius: 5px; ">
        <span onclick="hidealert('alert')" class="closebtn">&times;</span>  
        <!-- <strong>Warning!</strong>  -->
        <p style="text-align:center"><?=$_SESSION["adminsuc"]?></p>
        </div>
    </div>
    <?php
    unset($_SESSION['adminsuc']); 
}
?>