<?php

require_once __DIR__ . '/vendor/autoload.php';

echo "=== TESTE DE BOOTSTRAP COM BOOT ===\n\n";

try {
    // 1. Criar aplicação
    $app = new \Illuminate\Foundation\Application(
        $_ENV['APP_BASE_PATH'] ?? __DIR__
    );
    
    // 2. Bind Important Interfaces (como no bootstrap/app.php)
    $app->singleton(
        \Illuminate\Contracts\Http\Kernel::class,
        \App\Http\Kernel::class
    );
    
    $app->singleton(
        \Illuminate\Contracts\Console\Kernel::class,
        \App\Console\Kernel::class
    );
    
    $app->singleton(
        \Illuminate\Contracts\Debug\ExceptionHandler::class,
        \App\Exceptions\Handler::class
    );
    
    echo "1. Aplicação criada\n";
    echo "   - Classe: " . get_class($app) . "\n\n";
    
    // 2. Executar bootstrap steps até RegisterProviders
    $bootstrappers = [
        \Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables::class,
        \Illuminate\Foundation\Bootstrap\LoadConfiguration::class,
        \Illuminate\Foundation\Bootstrap\HandleExceptions::class,
        \Illuminate\Foundation\Bootstrap\RegisterFacades::class,
        \Illuminate\Foundation\Bootstrap\RegisterProviders::class,
    ];
    
    echo "2. Executando bootstrap steps (até RegisterProviders):\n";
    foreach ($bootstrappers as $i => $bootstrapper) {
        $stepNum = $i + 1;
        $className = class_basename($bootstrapper);
        echo "   Step {$stepNum}: {$className}\n";
        
        try {
            $app->bootstrapWith([$bootstrapper]);
            echo "     ✓ Sucesso\n\n";
        } catch (Exception $e) {
            echo "     ✗ Erro: " . $e->getMessage() . "\n\n";
            throw $e;
        }
    }
    
    // 3. Verificar providers carregados
    echo "3. Verificando providers carregados:\n";
    $providers = $app->getLoadedProviders();
    echo "   Total de providers: " . count($providers) . "\n";
    
    $essentialProviders = [
        'Illuminate\\Encryption\\EncryptionServiceProvider',
        'Illuminate\\Cookie\\CookieServiceProvider', 
        'Illuminate\\Session\\SessionServiceProvider'
    ];
    
    foreach ($essentialProviders as $provider) {
        if (isset($providers[$provider])) {
            echo "   ✓ {$provider}: CARREGADO\n";
        } else {
            echo "   ✗ {$provider}: NÃO CARREGADO\n";
        }
    }
    echo "\n";
    
    // 4. Testar serviços após registro (sem boot)
    echo "4. Testando serviços após registro (sem boot):\n";
    
    try {
        $encrypter = $app->make('encrypter');
        echo "   ✓ Encrypter resolvido: " . get_class($encrypter) . "\n";
        
        $encrypted = $encrypter->encrypt('test');
        $decrypted = $encrypter->decrypt($encrypted);
        echo "   ✓ Encrypt/Decrypt funcionando: {$decrypted}\n";
    } catch (Exception $e) {
        echo "   ✗ Erro no encrypter: " . $e->getMessage() . "\n";
    }
    
    // 5. Agora tentar o BootProviders
    echo "\n5. Executando BootProviders:\n";
    
    try {
        $app->bootstrapWith([\Illuminate\Foundation\Bootstrap\BootProviders::class]);
        echo "   ✓ BootProviders executado com sucesso\n";
        
        // Testar serviços após boot
        echo "\n6. Testando serviços após boot:\n";
        
        try {
            $encrypter = $app->make('encrypter');
            echo "   ✓ Encrypter após boot: " . get_class($encrypter) . "\n";
        } catch (Exception $e) {
            echo "   ✗ Erro no encrypter após boot: " . $e->getMessage() . "\n";
        }
        
        try {
            $middleware = $app->make(\Illuminate\Cookie\Middleware\EncryptCookies::class);
            echo "   ✓ EncryptCookies middleware após boot: " . get_class($middleware) . "\n";
        } catch (Exception $e) {
            echo "   ✗ Erro no EncryptCookies após boot: " . $e->getMessage() . "\n";
        }
        
    } catch (Exception $e) {
        echo "   ✗ Erro no BootProviders: " . $e->getMessage() . "\n";
        echo "   ✗ Arquivo: " . $e->getFile() . "\n";
        echo "   ✗ Linha: " . $e->getLine() . "\n";
        echo "   ✗ Stack trace:\n";
        
        $trace = $e->getTrace();
        foreach (array_slice($trace, 0, 5) as $i => $frame) {
            $file = $frame['file'] ?? 'unknown';
            $line = $frame['line'] ?? 'unknown';
            $function = $frame['function'] ?? 'unknown';
            $class = isset($frame['class']) ? $frame['class'] . '::' : '';
            echo "     #{$i} {$file}:{$line} {$class}{$function}()\n";
        }
    }
    
} catch (Exception $e) {
    echo "\n=== ERRO GERAL ===\n";
    echo "Erro: " . $e->getMessage() . "\n";
    echo "Arquivo: " . $e->getFile() . "\n";
    echo "Linha: " . $e->getLine() . "\n";
}

echo "\n=== FIM DO TESTE ===\n";