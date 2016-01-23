<?php

use Illuminate\Database\Seeder;

class OAuthClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::insert('insert into oauth_clients (id, secret, name, created_at) values (?, ?, ?, ?)',
            [env('OAUTH_CLIENT_ID'), env('OAUTH_CLIENT_SECRET'), env('OAUTH_CLIENT_ID'), date('Y-m-d H:i:s')]);
    }
}
