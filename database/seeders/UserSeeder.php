<?php

namespace Database\Seeders;

use App\Modules\Users\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    const USERS_NUM = 20;
    const EMAIL_ENDING = '@tmail.tst';


    public function run(): void
    {
        if (User::where('email', 'like', '%' . self::EMAIL_ENDING)->count() < 1) {
            for ($i = 0; $i < self::USERS_NUM; $i++) {
                self::createUser();
            }
        }
    }


    private static function createUser(): void
    {
        do { $name = fake()->name(); }
        while (!preg_match('/^[a-z]+ [a-z]+$/i', $name));

        $email_prefix = mb_strtolower(explode(' ', $name)[0]);
        $email = $email_prefix . self::EMAIL_ENDING;
        $email_cnt = 1;

        while (User::where('email', $email)->exists()) {
            $email = $email_prefix . $email_cnt . self::EMAIL_ENDING;
            $email_cnt++;
        }

        $date_time = fake()->dateTimeBetween('-3 month');

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->email_verified_at = now();
        $user->password = Hash::make('secret');
        $user->role = 'user';
        $user->is_active = true;
        $user->created_at = $date_time;
        $user->updated_at = $date_time;
        $user->save();
    }
}
