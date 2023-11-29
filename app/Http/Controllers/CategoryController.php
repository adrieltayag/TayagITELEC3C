<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withTrashed()->latest()->paginate(10);
        return view('admin.category.category', compact('categories'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:6114', 
        ]);
        $category = new Category();
        $category->category_name = $request->input('category_name');
        $category->user_id = Auth::id();
    
        // Handle image upload
        if ($request->hasFile('image')) {
            // Store the image in the public/image directory
            $imagePath = $request->file('image')->storeAs('public/image', $category->id . '.' . $request->file('image')->extension());
            
            // Update the category's image field with the filename
            $category->image = basename($imagePath);
        }
    
        $category->save();
    
        return redirect()->route('AllCat');
    
    }

    public function UpdateCat($id)
    {
        $category = Category::find($id);
        return view('admin.category.update', compact('category'));
    }

    public function softDelete($id)
    {
        $category = Category::find($id);
    
        if ($category) {
            $category->delete(); // Soft delete
            return redirect()->route('AllCat')->with('status', 'Category moved to soft-deleted list.');
        } else {
            return redirect()->route('AllCat')->with('status', 'Category not found.');
        }
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->find($id);
    
        if ($category) {
            $category->restore();
            return redirect()->route('AllCat')->with('status', 'Category restored successfully.');
        } else {
            return redirect()->route('AllCat')->with('status', 'Category not found.');
        }
    }
    
    public function forceDelete($id)
    {
        $category = Category::withTrashed()->find($id);
    
        if ($category) {
            $category->forceDelete();
            return redirect()->route('AllCat')->with('status', 'Category permanently deleted.');
        } else {
            return redirect()->route('AllCat')->with('status', 'Category not found.');
        }
    }
}
