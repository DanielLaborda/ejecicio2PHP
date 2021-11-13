
<?php
	function isInteger($input){
		//funcion validar numeros integer 
		if(is_numeric(strval($input)) == 1) {
		  if (is_integer(intval($input)) == 1) {
			return 1;
		  }
			return 0;
		}
		return 0;
	}
	if(isset($_POST['submit'])):
		// Validacion de Fichero 
		$errorFichero = '';

		// variable con los resultados
		$marcadores = [];
		// Leemos el fichero y validamos la información
		$lines = explode( PHP_EOL,file_get_contents($_FILES['file1']["tmp_name"]));

		if (count($lines) == 1):
			$line = explode("\n", $lines[0]);
		else:
			$line =$lines;
		endif;

		$ronda = 0;
		foreach($line as $l) {
			$numLineas = explode(" ", $l);
			if ( count($numLineas) == 1) {
			 	// si el primer dato es un numero entero
				$comprobar = isInteger($l);
				if ($comprobar == 0 ) {
					$errorFichero = "No es numero, la cantidad de jugadas: $l";
					break;
				} else {
					if(count($line) - 1 != intval($l)){
						$errorFichero = "No es el numero de la cantidad de jugadas: $l";
						break;
					}
				}
			} else {
				// las tiradas con los puntuajes
				$comprobarTirada1 = isInteger($numLineas[0]);
		 		$comprobarTirada2 = isInteger($numLineas[1]);
				if ( $comprobarTirada1 == 1 && $comprobarTirada2 == 1 ) {
					//debemos sumar las puntuaciones y ver quien va ganando
					$ronda= $ronda + 1;
					if(empty($marcadores)){
					// primera ronda
						$ventaja = $numLineas[0] - $numLineas[1];
						$lider = 0;
						if ($ventaja > 0) {
					 		$lider = 1;
						} else if ($ventaja <0) {
							$lider = 2;
							$ventaja = $ventaja * -1;
						} 
						array_push($marcadores, [$ronda, $numLineas[0], $numLineas[1],  $lider, $ventaja]);
										   
					} else {
						//siguentes rondas
						$rondaAnterior = end($marcadores);
						$puntuacionPj1 = $rondaAnterior[1] + $numLineas[0];
						$puntuacionPj2 = $rondaAnterior[2] + $numLineas[1];
						$liderRonda = 0;
						if($puntuacionPj1 > $puntuacionPj2){
							$liderRonda = 1;
						}else if($puntuacionPj1 < $puntuacionPj2) {
							$liderRonda = 2;
						}
						// calculamos ventaja
						$ventaja = $puntuacionPj1 - $puntuacionPj2;
						if($ventaja < 0) {
							$ventaja = $ventaja * -1;
						}
						// añadimos todos las rondas
						array_push($marcadores, [$ronda, $puntuacionPj1, $puntuacionPj2, $liderRonda, $ventaja]);	
					}
				} else {
					$errorFichero = "No es numero la puntuacion de jugadas: $numLineas[0] - $numLineas[1]";
					break;
				}
			}
		}

		
		
	
		$ganador = [];
		foreach ($marcadores as $marcador) {
			if(empty($ganador)){
				$ganador = [$marcador[3], $marcador[4]];
			} else {
				// comparamos si la ventaja es mayor
				if($marcador[4] > $ganador[1]){
					$ganador = [$marcador[3], $marcador[4]];
				}
			}
		}
		if ($errorFichero == '') {	
			//le informamos que será un archivo txt
		  	header('Content-type: application/txt');
		
			//también le damos un nombre
			header('Content-Disposition: attachment; filename="resultado.txt"');
		
			//generamos el contenido del archivo
			echo "$ganador[0]  $ganador[1]" ;

		} else {
		 	echo'<script type="text/javascript">
		 	 alert("'.$errorFichero.'");
		 	 window.location.href="../../index.php";
		 	 </script>';
		}
	endif;
		
  
	?>