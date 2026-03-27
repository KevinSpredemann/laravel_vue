## Projeto desenvolvido com Laravel 12 e Vue.js. 
### Como criar o projeto com Laravel e Vue.js?

## Requisitos

* PHP 8.2 ou superior - Conferir a versão: php -v
* MySQL 8 ou superior;
* Composer - Conferir a instalação: composer --version
* Node.js 22 ou superior - Conferir a versão: node -v

## Como rodar o projeto baixado

```
git clone https://github.com/KevinSpredemann/laravel_vue.git
```

- Duplicar o arquivo ".env.example" e renomear para ".env".

- Para a funcionalidade enviar e-mail funcionar, necessário alterar as credenciais do servidor de envio de e-mail no arquivo .env.
- Utilizar o servidor fake durante o desenvolvimento: [Acessar envio gratuito de e-mail](https://mailtrap.io)
```
MAIL_MAILER=smtp
MAIL_SCHEME=null
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=nome-do-usuario-na-mailtrap
MAIL_PASSWORD=senha-do-usuario-na-mailtrap
MAIL_FROM_ADDRESS="colocar-email-remetente@meu-dominio.com.br"
MAIL_FROM_NAME="${APP_NAME}"
```

Instalar as dependências do PHP.
```
composer install
```

Instalar as dependências do Node.js.
```
npm install
```

Gerar a chave no arquivo .env.
```
php artisan key:generate
```

Executar as migrations para criar as tabelas e as colunas.
```
php artisan migrate
```

Executar as seeders para cadastrar os dados de teste.
```
php artisan db:seed
```

Rodar o projeto local.
```
composer run dev
```

Acessar a página criada com Laravel.
```
http://127.0.0.1:8000
```

## Sequência para criar o projeto

Instalar o Laravel no computador.
```
composer global require laravel/installer
```

Criar o projeto com Laravel. A palavra "teste" no final indica o nome do diretório que será criado, e dentro dele o projeto será instalado.
```
laravel new teste
```

- Which starter kit would you like to install? / Qual kit inicial você gostaria de instalar? Digite vue e pressione Enter.
- Which authentication provider do you prefer? / Qual provedor de autenticação você prefere? Digite laravel e pressione Enter.
- Which testing framework do you prefer? / Qual framework de testes você prefere? Digite 0 e pressione Enter.
- Would you like to run npm install and npm run build? (yes/no) [yes]: / Você gostaria de executar npm install e npm run build? (sim/não) [sim]: Pressione Enter.

Acessar o diretório do projeto.
```
cd teste
```

Rodar o projeto local.
```
composer run dev
```

## 🐳 Como rodar o projeto com Docker

### Requisitos
* Docker - Conferir a instalação: docker -v
* Docker Compose - Conferir a instalação: docker compose version

### Como rodar o projeto com Docker
* Certifique-se de que o Docker está em execução (Docker Desktop aberto).

Criar o arquivo docker-compose.yml na raiz do projeto:
```
version: '3.8'

services:
  app:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: laravel_app
    restart: unless-stopped
    working_dir: /var/www
    volumes:
      - .:/var/www
    ports:
      - "8000:8000"
    depends_on:
      - mysql
    networks:
      - laravel

  mysql:
    image: mysql:8
    container_name: laravel_mysql
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: laravel
    ports:
      - "3307:3306"
    volumes:
      - mysql_data:/var/lib/mysql
    networks:
      - laravel

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    container_name: laravel_phpmyadmin
    restart: unless-stopped
    ports:
      - "8080:80"
    environment:
      PMA_HOST: mysql
      MYSQL_ROOT_PASSWORD: root
    depends_on:
      - mysql
    networks:
      - laravel

networks:
  laravel:

volumes:
  mysql_data:
```

Criar o arquivo Dockerfile na raiz do projeto:
```
FROM php:8.2-fpm

WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

CMD php artisan serve --host=0.0.0.0 --port=8000
```

Criar a pasta na docker/nginx com o arquivo default.conf
```
server {
    listen 80;

    root /var/www/public;
    index index.php index.html;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass app:9000;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
    }
}
```

Alterar as credenciais do banco de dados no arquivo .env
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=root
```

Subir o container da aplicação:
```
docker compose up -d --build
```

Acessar o container da aplicação:
```
docker exec -it laravel_app bash
```

Instalar as dependências e configurar o Laravel:
```
composer install
php artisan key:generate
php artisan migrate
php artisan db:seed
```

Acessar a página criada com Laravel.
```
http://localhost:8000
```

Acessar o phpMyAdmin (gerenciar banco de dados):
```
http://localhost:8080
```

Login no phpMyAdmin:
```
Servidor: mysql
Usuário: root
Senha: root
```



Traduzir para português [Módulo pt-BR](https://github.com/lucascudo/laravel-pt-BR-localization)

Criar migration para criar a tabela no banco de dados.
```
php artisan make:migration create_nome_table
```
```
php artisan make:migration create_tasks_table --create=tasks
```

Criar a Models. A models é usada para gerenciar a tabela do banco de dados através do Eloquent ORM.
```
php artisan make:model NomeDaModel
```
```
php artisan make:model Task
```

Criar Seed para cadastrar dados de teste.
```
php artisan make:seeder NomeSeeder
```
```
php artisan make:seeder TaskSeeder
```

Criar a Controller.
```
php artisan make:controller NomeController
```
```
php artisan make:controller Tasks/TaskController
```
