<?php

namespace App\Http\Controllers;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
{
    
    
    $loggedInUsername = auth()->user()->username;

    
    $restaurantId = \App\Models\Restaurant::where('username', $loggedInUsername)->value('id');

    
    $menus = \App\Models\Menu::where('restaurant_id', $restaurantId)
        ->with('category')
        ->latest()
        ->paginate(15);

    $categories = Category::withCount('menus')->get();
    return view('rest_editM', compact('categories', 'menus'));
   
}

    public function show(Category $category)
    {
        $menus = $category->menus()
            ->with('restaurant')
            ->where('is_avail', true)
            ->paginate(12);

        return view('categories.show', compact('category', 'menus'));
    }
    public function makeCat(Request $request)
{ 
    $validatedData = $request->validate([ 
        'name' => 'required', 
        'img' => 'required|image|mimes:jpg,jpeg,png|max:15000', 
    ]);

    if ($request->hasFile('img')) {
        // 1. Name the photo
        $filename = time() . "." . $request->img->extension(); 
        
        // 2. Save it to the target folder (added missing semicolon)
        $request->img->move(public_path('category_photos'), $filename);

        // 3. Update the validated dataset with the generated filename string
        $validatedData['img'] = $filename;
    }

    // 4. Create the category using the corrected payload
    Category::create([ 
        'name' => $validatedData['name'], 
        'img' => $validatedData['img'], // Now holds the string filename
    ]);
    // Add this at the end of your makeCat function
    return redirect()->back()->with('success', 'Category added!');

}


}
