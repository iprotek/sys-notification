<?php

namespace iProtek\SysNotification\Console\Commands;

use Illuminate\Console\Command;

class IprotekSysNotificationTest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'iprotek-sys-notification:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the PHP Value';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $result = \iProtek\SysNotification\Helpers\GitHelper::runGitCommand("git log --pretty=format:'{\"commit_hash\":\"%h\",\"author_name\":\"%an\",\"author_email\":\"%ae\",\"date\":\"%ad\",\"commit_message\":\"%s\",\"description\":\"%b\"},'  HEAD..FETCH_HEAD");
        echo $result."Loaded Notification";
        //\App\Helpers\ScheduleHelper::updatePHPCurrency();
        //return 0;
    }
}
