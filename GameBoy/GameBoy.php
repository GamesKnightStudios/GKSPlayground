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

		<meta name="viewport" content="width=device-width; initial-scale=1.0" />

		<link rel="stylesheet" href="gbstyle.css" />
		
		<script src="Z80.js"></script>
		<script src="GameBoy.js"></script>
		<script src="emulator.js"></script>
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
						<div class="controls-grid-item"><button class="square" onmousedown='gameKeyDown("upaction")' onmouseup='gameKeyUp("upaction")'>&uarr;</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"><button class="square" onmousedown='gameKeyDown("leftaction")' onmouseup='gameKeyUp("leftaction")'>&larr;</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"><button class="square" onmousedown='gameKeyDown("rightaction")' onmouseup='gameKeyUp("rightaction")'>&rarr;</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"><button class="square" onmousedown='gameKeyDown("aaction")' onmouseup='gameKeyUp("aaction")'>A</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"><button class="square" onmousedown='gameKeyDown("downaction")' onmouseup='gameKeyUp("downaction")'>&darr;</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"><button class="square" onmousedown='gameKeyDown("baction")' onmouseup='gameKeyUp("baction")'>B</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item">&#160;</div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"><button class="long" onmousedown='gameKeyDown("startaction")' onmouseup='gameKeyUp("startaction")'>Start</button></div>
						<div class="controls-grid-item"><button class="long" onmousedown='gameKeyDown("selectaction")' onmouseup='gameKeyUp("selectaction")'>Select</button></div>
						<div class="controls-grid-item"></div>
						<div class="controls-grid-item"></div>
					</div>

					
				</div>
				<script>
				function gameKeyDown(action) {
					document.getElementById(action).style.color = "red";
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

				function gameKeyUp(action) {
					document.getElementById(action).style.color = "black";
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
