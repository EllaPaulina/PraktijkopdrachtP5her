<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;

class ArticleController extends Controller
{

    public function search(Request $request)
    {
        //Input halen van form
        $queryText = $request->input('query');
        $categoryId = $request->input('category_id');

        //query voor model
        $articles = Article::query();

        //mogelijkheid search op title en inhoud
        if ($queryText) {
            $articles->where(function ($query) use ($queryText) {
                $query->where('name', 'like', '%' . $queryText . '%');

            });
        }

        //category filter toevoegen
        if ($categoryId) {
            $articles->where('category_id', $categoryId);
        }
        //fetch gefilterde articles
        $articles = $articles->get();

        //categoeries voor dropdownfilter
        $categories = Category::all();

        return view('articles.index', compact('articles', 'categories'));
    }

    public function adminIndex()
    {
        // Check if the user is authenticated
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect()->route('articles.index')->with('error', 'Unauthorized access.');
        }

        // Fetch articles for the admin view
        $articles = Article::all(); // Adjust this query as needed

        // Return the admin index view with articles
        return view('articles.admin_index', compact('articles'));
    }




    public function toggleVisibility($id)
    {
        // Find the article by ID
        $article = Article::find($id);

        if ($article) {
            // Toggle the visibility value
            $newVisibility = !$article->visible; // This will be true if it was false, and vice versa

            // Update the visibility in the database
            $article->update(['visible' => $newVisibility]);

            // Determine the status message
            $status = $newVisibility ? 'visible' : 'hidden';

            // Redirect with success message
            return redirect()->back()->with('success', "Article visibility updated successfully! The article is now {$status}.");
        }

        // Redirect with error if the article wasn't found
        return redirect()->back()->with('error', 'Article not found.');
    }







    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        // Fetch only visible articles and make sure to load categories with articles
        $articles = Article::with('category')->where('visible', true)->get();

        // Fetch all categories to pass to the view for filter options
        $categories = Category::all();

        return view('articles.index', compact('articles', 'categories'));
    }




    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect()->route('articles.index')->with('error', 'Unauthorized access.');
        }
        $categories = Category::all(); // Fetch all categories from the database
        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect()->route('articles.index')->with('error', 'Unauthorized access.');
        }
        $article = new Article();
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->published_by =auth()->user()->name;
        $article->user_id = Auth::id();
        $article->save();
        return redirect()->route('articles.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect()->route('articles.index')->with('error', 'Unauthorized access.');
        }
        $article = Article::findOrFail($id); // Find the article by ID
        return view('articles.edit', compact('article')); // Pass the article to the edit view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect()->route('articles.index')->with('error', 'Unauthorized access.');
        }
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string', // Assuming you have a content field
            'visible' => 'boolean', // Assuming you have a visible field
        ]);

        $article = Article::findOrFail($id); // Find the article by ID
        $article->update($request->only(['title', 'content', 'visible'])); // Update the article

        return redirect()->route('articles.index')->with('success', 'Article updated successfully!'); // Redirect with success message
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (!auth()->check() || !auth()->user()->is_admin) {
            return redirect()->route('articles.index')->with('error', 'Unauthorized access.');
        }
        $article = Article::findOrFail($id); // Find the article by ID
        $article->delete(); // Delete the article

        return redirect()->route('articles.admin_index')->with('success', 'Article deleted successfully!'); // Redirect with success message
    }
}
