<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $team = [
            [
                'name' => 'Ali Intizar',
                'position' => 'Assistant Professor & Supervisor',
                'image' => 'images/team/ali.jpg',
                'link' => 'https://www.intizarali.org/home',
            ],
            [
                'name' => 'Muhammad Ehsan',
                'position' => 'Research Assistant & Web Developer',
                'image' => 'images/team/ehsan.jpg',
                'link' => 'www.linkedin.com/in/muhammad-ehsan-28b105199',
            ]
        ];

        foreach ($team as $member) {
            Team::updateOrCreate(
                $member,$member
            );
        }
    }
}
