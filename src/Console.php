<?php

namespace Vgplay\CmsConsole;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class Console
{
    /**
     * Show console UI
     *
     * @return void
     */
    public function show()
    {
        return view('vgplay::console.index');
    }

    public function execute(Request $request)
    {
        try {
            return response()->json(['message' => $this->handle($request['command'] ?? '')]);
        } catch (\Exception $e) {
            return response()->json(['message' =>  $e->getMessage()], 500);
        }
    }

    /**
     * Execute artisan command
     *
     * @param string $command
     * @return string
     */
    public function handle(string $command)
    {
        [$name, $options] = $this->extractCommand($command);

        if (!in_array($name, config('vgplay.console.white_list', []))) {
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
