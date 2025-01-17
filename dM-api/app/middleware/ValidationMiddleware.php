<?php

use Respect\Validation\Exceptions\ValidationException;

class ValidationMiddleware
{
    public static function validation(array $data, array $rules)
    {
        $errors = [];

        foreach ($rules as $field => $rule) {
            try {
                $rule->assert($data[$field] ?? null);
            } catch (ValidationException $e) {
                $errors[$field] = $e->getMessage();
            }
        }

        if (!empty($errors)) {
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'errors' => $errors,
            ]);
            exit; // Termina a execução se houver erros
        }

        // Retorna os dados validados
        return $data;
    }
}
