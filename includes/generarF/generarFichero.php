
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
		$lines = explode( PHP_EOL,file_get_contents($_FILES['file1'][tmp_name]));
		foreach($lines as $line ) {
		    $numLineas = explode(" ", $line);
		    if ( count($numLineas) == 1) {
			 	// si el primer dato es un numero entero
			 	$comprobar = isInteger($line);
				if ($comprobar == 0 ) {
					$errorFichero = "No es numero, la cantidad de jugadas: $line";
					break;
				} else {
					if(count($lines) - 1 != intval($line)){
						$errorFichero = "No es el numero de la cantidad de jugadas: $line";
						break;
					}
				}
		    } else {
			 	// las tiradas con los puntuajes
				$comprobarTirada1 = isInteger($numLineas[0]);
				$comprobarTirada2 = isInteger($numLineas[1]);
				if ( $comprobarTirada1 == 1 && $comprobarTirada2 == 1 ) {
					$ventaja = $numLineas[0] - $numLineas[1];
					$ganadorJugada = 0;

					if ($ventaja > 0) {
						$ganadorJugada = 1;
					} else if ($ventaja <0) {
						$ganadorJugada = 2;
						$ventaja = $ventaja * -1;
					} 
					if (!$ganadorJugada == 0) {
						array_push($marcadores, [$ganadorJugada, $ventaja]);
					}
			    } else {
			   $errorFichero = "No es numero la puntuacion de jugadas: $numLineas[0] - $numLineas[1]";
			   break;
			}
		   }
		}
		
		// Recorremos los marcadores para saber los resultados
		$resultados = '';
		foreach($marcadores as $marcador) {
			if(empty($resultados)){
				$resultados= "$marcador[0] $marcador[1]";
			} else {
				$porciones = explode(" ", $resultados);
				if($marcador[1] > $porciones[1] ){
					$resultados = "$marcador[0] $marcador[1]";
					
				} 
			}
			
		}
		if ($errorFichero == '') {		   
			//le informamos que será un archivo txt
		   	header('Content-type: application/txt');
		
			//también le damos un nombre
			header('Content-Disposition: attachment; filename="resultado.txt"');
		
			//generamos el contenido del archivo
			echo $resultados;

		 } else {
			echo'<script type="text/javascript">
			 alert("'.$errorFichero.'");
			 window.location.href="../../index.php";
			 </script>';
		}
	endif;
		
  
	?>