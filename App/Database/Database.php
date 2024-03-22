<?php
namespace App\Database;
use PDO;
use PDOException;
use MongoDB\Client as MongoClient; // Importa o cliente MongoDB e apelida-o de MongoClient
use Exception;

class Database {
    private static $instance = null; // Mantém uma única instância da classe
    private $conn; // A conexão do banco de dados
    private $config; // As configurações do banco de dados

    private function __construct() {
        $this->config = require 'config.php'; // Carrega as configurações do banco de dados
        $dbConfig = $this->config['database']; // Obtém as configurações específicas do banco de dados
        $driver = $dbConfig['driver']; // Obtém o tipo de driver de banco de dados

        try {
            switch ($driver) {
                case 'mysql':
                    $mysqlConfig = $dbConfig['mysql']; // Configurações específicas para MySQL
                    $dsn = "mysql:host={$mysqlConfig['host']};dbname={$mysqlConfig['db_name']};charset={$mysqlConfig['charset']}";
                    // Define a string de conexão para o MySQL
                    $this->conn = new PDO($dsn, $mysqlConfig['username'], $mysqlConfig['password'], [PDO::ATTR_PERSISTENT => true]);
                    // Inicia a conexão PDO com o MySQL
                    break;
                case 'sqlite':
                    $sqliteConfig = $dbConfig['sqlite']; // Configurações específicas para SQLite
                    $dsn = "sqlite:{$sqliteConfig['path']}";
                    // Define a string de conexão para o SQLite
                    $this->conn = new PDO($dsn, null, null, [PDO::ATTR_PERSISTENT => true]);
                    // Inicia a conexão PDO com o SQLite
                    break;
                case 'sqlsrv':
                    $sqlsrvConfig = $dbConfig['sqlsrv']; // Configurações específicas para SQL Server
                    $dsn = "sqlsrv:Server={$sqlsrvConfig['host']};Database={$sqlsrvConfig['db_name']}";
                    // Define a string de conexão para o SQL Server
                    $this->conn = new PDO($dsn, $sqlsrvConfig['username'], $sqlsrvConfig['password'], [PDO::ATTR_PERSISTENT => true]);
                    // Inicia a conexão PDO com o SQL Server
                    break;
                case 'pgsql':
                    $pgsqlConfig = $dbConfig['pgsql']; // Configurações específicas para PostgreSQL
                    $dsn = "pgsql:host={$pgsqlConfig['host']};port={$pgsqlConfig['port']};dbname={$pgsqlConfig['db_name']};user={$pgsqlConfig['username']};password={$pgsqlConfig['password']}";
                    // Define a string de conexão para o PostgreSQL
                    $this->conn = new PDO($dsn);
                    // Inicia a conexão PDO com o PostgreSQL
                    break;
                // case 'mongodb':
                //     $mongodbConfig = $dbConfig['mongodb']; // Configurações específicas para MongoDB
                //     $dsn = "mongodb://{$mongodbConfig['host']}:{$mongodbConfig['port']}";
                //     $this->conn = new MongoClient($dsn, [
                //         'username' => $mongodbConfig['username'],
                //         'password' => $mongodbConfig['password']
                //     ]);
                //     $this->conn = $this->conn->selectDatabase($mongodbConfig['db_name']);
                //     break;
            }

            if (in_array($driver, ['mysql', 'sqlite', 'sqlsrv', 'pgsql'])) {
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // Define o modo de erro de exceção para a conexão PDO
            }
        } catch(PDOException $exception) {
            echo "Erro de conexão: " . $exception->getMessage();
            // Captura e imprime exceções do PDO
        } catch(Exception $exception) {
            echo "Erro de conexão (MongoDB): " . $exception->getMessage();
            // Captura e imprime exceções genéricas
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
            // Cria uma nova instância da classe se ainda não existir
        }
        return self::$instance->conn;
        // Retorna a conexão do banco de dados
    }

    private function __clone() {}
    // Evita que a classe seja clonada
}
