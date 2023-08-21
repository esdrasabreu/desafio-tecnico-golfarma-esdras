# API de Pedidos Golfarma
Esta é uma API desenvolvida em Laravel que permite gerenciar pedidos de um restaurante. A API oferece endpoints para listar, cadastrar e atualizar informações dos pedidos. A autenticação é feita através do JWT (JSON Web Token), permitindo que certas operações sejam acessíveis apenas para usuários autenticados.

## Pré-requisitos

- `PHP >= 7.4
- `Laravel 8.x
- `Docker
- `Composer (para instalação de dependências)
- `Banco de dados MySQL

## Rotas da API
        https:localhost
### Autenticação
A autenticação é necessária para acessar as rotas protegidas da API. A autenticação pode ser realizada enviando um token de autenticação válido no cabeçalho `Authorization` da solicitação. A autenticação é feita através de um token JWT. Para acessar os endpoints que exigem autenticação, você deve incluir o token no cabeçalho de autorização da requisição no formato Bearer <token>.

Para isso precisa cadastrar um usuário : POST /users
  
        {
          "name": "Nome do Usuário",
          "email": "email@example.com",
          "password": "senha123"
        }

- Para fazer o login do usuário: POST /login
          
        {
          "email": "email@example.com",
          "password": "senha123"
        }

- Para fazer o logout do usuário: POST /logout
  
- `POST /api/login: Realiza o login do usuário e retorna um token JWT para autenticação nas rotas protegidas.
- `POST /api/logout: Realiza saída do usuário autenticado.
- `POST /api/users: Cadastra um novo usuario.

### Pedidos
- `GET /api/pedidos: Lista todos os pedidos cadastrados.
- `GET /api/pedidos/{id_pedido}: Lista os detalhes de um pedido específico.
- `DELETE /api/pedidos/{id_pedido}: Exclui um pedido específico.
- `POST /api/pedidos: Cadastra um novo pedido
  
            
            {
              "cliente": "Carlos Alberto",
              "total": "100",
              "status": "processando"
            }
  
- `PUT /api/pedidos/{id_pedido}: Atualiza as informações de um pedido.
  
         
            {
              "cliente": "Carlos Alberto",
              "total": "155",
              "status": "concluido"
            }
  
