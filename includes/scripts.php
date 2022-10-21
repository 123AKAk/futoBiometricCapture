<!-- Script Start -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/popper.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script src="assets/js/swiper.min.js"></script>
<script src="assets/js/apexchart/apexcharts.min.js"></script>
<script src="assets/js/apexchart/control-chart-apexcharts.js"></script>
<!-- Page Specific -->
<script src="assets/js/nice-select.min.js"></script>
<!-- Custom Script -->
<script src="assets/js/custom.js"></script>

<script>
      //hides the feedback alert
    function hidealert(idname){
        var fade = document.getElementById(idname);
        var div = fade;
        setTimeout(function(){ div.style.display = "none"; }, 600);
        div.style.opacity = "0";
      }
      
      function goback()
      {
          window.history.back();
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
 
</body>

</html>