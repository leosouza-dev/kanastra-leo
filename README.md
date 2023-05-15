
# Kanastra 

## Informações sobre o projeto

### Introdução
Sistema criado para controle de Dívidas, Pagamento e Envio de Emails com boletos para devedores.
Para resolver o problema foi criado uma api usando PHP e Laravel.

### Organização do Projeto
Como comentado acima, o projeto foi desenvolvido utilizando Laravel e com isso acabamos usando um pouco da organização inicial que o framework fornce. Porém, para o desenvolvimeento da Regra de Negócio, foi criado uma pasta **src**.
Dentro da pasta **src** foi criado outras subpastas afim de criar uma arquitetura de camadas, inicialmente idelizando conceitos como Arquitetura Limpa, assim isolando o domínio e delegando as responsabilidades para cada camada.
As camadas criadas foram:

- Domain: que contém as **Entidades** da aplicação;
- Application: responsável por pela orquestração com os Casos de Usos;
- Infraestructure: que possui o **Controlador** e as implementações das abstrações de **Serviços** e **Repositórios**;

Para acesso ao Banco de Dados foi usado o ORM **Eloquent**;
O **Banco de Dados** usado foi o MySQL;
Na Pasta de **Test** foram criado testes para garantir uma maior qualidade de código;

### Setup e Execuçao do projeto

Para conseguirmos rodar o ambiente foi utilizado **Docker**. Com isso temos os arquivos de **Dockerfile** e **Docker-compose** para executarmos o projeto.

### Passo a Passo

1 - Clone do Reposótório
```sh
git clone https://github.com/leosouza-dev/kanastra-leo
```

2 - Acessar pasta do projeto
```sh
cd kanastra-leo
```

3 - Crie o Arquivo .env
```sh
cp .env.example .env
```

4 - Atualize as variáveis de ambiente do arquivo .env. Ex:
```dosini
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:l8dZ0OsMT7+Jd7mz/e0AZlJ+W+GdFm8dEQUNT4ZjPQo=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=kanastra
DB_USERNAME=kanastra
DB_PASSWORD=kanastra

QUEUE_CONNECTION=redis
REDIS_HOST=redis
REDIS_PASSWORD=null
REDIS_PORT=6379

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

5 - Suba os containers do projeto
```sh
docker-compose up -d
```

6 - Acesse o container app
```sh
docker-compose exec app bash
```

7 - Instale as dependências do projeto
```sh
composer install
```

8 - Gere a key do projeto Laravel
```sh
php artisan key:generate
```

9 - rodar migration
```sh
php artisan migrate
```

### Endpoints
Nese projeto temos três endpoints configurados dos arquivos de Rotas de API do Laravel.

1 -  Importação de Dívidas de Arquivo CSV: POST: 'http://localhost:8989/debts/import'
Responsável por receber e Persistir as dívidas presente em arquivo CSV. 
Exemplo de contéudo:
``` csv
name,governmentId,email,debtAmount,debtDueDate,debtId
John Doe,11111111111,johndoe@kanastra.com.br,1000000.00,2022-10-12,8291 
```

2 - Envio de Email para devedores: POST: 'http://localhost:8989/debts/sendEmail'
Responsável por enviar email para devedores (Dívidas com o status diferente de Paga).

3 - Realização de pagamento de Dívidas: POST: 'http://localhost:8989/debts/debtPaid'
Responsável por receber atualizações de pagamentos de dívida.
Exemplo de body:
``` json
{
	"debtId": "8291",
	"paidAt": "2022-06-09 10:00:00",
	"paidAmount": 100000.00,
	"paidBy": "John Doe"
}
```

### Melhorias
Devido as escolhas de Tecnologias utilizadas no desenvolvimento e ao tempo para entrega não foi possível finalizar o projeto como tinha planejado inicialmente.

Alguns Exemplos de melhorias: 
- [] Criar Autenticação - Ex: API Key para webhooks;
- [] Utilização de documentação;
- [] Utilização de cron job para controle de envio de email;
- [] Criar sistema de mensageria para tratar a conversão de Arquivos CSV e Envios de Emails;
- [] Utilização de Cache;