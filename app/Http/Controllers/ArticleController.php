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

        $categories = Category::all(); // Fetch all categories from the database
        return view('articles.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $article = new Article();
        $article->title = $request->input('title');
        $article->content = $request->input('content');
        $article->published_by = $request->input('published_by');
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
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
    }
}
