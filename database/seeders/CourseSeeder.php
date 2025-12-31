<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Course::create([
            'title' => 'Web Development Mastery',
            'description' => 'Learn complete web development from HTML, CSS, JavaScript to advanced frameworks. Build professional projects and become a full-stack developer.',
            'thumbnail' => 'https://via.placeholder.com/400x250/667eea/ffffff?text=Web+Development',
            'coach_name' => 'Alex Johnson',
            'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            'price' => 99.99,
        ]);

        Course::create([
            'title' => 'Digital Marketing Fundamentals',
            'description' => 'Master the art of digital marketing including SEO, social media, email marketing, and analytics. Transform your business growth strategies.',
            'thumbnail' => 'https://via.placeholder.com/400x250/764ba2/ffffff?text=Digital+Marketing',
            'coach_name' => 'Martha Williams',
            'video_url' => 'https://www.w3schools.com/html/movie.mp4',
            'price' => 79.99,
        ]);

        Course::create([
            'title' => 'Mobile App Development',
            'description' => 'Build stunning iOS and Android applications using React Native. Create your first mobile app and launch it on app stores.',
            'thumbnail' => 'https://via.placeholder.com/400x250/28a745/ffffff?text=Mobile+Apps',
            'coach_name' => 'Max Chen',
            'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            'price' => 129.99,
        ]);

        Course::create([
            'title' => 'Data Science & Machine Learning',
            'description' => 'Learn Python, data analysis, statistics, and ML algorithms. Build predictive models and work with real-world datasets.',
            'thumbnail' => 'https://via.placeholder.com/400x250/dc3545/ffffff?text=Data+Science',
            'coach_name' => 'John Smith',
            'video_url' => 'https://www.w3schools.com/html/movie.mp4',
            'price' => 149.99,
        ]);
    }
}
