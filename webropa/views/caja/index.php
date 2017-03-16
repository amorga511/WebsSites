<?php session_start(); ?>
<!DOCTYPE html>
<html ng-app="appMain">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<title></title>
<script>
var vCaja = <?php echo $_SESSION["infoCaja"]; ?>;
</script>
<?php
    if(isset($_SESSION["login"])){
        if($_SESSION["login"]==0){
            header("Location: ../../index.php");
        }
    }else{
        header("Location: ../../index.php");
    }
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

<link rel="stylesheet" href="../../css/bootstrap.min.css" />
<link rel="stylesheet" href="../../css/css_main.css" />
<link rel="stylesheet" href="../../css/simple-sidebar.css" />

</head>
<body ng-controller="appControl1">
<div id="wrapper">
    <!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <span id="btn_close_menu" class="glyphicon glyphicon-chevron-left btn_closemenu" ng-click="btn_menu=true"></span>
                <a href="#"  ng-click="switchMenu(1)">
                        HOME
                </a>
            </li>
            <li>
                <a href="#" ng-click="switchMenu(2)">Caja</a>
            </li>
            <li>
                <a href="#" ng-click="switchMenu(3)">Facturacion</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->

    <div id="page-content-wrapper" style="padding:0px">
        <!-- Div Contenido -->
        <div class="container-fluid" style="padding:0px;">
        	<!-- Barra Superior -->
            <div class="col-xs-12 barra_sup_css" style="padding:0px;">
                <div class="col-xs-1" style="padding: 5px">
                <span id="btn_menu" class="glyphicon glyphicon-menu-hamburger btn_menu_c" ng-click="btn_menu=false" ng-show="btn_menu"></span>
                </div>
                <div class="col-xs-8" style="padding-top:14px">
                <!--<img src="img/menu.png" id="btn_menu" width="35px" height="35px" />-->
                <center><span id="title" style="font-size: 16px;">{{ apptitle }}</span></center>
                </div>
                <div style="float: right;">
                <span></span>
                <span class="glyphicon glyphicon-log-out" style="cursor:pointer; margin:5px;color:#D8D8D8; font-size:1.6em"
                        ng-click="switchMenu(99)"></span>
                </div>
                
            </div>

            <!-- Div Inicio -->
            <div class="container-fluid c_anime_div" style="padding:20px; padding-top:60px;">
                <ul class="nav nav-tabs">
                    <li ng-class="{'active':cApertura}" ng-click="change_tab(1)">
                        <a href="#">Aperturas</a>
                    </li>
                   <!-- <li ng-class="{'active':cTrans}" ng-click="change_tab(2)">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Transacciones</a>
                    </li>-->
                    <li ng-class="{'active':cCierre}" ng-click="change_tab(3)"><a href="#">Cierre</a></li>
                    <li ng-class="{'active':cReports}" ng-click="change_tab(4)"><a href="#">Reportes</a></li>
                </ul>
                <!-- Seccion Apetura Caja -->
                <div class="col-xs-12" style="background-color:#FFFFFF" ng-show="cApertura">
                    <br />
                    <h4>Apertura Caja</h4>
                    <br />
                    <div class="row">
                        <div class="col-md-3">
                            <span>Tienda</span>
                            <select ng-model="caja_tienda" class="form-control" >
                                <option value="{{ row1.id }}" ng-repeat="row1 in arrTiendas">{{ row1.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <span>Cajero</span>
                            <select ng-model="caja_cajero" class="form-control">
                                 <option value="{{ row2.id }}" ng-repeat="row2 in arrEmpleados">{{ row2.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-1">
                            <span>Caja</span>
                            <select ng-model="caja_numero" class="form-control">
                                <option value="{{ row3.id }}" ng-repeat="row3 in arrCajas">{{ row3.name }}</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <span>Monto</span>
                            <input type="number" ng-model="caja_monto" class="form-control" placeholder="Monto" />
                        </div>
                         <div class="col-md-3">
                            <span>Fecha Apertura</span>
                            <input type="date" class="form-control" ng-model="caja_f_apertura" placeholder="Fecha" />
                        </div>
                    </div>
                    <br />
                    <input type="button" value="Guardas" class="btn btn-success" style="margin-right: 10px;" ng-click="f_save()"/>
                    <input type="button" value="Limpiar" class="btn btn-default" style="margin-right: 10px;" ng-click="f_limpiar()" />
                    <br />
                    <div class="panel panel-info" style="margin-top:50px;">
                        <div class="panel panel-heading">
                            <label>Cajas Aperturadas</label>
                        </div>
                        <div class="panel panel-body" style="padding-top: 0px">
                            <table class="table table-striped">
                                <thead>
                                  <tr>
                                    <th>Tienda</th>
                                    <th>Cajero</th>
                                    <th>Caja</th>
                                    <th>Monto Apertura</th>
                                    <th>Fecha Apertura</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr ng-repeat="rowC in arrCajasOpen">
                                    <td>{{rowC.tienda}}</td>
                                    <td>{{rowC.cajero}}</td>
                                    <td>{{rowC.caja}}</td>
                                    <td>{{rowC.monto}}</td>
                                    <td>{{rowC.f_open}}</td>
                                  </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>                    
                </div> 
                <!-- Fin Seccion Apertura Caja -->

                <!-- Cierres Caja -->
                <div class="col-xs-12" style="background-color:#FFFFFF" ng-show="cReports">
                    <br />
                    <h4>Reportes Caja</h4>
                    <br />
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NumCierre</th>
                                <th>Caja</th>
                                <th>Cajero</th>
                                <th>F_Open</th>
                                <th>F_Close</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="vCierr in vArr_Cierres">
                                <td>{{vCierr.num}}</td>
                                <td>{{vCierr.caja}}</td>
                                <td>{{vCierr.cajero}}</td>
                                <td>{{vCierr.fopen}}</td>
                                <td>{{vCierr.fclose}}</td>
                                <td><input type="button" value="Print" class="btn btn-link" id="{{vCierr.num}}" ng-click="printCierre($event)"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Fin Cierres Caja -->

                 <!-- Cierre Caja -->
                <div class="col-xs-12" style="background-color:#FFFFFF" ng-show="cCierre">
                    <br />
                    <h4>Cierre Caja</h4>
                    <div class="row">
                        <div class="col-xs-3">
                        <span>Caja</span>
                        <select ng-model="num_caja_c" class="form-control">
                            <option value="{{ row3.caja }}" ng-repeat="row3 in arrCajasOpen">{{ row3.caja }}</option>
                        </select>
                        </div>
                        <div class="col-xs-2">
                            <input type="button" value="Detalle" class="btn btn-info" style="margin-right:5px; margin-top:20px" ng-click="f_detalle()"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="panel panel-info" style="margin-top:50px;">
                            <div class="panel panel-heading">
                                <label>Detalle Cierre</label>
                            </div>
                            <div class="panel panel-body" style="padding-top: 0px">
                                <table class="table table-striped">
                                    <thead>
                                      <tr>
                                        <th>Factura</th>
                                        <th>Fecha</th>
                                        <th>Efectivo</th>
                                        <th>Tarjeta</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      <tr ng-repeat="rowD in arrDetalleCaja">
                                        <td>{{rowD.factura}}</td>
                                        <td>{{rowD.fecha}}</td>
                                        <td>{{rowD.efectivo}}</td>
                                        <td>{{rowD.tarjeta}}</td>
                                      </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <center>
                        <input type="button" value="Salvar" class="btn btn-success" style="margin-right:5px; margin-top:20px" ng-click="f_save_cierre()"/>
                        <input type="button" value="Limpiar" class="btn btn-default" style="margin-right:5px; margin-top:20px" ng-click="f_limpiar2()"/>
                        </center>
                    </div>
                    <br>
                </div>
                <!-- Fin Cierre Caja -->
            </div>
            <!-- Fin Div Contenido -->


        </div><!-- Fin Dvi Contenido -->      
    </div>
</div>
</body>

<script type="text/javascript" src="../../js/jquery-3.1.1.min.js"></script>
<!--<script type="text/javascript" src="cordova.js"></script>-->
<script type="text/javascript" src="../../js/bootstrap.min.js"></script>


<script src="../../js/angular.min.js"></script>
<script type="text/javascript" src="../../js/js_caja.js"></script>
<script type="text/javascript">
</script>

</html>
