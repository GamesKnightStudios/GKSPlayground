<!--

JS GameBoy Emulator v.1.0
Copyright (C) 2013 Alejandro Aladrén <alex@alexaladren.net> 

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.

-->
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />

		<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame
		Remove this if you use the .htaccess -->
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

		<title>GameBoy Emulator</title>
		<meta name="description" content="" />
		<meta name="author" content="GamesKnightStudios" />

		<meta name="viewport" content="width=device-width, initial-scale=1.0" />

		<link rel="stylesheet" href="gbstyle.css" />
		
		<script src="Z80.js"></script>
		<script src="GameBoy.js"></script>
		<script src="emulator.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</head>

	<body>
		<div id="wrapper">
			<header>
				<h1>GameBoy Emulator</h1>
			</header>

			<?php
				if(isset($_GET['game'])) {
					echo '<script type="text/javascript">',
					'downloadROM("'.$_GET['game'].'");',
					'</script>';
				}
			?>

			<div class="left-column">
			
				<div class="box display">
					<canvas id="display" width="320" height="288" onclick="pause()"></canvas>
					<div id="fps"></div>
				</div>
				<div class="box controls">
					<div class="controls-grid-container">
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"><button id="btnUp" class="square">&uarr;</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"><button id="btnLeft" class="square">&larr;</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"><button id="btnRight" class="square">&rarr;</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"><button id="btnA" class="square">A</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"><button id="btnDown" class="square">&darr;</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"><button id="btnB" class="square">B</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"><button id="btnStart" class="long">Start</button></div>
						<div class="controls-grid-item"><button id="btnSelect" class="long">Select</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
					</div>

					
				</div>
				<script>
				var btnUp = document.getElementById("btnUp");
				var btnDown = document.getElementById("btnDown");
				var btnLeft = document.getElementById("btnLeft");
				var btnRight = document.getElementById("btnRight");
				var btnA = document.getElementById("btnA");
				var btnB = document.getElementById("btnB");
				var btnStart = document.getElementById("btnStart");
				var btnSelect = document.getElementById("btnSelect");
				
				btnUp.addEventListener('mousedown', function(event) {gameKeyDown("upaction")}, false);
				btnDown.addEventListener('mousedown', function(event) {gameKeyDown("downaction")}, false);
				btnLeft.addEventListener('mousedown', function(event) {gameKeyDown("leftaction")}, false);
				btnRight.addEventListener('mousedown', function(event) {gameKeyDown("rightaction")}, false);
				btnA.addEventListener('mousedown', function(event) {gameKeyDown("aaction")}, false);
				btnB.addEventListener('mousedown', function(event) {gameKeyDown("baction")}, false);
				btnStart.addEventListener('mousedown', function(event) {gameKeyDown("startaction")}, false);
				btnSelect.addEventListener('mousedown', function(event) {gameKeyDown("selectaction")}, false);

				btnUp.addEventListener('touchstart', function(event) {gameKeyDown("upaction")}, false);
				btnDown.addEventListener('touchstart', function(event) {gameKeyDown("downaction")}, false);
				btnLeft.addEventListener('touchstart', function(event) {gameKeyDown("leftaction")}, false);
				btnRight.addEventListener('touchstart', function(event) {gameKeyDown("rightaction")}, false);
				btnA.addEventListener('touchstart', function(event) {gameKeyDown("aaction")}, false);
				btnB.addEventListener('touchstart', function(event) {gameKeyDown("baction")}, false);
				btnStart.addEventListener('touchstart', function(event) {gameKeyDown("startaction")}, false);
				btnSelect.addEventListener('touchstart', function(event) {gameKeyDown("selectaction")}, false);
				
				btnUp.addEventListener('mouseup', function(event) {gameKeyUp("upaction")}, false);
				btnDown.addEventListener('mouseup', function(event) {gameKeyUp("downaction")}, false);
				btnLeft.addEventListener('mouseup', function(event) {gameKeyUp("leftaction")}, false);
				btnRight.addEventListener('mouseup', function(event) {gameKeyUp("rightaction")}, false);
				btnA.addEventListener('mouseup', function(event) {gameKeyUp("aaction")}, false);
				btnB.addEventListener('mouseup', function(event) {gameKeyUp("baction")}, false);
				btnStart.addEventListener('mouseup', function(event) {gameKeyUp("startaction")}, false);
				btnSelect.addEventListener('mouseup', function(event) {gameKeyUp("selectaction")}, false);

				btnUp.addEventListener('touchend', function(event) {gameKeyUp("upaction")}, false);
				btnDown.addEventListener('touchend', function(event) {gameKeyUp("downaction")}, false);
				btnLeft.addEventListener('touchend', function(event) {gameKeyUp("leftaction")}, false);
				btnRight.addEventListener('touchend', function(event) {gameKeyUp("rightaction")}, false);
				btnA.addEventListener('touchend', function(event) {gameKeyUp("aaction")}, false);
				btnB.addEventListener('touchend', function(event) {gameKeyUp("baction")}, false);
				btnStart.addEventListener('touchend', function(event) {gameKeyUp("startaction")}, false);
				btnSelect.addEventListener('touchend', function(event) {gameKeyUp("selectaction")}, false);

				function gameKeyDown(action) {
					//console.log(action);
					el = document.getElementById(action);
					if (el != null){
						el.style.color = "red";
						if(action == "leftaction"){ // Left
							gb.keyPressed(2);
						}else if(action == "upaction"){ // Up
							gb.keyPressed(4);
						}else if(action == "rightaction"){ // Right
							gb.keyPressed(1);
						}else if(action == "downaction"){ // Down
							gb.keyPressed(8);
						}else if(action == "baction"){ // B
							gb.keyPressed(32);
						}else if(action == "aaction"){ // A
							gb.keyPressed(16);
						}else if(action == "startaction"){ // Start
							gb.keyPressed(128);
						}else if(action == "selectaction"){ // Select
							gb.keyPressed(64);
						}
					}
				}

				function gameKeyUp(action) {
					//console.log(action);
					el = document.getElementById(action);
					if (el != null){
						el.style.color = "black";
						if(action == "leftaction"){ // Left
							gb.keyReleased(2);
						}else if(action == "upaction"){ // Up
							gb.keyReleased(4);
						}else if(action == "rightaction"){ // Right
							gb.keyReleased(1);
						}else if(action == "downaction"){ // Down
							gb.keyReleased(8);
						}else if(action == "baction"){ // B
							gb.keyReleased(32);
						}else if(action == "aaction"){ // A
							gb.keyReleased(16);
						}else if(action == "startaction"){ // Start
							gb.keyReleased(128);
						}else if(action == "selectaction"){ // Select
							gb.keyReleased(64);
						}
					}
				}
				
				
				//btnUp.addEventListener("mousedown", gameKeyDown("upaction"));
				//btnUp.addEventListener("mouseup", gameKeyUp("upaction"));
				//btnUp.addEventListener("touchstart", gameKeyDown("upaction"));
				
				</script>
				<div class="copyright">
					<a>Emulator based on</a>
					<a href="https://github.com/alexaladren/jsgameboy"> jsgameboy</a>
					<a>by Alex Aladren</a>
				</div>
				
			</div>
			<div class="right-column">
				<!--
				<div class="box select">
					<div id="romlist">
						
					</div>
					
					<div class="button" id="addfrompc" onclick="addROMfromComputer(event)">Add a ROM from your PC</div>
				</div>
				-->
				
				<div class="box data" id="cartridge-data" style="display: none;">
					<div id="title" class="title"></div>
					<div id="cartridge"></div>
					<input type="button" id="save" value="Guardar" onclick="saveCartridgeRam()" style="display: none;" />
					<input type="button" id="delete" value="Eliminar partida" onclick="deleteCartridgeRam()" style="display: none;" />
				</div>
				
				<div class="box controls">
					<table>
						<tr>
							<td>Q</td><td id="selectaction">Select</td>
							<td>W</td><td id="startaction">Start</td>
						</tr>
						<tr>
							<td>A</td><td id="baction">B</td>
							<td>S</td><td id="aaction">A</td>
						</tr>
						<tr>
							<td>&uarr;</td><td id="upaction">Up</td>
							<td>&darr;</td><td id="downaction">Down</td>
						</tr>
						<tr>
							<td>&larr;</td><td id="leftaction">Left</td>
							<td>&rarr;</td><td id="rightaction">Right</td>
						</tr>
					</table>
				</div>
				
			</div>
		</div>
	</body>
</html>
