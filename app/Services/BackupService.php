<?php

namespace App\Services;

use App\Models\Backup;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use ZipArchive;

class BackupService
{
    protected string $backupPath = 'backups';

    public function createBackup(?string $description = null): Backup
    {
        // Create backup filename with timestamp
        $timestamp = now()->format('Y_m_d_H_i_s');
        $filename = "backup_{$timestamp}.sql";
        $filePath = storage_path("app/{$this->backupPath}/{$filename}");

        // Ensure directory exists
        if (!is_dir(dirname($filePath))) {
            mkdir(dirname($filePath), 0755, true);
        }

        // Get database credentials
        $database = config('database.connections.mysql.database');
        $username = config('database.connections.mysql.username');
        $password = config('database.connections.mysql.password');
        $host = config('database.connections.mysql.host');

        // Determine mysqldump path based on OS
        $mysqldumpPath = $this->getMysqldumpPath();

        // Run mysqldump command
        $command = sprintf(
            '%s -h %s -u %s -p%s %s > %s',
            $mysqldumpPath,
            escapeshellarg($host),
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($database),
            escapeshellarg($filePath)
        );

        exec($command, $output, $returnVar);

        if ($returnVar !== 0) {
            throw new \Exception('Backup failed: mysqldump command failed. Make sure mysqldump is installed and accessible.');
        }

        // Verify file was created and has content
        if (!file_exists($filePath) || filesize($filePath) === 0) {
            throw new \Exception('Backup failed: No data was written to backup file');
        }

        // Get file size
        $fileSize = filesize($filePath);

        // Create backup record
        $backup = Backup::create([
            'filename' => $filename,
            'path' => "{$this->backupPath}/{$filename}",
            'file_size' => $fileSize,
            'description' => $description,
            'created_by' => auth()->id(),
            'backup_at' => now(),
        ]);

        return $backup;
    }

    private function getMysqldumpPath(): string
    {
        $isWindows = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN';

        if ($isWindows) {
            // Try common XAMPP installation paths on Windows
            $possiblePaths = [
                'C:\\xampp\\mysql\\bin\\mysqldump.exe',
                'C:\\Program Files\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe',
                'C:\\Program Files\\MySQL\\MySQL Server 5.7\\bin\\mysqldump.exe',
                'C:\\Program Files (x86)\\MySQL\\MySQL Server 8.0\\bin\\mysqldump.exe',
                'C:\\Program Files (x86)\\MySQL\\MySQL Server 5.7\\bin\\mysqldump.exe',
            ];

            foreach ($possiblePaths as $path) {
                if (file_exists($path)) {
                    return '"' . $path . '"';
                }
            }

            // If no path found, try the command directly (might be in PATH)
            return 'mysqldump.exe';
        } else {
            // On Linux/Mac
            return 'mysqldump';
        }
    }

    public function listBackups(): \Illuminate\Database\Eloquent\Collection
    {
        return Backup::orderBy('created_at', 'desc')->get();
    }

    public function deleteBackup(Backup $backup): bool
    {
        $filePath = storage_path("app/{$backup->path}");

        if (file_exists($filePath)) {
            unlink($filePath);
        }

        return $backup->delete();
    }

    public function downloadBackup(Backup $backup)
    {
        $filePath = storage_path("app/{$backup->path}");

        if (!file_exists($filePath)) {
            throw new \Exception('Backup file not found');
        }

        return response()->download($filePath, $backup->filename);
    }

    public function autoBackup(): void
    {
        // Keep only the latest 10 backups
        $backups = Backup::orderBy('created_at', 'desc')->get();

        if ($backups->count() > 10) {
            foreach ($backups->skip(10) as $backup) {
                $this->deleteBackup($backup);
            }
        }
    }
}
