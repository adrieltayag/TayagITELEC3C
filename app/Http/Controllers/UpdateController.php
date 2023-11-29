<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
    

        $category->update([
            'category_name' => $request->input('category_name'),
        ]);
    

        if ($request->hasFile('image')) {
            $imageName = Str::random(10) . '.' . $request->file('image')->extension();
            $imagePath = $request->file('image')->storeAs('public/image', $imageName);
            $category->image = basename($imagePath);
        }
    
        $category->save();
    
        return redirect()->route('AllCat');
    }
}