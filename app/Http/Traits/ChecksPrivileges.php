<?php


namespace App\Http\Traits;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

trait ChecksPrivileges
{
    private array $exceptions = [
        '.update', '.store', '.html', 'login', 'logout'
    ];

    public function checkPrivilege(Request $request): bool
    {
        if ($request->session()->missing('privileges')) return true;

        $urls = session('privileges');
        $route_name = $request->route()->getName();

        if (!$urls && $this->checkIsException($route_name)) {

            Log::debug(sprintf('Method name %s authorizing route name %s', __FUNCTION__, $route_name));
            return true;
        }

        return collect($urls)->where('url', $route_name)->count() > 0 || $this->checkIsException($route_name);
    }



    /**
     * Same method than the checkPrivilege, but instead it's used by check_privilege helper
     * @param string $route_name
     * @return bool
     */
    public function checkPrivilegeRouteName(string $route_name): bool
    {
        $urls = session('privileges');

        if (!$urls && $this->checkIsException($route_name)) {

            Log::debug(sprintf('Method name %s authorizing route name %s', __FUNCTION__, $route_name));
            return true;
        }

        return collect($urls)->where('url', $route_name)->count() > 0;
    }

    /**
     * This method skips route declared in $exceptions
     * @param string $route_name
     * @return bool
     */
    private function checkIsException(string $route_name): bool
    {
        $result = collect($this->exceptions)->filter(function ($exception) use (&$route_name) {

            return strstr($route_name, $exception);
        });

        return sizeof($result) > 0;
    }
}
