<?php

use Illuminate\Database\Seeder;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $comment = new App\Comment;
        //$comment->title = "Neuer Kommentar";
        $comment->text = 'Lorem ipsum dolor sit amet.';

        $user = App\User::all()->find(3);
        $comment->user()->associate($user);

        $shoppinglist = App\Shoppinglist::all()->first();
        $comment->shoppinglist()->associate($shoppinglist);
        $comment->save();

    }
}
