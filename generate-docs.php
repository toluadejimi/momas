<?php

require __DIR__ . '/vendor/autoload.php';

use phpDocumentor\Reflection\DocBlockFactory;

$factory = DocBlockFactory::createInstance();
$outputDir = __DIR__ . '/docs_html';

// Ensure output directory exists
if (!is_dir($outputDir)) {
    mkdir($outputDir, 0777, true);
}

$directory = __DIR__ . '/app';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

$classes = [];

foreach ($iterator as $file) {
    if ($file->getExtension() === 'php') {
        $code = file_get_contents($file->getRealPath());

        // Match namespace
        preg_match('/namespace\s+(.+?);/', $code, $nsMatches);
        $namespace = $nsMatches[1] ?? '';

        // Match class
        if (preg_match('/class\s+(\w+)/', $code, $classMatches)) {
            $className = $classMatches[1];

            // Get docblock
            $description = '';
            if (preg_match('/\/\*\*(.*?)\*\/\s*class\s+' . $className . '/s', $code, $docMatches)) {
                $docblock = $factory->create($docMatches[1]);
                $description = $docblock->getSummary();
            }

            // Collect methods with PHPDoc
            $methods = [];
            preg_match_all('/public function (\w+)\s*\((.*?)\)\s*{/', $code, $methodMatches, PREG_SET_ORDER);
            foreach ($methodMatches as $method) {
                $methodName = $method[1];
                $methods[$methodName] = ''; // Optional: parse method PHPDoc if needed
            }

            $classes[] = [
                'namespace' => $namespace,
                'name' => $className,
                'description' => $description,
                'methods' => $methods
            ];
        }
    }
}

// Generate HTML
$html = "<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<title>Laravel App Documentation</title>
<style>
body { font-family: Arial, sans-serif; padding: 20px; }
h1 { color: #333; }
h2 { margin-top: 30px; color: #555; }
h3 { margin-left: 20px; color: #444; }
ul { list-style-type: square; margin-left: 40px; }
</style>
</head>
<body>
<h1>Laravel App Documentation</h1>";

foreach ($classes as $cls) {
    $html .= "<h2>{$cls['namespace']}\\{$cls['name']}</h2>";
    $html .= "<p><strong>Description:</strong> {$cls['description']}</p>";
    if (!empty($cls['methods'])) {
        $html .= "<h3>Methods:</h3><ul>";
        foreach ($cls['methods'] as $methodName => $methodDoc) {
            $html .= "<li>$methodName</li>";
        }
        $html .= "</ul>";
    }
}

$html .= "</body></html>";

// Save HTML
file_put_contents($outputDir . '/index.html', $html);

echo "HTML documentation generated in $outputDir/index.html\n";
