<?php session_start(); 

	$postdata = file_get_contents("php://input");
	$vPost = json_decode($postdata);

switch((int)$vPost->op) {
	case 100:
		validaLogin($vPost->usr, $vPost->pwd);
		break;
	case 101:
		getTiendas();
		break;
	case 102:
		getEmpleados($vPost->cargo);
		break;
	case 103:
		getCajas($vPost->tienda, $vPost->estado);
		break;
	case 104:
		closeSession();
		break;
	case 105:
		detalleFac($vPost->tienda, $vPost->caja);
		break;
	case 106:
		getFacturas($vPost->tipo, $vPost->fini, $vPost->ffin, $vPost->crit);
		break;
	case 107:
		getCierresCaja();
		break;
}

function validaLogin($vUser, $vPwd){	
	include 'dblink.php';
	$arrTemp =array();

	$vQuery = "SELECT * FROM usuarios where estado= 1 and usuario='" . $vUser . "'";
		$arrResult = array();
		if(strlen($vPwd)>0){
		if($result = $con->query($vQuery)){
			$rows = $result->fetch_array();
			if($rows[2]==$vPwd){
				$arrTemp = array("cod"=>1, "msj"=>"Success");
				$_SESSION["login"] = 1;
				echo json_encode($arrTemp);
			}
		}else{
			echo $con->error;
		}
	}else{ echo 'Error de Usuario'; } 
}

function getTiendas(){	
	include 'dblink.php';
	$arrTemp =array();

	$vQuery = "SELECT * FROM tbl_tiendas where status= 1";
	array_push($arrTemp, array("id"=>0,"name"=>"-"));
	if($result = $con->query($vQuery)){
		while($rows = $result->fetch_array())
		{
			array_push($arrTemp, array("id"=>$rows[0], "name"=>$rows[1]));			
		}
	}else{
		echo $con->error;
	}
	echo json_encode($arrTemp); 
}

function getEmpleados($vTipo){	
	include 'dblink.php';
	$arrTemp =array();

	$vQuery = "SELECT * FROM tbl_personal where status_persona= 1 and cargo_persona=" . $vTipo;
	array_push($arrTemp, array("id"=>0,"name"=>"-"));
	if($result = $con->query($vQuery)){
		while($rows = $result->fetch_array())
		{
			array_push($arrTemp, array("id"=>$rows[0], "name"=>$rows[1]));			
		}
	}else{
		echo $con->error;
	}
	echo json_encode($arrTemp); 
}

function getCajas($vTienda, $Open){	
	include 'dblink.php';
	$arrTemp =array();
	if((int)$Open == 0){
		$vQuery = "SELECT * FROM tbl_cajas where status= 1 and tienda='" . $vTienda . "' and estado_caja=0";
		array_push($arrTemp, array("id"=>0,"name"=>"-"));
		if($result = $con->query($vQuery)){
			while($rows = $result->fetch_array())
			{
				array_push($arrTemp, array("id"=>$rows[1], "name"=>$rows[1]));			
			}
		}else{
			echo $con->error;
		}
	}else{
		$vQuery = "SELECT tienda, cajero, num_caja, monto, fech_apertura FROM tbl_cajas where status= 1 and tienda='" . $vTienda . "' and estado_caja=1";
		
		if($result = $con->query($vQuery)){
			while($rows = $result->fetch_array())
			{
				array_push($arrTemp, array("tienda"=>$rows[0], "cajero"=>$rows[1],
										"caja"=>$rows[2],"monto"=>$rows[3],"f_open"=>$rows[4]));			
			}
		}else{
			echo $con->error;
		}
	}	
	echo json_encode($arrTemp); 
}

function closeSession(){	
	$_SESSION["login"] = 0;
}

function detalleFac($vTienda, $vCaja){
	include 'dblink.php';
	$vFopen = "";
	$vMonto = 0;
	$vUtilidad = 0;
	$vCajero = "";
	$arrTemp = array("detalle"=>array(),"cierre"=>array());

	$vQuery = "SELECT tienda, cajero, num_caja, monto, fech_apertura FROM tbl_cajas where estado_caja=1 and tienda='" . $vTienda . "' and num_caja=". $vCaja;
	//echo $vQuery;
	if($result = $con->query($vQuery)){
		while($rows = $result->fetch_array())
		{
			$vMonto = $rows[3];
			$vCajero = $rows[1];
			$vFopen = $rows[4];		
		}
	}else{
		echo $con->error;
	}

	$vQuery = "SELECT id, fech_fac, efectivo, tarjeta, total FROM tbl_facturas where caja= ". $vCaja ." and fech_fac between '" . $vFopen . "' and now()";
		
		if($result = $con->query($vQuery)){
			while($rows = $result->fetch_array())
			{
				array_push($arrTemp["detalle"], array("factura"=>$rows[0], "fecha"=>$rows[1],
										"efectivo"=>$rows[2],"tarjeta"=>$rows[3], "cajero"=>$vCajero));
				$vUtilidad += (float)$rows[4];		
			}
		}else{
			echo $con->error;
		}

		array_push($arrTemp["cierre"], array("caja"=>$vCaja, "cajero"=>$vCajero,"fopen"=>$vFopen,"saldo_ini"=>$vMonto, "saldo_fin"=>$vUtilidad));
	echo json_encode($arrTemp); 

}

function getFacturas($vTipoB, $vFIni, $vFFin, $vCrit){
	include 'dblink.php';
	$arrTemp = array();

	if((int)$vTipoB==1){
		$vQuery = "SELECT id, fech_fac, cliente, total FROM tbl_facturas where  fech_fac between '" . $vFIni . " 00:00:00' and '". $vFFin ." 23:59:59'";
	}else{
		$vQuery = "SELECT id, fech_fac, cliente, total FROM tbl_facturas where  id='" . $vCrit . "'";
	}
	
	if($result = $con->query($vQuery)){
		while($rows = $result->fetch_array())
		{
			array_push($arrTemp, array("factura"=>$rows[0], "fecha"=>$rows[1],"cliente"=>$rows[2],"total"=>$rows[3]) );			
		}
	}else{
		echo $con->error;
	}
	echo json_encode($arrTemp); 
}

function getCierresCaja(){
	include 'dblink.php';
	$arrTemp = array();
	$vQuery = "SELECT * FROM tbl_cajas_cierre";
	//echo $vQuery;
	if($result = $con->query($vQuery)){
		while($rows = $result->fetch_array())
		{
			array_push($arrTemp, array("num"=>$rows["id"], "caja"=>$rows["caja"],"cajero"=>$rows["cajero"],"fopen"=>$rows["fech_open"],"fclose"=>$rows["fech_close"]));	
		}
	}else{
		echo $con->error;
	}	
	echo json_encode($arrTemp); 
}

?>










