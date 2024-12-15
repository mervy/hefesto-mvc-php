<?php

namespace HefestoMVC\database;

use PDO;

class Model
{
    protected $table;
    protected $conn;
    protected $query;
    protected $bindings = [];

    public function __construct($table)
    {
        $this->table = $table;
        $this->conn = Connection::connect(); // Conectar ao banco de dados
        $this->resetQuery();
    }

    private function resetQuery()
    {
        $this->query = "SELECT * FROM {$this->table}";
        $this->bindings = [];
    }

    public function find($id)
    {
        return $this->where('id', '=', $id)->limit(1)->get()[0] ?? null;
    }

    public function where($field, $operator, $value)
    {
        $this->query .= empty($this->bindings) ? " WHERE" : " AND";
        $this->query .= " {$field} {$operator} :{$field}";
        $this->bindings[$field] = $value;

        return $this;
    }

    public function limit($limit)
    {
        $this->query .= " LIMIT {$limit}";
        return $this;
    }

    public function offset($offset)
    {
        $this->query .= " OFFSET {$offset}";
        return $this;
    }

    public function orderBy($field, $direction = 'ASC')
    {
        $this->query .= " ORDER BY {$field} {$direction}";
        return $this;
    }

    public function join($table, $foreignKey, $primaryKey, $columns = '*')
    {
        $this->query = str_replace('SELECT *', "SELECT {$columns}", $this->query);
        $this->query .= " INNER JOIN {$table} ON {$this->table}.{$foreignKey} = {$table}.{$primaryKey}";
        return $this;
    }

    public function like($field, $value)
    {
        $this->query .= empty($this->bindings) ? " WHERE" : " AND";
        $this->query .= " {$field} LIKE :{$field}";
        $this->bindings[$field] = "%{$value}%";

        return $this;
    }

    public function get()
    {
        $stmt = $this->conn->prepare($this->query);
        foreach ($this->bindings as $param => $value) {
            $stmt->bindValue(":{$param}", $value);
        }
        $stmt->execute();
        $this->resetQuery();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function insert(array $data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";

        $stmt = $this->conn->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        return $stmt->execute();
    }

    public function update(array $data, $id)
    {
        $setClause = implode(', ', array_map(fn($key) => "{$key} = :{$key}", array_keys($data)));
        $query = "UPDATE {$this->table} SET {$setClause} WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":{$key}", $value);
        }
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }

    public function delete($id)
    {
        $query = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(":id", $id);
        return $stmt->execute();
    }
    
    public function countAll() {
        $query = "SELECT COUNT(*) FROM {$this->table}";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchColumn(); // Retorna o número de registros encontrados
    }
}/*

Usos

$articleModel = new Model('articles');

// Buscar artigos publicados, com autores, ordenados por data de criação
$articles = $articleModel
    ->where('status', '=', 'published')
    ->join('authors', 'author_id', 'id', 'articles.*, authors.name AS author_name')
    ->orderBy('created_at', 'DESC')
    ->limit(10)
    ->offset(0)
    ->get();

// Iterar nos resultados
foreach ($articles as $article) {
    echo "Título: {$article->title}" . PHP_EOL;
    echo "Autor: {$article->author_name}" . PHP_EOL;
    echo "Conteúdo: " . substr($article->content, 0, 100) . "..." . PHP_EOL;
}

$articleModel = new Model('articles');
$newArticle = [
    'title' => 'Novo Artigo',
    'content' => 'Este é o conteúdo do novo artigo.',
    'author_id' => 1,
    'status' => 'draft',
];
$articleModel->insert($newArticle);


*/