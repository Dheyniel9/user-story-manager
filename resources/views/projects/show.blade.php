<!-- resources/views/projects/show.blade.php -->
@extends('layouts.app')

@section('title', $project->title)

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>{{ $project->title }}</h2>
                    <div>
                        <a href="{{ route('projects.edit', $project) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Project
                        </a>
                        <a href="{{ route('projects.user-stories.create', $project) }}" class="btn btn-primary">
                            <i class="fas fa-plus-circle"></i> Add User Story
                        </a>
                    </div>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-4">
                        <h4>Project Description</h4>
                        <p>{{ $project->description ?: 'No description provided.' }}</p>
                    </div>

                    <h4>User Stories</h4>

                    @if($project->userStories->isEmpty())
                        <div class="alert alert-info">
                            No user stories have been added to this project yet.
                            <a href="{{ route('projects.user-stories.create', $project) }}">Add your first user story</a>.
                        </div>
                    @else
                        <div class="row mt-4">
                            <!-- Backlog Column -->
                            <div class="col-md-3">
                                <div class="card mb-4">
                                    <div class="card-header bg-secondary text-white">
                                        <strong>Backlog</strong>
                                    </div>
                                    <div class="card-body p-2">
                                        @foreach($project->userStories->where('status', 'backlog') as $story)
                                            <div class="card mb-2 user-story-card {{ $story->priority > 7 ? 'priority-high' : ($story->priority > 3 ? 'priority-medium' : 'priority-low') }}">
                                                <div class="card-body p-2">
                                                    <h6 class="card-title">{{ $story->title }}</h6>
                                                    <p class="card-text small">{{ Str::limit($story->description, 100) }}</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="badge bg-{{ $story->priority > 7 ? 'danger' : ($story->priority > 3 ? 'warning' : 'success') }}">
                                                            Priority: {{ $story->priority }}
                                                        </span>
                                                        <div class="btn-group">
                                                            <a href="{{ route('user-stories.edit', $story) }}" class="btn btn-sm btn-outline-secondary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('user-stories.destroy', $story) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user story?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @if($project->userStories->where('status', 'backlog')->isEmpty())
                                            <div class="text-center text-muted my-3">
                                                <em>No stories in backlog</em>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- In Progress Column -->
                            <div class="col-md-3">
                                <div class="card mb-4">
                                    <div class="card-header bg-primary text-white">
                                        <strong>In Progress</strong>
                                    </div>
                                    <div class="card-body p-2">
                                        @foreach($project->userStories->where('status', 'in-progress') as $story)
                                            <div class="card mb-2 user-story-card {{ $story->priority > 7 ? 'priority-high' : ($story->priority > 3 ? 'priority-medium' : 'priority-low') }}">
                                                <div class="card-body p-2">
                                                    <h6 class="card-title">{{ $story->title }}</h6>
                                                    <p class="card-text small">{{ Str::limit($story->description, 100) }}</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="badge bg-{{ $story->priority > 7 ? 'danger' : ($story->priority > 3 ? 'warning' : 'success') }}">
                                                            Priority: {{ $story->priority }}
                                                        </span>
                                                        <div class="btn-group">
                                                            <a href="{{ route('user-stories.edit', $story) }}" class="btn btn-sm btn-outline-secondary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('user-stories.destroy', $story) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user story?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @if($project->userStories->where('status', 'in-progress')->isEmpty())
                                            <div class="text-center text-muted my-3">
                                                <em>No stories in progress</em>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Review Column -->
                            <div class="col-md-3">
                                <div class="card mb-4">
                                    <div class="card-header bg-warning text-dark">
                                        <strong>Review</strong>
                                    </div>
                                    <div class="card-body p-2">
                                        @foreach($project->userStories->where('status', 'review') as $story)
                                            <div class="card mb-2 user-story-card {{ $story->priority > 7 ? 'priority-high' : ($story->priority > 3 ? 'priority-medium' : 'priority-low') }}">
                                                <div class="card-body p-2">
                                                    <h6 class="card-title">{{ $story->title }}</h6>
                                                    <p class="card-text small">{{ Str::limit($story->description, 100) }}</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="badge bg-{{ $story->priority > 7 ? 'danger' : ($story->priority > 3 ? 'warning' : 'success') }}">
                                                            Priority: {{ $story->priority }}
                                                        </span>
                                                        <div class="btn-group">
                                                            <a href="{{ route('user-stories.edit', $story) }}" class="btn btn-sm btn-outline-secondary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('user-stories.destroy', $story) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user story?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @if($project->userStories->where('status', 'review')->isEmpty())
                                            <div class="text-center text-muted my-3">
                                                <em>No stories in review</em>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Completed Column -->
                            <div class="col-md-3">
                                <div class="card mb-4">
                                    <div class="card-header bg-success text-white">
                                        <strong>Completed</strong>
                                    </div>
                                    <div class="card-body p-2">
                                        @foreach($project->userStories->where('status', 'completed') as $story)
                                            <div class="card mb-2 user-story-card {{ $story->priority > 7 ? 'priority-high' : ($story->priority > 3 ? 'priority-medium' : 'priority-low') }}">
                                                <div class="card-body p-2">
                                                    <h6 class="card-title">{{ $story->title }}</h6>
                                                    <p class="card-text small">{{ Str::limit($story->description, 100) }}</p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="badge bg-{{ $story->priority > 7 ? 'danger' : ($story->priority > 3 ? 'warning' : 'success') }}">
                                                            Priority: {{ $story->priority }}
                                                        </span>
                                                        <div class="btn-group">
                                                            <a href="{{ route('user-stories.edit', $story) }}" class="btn btn-sm btn-outline-secondary">
                                                                <i class="fas fa-edit"></i>
                                                            </a>
                                                            <form action="{{ route('user-stories.destroy', $story) }}" method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this user story?')">
                                                                    <i class="fas fa-trash"></i>
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        @if($project->userStories->where('status', 'completed')->isEmpty())
                                            <div class="text-center text-muted my-3">
                                                <em>No completed stories</em>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="mt-4">
                        <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project? This will delete all associated user stories.')">
                                <i class="fas fa-trash"></i> Delete Project
                            </button>
                        </form>
                        <a href="{{ route('projects.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Projects
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
