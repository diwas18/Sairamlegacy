<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $categories= Category::orderBy('priority')->get();
        return view('category.index',compact('categories'));
    }
    public function create()
    {
        return view('category.create');
    }
    public function store( Request $request)
    {
    $data = $request->validate([
        'priority' => ['required', 'integer', 'min:1', 'unique:categories,priority,' . $request->id],
        'name' => [
            'required',
            'string',
            'regex:/^[a-zA-Z\-]+$/',
            'unique:categories,name',
        ],
    ]);


     Category::create($data);
    //return redirect(route('category.index));
    return redirect()->route('category.index')->with('success','Category Created Succesfully');
    }

    public function edit($id)
    {
        $category=Category::find($id);
        return view('category.edit',compact('category'));

    }
    public function update(Request $request,$id)
    {
$data = $request->validate([
        'priority' => ['required', 'integer', 'min:1', 'unique:categories,priority,' . $id],
    'name' => [
        'required',
        'string',
        'regex:/^[a-zA-Z\-]+$/',
        'unique:categories,name,' . $id,
    ],
]);
$category = Category::find($id);
$category->update($data);
return redirect()->route('category.index')->with('success','Category Updated Succesfully');
    }
    public function destroy(Request $request)
{
    $category = Category::find($request->dataid);
    $products= Product::Where('category_id',$request->dataid)->count();
    if($products>0){
        return redirect()->route('category.index')->with('success','Category cannot be Deleted,It has products');
        }

    $category->delete();
    return redirect()->route('category.index')->with('success','Category deleted Succesfully');
}

}
