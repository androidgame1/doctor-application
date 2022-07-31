<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user=[
            'cin'=>'EE000000',
            'fullname'=>'Amejjoud Anas',
            'email'=>'anas.wawa10@gmail.com',
            'password'=>'$2a$09$XkxIz3g.DVPcR1ZSIrJTAuG2SvDFEEaihImk4Gv4AfU8IF7BGJmHu',
            'address'=>'Massira 1',
            'phone'=>'0688622671',
            'city'=>'Marrakech',
            'isvalidate'=>'2'
        ];
        User::create($user);
    }
}
