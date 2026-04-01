<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use App\Services\BackupService;
use Illuminate\Http\Request;

class BackupController extends Controller
{
    protected BackupService $backupService;

    public function __construct(BackupService $backupService)
    {
        $this->backupService = $backupService;
    }

    public function index()
    {
        $backups = $this->backupService->listBackups();
        return view('backups.index', compact('backups'));
    }

    public function create(Request $request)
    {
        try {
            $description = $request->input('description', 'Manual backup');
            $backup = $this->backupService->createBackup($description);

            return redirect()->route('backups.index')->with('success', "Backup '{$backup->filename}' created successfully!");
        } catch (\Exception $e) {
            return redirect()->route('backups.index')->with('error', 'Backup failed: ' . $e->getMessage());
        }
    }

    public function download(Backup $backup)
    {
        try {
            return $this->backupService->downloadBackup($backup);
        } catch (\Exception $e) {
            return redirect()->route('backups.index')->with('error', 'Download failed: ' . $e->getMessage());
        }
    }

    public function destroy(Backup $backup)
    {
        try {
            $filename = $backup->filename;
            $this->backupService->deleteBackup($backup);

            return redirect()->route('backups.index')->with('success', "Backup '{$filename}' deleted successfully!");
        } catch (\Exception $e) {
            return redirect()->route('backups.index')->with('error', 'Delete failed: ' . $e->getMessage());
        }
    }
}
