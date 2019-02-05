<?php
    require_once 'Conexion.php';
    $con = getConnection();
    $id = $_GET["servicio"];
    $query = "SELECT S.Origen, S.Destino, S.HoraInicio, S.FechaInicio, C.* FROM CServicio AS S INNER JOIN MConductor AS C ON C.id = S.Conductor WHERE S.id = $id LIMIT 1";
    $result = mysqli_query($con,$query);
    $row = mysqli_fetch_array($result);        
?>
<!doctype html>
<html>
    <head>
        <style>
            #tabla {
                border-collapse:separate;
                border:solid black 1px;
                border-radius:6px;
                -moz-border-radius:6px;
            }
            .td, .th {
                border-left:solid black 1px;
                border-top:solid black 1px;
            }
            .th {
                background-color: blue;
                border-top: none;
            }
            .td:first-child, th:first-child {
                border-left: none;
            }   
            #img {
                border-radius: 50%;
            }
        </style>
    </head>
    <body>
        <center><img src="http://env-0293252.jl.serv.net.mx/Template/img/logo.png" alt="" width="150" height="" />
<table style="height: 221px;" border=".5" width="356" id="tabla">
<tbody>
<tr class="tr">
<td class="td" style="width: 346.8px;"><img src="https://maps.googleapis.com/maps/api/staticmap?center=<?=$row["Origen"]?>&size=640x480&maptype=roadmap&markers=color:green|label:A|<?=$row["Origen"]?>&markers=color:red|label:B|<?=$row["Destino"]?>&key=AIzaSyAAJnTQpxYqcz4-oMLB-iTajS6mH86BMqQ" width="480" height="320"></td>
</tr>
<tr class="tr">
<td style="width: 346.8px;" class="td">
        <?=$row["FechaInicio"]?><br>
<p><?=$row["Origen"]?> - <?=$row["HoraInicio"]?></p>
<p><?=$row["Destino"]?></p>
</td>
</tr>
  <tr>
<td style="width: 346.8px;" class="td">
 <table>
   	<tr>
      <td>
          <img src="http://crm.spinmexico.com.mx/test1.php?id=<?=$row["id"]?>" width="50" height="50" id="img"/>
      </td>
      <td>
          Conductor:<b><?=$row["Nombre"]?></b><BR>
        <?=$row["Marca"]?> <?=$row["Modelo"]?> (<?=$row["Placas"]?>)
      </td>
   </tr>
  </table>
</td>
  </tr>
<tr class="tr">
<td style="width: 346.8px;" class="td">
<p>&nbsp;Pasajeros:</p>
<ul>
<?php
    $result1 = mysqli_query($con,"SELECT * FROM DPasajero WHERE Servicio = ".$id);
    while($row1 = mysqli_fetch_array($result1)){
?>
    <li><?=$row1["Nombre"]?></li>
<?php
    }
?>
</ul>
</td>
  </tr>
</tbody>
  </table>
  <b><a href="http://spinmexico.com.mx">SPIN México</a></b><br>
  </center>
    </body>
</html>
<?php
mysqli_close($con);
?>