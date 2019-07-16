## Sobre API - Neoway

<p>Este projeto foi desenvolvido para fins de processo seletivo, aplicado pela empresa Neoway.</p>
<p>Foi criado uma interface UI para gerenciamento de CPF e CNPJ, portando o sistema consiste em:</p>
<ul>
    <li>Criar Registro</li>
    <li>Listar Registros</li>
    <li>Atualizar Registro</li>
    <li>Apagar Registro</li>
    <li>Adicionar um registro a uma Blacklist</li>
    <li>Remover um registro da Blacklist</li>
</ul>
<p>Utilizado o conceito de SPA (Single Page Application)</p>
<p>Para as telas de listagem, foi implementado opções de filtragem por número e ordenação</p>

## Tecnologias Utilizadas
- **Front End**:    Vue.js
- **Back End**:     PHP, Laravel
- **Banco de Dados (NoSQL)**:   MongoDB
- **Container**:   Docker, Docker-Compose
- **Gerenciador de Dependecias**:   NPM, Composer

## Utilização

<p>O acesso a API deverá ser feito através do endereço <b>localhost:8000</b></p>
<p>Devido ao padrão arquitetural da API, para consultar o uptime do servidor e a quantidade
de suas consultas, deverá ser acessado atráves do seguinte endereço: <b>localhost:8000/status</b></p>
<p>Suas operação são expostas atráves de serviços REST, podendo ser acessados através do verbos HTTP,
como por exemplo:
<ul> 
    <li>GET: <b>localhost:8000/api/registros</b>, para listar todos registros</li>
    <li>GET: <b>localhost:8000/api/registro/edit/{id}</b> para exibir um determinado registro</li>
    <li>PUT: <b>localhost:8000/api/registro/edit/{id}</b>, para atualizar o registro</li>
    <li>DELETE: <b>localhost:8000/api/registro/delete/{id}</b>, para deletar o registro</li>
    <li>POST: <b>localhost:8000/api/registro/create</b>, para criar um novo registro</li>
</ul>

## Instalação
<p>Requisito obrigatório que a máquina tenha o Docker e o Docker-Compose instalados</p>

1. Deverá ter uma conta no **[Docker Hub](https://hub.docker.com/)**.
2. Criar uma pasta no seu computador/servidor com o nome que desejar.
3. Criar um arquivo com o nome Dockerfile
4. Incluir a seguinte linha ao arquivo:
```
FROM wyveo/nginx-php-fpm:php72
```
5. Executar o comando:
```
$ sudo docker-compose up -d --build
```
    
## Criado por

- **[Lucas Vieira](malito:lucsolivier@gmail.com)**

