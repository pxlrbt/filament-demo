<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Symfony\Component\Finder\Finder;

class ObfuscateFilamentClasses extends Command
{
    protected $signature = 'filament:obfuscate
                            {--mapping-file=obfuscation-mapping.json : Path to the mapping file}';

    protected $description = 'Obfuscate all strings starting with fi- in vendor folder';

    private array $classMapping = [];

    private int $counter = 1;

    public function handle(): int
    {
        $mappingFile = storage_path('app/' . $this->option('mapping-file'));

        $this->info('Starting simple fi- string obfuscation...');

        // Load existing mapping if it exists
        if (file_exists($mappingFile)) {
            $this->classMapping = json_decode(file_get_contents($mappingFile), true) ?? [];
            $this->counter = count($this->classMapping) + 1;
            $this->info('Loaded existing mapping with ' . count($this->classMapping) . ' entries.');
        }

        // Process ALL files in vendor folder
        $this->processVendorFiles();

        // Process built CSS files
        $this->processCssFiles();

        // Save mapping
        $this->saveMappingFile($mappingFile);

        $this->info('Obfuscation completed. Total classes obfuscated: ' . count($this->classMapping));

        return Command::SUCCESS;
    }

    private function processVendorFiles(): void
    {
        $vendorPath = base_path('vendor');

        if (! is_dir($vendorPath)) {
            $this->warn('Vendor directory not found: ' . $vendorPath);

            return;
        }

        // Use Symfony Finder to find all relevant files recursively
        $finder = new Finder;
        $finder->files()
            ->in($vendorPath)
            ->name('/\.(php|blade\.php|css|js|html|vue|ts|jsx|tsx)$/')
            ->ignoreUnreadableDirs()
            ->notPath('node_modules')
            ->notPath('.git');

        $files = [];
        foreach ($finder as $file) {
            $files[] = $file->getRealPath();
        }

        $this->info('Found ' . count($files) . ' files to process in vendor directory.');

        if (count($files) === 0) {
            $this->warn('No files found in vendor directory.');

            return;
        }

        $progressBar = $this->output->createProgressBar(count($files));
        $progressBar->start();

        foreach ($files as $file) {
            $this->processFile($file);
            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine();
    }

    private function processFile(string $filePath): void
    {
        if (! is_readable($filePath) || ! is_writable($filePath)) {
            return;
        }

        $content = file_get_contents($filePath);
        if ($content === false) {
            return;
        }

        $originalContent = $content;

        // Simple regex to find all strings that contain fi-
        // This will match quoted strings, class attributes, etc.
        $content = preg_replace_callback(
            '/\bfi-[a-zA-Z0-9\-_]+/',
            [$this, 'obfuscateMatch'],
            $content
        );

        if ($content !== $originalContent) {
            file_put_contents($filePath, $content);
        }
    }

    private function obfuscateMatch(array $matches): string
    {
        $class = $matches[0];

        return $this->obfuscateClass($class);
    }

    private function processCssFiles(): void
    {
        try {
            // Get the manifest to find built CSS files
            $manifestPath = public_path('build/manifest.json');

            if (! file_exists($manifestPath)) {
                $this->warn('Vite manifest not found. Run npm run build first.');

                return;
            }

            $manifest = json_decode(file_get_contents($manifestPath), true);

            foreach ($manifest as $entry) {
                if (isset($entry['file']) && str_ends_with($entry['file'], '.css')) {
                    $cssPath = public_path('build/' . $entry['file']);
                    if (file_exists($cssPath)) {
                        $this->processFile($cssPath);
                        $this->info('Processed CSS file: ' . $entry['file']);
                    }
                }
            }
        } catch (Exception $e) {
            $this->warn('Error processing CSS files: ' . $e->getMessage());
        }
    }

    private function obfuscateClass(string $class): string
    {
        // If already mapped, return the existing obfuscated version
        if (isset($this->classMapping[$class])) {
            return $this->classMapping[$class];
        }

        // Generate new obfuscated class name
        $obfuscated = $this->getObfuscatedClass($class);
        $this->classMapping[$class] = $obfuscated;

        return $obfuscated;
    }

    private function getObfuscatedClass(string $originalClass): string
    {
        // Create a simple obfuscated class name
        $baseClass = 'ob-' . base_convert($this->counter, 10, 36);
        $this->counter++;

        return $baseClass;
    }

    private function saveMappingFile(string $filePath): void
    {
        $directory = dirname($filePath);
        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        file_put_contents($filePath, json_encode($this->classMapping, JSON_PRETTY_PRINT));
        $this->info('Mapping saved to: ' . $filePath);
    }
}
