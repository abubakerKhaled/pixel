<?php

namespace Database\Seeders;

use App\Models\Follow;
use App\Models\Like;
use App\Models\Post;
use App\Models\Profile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $profiles = Profile::factory()->count(20)->create();

        foreach ($profiles as $profile) {
            Post::factory()
                ->count(5)
                ->create(['profile_id' => $profile->id]);
        }

        foreach ($profiles as $profile) {
            $toFollow = Profile::query()
                ->where('id', '!=', $profile->id)
                ->inRandomOrder()
                ->limit(rand(3, 7))
                ->get();

            foreach ($toFollow as $target) {
                Follow::createFollow($profile, $target);
            }
        }

        $posts = Post::all();

        foreach ($profiles as $profile) {
            $toLike = Post::query()
                ->where('profile_id', '!=', $profile->id)
                ->inRandomOrder()
                ->limit(rand(10, 20))
                ->get();

            foreach ($toLike as $post) {
                Like::createLike($profile, $post);
            }
        }

        foreach ($profiles as $profile) {
            $toRepost = Post::query()
                ->where('profile_id', '!=', $profile->id)
                ->inRandomOrder()
                ->limit(rand(2, 7))
                ->get();

            foreach ($toRepost as $post) {
                $content = rand(0, 1) ? fake()->sentence() : null;
                Post::repost($profile, $post, $content);
            }
        }

        for ($i = 0; $i < rand(20, 30); $i++) {
            $parentPost = $posts->random();

            $replier = Profile::where('id', '!=', $parentPost->profile_id)
                ->inRandomOrder()
                ->first();

            Post::factory()
                ->reply($parentPost)
                ->create(['profile_id' => $replier->id]);
        }
    }
}
