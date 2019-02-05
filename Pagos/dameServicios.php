<?php
    require_once '../Valida.php';
    $solicitud = $_POST["solicitud"];
    $servicioActual = $_POST["servicio"];
?>
<label for="exampleInputName">Servicio</label>
                  <select class="form-control" id="serv" aria-describedby="nameHelp" placeholder="Servivcio" name="servicio" onchange="ponPasajeros()" required="required">
                      <?php
                        $query = "SELECT id,Origen,Destino,FechaInicio,HoraInicio FROM CServicio WHERE Solicitud = $solicitud AND Visible = TRUE";
                        $result = mysqli_query($con,$query);
                        while($row = mysqli_fetch_array($result)){
                      ?>
                            <option value="<?=$row["id"]?>" <?php if($servicioActual == $row["id"]) echo("selected"); ?>><?=$row["id"]?>,<?=$row["Origen"]?>-<?=$row["Destino"]?>,<?=$row["FechaInicio"]?>(<?=$row["HoraInicio"]?>)</option>
                      <?php
                        }
                      ?>
                  </select>