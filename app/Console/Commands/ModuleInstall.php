<?php
namespace App\Console\Commands;

use App\Events\ModuleInstalled;
use App\Models\Module\Module;
use App\Models\Module\ModuleHistory;
use Illuminate\Console\Command;
use Module as LaravelModule;

class ModuleInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'module:install {alias} {company_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the specified module.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $request = [
          'company_id' => $this->argument('company_id'),
          'alias' => strtolower($this->argument('alias')),
          'status' => '1',
        ];
        $model = Module::create($request);
        $module = LaravelModule::findByAlias($model->alias);
        // Add history
        $data = [
          'company_id' => $this->argument('company_id'),
          'module_id' => $model->id,
          'category' => $module->get('category'),
          'version' => $module->get('version'),
          'description' => trans('modules.history.installed', ['module' => $module->get('name')]),
        ];
        ModuleHistory::create($data);
        // Update database
        $this->call('migrate', ['--force' => true]);
        // Trigger event
        event(new ModuleInstalled($model->alias));
        $this->info('Module installed!');
    }
}
