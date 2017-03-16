<?php session_start(); ?>
<!DOCTYPE html>
<html ng-app="appMain">
<head>
<title></title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

<link rel="stylesheet" href="../../css/bootstrap.min.css" />
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
        $numFac = $_GET["vF"];

        $vItems = array();
        $vCantLetras = "0/100";

        $cai="";

        $rtn = "";
        $empresa = "";
        $eDir = "";
        $eTel = "";
        $eEmail = "";



        $vCliente = "";
        $vTel = "";
        $vRTN ="";
        $vCaja ="";
        $vCajero = "";
        $vFecha = "";
        $vVendedor = "";

        $vTotal = 0;
        $vSubTotal = 0;
        $vDesc = 0;
        $vISV = 0;
        $vEfectivo = 0;
        $vTarjeta = 0;

        
        $facDesd="";
        $facHasta="";
        $fechLimite ="";

        include '../../server/dblink.php';

        $vQuery = "SELECT * FROM tbl_facturas where id='" .  $numFac . "'";
        if($res1 = $con->query($vQuery)){
            $rows = $res1->fetch_assoc();

            $cai = $rows["cai"];

            $vFecha = $rows["fech_fac"];
            $vCliente = $rows["cliente"];
            $vTel = $rows["tel_cliente"];
            $vRTN = $rows["rtn_cliente"];
            $vVendedor = $rows["vendedor"];
            $vCajero = $rows["cajero"];
            $vCaja = $rows["caja"];


            $vSubTotal = $rows["subtotal"];
            $vDesc = $rows["descuento"];
            $vISV = $rows["isv"];
            $vTotal = $rows["total"];

            $vEfectivo = $rows["efectivo"];
            $vTarjeta = $rows["tarjeta"];
        }
        $vQuery = "SELECT * FROM tbl_factura_detalle where factura_id='" . $numFac . "'";
        if($res2 = $con->query($vQuery)){
            while($row2 = $res2->fetch_assoc()) {
                $sTot = (float)$row2["unidades"] * $row2["precio"];
                array_push($vItems, array("cod"=>$row2["cod_item"],"desc"=>$row2["detalle"], "und"=>$row2["unidades"],"price"=>$row2["precio"], "stot"=>$sTot));
            }
        }

        $vSQL = "SELECT * FROM tbl_cai_control where cai='" . $cai . "'";
        if($resC = $con->query($vSQL)){
            while($rowC = $resC->fetch_array()){
                //$cai = $rowC[3];
                //$rtn = $rowC[2];
                $facDesd = $rowC[4];
                $facHasta = $rowC[5];
                $fechLimite = $rowC[6];
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
    width:250px;
    /*background-color: gary;*/
}
.font1{
    font-family: 'Time New Roman';
    font-size:14px;
    line-height: 1.3;
    padding-left: 2px;
    padding-right: 2px;
}

.font2{
    line-height: 1.3;
    font-family: 'Time New Roman';
    font-size: 12px;
    padding-left: 2px;
    padding-right: 2px;
}

.font3{
    line-height: 1.3;
    font-family: 'Time New Roman';
    font-size: 12px;
    text-align: middle;    
    padding: 2px;
    /*border:solid 1px;*/
}


}
</style>
</head>
<body ng-controller="appControl1">
<div id="dvBody">
<center>
    <br />
    <img src="../../img/logoFac.png" width="130px" height="80px" style="margin-bottom:10px" /><br>
    <b><div class="font1"><?= $empresa; ?></div></b>
    <div class="font2" >RTN: <?= $rtn; ?></div>
    <div class="font2"><?= $eDir; ?></div>
    <div class="font2">Tel: <?= $eTel; ?></div>
    <div class="font2">E-mail: <?= $eEmail; ?></div>
    <div class="font2" style="margin-top:5px">CAI</div>
    <div class="font2"><?= $cai; ?></div>
   
    <div class="font2">Desde <?= $facDesd; ?></div>
    <div class="font2">Hasta <?= $facHasta; ?></div>
    <div class="font2">Fecha Limite Emisión</div>
    <div class="font2"><?= $fechLimite; ?></div>
    <br>
    <div class="font1"><b>Factura #</b></div>
    <div class="font1"><b><?= $numFac ?></b></div>
    <div class="font1">Fecha: <?= $vFecha ?></div>
    <div class="font1">Caja: <?= $vCaja ?></div>
    <div class="font1">Cajero: <?= $vCajero ?></div>
    <div class="font1">Vendedor: <?= $vVendedor ?></div>

    <div class="font1" style="text-align: left">Cliente: <?= $vCliente ?></div>
    <div class="font1" style="text-align: left">Telefono: <?= $vTel ?></div>
    <div class="font1" style="text-align: left">RTN: <?= $vRTN ?></div>

    <div class="font1" style="border-bottom: solid 1px gray; margin: 0px">-</div>
    <div class="row" style="margin: 0px; padding-bottom:2px; border-bottom: solid 1px gray;">
        <div class="col-xs-2 font2">Cod.</div>
        <div class="col-xs-4 font2">Descript</div>
        <div class="col-xs-2 font2">Unds.</div>
        <div class="col-xs-2 font2">Precio</div>
        <div class="col-xs-2 font2">S.Total</div>
    </div>
