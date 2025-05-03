@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>Projects</h2>
                    <a href="{{ route('projects.create') }}" class="btn btn-primary">Create New Project</a>
                </div>

                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="row">
                        @forelse ($projects as $project)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $project->title }}</h5>
                                        <p class="card-text">{{ Str::limit($project->description, 100) }}</p>
                                        <div class="d-flex justify-content-between">
                                            <a href="{{ route('projects.show', $project) }}" class="btn btn-info">View</a>
                                            <span class="badge bg-primary">{{ $project->userStories->count() }} stories</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p>No projects found. Create your first project!</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
