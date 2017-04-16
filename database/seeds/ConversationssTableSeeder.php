<?php

use Illuminate\Database\Seeder;

class ConversationssTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Conversation::class, 20)->create();
    }
}
