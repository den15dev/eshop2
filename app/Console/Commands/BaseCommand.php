<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BaseCommand extends Command
{
    protected $name = 'app:install';

    protected static ?string $test_db_connection = null;
}
