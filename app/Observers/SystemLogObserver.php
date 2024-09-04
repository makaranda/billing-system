<?php

namespace App\Observers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class SystemLogObserver
{
    public function created(Model $model)
    {
        $this->logChange($model, 'created');
    }

    public function updated(Model $model)
    {
        $this->logChange($model, 'updated');
    }

    public function deleted(Model $model)
    {
        $this->logChange($model, 'deleted');
    }

    protected function logChange(Model $model, $operation)
    {
        $routeName = Route::currentRouteName(); // Get current route name
        $previousData = $model->getOriginal(); // Get previous data (before update)
        $currentData = $model->getAttributes(); // Get current data (after update)

        DB::table('system_logs')->insert([
            'user_id' => Auth::id(),  // Get the authenticated user ID
            'table_name' => $model->getTable(),
            'operation' => $operation,
            'previous_data' => json_encode($previousData), // Store previous data
            'current_data' => json_encode($currentData), // Store current data
            'route_name' => $routeName, // Store current route name
            'created_at' => now(),
        ]);
    }
}
