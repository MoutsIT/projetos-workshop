<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../index.php';

class ValidacaoCPFTest extends TestCase
{
    public function testPrimeiroDigitoVerificadorInvalido()
    {
        // CPF com primeiro dígito verificador incorreto
        // CPF original válido: 529.982.247-25
        // Modificado o primeiro dígito verificador (9->0)
        $cpfInvalido = '529982247-05';
        
        // Executa a validação
        $resultado = validarCPF($cpfInvalido);
        
        // Verifica se o resultado está correto
        $this->assertFalse($resultado['valido']);
        $this->assertEquals(
            'Primeiro dígito verificador inválido',
            $resultado['erro']
        );
    }
    
    public function testPrimeiroDigitoVerificadorValido()
    {
        // CPF válido com primeiro dígito verificador correto
        $cpfValido = '529.982.247-25';
        
        // Executa a validação
        $resultado = validarCPF($cpfValido);
        
        // Verifica se o CPF é válido
        $this->assertTrue($resultado['valido']);
        $this->assertEquals(
            '529.982.247-25',
            $resultado['cpf_formatado']
        );
    }
    
    public function testCpfIncompleto()
    {
        // CPF válido com primeiro dígito verificador correto
        $cpfValido = '529.982.247-5';
        
        // Executa a validação
        $resultado = validarCPF($cpfValido);
        
        $this->assertFalse($resultado['valido']);
        $this->assertEquals(
            'CPF deve ter 11 dígitos',
            $resultado['erro']
        );
    }

    public function testCPFComTodosDigitosIguais()
    {
        // Testa CPF com todos os dígitos iguais
        $cpfDigitosIguais = '111.111.111-11';
        
        $resultado = validarCPF($cpfDigitosIguais);
        
        $this->assertFalse($resultado['valido']);
        $this->assertEquals(
            'CPF não pode ter todos os dígitos iguais',
            $resultado['erro']
        );
    }

    public function testSegundoDigitoVerificadorInvalido()
    {
        // Testa CPF com segundo dígito verificador inválido (linha 39)
        // CPF original válido: 529.982.247-25
        // Modificado o segundo dígito verificador (5->0)
        $cpfInvalido = '529982247-20';
        
        $resultado = validarCPF($cpfInvalido);
        
        $this->assertFalse($resultado['valido']);
        $this->assertEquals(
            'Segundo dígito verificador inválido',
            $resultado['erro']
        );
    }

    public function testDivisaoPorZero()
    {
        // Testa divisão por zero (linha 65)
        $num1 = 10;
        $num2 = 0;
        
        $resultado = dividir($num1, $num2);
        
        $this->assertEquals('Erro: Divisão por zero.', $resultado);
    }
} 