<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\UserStory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserStoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Project $project)
    {
        // Check if the user owns this project
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $userStories = $project->userStories;

        return view('user-stories.index', compact('project', 'userStories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function create(Project $project)
    {
        // Check if the user owns this project
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user-stories.create', compact('project'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Project $project)
    {
        // Check if the user owns this project
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:backlog,in-progress,review,completed',
            'priority' => 'required|integer|min:1|max:10',
        ]);

        $userStory = new UserStory($request->all());
        $userStory->project_id = $project->id;
        $userStory->save();

        return redirect()->route('projects.show', $project)
            ->with('success', 'User story created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserStory  $userStory
     * @return \Illuminate\Http\Response
     */
    public function show(UserStory $userStory)
    {
        $project = $userStory->project;

        // Check if the user owns this project
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user-stories.show', compact('userStory', 'project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserStory  $userStory
     * @return \Illuminate\Http\Response
     */
    public function edit(UserStory $userStory)
    {
        $project = $userStory->project;

        // Check if the user owns this project
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('user-stories.edit', compact('userStory', 'project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserStory  $userStory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserStory $userStory)
    {
        $project = $userStory->project;

        // Check if the user owns this project
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:backlog,in-progress,review,completed',
            'priority' => 'required|integer|min:1|max:10',
        ]);

        $userStory->update($request->all());

        return redirect()->route('projects.show', $project)
            ->with('success', 'User story updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserStory  $userStory
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserStory $userStory)
    {
        $project = $userStory->project;

        // Check if the user owns this project
        if ($project->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $userStory->delete();

        return redirect()->route('projects.show', $project)
            ->with('success', 'User story deleted successfully.');
    }
}
