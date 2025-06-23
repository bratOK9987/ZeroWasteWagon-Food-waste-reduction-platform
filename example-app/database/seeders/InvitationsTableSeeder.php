<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB; // Include the DB facade

class InvitationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 100; $i++) {
            DB::table('invitations')->insert([
                'invitation_code' => str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT), // Generate a 6-digit code.
                'used' => false, // Initially, codes are not used.
            ]);
        }
    }
}

