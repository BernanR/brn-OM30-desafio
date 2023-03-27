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
    Usuario e senha:
    User: admin@admin.com
    Senha: password

2. ```Registrar o serve:```
    Host: db
    Port: 5432
    Username: root
    Password: password

## Rodar migrates e seeds

1. ```docker-compose exec application.dev php artisan migrate```
2. ```docker-compose exec application.dev php artisan db:seed```
