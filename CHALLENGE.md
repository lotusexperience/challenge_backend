# Desafio Backend
A Lotus Experience é responsável pela tecnologia da Central do Frete.

Para esta vaga a atuação é direta nos projetos da Central do Frete, uma startup do segmento logístico que tem por missão facilitar a vida de empresas que precisam cotar e contratar fretes, para facilitar a compreensão nós somos a Trivago/Decolar dos fretes, guardadas as devidas proporções.

Trata-se de uma plataforma onde empresas podem realizar cotações com diversas transportadoras em poucos segundos e fazer todo o processo de contratação do frete de forma online.

Esse desafio consiste em uma pequena simulação de como será o sua dia a dia como desenvolvedor na Lotus Experience tomando esse contexto da Central do Frete como exemplo.
As principais tecnologias que você terá contato nesse desafio serão: Laravel, MySQL e GraphQL.

## Contexto
Uma das etapas de desenvolvimento é a validação de protótipo para, consequentemente, conseguir validar a ideia.
O protótipo começou a ser desenvolvido, sendo que por motivos de força maior foi parado e após um tempo você ficou encarregado de continuar o desenvolvimento dele.

Você receberá em seu e-mail os requisitos restantes para concluir esse protótipo.

## Instruções
Para ajudar no desenvolvimento e evitar perda de tempo com código _boilerplate_, decidimos prover uma estrutura básica para o desenvolvimento da sua solução utilizando a plataforma PHP (Laravel 6.* + MySQL). A estrutura deve ser utilizada no desenvolvimento da sua solução.

Execute a seguinte sequências de passos para iniciar corretamente a sua aplicação:
1. Copie o arquivo `.env.example` e salve como `.env`;
1. Execute o comando `docker-compose up --build` a partir do diretório raiz do projeto;
    1. A aplicação estará na porta `8010`, para verificar se está funcionando corretamente, basta acessar `http://localhost:8010/`.
1. `docker-compose run lotus-web composer install`;
1. `docker-compose run lotus-web php artisan key:generate`;
1. `docker-compose run mysql-database mysql -h mysql-database -u root --password=root -e "CREATE DATABASE central_do_frete;"`;
1. `docker-compose run lotus-web php artisan migrate`.

### Testar GraphQL
Você poderá testar suas _queries_ e _mutations_ através da página em `http://localhost:8010/graphql/test-panel`.

Algumas _queries_ e _mutations_ já foram criadas para servir de exemplo para você, seus exemplos de consulta e retorno estão no arquivo `GraphQL_Examples.md`.
Para ver como as suas respectivas operações ocorrem, basta acessar as classes mapeadas em `config/graphql.php`.

## Avaliação
A avaliação da sua solução será constituída de duas etapas principais: **Correção objetiva** e **Correção qualitativa**. 

Caso você não se sinta à vontade com a arquitetura proposta, você pode apresentar sua solução utilizando frameworks diferentes. 
Porém, nesse caso, uma entrevista de **Code Review** será necessária para a avaliação da sua solução.

A correção objetiva será realizada através da utilização de um script de correção automatizada. A correção qualitativa levará em conta os seguintes critérios:

* Modelagem de Dados
* Domínio da Linguagem
* Legibilidade do Código
* Estrutura do Código
* Organização do Código
* Design Patterns
* Manutenibilidade do Código
* Diferenciais: Testes Unitários e Cobertura de Testes
