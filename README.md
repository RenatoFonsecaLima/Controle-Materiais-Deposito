# Controle de Materiais Deposito

Este é um projeto de controle de estoque desenvolvido em PHP, utilizando HeidiSQL para gerenciar o banco de dados e XAMPP para o servidor local.

## Funcionalidades

- Cadastro de material
- Exclusão de material
- Retirada de material 
- Devolução de material
- Relatorio de material

## Tecnologias Utilizadas

- **PHP**: Linguagem principal do projeto
- **HeidiSQL**: Ferramenta de administração do banco de dados
- **WAMP64**: Ambiente de desenvolvimento
- **VSCode**: Editor de código

## Instalação

### Pré-requisitos

- [WAMP](https://wampserver.aviatechno.net/)) instalado
- [HeidiSQL](https://www.heidisql.com/) instalado
- [Git](https://git-scm.com/) instalado

### Passos

1. Clone este repositório:
    ```bash
    git clone https://github.com/RenatoFonsecaLima/Controle-Materiais-Deposito
    ```
2. Mova o projeto para a pasta `WWW` do WAMP:
    ```bash
    mv controle-materiais-deposito C:\xampp\htdocs\
    ```
3. Inicie o Apache e MySQL pelo painel de controle do WAMP.

4. Configure o banco de dados usando HeidiSQL:
    - Crie um novo banco de dados chamado `estoque_depositos`.
    - Importe o arquivo `estoque_depositos.sql` para criar as tabelas necessárias.

5. Configure o arquivo `config.php` com suas credenciais do banco de dados:
    ```php
    <?php
    $host = 'localhost';
    $db = 'estoque_deposito';
    $user = 'seu_usuario';
    $pass = 'sua_senha';
    ?>
    ```

6. Acesse o sistema no navegador:
    ```
    http://localhost/controle-materiais-deposito    ```

## Como Usar

- **Adicionar Material**: Vá para a página de adicionar produto e preencha os detalhes necessários.
- **Excluir Material**: Selecione um produto da lista e clique em remover.
- **Retirada do Material**: Selecione o material a ser retirado.
- **Devolução do Material**: Selecione o material a ser devolvido.
- **Relatorio**: Relatorio dos materiais e status dos mesmos.


## Contribuição

Contribuições são bem-vindas! Sinta-se à vontade para abrir uma issue ou enviar um pull request.

## Licença

Este projeto está licenciado sob a licença MIT. Veja o arquivo [LICENSE](LICENSE) para mais detalhes.

