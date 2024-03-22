<?php
namespace App\Repository;

use App\Database\Database;
use App\Model\Cliente; // Importa a classe Cliente
use PDO;

class ClienteRepository
{
    private $conn; // Variável para armazenar a conexão com o banco de dados

    // Método construtor, inicializa a conexão com o banco de dados
    public function __construct() {
        $this->conn = Database::getInstance(); // Obtém uma instância da classe de conexão com o banco de dados
    }

    // Método para inserir um novo cliente no banco de dados
    public function insert(Cliente $cliente){
        // Obtém os atributos do cliente
        $nome = $cliente->getNome();
        $email = $cliente->getEmail();
        $cidade = $cliente->getCidade();
        $estado = $cliente->getEstado();

        // Query SQL para inserção de dados
        $query = "INSERT INTO clientes (nome, email, cidade, estado) VALUES (:nome, :email, :cidade, :estado)";
        $stmt = $this->conn->prepare($query);

        // Associa os parâmetros da query aos valores obtidos do cliente
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":cidade", $cidade);
        $stmt->bindParam(":estado", $estado);

        // Executa a query preparada
        if($stmt->execute())
            return true; // Retorna true se a inserção for bem-sucedida
        else
            return false; // Retorna false se houver algum erro na inserção
    }

    // Método para obter todos os clientes do banco de dados
    public function getAll(){
        $query = "SELECT * FROM clientes"; // Query SQL para selecionar todos os clientes
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todos os resultados como uma matriz associativa
    }

    // Método para obter um cliente pelo ID
    public function getById(Cliente $cliente){
        $id = $cliente->getClienteId();
        $query = "SELECT * FROM clientes WHERE cliente_id = :id"; // Query SQL para selecionar um cliente por ID
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna um único resultado como uma matriz associativa
    }

    // Método para atualizar os detalhes de um cliente no banco de dados
    public function update(Cliente $cliente){
        $id = $cliente->getClienteId();
        $nome = $cliente->getNome();
        $email = $cliente->getEmail();
        $cidade = $cliente->getCidade();
        $estado = $cliente->getEstado();

        // Query SQL para atualizar os detalhes do cliente com base no ID
        $query = "UPDATE clientes SET  nome = :nome, email = :email, cidade = :cidade, estado = :estado WHERE cliente_id = :cliente_id";
        $stmt = $this->conn->prepare($query);

        // Associa os parâmetros da query aos valores obtidos do cliente
        $stmt->bindParam(":cliente_id", $id, PDO::PARAM_INT);
        $stmt->bindParam(":nome", $nome);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":cidade", $cidade);
        $stmt->bindParam(":estado", $estado);

        // Executa a query preparada
        if($stmt->execute())
            return true; // Retorna true se a atualização for bem-sucedida
        else
            return false; // Retorna false se houver algum erro na atualização
    }

    // Método para excluir um cliente do banco de dados
    public function delete(Cliente $cliente){
        $id = $cliente->getClienteId();
        $query = "DELETE FROM clientes WHERE cliente_id = :cliente_id"; // Query SQL para excluir um cliente por ID
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cliente_id", $id, PDO::PARAM_INT);
        
        // Executa a query preparada
        if($stmt->execute())
            return true; // Retorna true se a exclusão for bem-sucedida
        else
            return false; // Retorna false se houver algum erro na exclusão
    }
}