<?php
require_once ('conexion.php');

class transparencia {

    public function tableViews ()
    {
        $conexion = new MySQLConnection();
        $SenteceSql = "SELECT * FROM visitas ORDER BY hora_de_ingreso DESC";
        //$params=date('imd');
        $result = $conexion->query($SenteceSql,'','',false);
        $conexion->close();
        $ResultadoConsulta = $result->fetchAll();
       
        print_r($ResultadoConsulta);
       
    }
}