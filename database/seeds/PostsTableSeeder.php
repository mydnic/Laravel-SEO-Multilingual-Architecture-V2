<?php

use App\Post;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()->setLocale('en');

        $post = new Post;
        $post->title = 'Awesome Translated Post!';
        $post->content = 'Hello World! It works!!';
        $post->save();

        app()->setLocale('fr');

        $post->title = 'Super Article traduit en français!';
        $post->content = 'Bonjour le monde! Ca fonctionne bien !!';
        $post->save();
    }
}
