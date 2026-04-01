<?php

namespace App\Console\Commands;

use App\Services\BackupService;
use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:create {--description= : Optional backup description}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a database backup';

    /**
     * Execute the console command.
     */
    public function handle(BackupService $backupService)
    {
        $this->info('Creating database backup...');

        try {
            $description = $this->option('description') ?? 'Automated backup';
            $backup = $backupService->createBackup($description);
            $this->info("✓ Backup created successfully: {$backup->filename}");
            $this->info("  Size: {$backup->getFileSizeFormatted()}");

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('✗ Backup failed: ' . $e->getMessage());

            return Command::FAILURE;
        }
    }
}
