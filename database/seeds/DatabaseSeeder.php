<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         $this->call(UserSeeder::class);
        $userOne = entity(\App\Entities\User::class)->create([
            'name' => 'DarkWood',
            'email' => 'bariev.ilnarbi@gmail.com',
            'password' => bcrypt('123456')
        ]);
        $userTwo = entity(\App\Entities\User::class)->create([
            'name' => 'LockDown',
            'email' => 'lock@down.com',
            'password' => bcrypt('123456')
        ]);
    }
}
