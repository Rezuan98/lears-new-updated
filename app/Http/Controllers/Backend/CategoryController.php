<?php

namespace App\Http\Controllers\Backend;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Str;

use Illuminate\Support\Facades\Storage;



class CategoryController extends Controller
{
    

    public function create(){
        return view('back-end.category.create');
    }

    
    public function store(Request $request) {
        $info = new Category();
        
        if ($request->hasFile('icon')) {
            $icon = $request->file('icon');
            $filename = time() . '.' . $icon->getClientOriginalExtension();
            
          
            $path = $icon->storeAs('category-thumbnail', $filename, 'public');
            
            $info->icon = $path; 
        }
        
        $info->name = $request->name;
        $info->slug = Str::slug($request->name);
        
        $info->save();


        // $info = new Category();

        // if ($request->hasFile('icon')) {
        //     $icon = $request->file('icon');
        //     $filename = time() . '.' . $icon->getClientOriginalExtension();
            
            
        //     $img = Image::make($icon->getRealPath());
            
            
        //     $img->resize(300, 300, function ($constraint) {
        //         $constraint->aspectRatio();
        //         $constraint->upsize();
        //     });
            
           
        //     $path = 'category-thumbnail/' . $filename;
        //     $img->save(storage_path('app/public/' . $path));
            
        //     $info->icon = $path;
        // }
        
        // $info->name = $request->name;
        // $info->slug = Str::slug($request->name);
        
        // $info->save();



        return redirect()->back()->with('success', 'Category created successfully!');
    }
    public function index(){

        $info = Category::all();
       
        return view('back-end.category.index',compact('info'));
    }

    public function edit($id){

        $info = Category::where('id',$id)->first();
        
        return view('back-end.category.edit',compact('info'));
    }
    public function update(Request $request){


        if ($request->hasFile('icon')) {
            $category_image = $request->file('icon');
            $filename = time() . '.' . $category_image->getClientOriginalExtension();
            $path = $category_image->storeAs('category-thumbnail', $filename, 'public');

            $category =  Category::findOrFail($request->id);
        
            $category->name = $request->name;
        
            $category->slug = str::slug($request->name);
            $category->icon = $path;
        
            $category->save();
            return redirect()->route('category.index')->with('info','category updated');
           
        }

        $category =  Category::findOrFail($request->id);
        
        $category->name = $request->name;
    
        $category->slug = str::slug($request->name);
        
    
        $category->save();


        return redirect()->route('category.index')->with('info','category updated');
    }
    public function delete($id){

        $category = Category::find($id);

       
        if($category){
          
            return redirect()->back()->with('error', 'Please delete the child subcategories and try again.');;
        }

        $delete_category = Category::where('id',$id)->delete();
        return redirect()->back()->with('success', 'Category Deleted!');
    } 

    public function updateStatus(Request $request)
{
    try {
        $category = Category::findOrFail($request->category_id);
        $category->status = $request->status;
        $category->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Status updated successfully!'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Failed to update status!'
        ]);
    }
}

}
