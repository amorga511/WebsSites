


var appM = angular.module('appMain', []);

appM.controller('appControl1', function($scope,$http) {
    $scope.ISV_VAL = 0.15;
    $scope.btn_menu = false;
    $scope.cFacs = true;
    $scope.cConsultas = false;
    $scope.user_name = "Test usuario";

    $scope.vCriterioSearchF = "1";

    $scope.arr_items = [];
    $scope.arr_generales = {"cliente":"", "rtn":"", "tel":"", "nota":"", "subTotal":0, "desc":0, "isv":0, "total":0, "fecha":"", "vendedor":"NA", "cajero":"", "caja":"", "efectivo":0, "tarjeta":0};

    $scope.apptitle = "Venta de Ropa Nueva y Usada JIREH";
    limpiar_fac();
    limpia_busqueda();

    if(window.innerWidth<900){
        $scope.btn_menu = true;
    }

    $scope.calcPago = function(vTipo){
        calculaPago(vTipo);       
    }

    $scope.switchMenu = function(vM){
        switch(vM){
            case 1:
                window.location.replace('../../main.php');
            break;
            case 2:               
                window.location.replace('../../views/caja/index.php');
            break;
            case 3:
                window.refresh();               
            break;
            case 99:
                $http.post('http://192.168.0.254/webropa/server/svrConsultas.php', {op:104}).then(function(vResult){
                    window.location.reload();
                }); 
            break;
            default:
                return;
        }
        if(vM!=99){
            $("#wrapper").toggleClass("toggled");
        }
    }

    $scope.printFac = function(vFac){
        //alert(vFac.target.id);
        window.open("printFac.php?vF=" + vFac.target.id  ,"","width=500, height=600");
    }

    $scope.search_facs = function(){
        var vDate1 = "";
        var vDate2 ="";

        vDate1 = $scope.vFechIni_find.getFullYear();
        vDate1 += "-" + filldate($scope.vFechIni_find.getMonth()+1);
        vDate1 += "-" + filldate($scope.vFechIni_find.getDate());

        vDate2 = $scope.vFechFin_find.getFullYear();
        vDate2 += "-" + filldate($scope.vFechFin_find.getMonth()+1);
        vDate2 += "-" + filldate($scope.vFechFin_find.getDate());

        $http.post('http://192.168.0.254/webropa/server/svrConsultas.php', {op:106, tipo:$scope.vCriterioSearchF, fini:vDate1, ffin:vDate2, crit:$scope.vNumFac_find}).then(function(vResult){
            //alert(vResult.data),
            $scope.vArr_Facs_Search = vResult.data;
        });
    }

    $scope.change_tab = function(vIndex){
        switch(vIndex){
            case 1:
                $scope.cFacs = true;
                $scope.cConsultas = false;
            break;
            case 2:
                $scope.cFacs = false;
                $scope.cConsultas = true;
            break;
        }
    }

    $scope.save_fac = function(){
        var pagoFac = 0;
        var vResult = "";
        var vDate = "";

        vDate = $scope.vFecha.getFullYear();
        vDate += "-" + filldate($scope.vFecha.getMonth()+1);
        vDate += "-" + filldate($scope.vFecha.getDate());

        vDate += " " + filldate($scope.vFecha.getHours());
        vDate += ":" + filldate($scope.vFecha.getMinutes());
        vDate += ":" + filldate($scope.vFecha.getSeconds());

        pagoFac = parseFloat($scope.arr_generales.total) - (parseFloat($scope.arr_generales.efectivo) + parseFloat($scope.arr_generales.tarjeta));
//      alert(pagoFac);
        if($scope.vFecha!="" && $scope.vCliente.length >0 && String($scope.vTel).length >0 && $scope.vRTN.length>0 && pagoFac == 0 && parseInt($scope.vCaja)>0){
            calcula_fac();
            //alert($scope.arr_generales.total);
            $scope.arr_generales.cajero = $scope.vCajero;
            $scope.arr_generales.caja = $scope.vCaja;
            $scope.arr_generales.vendedor = $scope.vVendedor;
            $scope.arr_generales.fecha = vDate;

            $scope.arr_generales.cliente = $scope.vCliente;
            $scope.arr_generales.tel = $scope.vTel;
            $scope.arr_generales.rtn = $scope.vRTN;
            $scope.arr_generales.nota = $scope.vNota;

            if($scope.arr_generales.total>0){
                $http.post('http://192.168.0.254/webropa/server/svrTransacciones.php', {op:202, arrItems:$scope.arr_items, arrGenerales:$scope.arr_generales}).then(function(vResult){
                    vResult = vResult.data.split(',');
                    if(vResult[0]==1){                        
                        window.open("printFac.php?vF=" + vResult[2]  ,"","width=500, height=600");
                        limpiar_fac();
                    }else{
                        alert(vResult.data);
                    }
                }); 
            }else{
                alert("Factura en [0]");
            }
            
        }else{
            alert("Datos Incompletos");
        }
    }

    $scope.limpiar = function(){
        limpiar_fac()
    }

    $scope.f_addItem = function(){
        var isv =0;
        var vFlag = 0;
        if($scope.vISV){
            isv =1;
        }        

        if($scope.vCodItem.length > 0 && $scope.vDescrip.length >0 && parseInt($scope.vCantidad) > 0 && parseFloat($scope.vPrecio) >0 ){
            
            if($scope.arr_items.length == 0){
                $scope.arr_items.push({"cod": $scope.vCodItem,
                                    "desc": $scope.vDescrip,
                                    "cant": $scope.vCantidad,
                                    "isv": isv,
                                    "price": $scope.vPrecio});
            }else{
                //alert($scope.arr_items.length);
                for(i=0;i<$scope.arr_items.length;i++){
                    
                    if($scope.arr_items[i].cod == $scope.vCodItem){
                        $scope.arr_items[i].cant += $scope.vCantidad;                    
                        $scope.arr_items[i].price = $scope.vPrecio;                                            
                        $scope.arr_items[i].isv = isv;
                        vFlag = 1;
                        break;  
                    }                  
                }
                if(vFlag == 0){
                     $scope.arr_items.push({"cod": $scope.vCodItem,
                                        "desc": $scope.vDescrip,
                                        "cant": $scope.vCantidad,
                                        "isv": isv,
                                        "price": $scope.vPrecio});
                }
            }
            calcula_fac();
            limpia_addItem();
            //alert($scope.vFecha.getMonth() + '-' + $scope.vCliente);
        }else{
            alert('Datos Incompletos');
        }
    }

    function calculaPago(vT){
        var vTotalTemp = parseFloat($scope.arr_generales.total);
        if(vTotalTemp > 0){
            if(parseFloat($scope.vEfectivo)<=vTotalTemp && vT == 1){
                $scope.vTarjeta = vTotalTemp - $scope.vEfectivo;
            }
            if(parseFloat($scope.vTarjeta)<=vTotalTemp && vT == 0){
                $scope.vEfectivo = vTotalTemp - $scope.vTarjeta;
            }
        } 

        $scope.arr_generales.efectivo = $scope.vEfectivo;
        $scope.arr_generales.tarjeta = $scope.vTarjeta;
    }

    function calcula_fac(){
        var vISV=0;
        var vSubTotal=0;
        var vDescuento = 0;
        var vTotal = 0;

        for(i=0; i<$scope.arr_items.length;i++){
            vSubTotal += $scope.arr_items[i].cant * $scope.arr_items[i].price;
            if($scope.arr_items[i].isv == 1){
                vISV += vSubTotal*$scope.ISV_VAL;
            }
        }
        vTotal = (vSubTotal - vDescuento) + vISV;

        $scope.arr_generales.desc = 0;
        $scope.arr_generales.subTotal = vSubTotal;
        $scope.arr_generales.isv = vISV;
        $scope.arr_generales.total = vTotal;


    }

    $(document).ready(function(){
		//alert('Document Ready');
		$("#btn_menu").click(function(e) {
     		e.preventDefault();
    		$("#wrapper").toggleClass("toggled");
		});
		$("#btn_close_menu").click(function(){
    		$("#wrapper").toggleClass("toggled"); 
 		});
	});

function limpiar_fac(){
    $http.post('http://192.168.0.254/webropa/server/svrConsultas.php', {op:103, tienda:'TGU001', estado:1}).then(function(vResult){
        vCaja=vResult.data[0];
        $scope.vCajero = vCaja.cajero;
        $scope.vCaja = vCaja.caja;
    }); 

    $scope.vFecha = "";
    $scope.vCliente = ""; 
    $scope.vTel = "";
    $scope.vRTN = "";

    $scope.vFecha = new Date();
    $scope.vCodItem = "";
    $scope.vDescrip = "";
    $scope.vCantidad = 0;
    $scope.vPrecio = 0;
    $scope.arr_items = [];    
    $scope.arr_generales = {"cliente":"", "rtn":"", "tel":"", "nota":"", "subTotal":0, "desc":0, "isv":0, "total":0, "fecha":"", "vendedor":"NA", "cajero":"", "caja":"", "efectivo":0, "tarjeta":0};
    $scope.vISV = false;
    $scope.vVendedor = "0";

    $scope.vEfectivo = 0;
    $scope.vTarjeta = 0;

    $scope.vNota = "";
    
}

function limpia_busqueda(){
    $scope.vCriterioSearchF = "1";
    $scope.vFechIni_find = new Date();
    $scope.vFechFin_find = new Date();
    $scope.vNumFac_find = "";
}

function limpia_addItem(){
    $scope.vCodItem = "";
    $scope.vDescrip = "";
    $scope.vCantidad = 0;
    $scope.vPrecio = 0;
    $scope.vISV = false;
}

});
       

function getParams(param) {
    var vars = {};
    window.location.href.replace( location.hash, '' ).replace( 
        /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
        function( m, key, value ) { // callback
            vars[key] = value !== undefined ? value : '';
        }
    );

    if ( param ) {
        return vars[param] ? vars[param] : null;    
    }
    return vars;
}

function filldate(vNumber){
    var ret = "";
    if(vNumber < 10){
        ret = "0" + vNumber;
    }else{
        ret = vNumber
    }
    return ret;
}


