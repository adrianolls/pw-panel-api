<p align="left"><a href="https://www.adrianolls.dev/" target="_blank"><img src="https://i.imgur.com/ef7Oecs.png"></a></p>


# Perfect World Panel API

Este projeto será utilizado como portfólio de desenvolvimento com backend, aceito pull requests de contribuidores.

## Instalando dependências

Instalação de todos as dependências do composer.json no seu projeto. Esse comando irá fazer o download de tudo que será necessário:

`composer install`

## Configuração do env

Copie o arquivo .env.example e renomeie como .env:

`cp .env.example .env`

Configure com as informações do seu banco de dados no arquivo config/database.php e rode o seguinte comando:

`php artisan migrate`

## API Keys

Execute o comando no terminal para gerar as chaves de autorização de usuários

`php artisan passport:install`

## Iniciando o servidor

Após a instalação de todas as dependências e configuração do .env, você poderá iniciar o servidor com o seguinte comando:

`php -S 0.0.0.0:8000 -t public`

## Licença

Este projeto está licenciado sob a licença MIT
