# API de Calculadora com Validação de CPF - Workshop Mouts TI

API REST desenvolvida em PHP com funções de calculadora e validação de CPF, incluindo testes unitários com PHPUnit.

## Requisitos

- Docker
- Docker Compose

## Estrutura do Projeto
```
.
├── Dockerfile
├── docker-compose.yml
├── composer.json
├── phpunit.xml
├── index.php
└── tests/
    ├── CalculadoraTest.php
    └── ValidacaoCPFTest.php
```

## Instalação e Execução

1. Clone o repositório e acesse a pasta:
```bash
git clone https://github.com/MoutsIT/projetos-workshop
cd projetos-workshop
```

2. Construa e inicie os containers:
```bash
docker-compose build
docker-compose up -d
```

## Executando os Testes

Para executar os testes unitários e gerar o relatório de cobertura:
```bash
docker-compose run test
```

O relatório de cobertura será gerado em `coverage/index.html`

## Endpoints da API

### Operações Matemáticas
- **URL**: `/`
- **Método**: `POST`
- **Corpo da Requisição**:
```json
{
    "num1": 10,
    "num2": 5,
    "operation": "soma"
}
```

**Operações disponíveis:**
- `soma`
- `subtracao`
- `multiplicacao`
- `divisao`

### Exemplo de Uso
```bash
curl -X POST http://localhost:8080 \
     -H "Content-Type: application/json" \
     -d '{"num1": 10, "num2": 5, "operation": "soma"}'
```

## Validação de CPF

A função validarCPF() verifica:
- Formato correto (11 dígitos)
- Dígitos verificadores
- Números repetidos
- Caracteres especiais

## Solução de Problemas

1. Verificar status dos containers:
```bash
docker-compose ps
```

2. Verificar logs:
```bash
docker-compose logs test
```

3. Reconstruir containers:
```bash
docker-compose down
docker-compose build --no-cache
docker-compose up -d
```

## Desenvolvimento

Para adicionar novos testes:
1. Crie os arquivos de teste em `/tests`
2. Execute `docker-compose run test`
3. Verifique a cobertura em `coverage/index.html`