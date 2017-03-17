<?Php
class DBmysql {
			/* variables de conexi�n */
			var $BaseDatos;
			var $Servidor;
			var $Usuario;
			var $Clave;
			/* identificador de conexi�n y consulta */
			var $Conexion_ID = 0;
			var $Consulta_ID = 0;
			/* n�mero de error y texto error */
			var $Errno = 0;
			var $Error = "";
/* M�todo Constructor: Cada vez que creemos una variable
de esta clase, se ejecutar� esta funci�n */
function DBmysql($db = "inti_cms", $host = "localhost", $user = "root", $pass = "") {
//function DBmysql($db = "admin_inti", $host = "localhost", $user = "admin_apuser", $pass = "apcms") {
			$this->BaseDatos = $db;
			$this->Servidor = $host;
			$this->Usuario = $user;
			$this->Clave = $pass;	
	}

/*Conexi�n a la base de datos*/
function connect($db="", $host="", $user="", $pass="")
	{
	if ($db != "") $this->BaseDatos = $db;
	if ($host != "") $this->Servidor = $host;
	if ($user != "") $this->Usuario = $user;
	if ($pass != "") $this->Clave = $pass;
	// Conectamos al servidor
	$this->Conexion_ID = mysql_connect($this->Servidor, $this->Usuario, $this->Clave);
	//echo "c".$this->Conexion_ID;
	if (!$this->Conexion_ID) 
		{
		$this->Error = "Ha fallado la conexi�n.";
		return 0;
		}	
	//seleccionamos la base de datos
	//echo "base = ".$this->BaseDatos;
	if (!@mysql_select_db($this->BaseDatos, $this->Conexion_ID)) {
		$this->Error = "Imposible abrir ".$this->BaseDatos ;
		//echo "".$this->Error;
		
		return 0;
		}
	/* Si hemos tenido �xito conectando devuelve 
	el identificador de la conexi�n, sino devuelve 0 */
	return $this->Conexion_ID;
	}
 

/* Ejecuta un consulta */
function query($sql = "",$show=0){

		if ($show != 0)
			echo ""; //echo "sql=$sql";
		if ($sql == "")
			{
			$this->Error = "No ha especificado una consulta SQL";
			echo "<bn>ERROR". $this->Error;
			return 0;
			}
		//ejecutamos la consulta
		$this->Consulta_ID = mysql_query($sql, $this->Conexion_ID);
		if (!$this->Consulta_ID) {
			$this->Errno = mysql_errno();
			$this->Error = mysql_error();
//			echo "error en conexi�n ".$this->Conexion_ID . ",consulta realizada $sql ";
		}
		/* Si hemos tenido �xito en la consulta devuelve 
		el identificador de la conexi�n, sino devuelve 0 */
//		echo "ID=".$this->Consulta_ID."::";
		return $this->Consulta_ID;
}

/* Devuelve el n�mero de campos de una consulta */
function numfields() {
return mysql_num_fields($this->Consulta_ID);
}
/* Devuelve el n�mero de registros de una consulta */
function numrows(){
return mysql_num_rows($this->Consulta_ID);
}
/* Devuelve el nombre de un campo de una consulta */
function nombrecampo($numcampo) {
return mysql_field_name($this->Consulta_ID, $numcampo);
}
/* Muestra los datos de una consulta */
function verconsulta() {
		echo "<table border=1>\n";
		// mostramos los nombres de los campos
		for ($i = 0; $i < $this->numfields(); $i++){
		echo "<td><b>".$this->nombrecampo($i)."</b></td>\n";
		}
		echo "</tr>\n";
		// mostrarmos los registros
		while ($row = mysql_fetch_row($this->Consulta_ID)) {
		echo "<tr> \n";
		for ($i = 0; $i < $this->numfields(); $i++){
		echo "<td>".$row[$i]."</td>\n";
		}
		echo "</tr>\n";
		}
}

function next_record()
	{
	//echo "MAT".mysql_fetch_array($this->Consulta_ID);
	return mysql_fetch_array($this->Consulta_ID);
	}
function libera()
	{
	mysql_free_result ($this->Consulta_ID);
	}
    
} //fin de la Clse DBmysql
?>