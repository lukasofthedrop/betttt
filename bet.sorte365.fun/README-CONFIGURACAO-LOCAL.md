# 🎰 Projeto Sorte365 - Configuração para Desenvolvimento Local

## 📋 Visão Geral

O **Sorte365** é uma plataforma completa de cassino online desenvolvida em **Laravel 10.10** com frontend **Vue.js**. O sistema inclui:

- 🎮 **Cassino Online**: Slots, roleta, blackjack, cassino ao vivo
- ⚽ **Apostas Esportivas**: Sistema de apostas em futebol
- 💰 **Sistema de Afiliação**: Comissões multi-nível (3 níveis)
- 💳 **Múltiplos Gateways**: SuitPay, Stripe, BSPay, SharkPay, Digito, EzzePay
- 🏦 **PIX**: Depósitos e saques via PIX
- 👥 **Painel Admin**: Interface administrativa com Filament
- 🔐 **Autenticação**: JWT + Laravel Sanctum
- 🎯 **Provedores de Jogos**: Pragmatic Play e outros

## ✅ Pré-requisitos Verificados

- ✅ **PHP 8.2.12** (Compatível com Laravel 10.10)
- ✅ **Composer 2.8.10** (Gerenciador de dependências PHP)
- ✅ **Node.js v24.5.0** (Runtime JavaScript)
- ✅ **npm 11.5.1** (Gerenciador de pacotes Node.js)
- ✅ **MariaDB 10.4.32** (Compatível com MySQL)
- ✅ **Extensões PHP**: curl, intl, libxml, simplexml, zip, mbstring, openssl, pdo_mysql

## 🚀 Guia de Configuração Passo a Passo

### 1️⃣ Configuração do Banco de Dados

```bash
# 1. Inicie o XAMPP ou seu servidor MySQL/MariaDB

# 2. Acesse o MySQL
mysql -u root -p

# 3. Crie o banco de dados
CREATE DATABASE sorte365 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# 4. Crie um usuário (opcional, pode usar root)
CREATE USER 'sorte365'@'localhost' IDENTIFIED BY 'senha_segura';
GRANT ALL PRIVILEGES ON sorte365.* TO 'sorte365'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# 5. Importe o arquivo SQL
mysql -u root -p sorte365 < "c:\Users\h\Downloads\projetos\beti\sorte365.sql"
```

### 2️⃣ Configuração do Ambiente Laravel

```bash
# 1. Navegue para o diretório do projeto
cd "c:\Users\h\Downloads\projetos\beti\bet.sorte365.fun"

# 2. Copie o arquivo de ambiente para desenvolvimento
copy .env.local .env

# 3. Instale as dependências PHP
composer install

# 4. Gere a chave da aplicação
php artisan key:generate

# 5. Gere a chave JWT
php artisan jwt:secret

# 6. Configure as permissões de storage (se necessário)
php artisan storage:link
```

### 3️⃣ Configuração do Frontend

```bash
# 1. Instale as dependências Node.js
npm install

# 2. Compile os assets para desenvolvimento
npm run dev

# OU compile para produção
npm run build
```

### 4️⃣ Configuração Final do Laravel

```bash
# 1. Limpe todos os caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# 2. Execute as migrações (se necessário)
php artisan migrate

# 3. Execute os seeders (se necessário)
php artisan db:seed
```

### 5️⃣ Inicialização dos Servidores

```bash
# Terminal 1: Servidor Laravel
php artisan serve
# Acesse: http://localhost:8000

# Terminal 2: Servidor de desenvolvimento Vite (opcional)
npm run dev
# Para hot-reload dos assets
```

## 🔧 Configurações Importantes do .env

### Banco de Dados
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sorte365
DB_USERNAME=root
DB_PASSWORD=sua_senha
```

### Aplicação
```env
APP_NAME="Casino Local"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000
```

### Gateways de Pagamento (Desabilitados para Desenvolvimento)
```env
SUITPAY_IS_ENABLE=false
STRIPE_IS_ENABLE=false
BSPAY_IS_ENABLE=false
SHARKPAY_IS_ENABLE=false
DIGITO_IS_ENABLE=false
EZZEPAY_IS_ENABLE=false
```

## 🎯 Funcionalidades Testáveis Localmente

### ✅ Funcionalidades Disponíveis
- 🔐 **Sistema de Autenticação**: Registro, login, logout
- 👤 **Perfil de Usuário**: Edição de dados, upload de avatar
- 🎮 **Visualização de Jogos**: Catálogo de jogos (modo demo)
- 💰 **Sistema de Carteira**: Visualização de saldo (sem transações reais)
- 📊 **Painel Administrativo**: Acesso via Filament
- 🔗 **Sistema de Afiliação**: Códigos de convite, estrutura de comissões
- 🎨 **Interface**: Temas, responsividade, navegação

### ⚠️ Funcionalidades Limitadas (Requerem Configuração Adicional)
- 💳 **Pagamentos**: Requer configuração de gateways
- 📧 **E-mails**: Configurar SMTP ou usar driver 'log'
- 🎮 **Jogos Reais**: Requer integração com provedores
- 📱 **Notificações Push**: Requer configuração do Pusher

## 🛠️ Comandos Úteis para Desenvolvimento

```bash
# Limpar todos os caches
php artisan optimize:clear

# Recriar autoload do Composer
composer dump-autoload

# Verificar rotas
php artisan route:list

# Verificar configurações
php artisan config:show

# Executar testes
php artisan test

# Monitorar logs
tail -f storage/logs/laravel.log
```

## 🔍 Solução de Problemas Comuns

### Erro de Permissões
```bash
# Windows (executar como administrador)
icacls storage /grant Everyone:F /T
icacls bootstrap/cache /grant Everyone:F /T
```

### Erro de Chave da Aplicação
```bash
php artisan key:generate
```

### Erro de JWT
```bash
php artisan jwt:secret
```

### Erro de Banco de Dados
- Verifique se o MySQL/MariaDB está rodando
- Confirme as credenciais no .env
- Teste a conexão: `php artisan tinker` → `DB::connection()->getPdo()`

## 📁 Estrutura de Arquivos Importantes

```
bet.sorte365.fun/
├── app/
│   ├── Http/Controllers/     # Controladores
│   ├── Models/              # Modelos Eloquent
│   └── Traits/              # Traits reutilizáveis
├── config/                  # Configurações
├── database/
│   ├── migrations/          # Migrações do banco
│   └── seeders/            # Seeders
├── resources/
│   ├── views/              # Templates Blade
│   ├── js/                 # Arquivos JavaScript/Vue
│   └── css/                # Arquivos CSS
├── routes/                 # Definições de rotas
├── storage/                # Arquivos de storage
├── .env                    # Configurações de ambiente
├── composer.json           # Dependências PHP
├── package.json           # Dependências Node.js
└── vite.config.js         # Configuração do Vite
```

## 🎯 Próximos Passos

1. **Teste a Aplicação**: Acesse http://localhost:8000
2. **Crie um Usuário Admin**: Use o seeder ou crie manualmente
3. **Explore o Painel Admin**: Acesse /admin
4. **Configure Gateways**: Para testar pagamentos (opcional)
5. **Personalize**: Ajuste temas, logos, configurações

## 📞 Suporte

Se encontrar problemas durante a configuração:
1. Verifique os logs em `storage/logs/laravel.log`
2. Confirme se todos os pré-requisitos estão instalados
3. Verifique as configurações do .env
4. Execute `php artisan optimize:clear` para limpar caches

---

**✨ Projeto configurado com sucesso! Boa sorte com o desenvolvimento! 🚀**