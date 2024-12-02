<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../index.php';

class CalculadoraTest extends TestCase
{
    public function testSomar()
    {
        $this->assertEquals(4, somar(2, 2));
        $this->assertEquals(0, somar(-2, 2));
        $this->assertEquals(-4, somar(-2, -2));
        $this->assertEquals(0, somar(0, 0));
    }

    public function testSubtrair()
    {
        $this->assertEquals(0, subtrair(2, 2));
        $this->assertEquals(-4, subtrair(-2, 2));
        $this->assertEquals(0, subtrair(-2, -2));
        $this->assertEquals(5, subtrair(10, 5));
    }

    public function testMultiplicar()
    {
        $this->assertEquals(4, multiplicar(2, 2));
        $this->assertEquals(-4, multiplicar(-2, 2));
        $this->assertEquals(4, multiplicar(-2, -2));
        $this->assertEquals(0, multiplicar(0, 5));
    }

    public function testDividir()
    {
        $this->assertEquals(1, dividir(2, 2));
        $this->assertEquals(-1, dividir(-2, 2));
        $this->assertEquals(1, dividir(-2, -2));
        $this->assertEquals(2, dividir(10, 5));
        $this->assertEquals("Erro: Divisão por zero.", dividir(5, 0));
    }
}
