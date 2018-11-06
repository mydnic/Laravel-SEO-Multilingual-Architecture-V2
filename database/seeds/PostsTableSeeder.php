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

        $post = Post::create([
            'title' => 'Awesome Translated Post!',
            'content' => 'Hello World! It works!!',
        ]);

        app()->setLocale('fr');
        // dd($post);
        // $post->slug = null;

        $post->update([
            'title' => 'Super Article traduit en français!',
            'content' => 'Bonjour le monde! Ca fonctionne bien !!',
        ]);
    }
}
