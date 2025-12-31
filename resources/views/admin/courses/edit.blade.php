@extends('admin.layouts.app')

@section('title', 'Edit Course')
@section('page-title', '✏️ Edit Course')

@section('content')
    <div class="form-container">
        <form action="{{ route('admin.courses.update', $course->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Course Title *</label>
                <input type="text" id="title" name="title" required value="{{ $course->title }}" placeholder="e.g., Web Development Masterclass">
                @error('title') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea id="description" name="description" required placeholder="Detailed course description..." rows="5">{{ $course->description }}</textarea>
                @error('description') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="coach_name">Coach Name *</label>
                    <input type="text" id="coach_name" name="coach_name" required value="{{ $course->coach_name }}" placeholder="e.g., John Doe">
                    @error('coach_name') <span class="error">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="price">Price (USD) *</label>
                    <input type="number" id="price" name="price" required value="{{ $course->price }}" step="0.01" min="0" placeholder="99.99">
                    @error('price') <span class="error">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="form-group">
                <label for="thumbnail">Thumbnail Image *</label>
                <div style="margin-bottom: 10px;">
                    <img src="{{ $course->thumbnail }}" alt="{{ $course->title }}" style="max-width: 200px; height: auto; border-radius: 6px;">
                </div>
                <input type="url" id="thumbnail" name="thumbnail" required value="{{ $course->thumbnail }}" placeholder="https://example.com/image.jpg">
                <small>Enter image URL (PNG/JPG)</small>
                @error('thumbnail') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="video_url">Video URL *</label>
                <input type="url" id="video_url" name="video_url" required value="{{ $course->video_url }}" placeholder="https://youtube.com/embed/...">
                <small>Enter video embed URL (YouTube, Vimeo, etc.)</small>
                @error('video_url') <span class="error">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-success">Update Course</button>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

    <style>
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            padding: 30px;
            max-width: 700px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        input[type="url"],
        textarea {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 0.95em;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        input[type="url"]:focus,
        textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
        }

        small {
            display: block;
            margin-top: 5px;
            color: #999;
            font-size: 0.85em;
        }

        .error {
            color: #dc3545;
            font-size: 0.85em;
            display: block;
            margin-top: 5px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .form-actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 25px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
            font-size: 0.95em;
            flex: 1;
            text-align: center;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-success:hover {
            background: #218838;
            transform: scale(1.02);
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
        }

        @media (max-width: 768px) {
            .form-container {
                padding: 20px;
            }

            .form-row {
                grid-template-columns: 1fr;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
@endsection
