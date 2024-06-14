<?PHP
$conn=oci_connect("MARIOE","MESFEB2024$","(DESCRIPTION = (ADDRESS = (PROTOCOL = TCP)(HOST = id00-svpr23-scan.itregency.com)(PORT = 1521))(CONNECT_DATA = (SERVER = DEDICATED)(SERVICE_NAME = pprodpm.itregency.com)))");

if (!$conn) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
 }
 else {
    print "Conectado a Oracle!";

    $query= oci_parse($conn, "SELECT * FROM PLAN.V_EMPLEADOS_CLASIFICADOS ");
    oci_execute($query);
  //  oci_fetch_all($query, $res);

  /*  echo "<pre>\n";
    var_dump($res);
    echo "</pre>\n";*/


    $con = Db::connect();
   // $query = $con->query("");
   mysqli_query($con,"DELETE FROM  colab_pl_rh;");

    // Perform a query, check for error
   // while ($res=$query->oci_fetch_array()) {
      while ($row = oci_fetch_array($query)) {
if (!mysqli_query($con,"INSERT INTO  colab_pl_rh (CEDULA, 
NOMBRE_SEP, 
APELLIDO_SEP, 
NO_EMPLE, 
COD_PLANILLERA, 
PLANILLERA, 
COD_GRUPO, 
NOM_GRUPO, 
COD_SGRUPO, 
NOM_SGRUPO, 
COD_UBICACION, 
NOM_UBICACION, 
COD_CADENA, 
NOM_CADENA, 
COD_LINEA, 
NOM_LINEA, 
H_RESPONSABLE, 
COD_UE, 
UNI_ECO, 
COD_CIA_COSTO, 
CENTROCOSTO, 
COD_PUESTO_PL, 
COD_PUESTO_UNIPL, 
NOM_POSICIONPL, 
COD_PUESTO_RH, 
NOM_POSICIONRH, 
F_INGRESO, 
SEXO, 
F_NACIMI, 
ESTADO, 
COD_DEPTO_PL, 
NOMDEPTO_PL, 
COD_DEPTO_RH, 
DEPTO_RH, 
SECCION_PL, 
COD_EMP_JEFE, 
NOM_JEFE
) VALUES (
'".$row['CEDULA']."','".$row['NOMBRE_SEP']."','".$row['APELLIDO_SEP']."','".$row['NO_EMPLE']."','".$row['COD_PLANILLERA']."','".$row['PLANILLERA']."','".$row['COD_GRUPO']."','".$row['NOM_GRUPO']."','".$row['COD_SGRUPO']."','".$row['NOM_SGRUPO']."'
,'".$row['COD_UBICACION']."','".$row['NOM_UBICACION']."','".$row['COD_CADENA']."','".$row['NOM_CADENA']."','".$row['COD_LINEA']."','".$row['NOM_LINEA']."','".$row['H_RESPONSABLE']."','".$row['COD_UE']."','".$row['UNI_ECO']."','".$row['COD_CIA_COSTO']."'
,'".$row['CENTROCOSTO']."','".$row['COD_PUESTO_PL']."','".$row['COD_PUESTO_UNIPL']."','".$row['NOM_POSICIONPL']."','".$row['COD_PUESTO_RH']."','".$row['NOM_POSICIONRH']."','".$row['F_INGRESO']."','".$row['SEXO']."','".$row['F_NACIMI']."','".$row['ESTADO']."'
,'".$row['COD_DEPTO_PL']."','".$row['NOMDEPTO_PL']."','".$row['COD_DEPTO_RH']."','".$row['DEPTO_RH']."','".$row['SECCION_PL']."','".$row['COD_EMP_JEFE']."','".$row['NOM_JEFE']."');")) {
   echo("Error description: " . mysqli_error($con));
 }
	 }
    mysqli_query($con,"INSERT INTO  colab_planillera_ceco SELECT COD_PLANILLERA, PLANILLERA,COD_CIA_COSTO, CENTROCOSTO FROM `colab_pl_rh` where COD_CIA_COSTO not in (Select COD_CIA_COSTO from colab_planillera_ceco) group by COD_PLANILLERA, PLANILLERA,COD_CIA_COSTO, CENTROCOSTO"); 
 }
 // Close the Oracle connection
 oci_close($conn);

 class Db{
	public static function connect(){
		$host="localhost";
		$user="usrlocal";
		$password="fHHn-YTsmwJy]XT2";
		$db="db_headcontrol";
		return new mysqli($host,$user,$password,$db);
	}
}

 ?>