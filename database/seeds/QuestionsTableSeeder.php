<?php

use App\Models\Like;
use App\Models\Question;
use App\Models\Reply;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        Like::truncate();
        Reply::truncate();
        Question::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        factory(Question::class, 25)->create();
    }
}
