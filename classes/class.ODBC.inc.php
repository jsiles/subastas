<?php

/*	$driver = "{SQL Server Native Client 11.0}";
	$servidor = "DESKTOP-FG08IPJ\SQLEXPRESS2014";
	$database = "subastaBNB";
	$stringDSN = "Driver=" . $driver . ";Server=" . $servidor . ";Database=" . $database . ";";
	
	$userSQL = "userSubasta";
	$pswdSQL = "Abc-1234";
	$conn = odbc_connect($stringDSN, $userSQL, $pswdSQL) 
			or die("Error de Conexion");
        echo "Intentado conexion"."<br>";
        $sql="select usr_uid, usr_firstname from sys_users";
        $res = odbc_exec($conn, $sql);
        while(odbc_fetch_row($res)){
            echo odbc_result($res, 1)."<BR>";
            echo odbc_result($res, 2)."<BR>";
            
        }
        odbc_close($conn);
*/
class DBmysql {

private $debug;
private $row;

			var $BaseDatos;
			var $Servidor;
			var $Usuario;
			var $Clave;
			var $Conexion_ID = 0;
			var $Consulta_ID = 0;
			var $Errno = 0;
			var $Error = "";
			var $engine;

			function __construct($db=DATABASE, $host=DBHOST, $user=DBUSER, $pass=DBPASSWORD) {
			$this->BaseDatos = $db;
			$this->Servidor = $host;
			$this->Usuario = $user;
			$this->Clave = $pass;	
			$this->engine="Driver={SQL Server Native Client 11.0}";
			$this->connect();
	}

function connect($db="", $host="", $user="", $pass="")
	{
	if ($db != "") $this->BaseDatos = $db;
	if ($host != "") $this->Servidor = $host;
	if ($user != "") $this->Usuario = $user;
	if ($pass != "") $this->Clave = $pass;
    		$this->Conexion_ID = odbc_connect($this->engine.";Server=".$this->Servidor.";Database=".$this->BaseDatos,  $this->Usuario, $this->Clave);
                if(is_resource($this->Conexion_ID))
                    return true;
                else
                    return false;
	}
 
/**
 * Initialize debbuger
 *
 * @param boolean $debug
 */
function debug($debug=true){
   $this->debug=$debug; 
}


/* Ejecuta un consulta */
function query($sql = "",$show=0){

		if ($show != 0)
			echo "sql=$sql";
		if ($sql == "")
			{
			$this->Error = "No ha especificado una consulta SQL";
			echo "<bn>ERROR". $this->Error;
			return 0;
			}
		$this->Consulta_ID =odbc_exec($this->Conexion_ID, $sql) or die("ERROR DB ".  odbc_errormsg());
		return $this->Consulta_ID;
}

function next_record()
	{
		return (!$this->Consulta_ID)?null:odbc_fetch_row($this->Consulta_ID);
	}
function numrows($_pagi_sql="")	
{
   return (!$this->Consulta_ID)?0:odbc_num_rows($this->Consulta_ID);

}
/*
function numrows($_pagi_sql="")	
{
	if(strlen($_pagi_sql)>0)
	{
   		$_pagi_sql = strtoupper($_pagi_sql);
   		$_pagi_sqlConta = preg_replace("[(^SELECT.*FROM)]", "SELECT COUNT(*) FROM", $_pagi_sql );
   		$_pagi_sqlConta = preg_replace("[(ORDER BY.*)]", "", $_pagi_sqlConta);
                $_pagi_sqlConta = preg_replace("[(GROUP BY.*)]", "", $_pagi_sqlConta);
                $_pagi_sqlConta = strtolower($_pagi_sqlConta);
                //echo $_pagi_sqlConta;die;
   		$this->Consulta_ID = $this->Conexion_ID->query($_pagi_sqlConta); 
	}
   return ((!$this->Consulta_ID)||($this->Consulta_ID=='NULL'))?0:$this->Consulta_ID->fetch()[0];
   

}*/
} //fin de la Clase DBmysql
?>