<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class UpdateController extends Controller
{
    public function showUpdateForm($id)
    {
        $category = Category::find($id);

        return view('admin.category.update', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::find($id);

        $request->validate([
            'category_name' => 'required|string|max:255',
            'image' => 'image|mimes:jpeg,png,jpg,gif|max:6114', 
        ]);

        // Update the category details based on the form data
        $category->update([
            'category_name' => $request->input('category_name'),
        ]);

        // Handle image update
        if ($request->hasFile('image')) {
            // Store the image in the public/image directory
            $imagePath = $request->file('image')->storeAs('public/image', $category->id . '.' . $request->file('image')->extension());
            
            // Update the category's image field with the filename
            $category->image = basename($imagePath);
        }
    
        $category->save();
    
        return redirect()->route('AllCat');
    }
}