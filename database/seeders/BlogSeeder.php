<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class BlogSeeder extends Seeder
{
    public function run()
    {
        // Disable foreign key checks temporarily
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Truncate tables to start fresh
        Comment::truncate();
        Post::truncate();
        Category::truncate();
        Tag::truncate();
        User::truncate();
        
        // Re-enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');

        // Create Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@blog.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Create Regular User
        $user = User::create([
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);

        // Create Categories
        $categories = [
            ['name' => 'Technology', 'slug' => 'technology'],
            ['name' => 'Travel', 'slug' => 'travel'],
            ['name' => 'Food', 'slug' => 'food'],
            ['name' => 'Lifestyle', 'slug' => 'lifestyle'],
            ['name' => 'Health', 'slug' => 'health'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create Tags
        $tags = [
            ['name' => 'Laravel', 'slug' => 'laravel'],
            ['name' => 'PHP', 'slug' => 'php'],
            ['name' => 'JavaScript', 'slug' => 'javascript'],
            ['name' => 'Web Development', 'slug' => 'web-development'],
            ['name' => 'Programming', 'slug' => 'programming'],
            ['name' => 'Cooking', 'slug' => 'cooking'],
            ['name' => 'Travel Tips', 'slug' => 'travel-tips'],
            ['name' => 'Fitness', 'slug' => 'fitness'],
        ];

        foreach ($tags as $tag) {
            Tag::create($tag);
        }

        // Create Sample Posts
        $posts = [
            [
                'title' => 'Getting Started with Laravel',
                'excerpt' => 'Learn how to start your first Laravel project and build amazing web applications.',
                'content' => $this->generateContent('Laravel'),
                'category_id' => 1,
                'user_id' => $admin->id,
                'published' => true,
                'published_at' => now(),
                'tags' => [1, 2, 4, 5]
            ],
            [
                'title' => 'Best Travel Destinations for 2024',
                'excerpt' => 'Discover the most amazing places to visit this year and plan your perfect vacation.',
                'content' => $this->generateContent('Travel'),
                'category_id' => 2,
                'user_id' => $admin->id,
                'published' => true,
                'published_at' => now()->subDays(1),
                'tags' => [7]
            ],
            [
                'title' => 'Healthy Recipes for Busy People',
                'excerpt' => 'Quick and nutritious meal ideas that you can prepare in under 30 minutes.',
                'content' => $this->generateContent('Food'),
                'category_id' => 3,
                'user_id' => $user->id,
                'published' => true,
                'published_at' => now()->subDays(2),
                'tags' => [6]
            ],
            [
                'title' => 'JavaScript ES6 Features You Should Know',
                'excerpt' => 'Explore the powerful features introduced in ES6 that every developer should master.',
                'content' => $this->generateContent('JavaScript'),
                'category_id' => 1,
                'user_id' => $admin->id,
                'published' => true,
                'published_at' => now()->subDays(3),
                'tags' => [3, 4, 5]
            ],
            [
                'title' => 'Morning Routine for Productivity',
                'excerpt' => 'Start your day right with these simple habits that will boost your productivity.',
                'content' => $this->generateContent('Productivity'),
                'category_id' => 4,
                'user_id' => $user->id,
                'published' => true,
                'published_at' => now()->subDays(4),
                'tags' => []
            ],
            [
                'title' => 'Benefits of Regular Exercise',
                'excerpt' => 'Discover how regular physical activity can improve your physical and mental health.',
                'content' => $this->generateContent('Exercise'),
                'category_id' => 5,
                'user_id' => $admin->id,
                'published' => true,
                'published_at' => now()->subDays(5),
                'tags' => [8]
            ],
            [
                'title' => 'Web Development Best Practices in 2024',
                'excerpt' => 'Stay updated with the latest web development trends and best practices for modern applications.',
                'content' => $this->generateContent('Web Development'),
                'category_id' => 1,
                'user_id' => $admin->id,
                'published' => true,
                'published_at' => now()->subDays(6),
                'tags' => [3, 4, 5]
            ],
            [
                'title' => 'Budget Travel Tips for Students',
                'excerpt' => 'Travel the world without breaking the bank with these practical budget travel tips.',
                'content' => $this->generateContent('Budget Travel'),
                'category_id' => 2,
                'user_id' => $user->id,
                'published' => true,
                'published_at' => now()->subDays(7),
                'tags' => [7]
            ],
            [
                'title' => 'Vegan Cooking for Beginners',
                'excerpt' => 'Easy and delicious vegan recipes that even meat-lovers will enjoy.',
                'content' => $this->generateContent('Vegan Cooking'),
                'category_id' => 3,
                'user_id' => $admin->id,
                'published' => true,
                'published_at' => now()->subDays(8),
                'tags' => [6]
            ],
            [
                'title' => 'Mental Health and Self-Care Strategies',
                'excerpt' => 'Practical self-care techniques to maintain good mental health in today\'s fast-paced world.',
                'content' => $this->generateContent('Mental Health'),
                'category_id' => 5,
                'user_id' => $user->id,
                'published' => true,
                'published_at' => now()->subDays(9),
                'tags' => [8]
            ]
        ];

        $createdPosts = [];
        
        foreach ($posts as $postData) {
            $tags = $postData['tags'];
            unset($postData['tags']);

            $postData['slug'] = Str::slug($postData['title']);
            
            // Create the post
            $post = Post::create($postData);
            $createdPosts[] = $post;
            
            // Attach tags if any
            if (!empty($tags)) {
                $post->tags()->sync($tags);
            }
        }

        // Create Sample Comments - Use the actual created posts
        $comments = [
            ['post_id' => $createdPosts[0]->id, 'user_id' => $user->id, 'content' => 'Great article! Very helpful for beginners.', 'approved' => true],
            ['post_id' => $createdPosts[0]->id, 'user_id' => $admin->id, 'content' => 'Thanks for reading! Let me know if you have any questions.', 'approved' => true],
            ['post_id' => $createdPosts[1]->id, 'user_id' => $user->id, 'content' => 'I visited Bali last year and it was amazing!', 'approved' => true],
            ['post_id' => $createdPosts[2]->id, 'user_id' => $admin->id, 'content' => 'These recipes look delicious. Can\'t wait to try them!', 'approved' => true],
            ['post_id' => $createdPosts[3]->id, 'user_id' => $user->id, 'content' => 'ES6 really changed the game for JavaScript development.', 'approved' => true],
            ['post_id' => $createdPosts[4]->id, 'user_id' => $admin->id, 'content' => 'Great productivity tips! I\'ll implement these tomorrow.', 'approved' => true],
            ['post_id' => $createdPosts[5]->id, 'user_id' => $user->id, 'content' => 'Exercise has completely changed my life for the better.', 'approved' => true],
            ['post_id' => $createdPosts[6]->id, 'user_id' => $admin->id, 'content' => 'Excellent overview of modern web development practices.', 'approved' => true],
            ['post_id' => $createdPosts[7]->id, 'user_id' => $user->id, 'content' => 'These budget tips are perfect for students like me!', 'approved' => true],
            ['post_id' => $createdPosts[8]->id, 'user_id' => $admin->id, 'content' => 'Even as a non-vegan, these recipes look amazing.', 'approved' => true],
            ['post_id' => $createdPosts[9]->id, 'user_id' => $user->id, 'content' => 'Mental health is so important. Thanks for addressing this topic.', 'approved' => true],
        ];

        foreach ($comments as $commentData) {
            Comment::create($commentData);
        }

        $this->command->info('Blog sample data seeded successfully!');
        $this->command->info('Admin Login: admin@blog.com / password');
        $this->command->info('User Login: john@example.com / password');
        $this->command->info('Total Posts: ' . Post::count());
        $this->command->info('Total Comments: ' . Comment::count());
    }

    private function generateContent($topic)
    {
        return "
        <h2>Introduction to $topic</h2>
        <p>This is a comprehensive guide about $topic. Whether you're a beginner or an experienced enthusiast, this article will provide valuable insights and practical tips.</p>
        
        <h3>Key Benefits</h3>
        <p>Discover the amazing benefits of exploring $topic and how it can transform your experience.</p>
        
        <h3>Getting Started</h3>
        <p>Follow these simple steps to begin your journey with $topic:</p>
        <ol>
            <li>Step 1: Understand the basics</li>
            <li>Step 2: Practice regularly</li>
            <li>Step 3: Join the community</li>
            <li>Step 4: Keep learning and improving</li>
        </ol>
        
        <h3>Advanced Techniques</h3>
        <p>Once you've mastered the basics, explore these advanced techniques to take your skills to the next level.</p>
        
        <h3>Conclusion</h3>
        <p>$topic offers endless possibilities for growth and discovery. Start your journey today and unlock new opportunities!</p>
        ";
    }
}
