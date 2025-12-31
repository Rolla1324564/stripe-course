@extends('admin.layouts.app')

@section('title', 'Courses Management')
@section('page-title', '📚 All Courses')

@section('content')
    <div class="courses-header">
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">+ Add New Course</a>
    </div>

    @if ($courses->count() > 0)
        <div class="courses-grid">
            @foreach ($courses as $course)
                <div class="course-card">
                    <div class="course-thumbnail">
                        <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}">
                    </div>
                    <div class="course-body">
                        <h3>{{ $course->title }}</h3>
                        <p class="coach">👨‍🏫 {{ $course->coach_name }}</p>
                        <p class="description">{{ Str::limit($course->description, 80) }}</p>
                        <div class="course-footer">
                            <div class="price">${{ number_format($course->price, 2) }}</div>
                            <div class="actions">
                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-small btn-edit">Edit</a>
                                <form action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-small btn-delete" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="no-data">
            <p>No courses found. <a href="{{ route('admin.courses.create') }}">Create one now!</a></p>
        </div>
    @endif

    <style>
        .courses-header {
            margin-bottom: 30px;
        }

        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            border: none;
            display: inline-block;
            transition: all 0.3s;
            font-size: 0.95em;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: scale(1.02);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-small {
            padding: 6px 12px;
            font-size: 0.85em;
        }

        .btn-edit {
            background: #28a745;
            color: white;
            margin-right: 5px;
        }

        .btn-edit:hover {
            background: #218838;
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 25px;
        }

        .course-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .course-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15);
        }

        .course-thumbnail {
            width: 100%;
            height: 200px;
            overflow: hidden;
            background: #f0f0f0;
        }

        .course-thumbnail img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .course-body {
            padding: 20px;
        }

        .course-body h3 {
            color: #667eea;
            margin-bottom: 8px;
            font-size: 1.2em;
        }

        .coach {
            color: #666;
            font-size: 0.9em;
            margin-bottom: 10px;
        }

        .description {
            color: #999;
            font-size: 0.9em;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .course-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #eee;
            padding-top: 15px;
        }

        .price {
            font-size: 1.5em;
            font-weight: bold;
            color: #667eea;
        }

        .actions {
            display: flex;
            gap: 5px;
        }

        .no-data {
            text-align: center;
            padding: 60px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }

        .no-data a {
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
        }

        .no-data a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            .courses-grid {
                grid-template-columns: 1fr;
            }

            .actions {
                flex-direction: column;
                width: 100%;
            }

            .btn-small {
                width: 100%;
                text-align: center;
            }

            .btn-edit {
                margin-right: 0;
                margin-bottom: 5px;
            }
        }
    </style>
@endsection
