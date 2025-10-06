<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('clearseed', function () {
    $this->info('Clearing selected tables...');

    DB::statement('SET FOREIGN_KEY_CHECKS=0;');

    DB::table('students')->truncate();
    DB::table('events')->truncate();
    DB::table('participations')->truncate();

    DB::statement('SET FOREIGN_KEY_CHECKS=1;');

    $this->info('Tables truncated successfully!');
})->describe('Truncate the students, events, and participations tables.');