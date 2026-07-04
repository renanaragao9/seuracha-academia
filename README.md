# Academia SeuRacha

Plataforma full-stack para gestão de academia, com painel administrativo e portal do aluno.

- **Backend:** API REST + painel admin (Laravel 13 / Filament 5)
- **Frontend:** SPA para alunos (Nuxt 4 / Vue 3)
- **IA integrada:** chat, geração de treinos e planos alimentares (OpenRouter)

---

## Tecnologias

### Backend (`backend/`)

| Tecnologia | Versão |
|---|---|
| PHP | ^8.3 |
| Laravel | ^13.8 |
| Filament | ^5.6 |
| Laravel Sanctum | ^4.3 |
| spatie/laravel-activitylog | ^5.0 |
| spatie/browsershot | ^5.4 |
| moe-mizrak/laravel-openrouter | ^2.11 |
| Tailwind CSS | ^4.0 |
| Vite | ^8.0 |

### Frontend (`frontend/`)

| Tecnologia | Versão |
|---|---|
| Nuxt | ^4.4.7 |
| Vue | ^3.5 |
| Pinia | ^3.0 |
| Tailwind CSS | ^6.4 |
| @nuxt/icon | ^2.2 |
| marked | ^18.0 |

---

## Pré-requisitos

- **PHP 8.3+** com extensões: `pdo_mysql`, `mbstring`, `xml`, `curl`, `gd`, `zip`
- **Node.js 20+**
- **MySQL 8.0+** (ou MariaDB)
- **Composer 2**
- **Google Chrome / Chromium** (para geração de PDFs via Browsershot)
- **[Mailpit](https://github.com/axllent/mailpit)** ou MailHog (opcional, para teste de e-mails)

---

## Instalação e execução

### 1. Clonar o repositório

```bash
git clone <repo-url> academia-seuracha
cd academia-seuracha
```

### 2. Backend

```bash
cd backend

# Dependências PHP
composer install

# Dependências Node (Vite, Tailwind, Puppeteer)
npm install

# Configurar ambiente
cp .env.example .env

# Gerar chave da aplicação
php artisan key:generate

# Banco de dados — criar o schema `academia_renan` no MySQL e ajustar .env

# Migrations + seeders
php artisan migrate --seed

# Link simbólico para arquivos públicos
php artisan storage:link

# Iniciar servidor de desenvolvimento (API + queue + Vite)
composer dev
```

**Acessos:**
- API: `http://127.0.0.1:8000/api/v1`
- Painel admin (Filament): `http://127.0.0.1:8000/admin`

### 3. Frontend

```bash
cd frontend

# Dependências
npm install

# Iniciar servidor de desenvolvimento
npm run dev
```

**Acesso:** `http://localhost:3000`

### 4. Produção

```bash
# Backend
cd backend
npm run build
# Configure o Apache/Nginx para apontar para public/

# Frontend
cd frontend
npm run build
# Sirva o diretório .output/public/
```

---

## Estrutura do projeto

```
academia-seuracha/
├── backend/                       # Laravel 13 API + Filament Admin
│   ├── app/
│   │   ├── Filament/Resources/    # 32 CRUDs do painel admin
│   │   ├── Http/Controllers/Api/  # Controllers REST (16)
│   │   ├── Models/                # 44 modelos Eloquent
│   │   ├── Services/              # Lógica de negócio (18 serviços)
│   │   ├── Prompts/               # Templates de prompt (IA)
│   │   └── Observers/             # Observers de modelo
│   ├── database/migrations/       # 52 migrações
│   ├── routes/
│   │   ├── api.php                # Rotas da API (/api/v1/*)
│   │   └── web.php                # Rotas web
│   └── config/                    # Configurações do Laravel
│
├── frontend/                      # Nuxt 4 SPA (portal do aluno)
│   ├── app/
│   │   ├── pages/                 # Páginas do portal
│   │   ├── components/            # Componentes Vue
│   │   ├── stores/                # 13 stores Pinia
│   │   ├── services/              # 14 serviços de API
│   │   ├── interfaces/            # Tipagens TypeScript
│   │   └── composables/           # Composables Vue
│   └── nuxt.config.ts             # Configuração do Nuxt
```

---

## Funcionalidades principais

- Cadastro e gestão de alunos
- Fichas de treino com divisões e exercícios
- Planos alimentares personalizados
- Avaliações físicas
- Controle de mensalidades e despesas
- Agendamento de aulas/mod
- Vendas e controle de estoque
- Blog/posts
- Registro de treinos realizados (workout logs)
- **Chat com IA** para dúvidas do aluno
- **Geração de treinos e dietas por IA**
- Geração de PDFs (fichas, avaliações, recibos)
- Painel admin completo (Filament)
