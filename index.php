
<?php 
     include 'includes/layout/header.php';
?>

<div>
    <div class='titulo-container'>
        <h1 class='titulo' data-text='Inserte los puntuajes'>Inserte los puntuajes</h1>
    </div>  
    <div className='input-container'>

      <form action="./includes/generarF/generarFichero.php" class="login" method="POST" enctype="multipart/form-data">
        <div>
          <input 
            type='file' 
            id='file1'
            name='file1'
            class='inputfile'
          />
          <label for='file1' class='labelInputFile'><i class="fas fa-file-upload"></i> <span>Seleccionar archivo</span></label>
          </div>
          <!-- <span id='nameFileSpan'></span> -->
          <div class="boton">
            <input type="submit" name="submit" class="button" value="Comprobar ganador">
          </div>
        </div>
      </form>
      
</div>

<?php include 'includes/layout/footer.php'; ?>