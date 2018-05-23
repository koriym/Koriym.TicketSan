<?php
namespace Koriym\TicketSan\Module;

use BEAR\Package\PackageModule;
use BEAR\Package\Provide\Router\AuraRouterModule;
use BEAR\Resource\Module\JsonSchemalModule;
use josegonzalez\Dotenv\Loader as Dotenv;
use Koriym\Now\NowModule;
use Koriym\QueryLocator\QueryLocatorModule;
use Koriym\TicketSan\Form\TicketForm;
use Ray\AuraSqlModule\AuraSqlModule;
use Ray\Di\AbstractModule;
use Ray\Query\SqlQueryModule;
use Ray\WebFormModule\AuraInputModule;
use Ray\WebFormModule\FormInterface;

class AppModule extends AbstractModule
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $appDir = dirname(__DIR__, 2);
        Dotenv::load([
            'filepath' => $appDir . '/.env',
            'toEnv' => true
        ]);
        $this->install(new AuraRouterModule($appDir . '/var/conf/aura.route.php'));
        $this->install(new PackageModule);
        $this->install(new NowModule);
        $this->install(new JsonSchemalModule($appDir . '/var/json_schema', $appDir . '/var/json_validate'));
        // Database
        $dbConfig = 'sqlite:' . $appDir . '/var/db/ticket.sqlite3';
        $this->install(new AuraSqlModule($dbConfig));
        // Form
        $this->install(new AuraInputModule);
        $this->bind(TicketForm::class);
        $this->bind(FormInterface::class)->annotatedWith('ticket_form')->to(TicketForm::class);
        $this->install(new SqlQueryModule($appDir . '/var/sql'));
        $this->install(new PackageModule);
    }
}
