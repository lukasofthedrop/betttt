<?php

require_once __DIR__ . '/vendor/autoload.php';

// Bootstrap da aplicação Laravel
$app = require_once __DIR__ . '/bootstrap/app.php';

// Bind das interfaces necessárias
$app->singleton(
    Illuminate\Contracts\Http\Kernel::class,
    App\Http\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

// Bootstrap da aplicação
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "=== Teste do Modelo CustomLayout ===\n";

try {
    // Verificar se a classe CustomLayout existe
    if (!class_exists('App\\Models\\CustomLayout')) {
        echo "❌ Classe App\\Models\\CustomLayout não encontrada\n";
        exit(1);
    }
    
    echo "✅ Classe CustomLayout encontrada\n";
    
    // Testar conexão com banco
    $connection = DB::connection();
    echo "✅ Conexão com banco estabelecida: " . $connection->getDatabaseName() . "\n";
    
    // Verificar se a tabela existe
    $tableExists = Schema::hasTable('custom_layouts');
    echo $tableExists ? "✅ Tabela 'custom_layouts' existe\n" : "❌ Tabela 'custom_layouts' não existe\n";
    
    if ($tableExists) {
        // Verificar se a coluna vip_descrição existe
        $columnExists = Schema::hasColumn('custom_layouts', 'vip_descrição');
        echo $columnExists ? "✅ Coluna 'vip_descrição' existe\n" : "❌ Coluna 'vip_descrição' não existe\n";
        
        // Listar todas as colunas da tabela
        $columns = Schema::getColumnListing('custom_layouts');
        echo "📋 Colunas disponíveis na tabela:\n";
        foreach ($columns as $column) {
            echo "   - $column\n";
        }
        
        // Tentar fazer uma consulta simples
        echo "\n=== Teste de Consulta ===\n";
        $count = App\Models\CustomLayout::count();
        echo "✅ Total de registros: $count\n";
        
        if ($count > 0) {
            // Tentar acessar o primeiro registro
            $first = App\Models\CustomLayout::first();
            echo "✅ Primeiro registro carregado\n";
            
            // Tentar acessar a coluna vip_descrição
            if ($columnExists) {
                $vipDescricao = $first->vip_descrição ?? 'NULL';
                echo "✅ Valor da coluna vip_descrição: $vipDescricao\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "❌ Erro durante o teste: " . $e->getMessage() . "\n";
    echo "📍 Arquivo: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "📋 Stack trace:\n" . $e->getTraceAsString() . "\n";
}

echo "\n=== Fim do Teste ===\n";