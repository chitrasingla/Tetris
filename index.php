<?php
//index.php

include('header.php');
?>

<!--js for toggle related work-->
  <script>
    var checkbox = document.querySelector("input[id=togBtn]");
    checkbox.addEventListener( 'change', function() {
        document.body.classList.toggle("dark-theme");   
        //set colour value according to the mode
        set_Colour(); 
        draw();
    });
  </script>

  <br>
  <div class="card bg-transparent border-primary mb-3" style="width: 18rem;">
      <ul class="list-group list-group-flush">
        <div class="card-body">High Score </div>
        <div class="card-body">Level </div>
        <div class="card-body">Line</div>
        <div class="card-body">Score</div>
      </ul>   
  </div>  
 
  <!--js for tetris game play-->
  <!--Use graphics-->
      <!--using js canvas-->
      <canvas id='c' style='position:absolute; left:0px; top:90px;'>
      </canvas>
      <script src="js/Tetris.js"></script>
  
  <!-- Site footer -->
    <footer class="site-footer">
      <div class="container">
        <div class="row">
            <p class="copyright-text">Copyright &copy; 2020 All Rights Reserved by <a href="#">Tetris 1.0</a>.</p>
        </div>
      </div>
  </footer>
</body>
 
</html>


