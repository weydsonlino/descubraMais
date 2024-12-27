<?php

require_once 'config/database.php';

class Model
{
    protected static $bd;

    protected static function getDb()
    {
        // Verifica se a conexão já foi estabelecida
        if (!self::$bd) {
            try {
                // Configuração do DSN
                $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;

                // Opções para o PDO
                $options = [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Erros como exceções
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Retorno de arrays associativos
                    PDO::ATTR_EMULATE_PREPARES => false,                 // Desativa emulação de prepared statements
                ];

                // Cria a conexão com o banco de dados
                self::$bd = new PDO($dsn, DB_USER, DB_PASS, $options);

            } catch (PDOException $e) {
                // Trata erros de conexão
                die("Erro ao conectar ao banco de dados: " . $e->getMessage());
            }
        }

        return self::$bd;
    }
}
?>