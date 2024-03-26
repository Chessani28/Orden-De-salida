<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;


class ListRoutesForUser extends Command
{
    protected $signature = 'user:routes {user_id}';

    protected $description = 'List routes available for a user';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $userId = $this->argument('user_id');
        $user = User::find($userId);

        if (!$user) {
            $this->error('User not found.');
            return;
        }

        $routes = [];

        foreach (Route::getRoutes() as $route) {
            if ($this->userHasAccessToRoute($user, $route)) {
                $routes[] = [
                    'method' => implode('|', $route->methods()),
                    'uri' => $route->uri(),
                    'name' => $route->getName(),
                ];
            }
        }

        $this->table(['Method', 'URI', 'Name'], $routes);
    }

    private function userHasAccessToRoute($user, $route)
    {
        // Implement logic to check if the user has access to the route based on their role or permissions.
        // You can access the route's middleware and other properties to make this determination.
        // Return true if the user has access, otherwise return false.
    }
}
