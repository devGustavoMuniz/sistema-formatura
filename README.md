# Sistema de Gerenciamento de Álbuns de Formatura

Este é um projeto Laravel para gerenciar álbuns de formatura, utilizando a stack TALL (Tailwind, Alpine.js, Laravel, Livewire) com Inertia.js e Vue.js, e Docker através do Laravel Sail.

---

## Pré-requisitos

Para executar este projeto, você precisará ter instalado em sua máquina:

* **Docker Desktop**

> **Nota para usuários Windows:** É altamente recomendado o uso do **WSL 2 (Windows Subsystem for Linux)** para uma melhor performance e compatibilidade com o Docker.

---

## Guia de Instalação (Setup)

Siga os passos abaixo para clonar e executar o projeto localmente.

### 1. Clonar o Repositório

Abra seu terminal e clone este repositório para a sua máquina.

```bash
git clone git@github.com:devGustavoMuniz/sistema-formatura.git
cd sistema-formatura
```

### 2. Configurar o Arquivo de Ambiente

O Laravel utiliza um arquivo `.env` para suas configurações. Vamos criar uma cópia do arquivo de exemplo.

```bash
cp .env.example .env
```

*Este arquivo já vem pré-configurado com as credenciais padrão do banco de dados para o ambiente Sail.*

### 3. Iniciar os Contêineres do Docker

Vamos usar o Laravel Sail para subir a aplicação. O script do Sail se encontra na pasta `vendor`, mas como ainda não instalamos as dependências, usaremos um comando inicial para contornar isso.

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd)":/var/www/html \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

> **O que o comando acima faz?** Ele usa uma imagem temporária do Docker que contém o Composer para instalar as dependências do projeto (incluindo o próprio Sail) na pasta `vendor`.

### 4. Subir a Aplicação com Sail

Agora que o Sail está instalado, podemos usar seus comandos para subir os contêineres definidos no `docker-compose.yml`.

```bash
./vendor/bin/sail up -d
```

> **Nota:** Na primeira vez, este comando pode demorar vários minutos, pois o Docker fará o download e a construção das imagens do PHP, Nginx e PostgreSQL.

### 5. Gerar a Chave da Aplicação

Toda aplicação Laravel precisa de uma chave de encriptação única.

```bash
./vendor/bin/sail artisan key:generate
```

### 6. Executar as Migrations

Este comando irá criar todas as tabelas necessárias no banco de dados.

```bash
./vendor/bin/sail artisan migrate
```

### 7. Instalar as Dependências do Frontend

Agora vamos instalar os pacotes JavaScript (Vue, Inertia, etc.).

```bash
./vendor/bin/sail npm install
```

### 8. Compilar os Assets e Iniciar o Servidor de Desenvolvimento

Para finalizar, vamos compilar os arquivos CSS e JS e iniciar o servidor do Vite, que ficará observando por alterações nos arquivos.

```bash
./vendor/bin/sail npm run dev
```

---

## Acessando a Aplicação

Pronto! A aplicação está rodando.

* **URL da Aplicação:** `http://localhost`
* **Acesso ao Banco (Opcional):** Você pode se conectar ao banco de dados PostgreSQL usando suas ferramentas preferidas com os dados do seu arquivo `.env` (Host: `localhost`, Porta: `5432`).

## Comandos Úteis do Sail

* **Parar a aplicação:** `./vendor/bin/sail down`
* **Executar qualquer comando do Artisan:** `./vendor/bin/sail artisan <comando>`
* **Entrar no shell do Tinker:** `./vendor/bin/sail tinker`

Lembre-se: todos os comandos que você normalmente executaria com `php`, `artisan` ou `composer` devem ser prefixados com `./vendor/bin/sail`.
