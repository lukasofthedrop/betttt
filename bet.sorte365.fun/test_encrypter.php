<?php

require_once __DIR__ . '/vendor/autoload.php';

// Carregar o ambiente
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    // Criar uma instância básica da aplicação Laravel
    $app = new Illuminate\Foundation\Application(
        $_ENV['APP_BASE_PATH'] ?? dirname(__DIR__)
    );
    
    // Configurar o encrypter manualmente
    $key = $_ENV['APP_KEY'] ?? null;
    
    echo "APP_KEY encontrada: " . ($key ? 'Sim' : 'Não') . "\n";
    echo "APP_KEY: " . $key . "\n";
    
    if ($key) {
        // Remover o prefixo base64: se existir
        if (strpos($key, 'base64:') === 0) {
            $key = base64_decode(substr($key, 7));
            echo "Chave decodificada com sucesso\n";
        }
        
        // Tentar criar o encrypter
        $encrypter = new Illuminate\Encryption\Encrypter($key, 'AES-256-CBC');
        echo "Encrypter criado com sucesso\n";
        
        // Testar criptografia
        $testData = 'Hello World';
        $encrypted = $encrypter->encrypt($testData);
        echo "Dados criptografados: " . $encrypted . "\n";
        
        $decrypted = $encrypter->decrypt($encrypted);
        echo "Dados descriptografados: " . $decrypted . "\n";
        
        if ($testData === $decrypted) {
            echo "✅ Encrypter funcionando corretamente!\n";
        } else {
            echo "❌ Erro na criptografia/descriptografia\n";
        }
    } else {
        echo "❌ APP_KEY não encontrada\n";
    }
    
} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
}