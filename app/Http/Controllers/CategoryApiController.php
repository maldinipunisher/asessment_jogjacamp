<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use App\Notifications\AddNotification;
use App\Notifications\DeleteNotification;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{
    public function get_all(Request $request)
    {
        if ($request->has('searchByName')) {
            $categories = Category::where('name', 'like', '%' . $request->searchByName . '%')->paginate(15);
        } else {
            $categories = Category::paginate(15);
        }
        return response()->json($categories, 200);
    }

    public function get(Request $request)
    {
        $categories = Category::find($request->id);
        return response()->json($categories, 200);
    }

    public function add(Request $request)
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

        return response()->json($category, 201);
    }


    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'is_publish' => 'required'
        ]);

        $category = Category::find($request->id);
        $category->name = $request->name;
        $category->is_publish = $request->is_publish == 'true' ? 1 : 0;
        $category->save();

        return response()->json(['message' => 'success mengedit'], 200);
    }

    public function delete(Request $request)
    {
        try {
            Category::find($request->id)->delete();
            $users = User::all();
            foreach ($users as $user) {
                $user->notify(new DeleteNotification());
            }

            return response()->json(['message' => 'success menghapus'], 200);
        } catch (\Throwable $th) {
            return response()->json(['message' => 'error saat menghapus file'], 400);
        }
    }
}
