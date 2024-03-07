[![Codacy Badge](https://app.codacy.com/project/badge/Grade/c894f7a6a1544b2587b471af2ae7d808)](https://app.codacy.com/gh/josegabriel42/ufape-sports/dashboard?utm_source=gh&utm_medium=referral&utm_content=&utm_campaign=Badge_grade)

## Descrição

Modelo simples de um e-commerce de artigos esportivos. Projeto criado para compor nota na matéria de Banco de Dados no curso de BCC.

## Como rodar

1. Clone o projeto
2. Crie uma cópia do arquivo .env.example e renomeie para .env
3. Insira as informações de seu banco de dados local no arquivo .env
4. Rode os seguintes comandos para configurar o ambiente
	- composer update
	- composer install
	- npm install
	- npm run dev
5. Instale os seeders do projeto usando o comando: php artisan migrate:fresh --seed
6. Rode "php artisan serve" toda vez que quiser começar o desenvolvimento local

## Funcionalidades
    - Como ADM:
        1. Login
        2. Gerenciar os produtos / categorias / promoções no sistema;
        3. Visualizar histórico de vendas.
    - Como usuário convencional:
        1. Cadastro, login e edição perfil;
        2. Adicionar produtos ao carrinho e efetuar compra;
        3. Visualizar histórico de compras;
        
## Observações:
No sistema só existe um usuário com perfil de administrador. Esse não pode ser modificado. Necessário rodar os seeders da aplicação para ter acesso à ele e suas funcionalidades.
    Login = adm@adm
    Senha = 1

Junto do ADM já existem também alguns outros usuários e produtos cadastrados para testes.
    Login = 1@1 ou 2@2 ... ou 5@5
    Senha = 1

## License
Projeto licenciado sob a [MIT license](https://opensource.org/licenses/MIT).
