<?php

namespace HefestoMVC\database;

use PDO;
use PDOException;

class Connection {

    private static $conn;

    // Tornar o método e a propriedade estáticos
    public static function connect() {
        if (self::$conn === null) {
            try {
                // Corrigir a interpolação de variáveis
                $dsn = "mysql:host={$_ENV['DB_HOST']};dbname={$_ENV['DB_NAME']}";
                $username = $_ENV['DB_USER'];
                $password = $_ENV['DB_PASS'];

                // Criar a conexão PDO
                self::$conn = new PDO($dsn, $username, $password);

                // Configurar o modo de recuperação de dados
                self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            } catch (PDOException $e) {
                // Exibir erro de conexão
                echo "Connection failed: " . $e->getMessage();
            }
        }

        return self::$conn;
    }
}