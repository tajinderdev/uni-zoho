<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use DB;

class TokenSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        $tokens = [[
            'access_token' => Str::random(30),
            'refresh_token' => Str::random(30),
            'scope' => "all",
            'expired_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ],
        [
            'access_token' => Str::random(30),
            'refresh_token' => Str::random(30),
            'scope' => "all",
            'expired_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]];
        DB::table('tokens')->insert($tokens);
    }
}
