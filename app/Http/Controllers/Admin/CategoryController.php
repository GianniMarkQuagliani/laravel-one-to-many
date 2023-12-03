<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Functions\Helper;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
       return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $exists = Category::where('name', $request->name)->first();
        if ($exists) {
            return redirect()->route('admin.categories.index')->with('error', 'Categoria già presente');
       }else {
            $new_category = new Category();
            $new_category->name = $request->name;
            $new_category->slug = Helper::generateSlug($request->name, Category::class);
            $new_category->save();
            return redirect()->route('admin.categories.index')->with('success', 'Categoria creata con successo');

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {

        $val_data = $request->validate([
            'name' => 'required|min:2|max:20',
        ],[
            'name.required' => 'Devi inserire il nome della categoria',
            'name.min' => 'Il nome della categoria deve essere minimo 2 caratteri',
            'name.max' => 'Il nome della categoria deve essere massimo 20 caratteri'
        ]);

        $exixts = Category::where('name', $request->name)->first();
        if($exixts){
            return redirect()->route('admin.categories.index')->with('error', 'Categoria già presente');
        }

        $val_data['slug'] = Helper::generateSlug($request->name, Category::class);

        $category->update($val_data);

        return redirect()->route('admin.categories.index')->with('success', 'Categoria aggiornata con successo');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Categoria eliminata con successo');
    }
}
