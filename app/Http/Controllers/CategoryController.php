<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Notifications\AddNotification;
use App\Notifications\DeleteNotification;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function createIndex(Request $request)
    {
        return view('create');
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'is_publish' => 'required'
        ]);
        $category = new Category();
        $category->name = $request->name;
        $category->is_publish = $request->is_publish == 'true' ? 1 : 0;
        $category->save();

        $users = User::all();
        foreach ($users as $user) {
            $user->notify(new AddNotification());
        }

        return redirect()->back()->with('success', 'Sukses membuat kategori baru:' . $request->name);
    }

    public function editIndex(Request $request)
    {
        $category = Category::find($request->id);
        return view('edit')->with('category', $category);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'is_publish' => 'required'
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->is_publish = $request->is_publish == 'true' ? 1 : 0;
        $category->save();

        return redirect()->back()->with('success', 'Sukses mengedit kategori');
    }

    public function index(Request $request)
    {
        // dd($request);
        if ($request->has('searchByName')) {
            $categories = Category::where('name', 'like', '%' . $request->searchByName . '%')->paginate(15);
        } else {
            $categories = Category::paginate(15);
        }
        // dd($categories->onEachSide(15)->links());
        return view('index')->with('categories', $categories);
    }

    public function delete(Request $request)
    {
        try {
            Category::find($request->id)->delete();
            $users = User::all();
            foreach ($users as $user) {
                $user->notify(new DeleteNotification());
            }
            return redirect()->back();
        } catch (\Throwable $th) {
            abort(400);
        }
    }
}
