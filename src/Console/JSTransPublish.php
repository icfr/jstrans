<?php

namespace MisterPaladin\Console;

use Illuminate\Console\Command;

class JSTransPublish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'jstrans:publish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create jstrans file';

    protected $config;

    protected $lang;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct($config, $lang)
    {
        $this->config  = $config;
        $this->lang    = $lang;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $trans = [];

        foreach ($this->config->get('jstrans.lang_files', []) as $file) {
            $trans[$file] = $this->lang->get($file);
        }

        $json = json_encode($trans);

        $js     = sprintf(file_get_contents(__DIR__ . '/../js/jstrans.js'), $json);
        $jsFile = $this->config->get('jstrans.js_file') . '/jstrans.js';
        file_put_contents($jsFile, $js);
        $this->info('Js file saved to '.$jsFile);

    }
}
