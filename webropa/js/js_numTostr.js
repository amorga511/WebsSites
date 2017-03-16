// Clas for convert number to letters 

var moneda = "LEMPIRAS";
var cero = "CERO";
var un = "UN";
var dos = "DOS";
var tres = "TRES";
var cuatro = "CUATRO";
var cinco = "CINCO";
var seis = "SEIS";
var siete = "SIETE";
var ocho = "OCHO";
var nueve = "NUEVE";
var diez = "DIEZ";
var veinte = "VEINTE";
var veinti = "VEINTI";
var treinta = "TREINTA";
var cuarenta = "CUARENTA";
var cincuenta = "CINCUENTA";
var sesenta = "SESENTA";
var setenta = "SETENTA";
var ochenta = "OCHENTA";
var noventa = "NOVENTA";
var cien = "CIEN";
var ciento = "CIENTO";
var cientos = "CIENTOS";
var doci = "DO";
var tre = "TRE";
var qui = "QUINIENTOS";
var sete = "SETE";
var nove = "NOVE";

var strReturn = "";


//Funcion Principal
function str_number(num)
{
			strReturn = "";
			var result;
			try
			{
				if (parseFloat(num) > 0.0)
				{
					var i = parseFloat(num).toLocaleString('en');
					i = i.replace(',', '').replace(',', '').replace(',', '');

					anumero = i.split('.');
					var numero = anumero[0];

					var decimales;
					if (anumero.length > 1)
					{
						decimales = anumero[1];
						if (decimales.length == 1)
						{
							decimales += "0";
						}
					}
					else
					{
						decimales = "0";
					}


					
					switch (numero.length)
					{
					case 1:
						strReturn = unidades(numero);
						break;
					case 2:
						strReturn = decenas(numero);
						break;
					case 3:
						strReturn = centenas(numero);
						break;
					case 4:
						strReturn = unidades(numero.substring(0, 1)) + " MIL ";
						strReturn += centenas(numero.substring(1, 4));
						break;
					case 5:
						strReturn = decenas(numero.substring(0, 2)) + " MIL ";
						strReturn += centenas(numero.substring(2, 5));
						break;
					case 6:
						strReturn = centenas(numero.substring(0, 3)) + " MIL ";
						strReturn += centenas(numero.substring(3, 6));
						break;
					case 7:
						if (numero.substring(0, 1) == "1")
						{
							strReturn = unidades(numero.substring(0, 1)) + " MILLON ";
						}
						else
						{
							strReturn = unidades(numero.substring(0, 1)) + " MILLONES ";
						}
						strReturn = strReturn + centenas(numero.substring(1, 4)) + " MIL ";
						strReturn += centenas(numero.substring(4, 7));
						break;
					case 8:
						strReturn = decenas(numero.substring(0, 2)) + " MILLONES ";
						strReturn = strReturn + centenas(numero.substring(2, 5)) + " MIL ";
						strReturn += centenas(numero.substring(5, 8));
						break;
					case 9:
						strReturn = centenas(numero.substring(0, 3)) + " MILLONES ";
						strReturn = strReturn + centenas(numero.substring(3, 6)) + " MIL ";
						strReturn += centenas(numero.substring(6, 9));
						break;
					case 10:
						strReturn = unidades(numero.substring(0, 1)) + " MIL ";
						strReturn = strReturn + centenas(numero.substring(1, 4)) + " MILLONES ";
						strReturn = strReturn + centenas(numero.substring(4, 7)) + " MIL ";
						strReturn += centenas(numero.substring(7, 10));
						break;
					default:
						strReturn = "NA";
						break;
					}
					var text = strReturn;
					strReturn = text + " " + moneda + " CON " + decimales + "/100 CTVS.";
					result = strReturn;
				}
				else
				{
					result = cero + ' ' + moneda;
				}
			}
			catch (ex)
			{
				result = ex.toString();
			}
			return result;
}
//Fin Funcion Principal


