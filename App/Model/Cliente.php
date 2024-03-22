<?php
namespace App\Model;

class Cliente{
    // Propriedades da classe Cliente
    private int $cliente_id; // ID do cliente (inteiro)
    private string $nome; // Nome do cliente (string)
    private string $email; // E-mail do cliente (string)
    private string $cidade; // Cidade do cliente (string)
    private string $estado; // Estado do cliente (string)
    
    // Construtor da classe (vazio neste caso)
    public function __construct() {
        
    }

    // Métodos para acessar e definir o ID do cliente
    public function getClienteId(): int {
        return $this->cliente_id;
    }

    public function setClienteId(int $cliente_id): void {
        $this->cliente_id = $cliente_id;
    }

    // Métodos para acessar e definir o nome do cliente
    public function getNome(): string {
        return $this->nome;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    // Métodos para acessar e definir o e-mail do cliente
    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    // Métodos para acessar e definir a cidade do cliente
    public function getCidade(): string {
        return $this->cidade;
    }

    public function setCidade(string $cidade): void {
        $this->cidade = $cidade;
    }

    // Métodos para acessar e definir o estado do cliente
    public function getEstado(): string {
        return $this->estado;
    }

    public function setEstado(string $estado): void {
        $this->estado = $estado;
    }
}
