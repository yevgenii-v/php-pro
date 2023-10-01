<?php

namespace App\Services\Supervisor;

use Exception;
use fXmlRpc\Client;
use fXmlRpc\Transport\HttpAdapterTransport;
use GuzzleHttp\Client as GuzzleClient;
use Http\Message\MessageFactory\GuzzleMessageFactory;
use Illuminate\Support\Facades\Log;
use Supervisor\Configuration\Loader\IniFileLoader;
use Supervisor\Configuration\Section\Program;
use Supervisor\Configuration\Writer\IniFileWriter;
use Supervisor\Supervisor;

class SupervisorService
{
    private const PREFIX = 'program:';
    private const PROCESS_NAME_FORMULA = '%(program_name)s_%(process_num)02d';
    private const AUTO_START = true;
    private const AUTO_RESTART = true;
    private const USER = 'www-data';
    private const START_RETRIES = 100;
    private Supervisor $supervisor;
    private IniFileLoader $iniFileLoader;
    private IniFileWriter $iniFileWriter;
    public function __construct()
    {
        $guzzleClient = new GuzzleClient([
            'auth' => [
                config('supervisor.user'),
                config('supervisor.password'),
            ],
        ]);

        $client = new Client(
            config('supervisor.clientUrl'),
            new HttpAdapterTransport(
                new GuzzleMessageFactory(),
                $guzzleClient,
            )
        );

        $this->supervisor = new Supervisor($client);
        $this->iniFileLoader = new IniFileLoader(base_path() . '/' . config('supervisor.configPath'));
        $this->iniFileWriter = new IniFileWriter(config('supervisor.configPath'));
    }

    /**
     * @param string $name
     * @return bool
     */
    public function startProcess(string $name): bool
    {
        try {
            $this->supervisor->startProcessGroup($name);

            return true;
        } catch (Exception $e) {
            Log::info($e->getMessage());

            return false;
        }
    }

    /**
     * @param string $name
     * @return bool
     */
    public function stopProcess(string $name): bool
    {
        try {
            $this->supervisor->stopProcessGroup($name);

            return true;
        } catch (Exception $e) {
            Log::info($e->getMessage());

            return false;
        }
    }

    public function addProcessConfig(ProcessDTO $DTO): void
    {
        try {
            $loader = $this->iniFileLoader->load();
            if ($loader->hasSection(self::PREFIX . $DTO->getName()) === true) {
                return;
            }

            $section = new Program(
                $DTO->getName(),
                [
                    'command' => $DTO->getCommand(),
                    'process_name' => self::PROCESS_NAME_FORMULA,
                    'autostart' => self::AUTO_START,
                    'autorestart' => self::AUTO_RESTART,
                    'user' => self::USER,
                    'numprocs' => $DTO->getNumber(),
                    'startretries' => self::START_RETRIES,
                ]
            );
            $loader->addSection($section);
            $this->iniFileWriter->write($loader);
            $this->supervisor->reloadConfig();
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }

    public function updateProcess(ProcessDTO $DTO): void
    {
        try {
            $loader = $this->iniFileLoader->load();

            if ($loader->hasSection(self::PREFIX . $DTO->getName()) === false) {
                return;
            }

            $loader->removeSection(self::PREFIX . $DTO->getName());
            $section = new Program(
                $DTO->getName(),
                [
                    'command' => $DTO->getCommand(),
                    'process_name' => self::PROCESS_NAME_FORMULA,
                    'autostart' => self::AUTO_START,
                    'autorestart' => self::AUTO_RESTART,
                    'user' => self::USER,
                    'numprocs' => $DTO->getNumber(),
                    'startretries' => self::START_RETRIES,
                ]
            );

            $loader->addSection($section);
            $this->iniFileWriter->write($loader);
            $this->supervisor->reloadConfig();
        } catch (Exception $e) {
            Log::info($e->getMessage());
        }
    }

    /**
     * @param string $name
     * @return void
     */
    public function delete(string $name): void
    {
        try {
            $loader = $this->iniFileLoader->load();
            if ($loader->hasSection(self::PREFIX . $name) === false) {
                return;
            }
            $loader->removeSection(self::PREFIX . $name);
            $this->iniFileWriter->write($loader);
            $this->supervisor->reloadConfig();
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    public function hasSection(string $name): bool
    {
        return $this->iniFileLoader
            ->load()
            ->hasSection(self::PREFIX . $name);
    }
}
