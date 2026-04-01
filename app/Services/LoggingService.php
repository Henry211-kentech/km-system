<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class LoggingService
{
    public static function log(
        string $action,
        string $modelType,
        int $modelId,
        string $description,
        ?array $oldValues = null,
        ?array $newValues = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => Auth::id() ?? 1,
            'action' => $action,
            'model_type' => $modelType,
            'model_id' => $modelId,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => Request::ip(),
            'user_agent' => Request::userAgent(),
        ]);
    }

    public static function logCreate(string $modelType, int $modelId, string $description, array $data = []): ActivityLog
    {
        return self::log('CREATE', $modelType, $modelId, $description, null, $data);
    }

    public static function logUpdate(string $modelType, int $modelId, string $description, array $oldValues, array $newValues): ActivityLog
    {
        return self::log('UPDATE', $modelType, $modelId, $description, $oldValues, $newValues);
    }

    public static function logDelete(string $modelType, int $modelId, string $description, array $data = []): ActivityLog
    {
        return self::log('DELETE', $modelType, $modelId, $description, $data, null);
    }

    public static function logView(string $modelType, int $modelId, string $description): ActivityLog
    {
        return self::log('VIEW', $modelType, $modelId, $description);
    }

    public static function logDownload(string $modelType, int $modelId, string $description): ?ActivityLog
    {
        $userId = Auth::id() ?? 1;
        $recent = ActivityLog::where('user_id', $userId)
            ->where('action', 'DOWNLOAD')
            ->where('model_type', $modelType)
            ->where('model_id', $modelId)
            ->where('description', $description)
            ->where('created_at', '>=', now()->subMinute())
            ->first();
        if ($recent) {
            return null;
        }
        return self::log('DOWNLOAD', $modelType, $modelId, $description);
    }
}
