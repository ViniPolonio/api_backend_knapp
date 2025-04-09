# Projeto API com Laravel 11
API desenvolvida para a empresa KNAPP Sudamérica, destinada ao portal "MAIS Cloud User Management Portal". Esse portal permite que os usuários realizem seu cadastro, passando por um processo de aprovação conduzido por um responsável de gestão. Após a aprovação, os usuários terão acesso aos recursos específicos de acordo com os perfis definidos no sistema. O objetivo é proporcionar uma gestão eficiente de usuários e seus respectivos níveis de permissão, garantindo segurança e controle no acesso aos recursos disponíveis.

## 📁 Estrutura do Projeto
- Laravel 11
- PHP 8.3
- Composer
- Banco de Dados (MySQL) -> Conexão com Oracle também 

## 🛠️ Pré-requisitos
- PHP >= 8.3
- Composer instalado
- MySQL

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

5. **Rodar as migrations:**

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

## 📄 Licença
Este projeto está sob a licença da equipe 11 da turma de Engenharia de Software, 7º período.
Developer: Vinicius Polonio.
