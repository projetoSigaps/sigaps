## Sobre API - Neoway

<p>Este projeto foi desenvolvido para fins de processo seletivo, aplicado pela empresa Neoway.</p>
<p><ul>Foi criado uma interface UI para gerenciamento de CPF e CNPJ, portando o sistema consiste em:
    <li>Criar Registro</li>
    <li>Listar Registros</li>
    <li>Atualizar Registro</li>
    <li>Apagar Registro</li>
    <li>Adicionar um registro a uma Blacklist</li>
    <li>Remover um registro da Blacklist</li>
</ul></p>
<p>Utilizado o conceito de SPA (Single Page Application)</p>
<p>Para as telas de listagem, foi implementado opções de filtragem por número e ordenação</p>
<p></p>


## Tecnologias Utilizadas
- Front End:    [Vue.js]
- Back End:     [PHP], [Laravel]
- Banco de Dados (NoSQL):   [MongoDB]
- Container:   [Docker],[Docker-Compose]
- Gerenciador de Dependecias:   [Npm],[Composer]

## Utilização

<p>O acesso a API deverá ser feito através do endereço **localhost:8000**</p>
<p>Devido ao padrão arquitetural da API, para consultar o uptime do servidor e a quantidade
de suas consultas, deverá ser acessado atráves do seguinte endereço: **localhost:8000/status**</p>
<p>Suas operação são expostas atráves de serviços REST, podendo ser acessados através do verbos HTTP,
como por exemplo:
<ul> 
    <li>GET: **localhost:8000/api/registros**, para listar todos registros</li>
    <li>GET: **localhost:8000/api/registro/edit/{id}**, para exibir um determinado registro</li>
    <li>PUT: **localhost:8000/api/registro/edit/{id}**, para atualizar o registro</li>
    <li>DELETE: **localhost:8000/api/registro/delete/{id}**, para deletar o registro</li>
    <li>POST: **localhost:8000/api/registro/create**, para criar um novo registro</li>
</ul>

## Instalação
<p>Requisito obrigatório que a máquina tenha o docker instalado</p>

1. Deverá ter uma conta no - **[Docker Hub](http://docker-hub.com)**.
2. Criar uma pasta no seu computador/servidor com o nome que desejar.
3. Criar um arquivo com o nome Dockerfile
4. Incluir as seguintes Linhas ao arquivo:

5. executar o comando:
    
## Criado por

- **[Lucas Vieira](lucsolivier@gmail.com)**

