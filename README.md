# Projeto Laravel com PHP 8

Este projeto é um exemplo de aplicação Laravel desenvolvido com PHP 8.

## 📁 Estrutura do Projeto
- Laravel 10
- PHP 8
- Composer
- Banco de Dados (MySQL, PostgreSQL, etc.)

## 🛠️ Pré-requisitos
- PHP >= 8.1
- Composer instalado
- MySQL ou outro banco de dados compatível

## 📥 Instalação

1. **Clone o repositório:**

```bash
git clone https://github.com/ViniPolonio/backend_api_knapp.git
cd seu-repositorio
```

2. **Instale as dependências:**

```bash
composer install
```

3. **Configuração do ambiente:**

- Copie o arquivo `.env.example` para `.env`:

```bash
cp .env.example .env
```

- Configure as variáveis de ambiente no arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=seu_banco
DB_USERNAME=seu_usuario
DB_PASSWORD=sua_senha
```

4. **Gere a chave da aplicação:**

```bash
php artisan key:generate
```

5. **Migre o banco de dados:**

```bash
php artisan migrate
```

## 🚀 Executando o projeto

Inicie o servidor local com o comando:

```bash
php artisan serve
```

O projeto estará disponível em:
[http://127.0.0.1:8000](http://127.0.0.1:8000)

## 🧩 Estrutura de pastas
- `app/` - Código fonte principal da aplicação
- `routes/` - Arquivos de rotas da aplicação
- `database/` - Migrações e seeds do banco de dados
- `resources/` - Views e assets

## 🔧 Principais comandos do Artisan
- `php artisan make:model NomeDoModel` — Criação de um Model
- `php artisan make:controller NomeDoController` — Criação de um Controller
- `php artisan make:migration create_nome_da_tabela` — Criação de uma Migration

## 📄 Licença
Este projeto está sob a licença da equipe 3 da turma de Engenharia de Software, 7º período.

