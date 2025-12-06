<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class SyncContentImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:sync-images 
                            {--dry-run : Show what would be done without making changes}
                            {--force : Overwrite existing files in content-images}';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Sync image files to match database content keys';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $dryRun = $this->option('dry-run');
        $force = $this->option('force');
        
        $this->info('🎯 Content Images Sync Tool');
        $this->info('==========================');
        
        if ($dryRun) {
            $this->warn('DRY RUN MODE: No files will be modified');
        }
        
        // Get all image content entries
        $imageEntries = DB::table('contents')
            ->whereIn('type', ['image', 'video'])
            ->get(['key', 'value']);
            
        if ($imageEntries->isEmpty()) {
            $this->info('No media entries found in database.');
            return 0;
        }

        $this->info("Found {$imageEntries->count()} media entries in database.");
        $this->newLine();
        
        $synced = 0;
        $errors = 0;
        $skipped = 0;
        
        foreach ($imageEntries as $entry) {
            $result = $this->syncImageEntry($entry, $dryRun, $force);
            
            switch ($result) {
                case 'synced':
                    $synced++;
                    break;
                case 'error':
                    $errors++;
                    break;
                case 'skipped':
                    $skipped++;
                    break;
            }
        }
        
        $this->newLine();
        $this->info('📊 Summary:');
        $this->line("✅ Synced: {$synced}");
        $this->line("⏭️  Skipped: {$skipped}");
        $this->line("❌ Errors: {$errors}");
        
        if (!$dryRun && $synced > 0) {
            $this->info('\n🧹 Clearing content cache...');
            $this->call('cache:clear');
        }
        
        return 0;
    }
    
    private function syncImageEntry($entry, $dryRun, $force)
    {
        $key = $entry->key;
        $valueJson = json_decode($entry->value, true);
        if (is_string($valueJson)) {
            $valueJson = ['path' => $valueJson];
        } elseif (!is_array($valueJson)) {
            $valueJson = [];
        }
        $currentFilename = $valueJson['path'] ?? null;
        
        if (!$currentFilename) {
            $this->error("❌ {$key}: No path specified in database");
            return 'error';
        }
        
        // Generate expected filename based on content key
        $expectedFilename = $key . '.png';
        $expectedPath = "content-images/{$expectedFilename}";
        $expectedFullPath = public_path($expectedPath);
        
        // Check if file already exists with correct name
        if (file_exists($expectedFullPath) && !$force) {
            $this->line("⏭️  {$key}: Already exists at {$expectedPath}");
            
            // Update database if filename doesn't match
            if ($currentFilename !== $expectedFilename) {
                $this->updateDatabasePath($entry, $expectedFilename, $dryRun);
            }
            
            return 'skipped';
        }
        
        // Look for the current file in multiple locations
        $searchPaths = [
            "content-images/{$currentFilename}" => public_path("content-images/{$currentFilename}"),
            "img/{$currentFilename}" => public_path("img/{$currentFilename}"),
            "img/vectors/{$currentFilename}" => public_path("img/vectors/{$currentFilename}"),
            // Try without extension if current filename has no extension
            "img/{$currentFilename}.png" => public_path("img/{$currentFilename}.png"),
            "img/vectors/{$currentFilename}.png" => public_path("img/vectors/{$currentFilename}.png"),
        ];
        
        $sourceFile = null;
        $sourcePath = null;
        
        foreach ($searchPaths as $relativePath => $fullPath) {
            if (file_exists($fullPath)) {
                $sourceFile = $fullPath;
                $sourcePath = $relativePath;
                break;
            }
        }
        
        if (!$sourceFile) {
            $this->error("❌ {$key}: Source file not found. Looked for:");
            foreach ($searchPaths as $path => $fullPath) {
                $this->line("   - {$path}");
            }
            return 'error';
        }
        
        $action = file_exists($expectedFullPath) ? 'Overwriting' : 'Copying';
        $this->info("✅ {$key}: {$action} {$sourcePath} → {$expectedPath}");
        
        if (!$dryRun) {
            // Ensure content-images directory exists
            if (!File::exists(dirname($expectedFullPath))) {
                File::makeDirectory(dirname($expectedFullPath), 0755, true);
            }
            
            // Copy the file
            if (!File::copy($sourceFile, $expectedFullPath)) {
                $this->error("❌ {$key}: Failed to copy file");
                return 'error';
            }
            
            // Update database with correct filename
            $this->updateDatabasePath($entry, $expectedFilename, false);
        }
        
        return 'synced';
    }
    
    private function updateDatabasePath($entry, $newFilename, $dryRun)
    {
        $newValue = json_encode(['path' => $newFilename]);
        
        if (!$dryRun) {
            DB::table('contents')
                ->where('key', $entry->key)
                ->update(['value' => $newValue]);
                
            // Clear cache for this specific content key
            \Illuminate\Support\Facades\Cache::forget("cms:content-media:{$entry->key}");
        }
        
        $this->line("   📝 Updated database: {$entry->key} → {$newFilename}");
    }
}
