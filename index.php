<?php
// Configuração de cabeçalhos para permitir acesso à API
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Funções básicas de cálculo
function somar($num1, $num2) {
    return $num1 + $num2;
}

function subtrair($num1, $num2) {
    return $num1 - $num2;
}

function multiplicar($num1, $num2) {
    return $num1 * $num2;
}

function dividir($num1, $num2) {
    if ($num2 == 0) {
        return "Erro: Divisão por zero.";
    }
    return $num1 / $num2;
}

function validarCPF($cpf) {
    // Remove caracteres não numéricos
    $cpf = preg_replace('/[^0-9]/', '', $cpf);
    
    // Verifica se tem 11 dígitos
    if (strlen($cpf) != 11) {
        return ["valido" => false, "erro" => "CPF deve ter 11 dígitos"];
    }
    
    // Verifica se todos os dígitos são iguais
    if (preg_match('/^(\d)\1*$/', $cpf)) {
        return ["valido" => false, "erro" => "CPF não pode ter todos os dígitos iguais"];
    }
    
    // Calcula o primeiro dígito verificador
    $soma = 0;
    for ($i = 0; $i < 9; $i++) {
        $soma += $cpf[$i] * (10 - $i);
    }
    $resto = $soma % 11;
    $digito1 = ($resto < 2) ? 0 : 11 - $resto;
    
    // Verifica o primeiro dígito
    if ($cpf[9] != $digito1) {
        return ["valido" => false, "erro" => "Primeiro dígito verificador inválido"];
    }
    
    // Calcula o segundo dígito verificador
    $soma = 0;
    for ($i = 0; $i < 10; $i++) {
        $soma += $cpf[$i] * (11 - $i);
    }
    $resto = $soma % 11;
    $digito2 = ($resto < 2) ? 0 : 11 - $resto;
    
    // Verifica o segundo dígito
    if ($cpf[10] != $digito2) {
        return ["valido" => false, "erro" => "Segundo dígito verificador inválido"];
    }
    
    return ["valido" => true, "cpf_formatado" => substr($cpf, 0, 3) . '.' . 
           substr($cpf, 3, 3) . '.' . 
           substr($cpf, 6, 3) . '-' . 
           substr($cpf, 9, 2)];
}

// Obtendo os dados da requisição
$method = $_SERVER['REQUEST_METHOD'];
if ($method == 'POST') {
    $input = json_decode(file_get_contents("php://input"), true);

    // Verifica se é uma requisição de validação de CPF
    if (isset($input['cpf'])) {
        $resultado = validarCPF($input['cpf']);
        http_response_code(200);
        echo json_encode($resultado);
        exit;
    }

    // Verifica se é uma requisição de cálculo
    if (!isset($input['num1']) || !isset($input['num2']) || !isset($input['operation'])) {
        http_response_code(400);
        echo json_encode(["error" => "Parâmetros inválidos. Envie num1, num2 e operation ou cpf para validação."]);
        exit;
    }

    $num1 = $input['num1'];
    $num2 = $input['num2'];
    $operation = $input['operation'];

    switch ($operation) {
        case 'soma':
            $result = somar($num1, $num2);
            break;
        case 'subtracao':
            $result = subtrair($num1, $num2);
            break;
        case 'multiplicacao':
            $result = multiplicar($num1, $num2);
            break;
        case 'divisao':
            $result = dividir($num1, $num2);
            break;
        default:
            http_response_code(400);
            echo json_encode(["error" => "Operação inválida. Use soma, subtracao, multiplicacao ou divisao."]);
            exit;
    }

    http_response_code(200);
    echo json_encode(["result" => $result]);
} else {
    http_response_code(405);
    echo json_encode(["error" => "Método não permitido. Use POST."]);
}
?>