<?php
    for($i=0;$i<count($vItems); $i++){
    echo "<div class=\"row\" style=\"margin: 0px;\">
        <div class=\"col-xs-2 font3\">". $vItems[$i]["cod"] ."</div>
        <div class=\"col-xs-4 font3\">". $vItems[$i]["desc"] ."</div>
        <div class=\"col-xs-2 font3\">". $vItems[$i]["und"] ."</div>
        <div class=\"col-xs-2 font3\">". $vItems[$i]["price"] ."</div>
        <div class=\"col-xs-2 font3\" style=\"text-align:right;\"><span\">". $vItems[$i]["stot"] ."</span></div>
        </div>";
    }
?>
    <div class="row font1" style="margin: 0px; margin-top:7px; padding-top: 5px; border-top: solid 1px gray; text-align: right;">
        <div class="col-xs-7 " >Sub Total L.</div>
        <div class="col-xs-5 " style="padding-right:2px"><?= $vSubTotal ?></div>
    </div>
    <div class="row font1" style="margin: 0px; text-align: right;">
        <div class="col-xs-7 ">Descuento L.</div>
        <div class="col-xs-5 " style="padding-right:2px"><?= $vDesc ?></div>
    </div>
    <div class="row font1" style="margin: 0px; text-align: right;">
        <div class="col-xs-7 ">ISV L.</div>
        <div class="col-xs-5 " style="padding-right:2px"><?= $vISV ?></div>
    </div>
    <div class="row font1" style="margin: 0px; text-align: right;">
        <div class="col-xs-7" style="padding-top:5px"><b>TOTAL L.</b></div>
        <div class="col-xs-5" style="border-top: solid 1px gray; padding-right:2px; padding-top:5px"><b><?= $vTotal ?></b></div>
    </div>

    <div class="row font1" style="margin: 0px; text-align: right; margin-top: 8px">
        <div class="col-xs-7" style="padding-top:0px"><b>EFECTIVO L.</b></div>
        <div class="col-xs-5" style="padding-right:2px"><b><?= $vEfectivo ?></b></div>
    </div>
    <div class="row font1" style="margin: 0px; text-align: right;">
        <div class="col-xs-7" style=""><b>TARJETA L.</b></div>
        <div class="col-xs-5" style="padding-right:2px"><b><?= $vTarjeta ?></b></div>
    </div>

    <div class="font2" id="cantLtr" style="text-align: left; margin-top:10px; margin-bottom:10px;"><?= $vCantLetras; ?></div>
    <div class="font1" style="text-align: left;">*************************************</div>
    <div class="font1"><b>!! Gracias por su Compra !!</b></div>
    <br />-
</center>
</div>
</body>

<script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>
<!--<script type="text/javascript" src="cordova.js"></script>-->
<script type="text/javascript" src="../../js/bootstrap.min.js"></script>


<script src="../../js/angular.min.js"></script>
<script src="../../js/js_numTostr.js"></script>
<script type="text/javascript">
    
    $("#cantLtr").html(str_number(<?= $vTotal; ?>));
   window.print();
</script>

</html>
