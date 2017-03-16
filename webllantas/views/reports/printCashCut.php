<?php session_start(); ?>
<!DOCTYPE html>
<html ng-app="appMain">
<head>
<title></title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

<?php

    if(isset($_SESSION["login"])){
        if($_SESSION["login"]==0){
            header("Location: ../../index.php");
        }
    }else{
        header("Location: ../../index.php");
    }

    if($_SESSION["login"]==0){
        $x=null;
    }else{
        $numCierre = $_GET["vC"];

        $vFacturas = array();
        $vCantLetras = "0/100";

        $rtn = "";
        $empresa = "";
        $eDir = "";
        $eTel = "";
        $eEmail = "";

        $vCaja ="";
        $vCajero = "";

        $vTotalFacs = 0;
        $vEfectivo = 0;
        $vTarjeta = 0;
        
        $fechDesd="";
        $fechHasta="";

        include '../../server/dblink.php';

        $vQuery = "SELECT * FROM tbl_cajas_cierre where id=" .  $numCierre;
        if($res1 = $con->query($vQuery)){
            while($rows = $res1->fetch_assoc()){
                $vCaja = $rows["caja"];
                $vCajero = $rows["cajero"];
                $fechDesd = $rows["fech_open"];
                $fechHasta = $rows["fech_close"];
                //$vTotalFacs = $rows["ingresos_fac"];
                $vSaldo_ini = $rows["saldo_inicial"];
                $vUtilNeta = $rows["utilidad_neta"];
            }
        }else{
            echo $con->error;
        }
        
        $vQuery = "SELECT * FROM tbl_facturas where fech_fac between '" . $fechDesd . "' and '" . $fechHasta . "'";
        if($res2 = $con->query($vQuery)){
            while($row2 = $res2->fetch_assoc()) {
                array_push($vFacturas, array("numfac"=>$row2["id"],"efectivo"=>$row2["efectivo"], "tarjeta"=>$row2["tarjeta"], "total"=>$row2["total"]));
                $vEfectivo += (float)$row2["efectivo"];
                $vTarjeta += (float)$row2["tarjeta"];
                $vTotalFacs += (float)$row2["total"];
            }

        }

        $vSQL = "SELECT * FROM tbl_tiendas";
        if($resC = $con->query($vSQL)){
            while($rowC = $resC->fetch_array()){
                //$cai = $rowC[3];
                $rtn = $rowC[5];
                $empresa = $rowC[1];
                $eDir = $rowC[2];
                $eTel = $rowC[3];
                $eEmail = $rowC[4];
            }
        }
    }
?>

<style>
#dvBody{
    padding:20px;
    width:800px;
    margin:0 auto;
    /*background-color: gary;*/
}
.font1{
    font-family: 'Time New Roman';
    font-size:16px;
    line-height: 1.3;
    padding-left: 2px;
    padding-right: 2px;
}

.font2{
    line-height: 1.3;
    font-family: 'Time New Roman';
    font-size: 14px;
    padding-left: 2px;
    padding-right: 2px;
}

.font3{
    line-height: 1.3;
    font-family: 'Time New Roman';
    font-size: 14px;
    text-align: middle;    
    padding: 2px;
    /*border:solid 1px;*/
}

.grid{
    border:solid 1px gray;
    border-collapse: collapse;
}

.bg{
    background-color:gray;
    color:#FFF;
}

.row {
    width: 100%;
    float: left;
}

.col-6{
    width: 50%;
    float: left;
}

.col-2{
    width: 16.66%;
    float: left;
}

}
</style>
</head>
<body ng-controller="appControl1">
<div id="dvBody">
    <br />
    <div class="row" style="margin-bottom:30px;">
        <center>
        <div class="col-6"><img src="../../img/logo.png" width="150px" height="80px" style="margin-bottom:10px" /></div>
        <div class="col-6">
            <div class="row font1"><?= $empresa; ?></div></b>
            <div class="row font2" >RTN: <?= $rtn; ?></div>
            <div class="row font2"><?= $eDir; ?></div>
            <div class="row font2">Tel: <?= $eTel; ?></div>
            <div class="row font2">E-mail: <?= $eEmail; ?></div>
        </div>
        </center>
    </div>
    <br>
    <center><h3>Cierre de Caja</h3></center>
    <div style="padding:1%; width:99%; float:left; margin-bottom:25px; border:solid 1px gray">
        <table>
            <tr>
                <td width="150px">Cierre Numero:</td>
                <td width="150px"><?= $numCierre ?></td>
                <td width="150px">Caja:</td>
                <td width="150px"><?= $vCaja ?></td>
            </tr>
            <tr>
                <td width="150px">Cajero</td>
                <td width="150px"><?= $vCajero ?></td>
                <td width="150px">Fecha Open:</td>
                <td width="150px"><?= $fechDesd ?></td>
            </tr>
            <tr>
                <td width="150px"></td>
                <td width="150px"></td>
                <td width="150px">Fecha Close:</td>
                <td width="150px"><?= $fechHasta ?></td>
            </tr>
        </table>
    </div>
    <br/>
    <table width="100%" cellspacing="0" cellpadding="3" border="1">
        <tr><td><b>Monto Apertura</b></td><td align="right"><b><label style="float:left">L.</label><?= number_format((float)$vSaldo_ini,2) ?></b></td></tr>
    </table>
    <br />

    <table width="100%" cellspacing="0" cellpadding="3" border="1">
        <tr style="background-color:gray; color:#FFF">
            <th>Factura</th>
            <th>Efectivo</th>
            <th>Tarjeta</th>
            <th>Total</th>
        </tr>
<?php
    for($i=0;$i<count($vFacturas); $i++){
    echo "<tr>
            <td align=\"left\"><label style=\"float:left\">L.</label>". $vFacturas[$i]["numfac"] ."</td>
            <td align=\"right\"><label style=\"float:left\">L.</label>". $vFacturas[$i]["efectivo"] ."</td>
            <td align=\"right\"><label style=\"float:left\">L.</label>". $vFacturas[$i]["tarjeta"] ."</td>
            <td align=\"right\"><label style=\"float:left\">L.</label>". $vFacturas[$i]["total"] ."</td>
        </tr>";
    }
?>  <tr bgcolor="#F2F2F2">
        <td><center><b>Totales</b></center></td>        
        <td align="right"><b><label style="float:left">L.</label><?= number_format((float)$vEfectivo, 2) ?></b></td>
        <td align="right"><b><label style="float:left">L.</label><?= number_format((float)$vTarjeta,2) ?></b></td>        
        <td align="right"><b><label style="float:left">L.</label><?= number_format((float)$vTotalFacs,2) ?></b></td>
    </tr>
    </table>

    <br />
</div>
</body>

<script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>
<!--<script type="text/javascript" src="cordova.js"></script>-->

<script src="../../js/angular.min.js"></script>
<script type="text/javascript">    
   window.print();
</script>

</html>
