## Como instalar e rodar o projeto

1. ```git clone https://github.com/BernanR/brn-OM30-desafio.git```
2. ```cd application```
3. ```composer install```
3. Copy ```.env.example``` to ```.env```
4. ```docker-compose build```
5. ```docker compose up -d```
6. disponível na url ```127.0.0.1:8080```

## Criar servidor para o postgresql

1. Acessar painel pgAdmin4 ```http://localhost:5050/```
  - Usuario e senha:
    - User: admin@admin.com
    - Senha: password

2. ```Registrar o serve:```
  - Host: db
  - Port: 5432
  - Username: root
  - Password: password

## Rodar migrates e seeds

1. ```docker-compose exec application.dev php artisan migrate```
2. ```docker-compose exec application.dev php artisan db:seed```

## Link da Aplicação no postaman
```https://www.postman.com/red-star-7529/workspace/brn-0m30-desafio/overview```

## O que foi feito neste projeto.

 - desenvolvimento das API's nos padrões RESTful.
 - listagem de pacientes com busca, do qual deve-se permitir a adição, edição, visualização e exclusão de cada um dos pacientes.
 - endereço cadastrado em uma tabela à parte.
 - Utilizado banco de dados PostgreSQL e Redis (Cache e Queue).
 - Utilizado migration, factory, faker e seeder.
 - Criado endpoint para listagem onde seja possível consultar pacientes pelo nome ou CPF.
 - Criado um endpoint para obter os dados de um único pacientes (paciente e seu endereço).
 - Criado endpoints de cadastro e atualização de paciente, contendo os campos e suas respectivas validações.
 - Criado endpoint para excluir um paciente (paciente e seu endereço).
 - Criado endpoint para consulta de CEP e com cache (Redis) dos dados para futuras consultas.
 - Criado Criar um endpoint que faça importação de dados (pacientes) via arquivo .csv (não finalizei o processo assicrono))
 - Utilizado docker e docker-compose para execução do projeto 

## Link Public Collection API's
https://www.postman.com/red-star-7529/workspace/brn-0m30-desafio/collection/8990285-8b82e5bb-5e67-4956-8f77-758ec9bf57d4?action=share&creator=8990285
