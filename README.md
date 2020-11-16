Desafio NetShow.me
=======================

Tecnologias utilizadas:
-----------------------

 * PHP v7.3 ou superior
 * Node v14.15.0
 * MySql v5.7.32
 * VueJs v2.5.17 ou superior

Instalação e Execução do projeto
------------
Clone o projeto:

    git clone https://github.com/guilhermeof/netshowme-desafio.git

Após efetuar o clone do projeto acesse a pasta e rode o seguinte comando para instalar as dependências:

    composer install
    
Após a instalação copia o arquivo .env.example (Caso esteja em um ambiente linux, basta executar o seguinte comando):

    cp .env.example .env

Agora insira as informações do seu banco local nas seguintes variáveis:

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=database
    DB_USERNAME=user
    DB_PASSWORD=password

Logo em seguinte execute o comando abaixo para rodar as migrations do projeto:

    php artisan migrate
    
Execute o comando abaixo para gerar a chave da aplicação:

    php artisan key:generate

Para instalar as dependências do node e buildar o projeto, execute o comando abaixo:

    npm install && npm run dev

Para executar a aplicação execute o server do laravel:

    php artisan serve
    
Logo em seguida acesse a URL:

    http://localhost:8000/
    
Execução dos testes unitários:

    ./vendor/bin/phpunit
    
**Observação.:** Para setar o recebedor do e-mail, basta preencher a variável `MAIL_TO` que encontra-se no arquivo de configuração do projeto `.env`. Deve ser inserido também as informações do seu servidor de e-mail para que funcione tudo corretamente.
    
