<?php

// Defines the namespace for this controller, organizing code under App\Http\Controllers
namespace App\Http\Controllers;

// Imports the Project model class to interact with the projects database table
use App\Models\Project;
// Imports the Request class to handle HTTP requests
use Illuminate\Http\Request;
// Imports the Auth facade to access authenticated user information
use Illuminate\Support\Facades\Auth;

// The ProjectController class handles all operations related to projects
class ProjectController extends Controller
{
    /**
     * Display a listing of all projects belonging to the authenticated user
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Gets all projects associated with the current logged-in user, ordered by most recently updated
        $projects = Auth::user()->recentProjects()->get();
        // Returns the index view with the projects data
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new project
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Returns the view containing the form to create a new project
        return view('projects.create');
    }

    /**
     * Store a newly created project in the database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validates the incoming form data
        $request->validate([
            'title' => 'required|string|max:255', // Title is required, must be a string, max 255 characters
            'description' => 'nullable|string',    // Description is optional, but must be a string if provided
        ]);

        // Creates a new Project instance with the validated data
        $project = new Project($request->all());
        // Associates the project with the currently logged-in user
        $project->user_id = Auth::id();
        // Saves the project to the database
        $project->save();

        // Redirects to the projects index page with a success message
        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified project
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\View\View
     */
    public function show(Project $project)
    {
        // Security check: Verifies that the current user owns this project
        if ($project->user_id !== Auth::id()) {
            // If not, returns a 403 Forbidden error
            abort(403, 'Unauthorized action.');
        }

        // Returns the show view with the project data
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified project
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\View\View
     */
    public function edit(Project $project)
    {
        // Security check: Verifies that the current user owns this project
        if ($project->user_id !== Auth::id()) {
            // If not, returns a 403 Forbidden error
            abort(403, 'Unauthorized action.');
        }

        // Returns the edit view with the project data
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified project in the database
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Project $project)
    {
        // Security check: Verifies that the current user owns this project
        if ($project->user_id !== Auth::id()) {
            // If not, returns a 403 Forbidden error
            abort(403, 'Unauthorized action.');
        }

        // Validates the incoming form data
        $request->validate([
            'title' => 'required|string|max:255', // Title is required, must be a string, max 255 characters
            'description' => 'nullable|string',    // Description is optional, but must be a string if provided
        ]);

        // Updates the project with the validated data
        $project->update($request->all());

        // Redirects to the projects index page with a success message
        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified project from the database
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Project $project)
    {
        // Security check: Verifies that the current user owns this project
        if ($project->user_id !== Auth::id()) {
            // If not, returns a 403 Forbidden error
            abort(403, 'Unauthorized action.');
        }

        // Deletes the project from the database
        $project->delete();

        // Redirects to the projects index page with a success message
        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
