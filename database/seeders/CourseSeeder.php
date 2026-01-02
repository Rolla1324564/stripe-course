<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = [
            [
                'title' => 'Web Development Mastery',
                'description' => 'Learn complete web development from HTML, CSS, JavaScript to advanced frameworks. Build real-world projects.',
                'coach_name' => 'Alex Johnson',
                'price' => 99.99,
                'thumbnail' => 'https://via.placeholder.com/400x250/667eea/ffffff?text=Web+Development',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            ],
            [
                'title' => 'Digital Marketing Fundamentals',
                'description' => 'Master the art of digital marketing including SEO, social media, email marketing, and more.',
                'coach_name' => 'Martha Williams',
                'price' => 79.99,
                'thumbnail' => 'https://via.placeholder.com/400x250/764ba2/ffffff?text=Digital+Marketing',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            ],
            [
                'title' => 'Mobile App Development',
                'description' => 'Build stunning iOS and Android applications using React Native. Create your first mobile app today.',
                'coach_name' => 'Max Chen',
                'price' => 129.99,
                'thumbnail' => 'https://via.placeholder.com/400x250/f093fb/ffffff?text=Mobile+Development',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            ],
            [
                'title' => 'Data Science & Machine Learning',
                'description' => 'Learn Python, data analysis, statistics, machine learning, and build AI models from scratch.',
                'coach_name' => 'John Smith',
                'price' => 149.99,
                'thumbnail' => 'https://via.placeholder.com/400x250/4facfe/ffffff?text=Data+Science',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            ],
            [
                'title' => 'UI/UX Design Masterclass',
                'description' => 'Master user interface and user experience design principles. Create beautiful and functional designs.',
                'coach_name' => 'Sarah Davis',
                'price' => 89.99,
                'thumbnail' => 'https://via.placeholder.com/400x250/00f2fe/ffffff?text=UI+UX+Design',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            ],
            [
                'title' => 'Python Programming Bootcamp',
                'description' => 'Complete Python programming course from basics to advanced. Build real projects with Python.',
                'coach_name' => 'David Brown',
                'price' => 69.99,
                'thumbnail' => 'https://via.placeholder.com/400x250/ffa400/ffffff?text=Python',
                'video_url' => 'https://www.w3schools.com/html/mov_bbb.mp4',
            ],
        ];

        foreach ($courses as $course) {
            Course::firstOrCreate(
                ['title' => $course['title']],
                $course
            );
        }
    }
}
