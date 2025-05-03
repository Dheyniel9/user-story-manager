<!-- resources/views/layouts/partials/sidebar.blade.php -->
<div class="position-sticky pt-3">
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Quick Actions</span>
    </h6>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('projects.index') ? 'active' : '' }}" href="{{ route('projects.index') }}">
                <i class="fas fa-list"></i> All Projects
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('projects.create') ? 'active' : '' }}" href="{{ route('projects.create') }}">
                <i class="fas fa-plus"></i> New Project
            </a>
        </li>
    </ul>

    @if(isset($project) && $project->id)
    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Current Project</span>
    </h6>
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('projects.show') ? 'active' : '' }}" href="{{ route('projects.show', $project) }}">
                <i class="fas fa-eye"></i> View Details
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('projects.edit') ? 'active' : '' }}" href="{{ route('projects.edit', $project) }}">
                <i class="fas fa-edit"></i> Edit Project
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::routeIs('projects.user-stories.create') ? 'active' : '' }}" href="{{ route('projects.user-stories.create', $project) }}">
                <i class="fas fa-plus-circle"></i> Add User Story
            </a>
        </li>
    </ul>
    @endif

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>Recent Projects</span>
    </h6>
    <ul class="nav flex-column mb-2">
        @php
            $recentProjects = [];
            if (Auth::check() && method_exists(Auth::user(), 'recentProjects')) {
                $recentProjects = Auth::user()->recentProjects()->take(5)->get();
            }
        @endphp

        @forelse($recentProjects as $recentProject)
            <li class="nav-item">
                <a class="nav-link" href="{{ route('projects.show', $recentProject) }}">
                    <i class="fas fa-folder"></i> {{ Str::limit($recentProject->title, 20) }}
                </a>
            </li>
        @empty
            <li class="nav-item">
                <span class="nav-link text-muted">No recent projects</span>
            </li>
        @endforelse
    </ul>
</div>
