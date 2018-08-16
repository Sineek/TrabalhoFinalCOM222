<?php
  $bg = array('../imagens/1.jpg', '../imagens/2.jpg', '../imagens/3.jpg', '../imagens/4.jpg', '../imagens/5.jpg', '../imagens/6.jpg'); // array of filenames

  $i = rand(0, count($bg)-1); // generate random number size of the array
  $selectedBg = "$bg[$i]"; // set variable equal to which random filename was chosen
  
  echo '<style type="text/css">
			body
			{
				background: url(' . $selectedBg . ') no-repeat center center fixed;
				background-size: cover;
				height: 100vh;
				overflow: hidden;
			}
		</style>'
?>