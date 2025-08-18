<?php
try {
    $pdo = new PDO('mysql:host=127.0.0.1;dbname=sorte365', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $stmt = $pdo->query('SHOW COLUMNS FROM custom_layouts');
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Colunas na tabela custom_layouts:\n";
    $found = false;
    foreach ($columns as $column) {
        echo "- " . $column['Field'] . " (" . $column['Type'] . ")\n";
        if ($column['Field'] === 'vip_descriçao') {
            $found = true;
        }
    }
    
    echo "\n";
    if ($found) {
        echo "✓ Coluna 'vip_descriçao' ENCONTRADA!\n";
    } else {
        echo "✗ Coluna 'vip_descriçao' NÃO ENCONTRADA!\n";
    }
    
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
?>