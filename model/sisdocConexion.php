<?php 
class sisdocConexion {

    private $host;
    private $port;
    private $username; 
    private $password; 
    private $db;
    private $pdo;
    private $cacheQueries = array();

    public function __construct()
    {
        $this->host = '';
        $this->port = '';
        $this->username = '';
        $this->password = '';
        $this->db = '';
    }

    private function connect(){
        if($this->pdo === null){
            $dsn = "mysql:host={$this->host};dbname={$this->db}; port={$this->port}; charset=utf8mb4";
            $this->pdo = new PDO( $dsn, $this->username, $this->password, array (
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ) );
        }
        return $this->pdo;
    }

    private function execute( string $sql, array $params = array() )
    {
        $pdo = $this->connect();
        $stmt = $pdo->prepare($sql);
        $stmt = $pdo->execute($params);
        return $stmt; 
    }

    public function query( string $sql, array $params= array(), $cacheKey='', $useCache=false)
    {
        if( $useCache && empty($cacheKey) && isset($this->cacheQueries[$cacheKey])){
            
        }
    
    }


    protected function handlerException ($e)
    {
        $errorMessage = date("Y-m-d H:i:s") . ":" . $e->getMessage() . " || " . $e . "\n"; 
        error_log($errorMessage, 3, _ROOT_PATH . '/log/conexiones.log');
    }
}