<?php

//help.php

include('header.php');

?>
<!--js for toggle related work-->
	<script>
	    var checkbox = document.querySelector("input[id=togBtn]");
	    checkbox.addEventListener( 'change', function() {
	        document.body.classList.toggle("dark-theme");   
	    });
  	</script>

	<!--Help page-->
	<h1>Help</h1>
	<br>
	<h3>Game Controls</h3>
	<p>
	<ul>
		<li>Up Arrow      :  Rotate</li>
		<li>Down Arrow    :  Move down</li>
		<li>Left Arrow    :  Move in Left Direction</li>
		<li>Right Arrow   :  Move in Right Direction</li>
	</ul>

	<h5>	There are seven different types of tetrominoes: </h5>
	

	<ul>
	<li>I-blocks are useful for getting 'Tetris', that is competing four lines at once.</li>
	<li>O-blocks for filling large gaps.</li>
	<li>L-blocks for filling medium-sized holes.</li>
	<li>J-blocks face the opposite direction as L-blocks.</li>
	<li>S-blocks for filling small holes.</li>
	<li>Z-blocks face the opposite direction as S-blocks.</li>
	</ul>

	Complete lines to gain points and increase the level.
	Speed with which the tetriminos fall increases as the level increases. 
	<br>The more lines completed at once, the more points gained. 
	Completing the maximum number of lines at once, four,<br>is known as a 'Tetris' and can only be 
	pulled off with straight, long rectangle tetrominoes.  <br>
	Check upcoming pieces and plan for them. 
	This will become easier the more you play, don't rush yourself.
	</p>

	<!-- Site footer -->
    <footer class="site-footer">
      <div class="container">
        <div class="row">
          <div class="col-md-8 col-sm-6 col-xs-12">
            <p class="copyright-text">Copyright &copy; 2020 All Rights Reserved by 
         <a href="#">Tetris 1.0</a>.
            </p>
          </div>
        </div>
      </div>
	</footer>
</body>
</html>