# back_tech_test
Teste de backend em laravel

### Inicialização
Baixe o projeto e faça uma cópia do arquivo .env.example para .env com as variáveis do seu ambiente

em seguida execute o comando
```shell
$ composer install
```

O comando irá baixar as dependências do projeto

### Execução
Para executar basta subir o container utilizando os comandos do sail

Na pasta do projeto, para subir o ambiente execute:
```shell
$ ./vendor/bin/sail up -d
```
O comando irá criar novos containers seguindo a receita do arquivo `docker-compose.yml`, executando em segundo plano.

Para para a execução:
```shell
$ ./vendor/bin/sail down
```

Com o banco de dados configurado no .env, efetue as migrações para criar as tabelas:
```shell
$ ./vendor/bin/sail artisan migrate
```

Para executar os testes das funcionalidade:
```shell
$ ./vendor/bin/sail artisan test
```
