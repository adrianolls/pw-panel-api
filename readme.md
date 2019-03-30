<p align="left"><img src="https://i.imgur.com/ef7Oecs.png"></p>


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

## Iniciando o servidor

Após a instalação de todas as dependências e configuração do .env, você poderá iniciar o servidor com o seguinte comando:

`php -S 0.0.0.0:8000 -t public`

## Documentação

Para acessar a documentação entre no diretório development no terminal e digite o comando:

`./swagger.sh`

Se você for um usuário de linux é necessário dar permissão de execução para o swagger, então antes de rodar o comando acima digite:

`sudo chmod +x swagger.sh`

Tendo em mente que o servidor do projeto está rodando acesse a URL ['http://localhost:8000/swagger'](http://localhost:8000/swagger) para acessar a documentação da API

## Licença

Este projeto está licenciado sob a licença MIT
