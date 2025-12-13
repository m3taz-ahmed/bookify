<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class UpdateAssetVersion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-asset-version {version?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the asset version for cache busting';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $versionFile = storage_path('app/version.txt');
        
        if ($this->argument('version')) {
            $newVersion = $this->argument('version');
        } else {
            // Auto-generate version based on current timestamp
            $newVersion = date('Ymd.His');
        }
        
        file_put_contents($versionFile, $newVersion);
        
        $this->info("Asset version updated to: {$newVersion}");
        
        // Clear cache to ensure changes take effect
        $this->call('cache:clear');
        $this->call('view:clear');
        $this->call('config:clear');
        
        $this->info('All caches cleared successfully!');
    }
}