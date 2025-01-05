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

        if ($queryText) {
            $articles->where(function ($query) use ($queryText) {
                $query->where('title', 'like', '%' . $queryText . '%')
                    ->orWhere('content', 'like', '%' . $queryText . '%');
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
        // Ensure the user is authenticated and is an admin
        if (!auth()->user() || !auth()->user()->is_admin) {
            return redirect()->route('articles.index')->with('error', 'Unauthorized access.');
        }

        // Fetch all articles from the database
        $articles = Article::all(); // This retrieves the latest state of visibility

        return view('articles.admin_index', compact('articles'));
    }




    public function toggleVisibility($id)
    {
        $article = Article::find($id);

        if ($article) {
            $article->visible = !$article->visible;
            $article->save();

            return redirect()->back()->with('success', 'Article visibility updated successfully.');
        }

        return redirect()->back()->with('error', 'Article not found.');
    }




    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Fetch only visible articles, order by created_at in descending order, and load categories with articles
        $articles = Article::with('category')
            ->where('visible', true)
            ->orderBy('created_at', 'desc')  // Order by created_at (latest first)
            ->get();

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
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id', // Ensure a valid category is selected
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate the image if provided
        ]);

        // Handle image upload if an image is provided
        if ($request->hasFile('image')) {
            $filePath = $request->file('image')->store('articles', 'public');
            $validated['image'] = $filePath;
        } else {
            // If no image is uploaded, set the default image
            $validated['image'] = 'articles/default.png'; // Path to default image
        }

        // Add the published_by field (using the logged-in user's name or ID)
        $validated['user_id'] = Auth::id();  // Use the authenticated user's ID
        $validated['published_by'] = Auth::user()->name;  // or use Auth::user()->id if you want the ID

        // Create the article
        Article::create($validated);

        // Redirect back to the articles index with a success message
        return redirect()->route('articles.index')->with('success', 'Article created successfully!');
    }





    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the article along with its comments (with pagination) and category
        $article = Article::with('comments.user', 'category') // Assuming you have user relationship with comments
        ->findOrFail($id);

        // Paginate the comments (10 per page)
        $comments = $article->comments()->paginate(10);

        return view('articles.show', compact('article', 'comments'));
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
    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Find the article by ID
        $article = Article::findOrFail($id);
        $article->title = $request->input('title');
        $article->content = $request->input('content');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            if ($article->image && file_exists(public_path('storage/' . $article->image))) {
                unlink(public_path('storage/' . $article->image));
            }

            // Store the new image with the original filename
            $fileName = $request->file('image')->getClientOriginalName(); // Get the original file name
            $path = $request->file('image')->storeAs('articles', $fileName, 'public');
            $article->image = $path; // Save the path with the original file name
        }

        // Save the updated article
        $article->save();

        // Redirect back to the articles index with a success message
        return redirect()->route('articles.index')->with('success', 'Article updated successfully.');
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
