# Desafio técnico da Lotus Experience
Olá!

Seja muito bem-vindo à desafio técnico da Lotus Experience.
Preparamos esse desafio técnico para você ter a oportunidade de demonstrar o seu conhecimento e experiência, na prática.
Queremos que essa seja uma boa experiência para você e para nós!

A Lotus Experience é responsável pela tecnologia da Central do Frete.

Para esta vaga a atuação é direta nos projetos da Central do Frete, uma startup do segmento logístico que tem por missão facilitar a vida de empresas que precisam cotar e contratar fretes, para facilitar a compreensão nós somos a Trivago/Decolar dos fretes, guardadas as devidas proporções.

Trata-se de uma plataforma onde empresas podem realizar cotações com diversas transportadoras em poucos segundos e fazer todo o processo de contratação do frete de forma online.

Esse desafio consiste em uma pequena simulação de como será o sua dia a dia como desenvolvedor na Lotus Experience tomando esse contexto da Central do Frete como exemplo.
As principais tecnologias que você terá contato nesse desafio serão: Laravel, MySQL e GraphQL.

## Nenhum teste será deixado de lado
Talvez você já tenha visto ou já passou por uma situação onde uma empresa pede para você fazer um teste técnico, você envia e depois eles não te dão resposta. Sim, muitos de nós já passamos por isso.

Na Lotus Experience, nós respeitamos e valorizamos o seu tempo. Todos os testes serão avaliados e todos os testes terão uma sessão de feedback, onde nós te contamos o que achamos do seu projeto. Nessa mesma sessão, nós também te contamos se você conseguiu passar para a próxima fase ou não.

## Tempo para Entrega

Após receber esse desafio, você possui 1 semana para entrega-lo. Se você não puder fazer o desafio na semana que você recebeu, avisa pra gente com antecedência.

Nós estamos aqui para conhecer mais sobre você e esse desafio é apenas um meio que encontramos de fazer isso. Então mesmo que você não esteja confiante com a versão que você fez ou não tenha conseguido concluí-la, pode mandar pra gente mesmo assim!

## Contexto
Uma das etapas de desenvolvimento é a validação de protótipo para, consequentemente, conseguir validar a ideia.
O protótipo começou a ser desenvolvido, sendo que por motivos de força maior foi parado e após um tempo você ficou encarregado de continuar o desenvolvimento dele.

## Como funciona
 - Você encontrará uma descrição detalhada sobre o desafio mais abaixo;
 - Você pode alterar o escopo do desafio, adicionando ou removendo algo se achar que vale a pena.
 - O desafio possui diversas tarefas. Você tem liberdade para decidir quais deseja fazer ou não.
 - Após concluir o projeto, é só mandar pra gente um link via e-mail falecom@lotusexperience.com.br
 - Ah! Super importante: o desafio possui um tempo para entrega. Mesmo que não consiga concluir tudo nesse tempo, você pode mandar pra gente e faremos a avaliação. =)

## Requisitos
Para garantir que seremos capazes de executar o teste, é extremamente importante que:

- O seu desafio esteja disponível em um repositório público no GitHub.
- O seu código deve ser escrito totalmente em inglês.
- Utilizar Semantic Commit Messages (https://gist.github.com/joshbuchea/6f47e86d2510bce28f8e7f42ae84c716), para cada tarefa um commit. nada de só um commit para todo o challenge, queremos ver como você evoluiu o projeto.

## Tarefas

### Tarefa 1:
Insira na tabela users os campos:
    - cpf: varchar(11)
    - birth_dt: date
Atualize a query fetchUsers para retornar o CPF formatado e birth_dt no formato d/m/Y.

### Tarefa 2:
Adicione um sistema de papéis (roles) aos usuários, podendo assumir os pápeis de: "customer", "shipping_carrier" e "admin". Cada usuário só pode ter um papel por vez.
Atualize a query fetchUsers para retornar o papel do usuário.

### Tarefa 3:
Os usuários do tipo shipping-carrier deverão ter os seguintes dados adicionais:
    - CNPJ;
    - Valor de transporte por kg.
Atualize a query fetchUsers para retornar um subarray com os novos dados quando o usuário possuir esse papel. O CNPJ deve está formatado.

### Tarefa 4:
Adicione o campo que víncule uma transportadora (usuário do tipo "shipping_carrier") ao pedido ("orders"). Além disso, adicione um novo status possível ao pedido:
    - delivered: quando for entregue.

### Tarefa 5:
Após registrado o pedido, deverá retornar uma lista com o valor cobrado pelas 5 transportadoras com menor preço. Esse valor será o seguinte cálculo para cada item: ((quantidade) * (peso)) * (valor_do_transporte_da_transportadora);

### Tarefa 6:
Os usuários "shipping_carrier" devem conseguir alterar o status dos seus pedidos, seguindo a seguinte ordem: "new" -> "on_carriage" -> "delivered". Cada alteração deve gerar um log salvando os seguintes dados (vale ressaltar desde já que uma tabela de log pode ser usado para diversos tipos de log, logo espera-se que você generalize essa tabela para permitir tal requisito):
    - Tipo de log (nesse caso seria "order_change_status");
    - Identificador do pedido;
    - Valores antigos;
    - Valores novos;
    - Data e hora da mudança.

### Tarefa 7:
Os usuários "admin" devem conseguir listar todos os usuários "shipping carrier" que realizaram transportes em um determinado mês. Além dos dados desses usuários deve ser mostrado a quantidade de transportes realizados e o total de dinheiro dos pedidos transportados.

### Tarefa 8:
Finalize a query fetchUsers (\App\GraphQL\TestPanel\Queries\FetchUsers). Nela falta realizar a operação de like (pesquisa) a partir do parâmetro recebido de mesmo nome.

### Tarefa 9:
Crie a query fetchOrders para retornar todos os pedidos páginados, ordenados do mais recente ao mais antigo.

### Tarefa 10:
Crie a query detailOrder que receberá como parâmetro o id do pedido e deve retornar todos os seus dados, além dos dados do usuário que registrou o pedido, os dados da transportadora e a lista de itens.

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
A avaliação da sua solução levará em conta os seguintes critérios:

* Modelagem de Dados
* Domínio da Linguagem
* Legibilidade do Código
* Estrutura do Código
* Organização do Código
* Design Patterns
* Manutenibilidade do Código
* Diferenciais: Testes Unitários e Cobertura de Testes

Você receberá uma resposta em até 1 semana. Iremos avaliar o seu teste e te passar um feedback, te contando se você passou para a próxima fase ou não.

## Disclaimer
Este projeto não é um produto, nunca será, não entrará em produção e não tem intenção de servir a nenhum outro propósito além de ser um aplicativo de mundo real para testar candidatos a uma posição na Lotus Experience.

## Dúvidas?
Se você tiver qualquer dúvida sobre o desafio, é só mandar um email para falecom@lotusexperience.com.br
