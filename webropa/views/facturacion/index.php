<?php session_start(); ?>
<!DOCTYPE html>
<html ng-app="appMain">
<head>
<title></title>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

<link rel="stylesheet" href="../../css/bootstrap.min.css" />
<link rel="stylesheet" href="../../css/css_main.css" />
<link rel="stylesheet" href="../../css/simple-sidebar.css" />
<?php
    if(isset($_SESSION["login"])){
        if($_SESSION["login"]==0){
            header("Location: ../../index.php");
        }
    }else{
        header("Location: ../../index.php");
    }
?>
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
                <div class="col-xs-9" style="padding-top:14px">
                <!--<img src="img/menu.png" id="btn_menu" width="35px" height="35px" />-->
                <center><span id="title" style="font-size: 16px;">{{ apptitle }}</span></center>
                </div>
                <div style="float: right;">
                <span></span>
                <span class="glyphicon glyphicon-log-out" style="cursor:pointer; margin:5px;color:#D8D8D8; font-size:1.6em"
                        ng-click="switchMenu(99)"></span>
                </div>
                
            </div>

            <!-- Div Contenido -->
            <div class="container-fluid c_anime_div" style="padding:20px; padding-top:60px;">
                <ul class="nav nav-tabs">
                    <li ng-class="{'active':cFacs}" ng-click="change_tab(1)">
                        <a href="#">Facturas</a>
                    </li>
                    <li ng-class="{'active':cConsultas}" ng-click="change_tab(2)">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Consultas</a>
                    </li>
                </ul>

                 <!-- Seccion Facturas -->
                <div class="col-xs-12" style="background-color:#FFFFFF" ng-show="cFacs">
                    <br />
                    <h3>Factura </h3>
                    <br />
                    <div class="row"> 
                        <div class="col-md-3"><span>Fecha<input type="date" class="form-control" ng-model="vFecha" /></div>                   
                        <div class="col-md-3"><span>Vendedor</span>
                            <select class="form-control" ng-model="vVendedor">
                                <option value="0">NA</option>
                            </select>
                        </div>
                        <div class="col-md-3"><span>Cajero<input type="text" class="form-control" ng-model="vCajero" readonly /></div>
                        <div class="col-md-2"><span>Caja<input type="text" class="form-control" ng-model="vCaja" readonly /></div>
                    </div>

                    <div class="row" style="margin-top:8px">
                        <div class="col-md-3">
                            <span>Cliente</span>
                            <input type="text" class="form-control" placeholder="Cliente" ng-model="vCliente" />
                        </div>
                        <div class="col-md-3">
                            <span>RTN</span>
                            <input type="text" class="form-control" placeholder="RTN" ng-model="vRTN" />
                        </div>   
                        <div class="col-md-3">
                            <span>Telefono</span>
                            <input type="number" class="form-control" placeholder="Telefono" ng-model="vTel" />
                        </div>                    
                    </div>
                    <hr />
                    <div class="row">
                        <div class="col-md-2" style="padding-right:3px">
                            <span>Cod Item.</span>
                            <input type="text"  ng-model="vCodItem" placeholder="Cod Item" class="form-control"/>
                        </div>
                        <div class="col-md-4 input_fac">
                            <span>Descripcion</span>
                            <input type="text" ng-model="vDescrip" placeholder="Descripcion" class="form-control" />
                        </div>
                        <div class="col-md-2 input_fac">
                            <span>Cantidad</span>
                            <input type="number" ng-model="vCantidad" placeholder="0" class="form-control" />
                        </div>
                        <div class="col-md-2 input_fac">
                            <span>Precio</span>
                            <input type="number" ng-model="vPrecio" placeholder="L" class="form-control" />                            
                        </div>
                        <div class="col-md-1 input_fac" style="padding-left:10px">
                            <span>ISV</span><br />
                            <input type="checkbox" ng-model="vISV" style="margin-left:10px"></label>
                        </div>
                        <div class="col-md-1 input_fac" style="padding:0px">
                            <input type="button" value="Add" class="btn btn-info" ng-click="f_addItem()" style="margin-top:20px; width:50px" />
                        </div>
                    </div>
                    <br />
                    <div class="panel panel-info">
                    <div class="panel panel-heading" style="margin:0px">
                        Detalle
                    </div>
                    <div class="panel panel-body" style="padding-top: 0px">
                        <table class="table table-striped">
                            <thead>
                                <th>CodItem</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>ISV</th>
                                <th>Precio</th>
                            </thead>
                            <tbody>
                                <tr ng-repeat="rItems in arr_items">
                                    <td>{{ rItems.cod }}</td>
                                    <td>{{ rItems.desc }}</td>
                                    <td>{{ rItems.cant }}</td>
                                    <td>{{ rItems.isv }}</td>
                                    <td>{{ rItems.price }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-2"><span>SubTotal</span><span style="float: right;">L.</span></div>
                        <div class="col-md-2" style="text-align: right; padding-right:40px"><span>{{ arr_generales.subTotal }}</span></div>
                    </div>
                    <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-2"><span>Descuento</span><span style="float: right;">L.</span></div>
                        <div class="col-md-2" style="text-align: right; padding-right:40px"><span>0</span></div>
                    </div>
                    <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-2"><span>ISV</span><span style="float: right;">L.</span></div>
                        <div class="col-md-2" style="text-align: right; padding-right:40px"><span>{{ arr_generales.isv }}</span></div>
                    </div>
                    <div class="row"><div class="col-md-8"></div>
                        <div class="col-md-2"><b><span>TOTAL</span><span style="float: right;">L.</span></b></div>
                        <div class="col-md-2" style="text-align: right; padding-right:40px"><b><span>{{ arr_generales.total }}</span></b></div>
                    </div>
                    <br />
                    <div class="row"><div class="col-md-6"><span>Nota:</span><textarea class="form-control" ng-model="vNota"></textarea></div></div>
                    <br />

                    <b><span>Pago</span></b><br />
                    <div class="row" style="margin-top: 5px">
                        <div class="col-md-3"><span>Efectivo</span>
                            <input type="numer" class="form-control"  placeholder="L." ng-model="vEfectivo" ng-blur="calcPago(1)"></input>
                        </div>
                        <div class="col-md-3"><span>Tarjeta</span>
                            <input type="number" class="form-control" placeholder="L." ng-model="vTarjeta" ng-blur="calcPago(0)"></input>
                        </div>
                    </div>
                    <br />
                    <input type="button" id="btn_save" value="Save" class="btn btn-success" ng-click="save_fac()" />
                    <input type="button" id="btn_clear" value="Clear" class="btn btn-default" ng-click="limpiar()" />
                    

                    <br /><br />
                </div><!-- Fin Facturacion -->

                <!-- Seccion Facturas -->
                <div class="col-xs-12" style="background-color:#FFFFFF" ng-show="cConsultas">
                    <br />
                    <h3>Busqueda Factura </h3>
                    <br />
                    <div class="row">
                        <div class="col-md-3"><span>Criterio</span>
                            <select class="form-control" ng-model="vCriterioSearchF">
                                <option value="1">Por Fechas</option>
                                <option value="2">Por Num. Factura</option>
                            </select>
                        </div>   
                    </div>
                    <div class="row" style="margin-top:5px">
                        <div class="col-md-3"><span>Fecha Inicio</span>
                            <input type="date" class="form-control" ng-model="vFechIni_find" />
                        </div> 
                        <div class="col-md-3"><span>Fecha Fin</span>
                            <input type="date" class="form-control" ng-model="vFechFin_find"/>
                        </div>   
                    </div>

                    <div class="row" style="margin-top:5px">
                        <div class="col-md-3"><span>Num Factura</span>
                            <input type="text" class="form-control" ng-model="vNumFac_find"/>
                        </div>  
                    </div>
                    <input type="button" style="margin-top:15px" class="btn btn-info" value="Buscar" ng-click="search_facs()">
                    <br /><br />
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>NumFac</th>
                                <th>Fecha</th>
                                <th>Cliente</th>
                                <th>Monto</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="vFacs in vArr_Facs_Search">
                                <td>{{vFacs.factura}}</td>
                                <td>{{vFacs.fecha}}</td>
                                <td>{{vFacs.cliente}}</td>
                                <td>{{vFacs.total}}</td>
                                <td><input type="button" value="Print" class="btn btn-link" id="{{vFacs.factura}}" ng-click="printFac($event)"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
<script type="text/javascript" src="../../js/js_facturacion.js"></script>

</html>
