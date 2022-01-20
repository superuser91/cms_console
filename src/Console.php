<?php

namespace Vgplay\CmsConsole;

use Illuminate\Support\Facades\Artisan;

class Console
{
    /**
     * Execute artisan command
     *
     * @param string $command
     * @return string
     */
    public function execute(string $command)
    {
        [$name, $options] = $this->extractCommand($command);

        if (!in_array($name, config('cms_console.white_list', []))) {
            throw new \Exception("Không được phép thực thi lệnh: php artisan " . $command);
        }

        Artisan::call($name, $options);

        return Artisan::output();
    }

    protected function extractCommand($rawCommand)
    {
        $params = explode(' ', $rawCommand);

        $name = $params[0];

        $options = [];

        for ($i = 1; $i < count($params); $i++) {
            if (trim($params[$i])) {
                $arg = explode('=', $params[$i]);
                $options[$arg[0]] = $arg[1] ?? true;
            }
        }

        return [$name, $options];
    }
}