//Funcion Para las Unidades 
function unidades(digito)
{
	var strdigito = "";
	switch (digito)
	{
	case "1":
		strdigito = un;
		break;
	case "2":
		strdigito = dos;
		break;
	case "3":
		strdigito = tres;
		break;
	case "4":
		strdigito = cuatro;
		break;
	case "5":
		strdigito = cinco;
		break;
	case "6":
		strdigito = seis;
		break;
	case "7":
		strdigito = siete;
		break;
	case "8":
		strdigito = ocho;
		break;
	case "9":
		strdigito = nueve;
		break;
	}
	return strdigito;
}

//Funcion para las Decenas
function decenas(digitod)
{	
	var strdigitod = unidades(digitod.substring(1, 2));

	var text = digitod.substring(0, 1);
	switch (text)
	{
	case "1":
		if (strdigitod.length > 0)
		{
			strdigitod = decenas_diez(digitod);
		}
		else
		{
			strdigitod = diez;
		}
	break;
	case "2":
		if (strdigitod.length > 0)
		{
			strdigitod = veinti + strdigitod;
		}
		else
		{
			strdigitod = veinte;
		}
	break;
	case "3":
		if (strdigitod.length > 0)
		{
			strdigitod = treinta + " Y " + strdigitod;
		}
		else
		{
			strdigitod = treinta + strdigitod;
		}
		break;
	case "4":
		if (strdigitod.length > 0)
		{
			strdigitod = cuarenta + " Y " + strdigitod;
		}
		else
		{
			strdigitod = cuarenta + strdigitod;
		}
	break;
	case "5":
		if (strdigitod.length > 0)
		{
			strdigitod = cincuenta + " Y " + strdigitod;
		}
		else
		{
			strdigitod = cincuenta + strdigitod;
		}
	break;
	case "6":
		if (strdigitod.length > 0)
		{
			strdigitod = sesenta + " Y " + strdigitod;
		}
		else
		{
			strdigitod = sesenta + strdigitod;
		}
	break;
	case "7":
		if (strdigitod.length > 0)
		{
			strdigitod = setenta + " Y " + strdigitod;
		}
		else
		{
			strdigitod = setenta + strdigitod;
		}
	break;
	case "8":
		if (strdigitod.length > 0)
		{
			strdigitod = ochenta + " Y " + strdigitod;
		}
		else
		{
			strdigitod = ochenta + strdigitod;
		}
	break;
	case "9":
		if (strdigitod.length > 0)
		{
			strdigitod = noventa + " Y " + strdigitod;
		}
		else
		{
			strdigitod = noventa + strdigitod;
		}
	break;
	}
	return strdigitod;
}

//Funcion para las Centenas
function centenas(digitoc)
{
	var strdigitc = decenas(digitoc.substring(1, 3));
	var text = digitoc.substring(0, 1);
	switch (text)
	{
	case "1":
		if (strdigitc.length > 0)
		{
			strdigitc = ciento + " " + strdigitc;
		}
		else
		{
			strdigitc = cien + strdigitc;
		}
		break;
	case "2":
		strdigitc = doci + cientos + " " + strdigitc;
	break;
	case "3":
		strdigitc = tre + cientos + " " + strdigitc;
	break;
	case "4":
		strdigitc = cuatro + cientos + " " + strdigitc;
	break;
	case "5":
		strdigitc = qui + " " + strdigitc;
	break;
	case "6":
		strdigitc = seis + cientos + " " + strdigitc;
	break;
	case "7":
		strdigitc = sete + cientos + " " + strdigitc;
	break;
	case "8":
		strdigitc = ocho + cientos + " " + strdigitc;
	break;
	case "9":
		strdigitc = nove + cientos + " " + strdigitc;
	break;
	}
	return strdigitc;
}

//Funcion decenas_diez
function decenas_diez(diezd)
{
	var rdiez = "";
	if (diezd != null)
	{
		if (!(diezd == "11"))
		{
			if (!(diezd == "12"))
			{
				if (!(diezd == "13"))
				{
					if (!(diezd == "14"))
					{
						if (diezd == "15")
						{
							rdiez = "QUINCE";
						}
					}
					else
					{
						rdiez = "CATORCE";
					}
				}
				else
				{
					rdiez = "TRECE";
				}
			}
			else
			{
				rdiez = "DOCE";
			}
		}
		else
		{
			rdiez = "ONCE";
		}
	}
	return rdiez;
}