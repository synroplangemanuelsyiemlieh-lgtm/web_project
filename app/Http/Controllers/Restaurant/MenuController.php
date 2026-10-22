<?php

namespace App\Http\Controllers\Restaurant;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Menu;
use App\Models\Restaurant;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    private function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'price'       => ['required', 'numeric', 'min:0', 'max:99999.99'],
            'img'         => ['nullable', 'image', 'max:2048'],
        ];
    }

    private function ownMenu(Menu $menu): Menu
    {
        abort_unless($menu->restaurant_id === auth('restaurant')->id(), 403);

        return $menu;
    }

    public function index()
    {
        $menus = auth('restaurant')->user()
            ->menus()
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('restaurant.menus.index', compact('menus'));
    }

    public function create()
    {
        return view('restaurant.menus.create', ['categories' => Category::all()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());
        $data['is_veg']   = $request->boolean('is_veg');
        $data['is_avail'] = $request->boolean('is_avail');

       

        if ($request->hasFile('img')) {
            $filename = time() . "." . $request->img->extension(); 
            $request->img->move(public_path('Menu_photos'), $filename);
            $data['img'] = $filename;
        }
        $loggedusername=auth()->user()->username;
        $rest_id=Restaurant::where('username',$loggedusername)->value('id');
        $data['restaurant_id']=$rest_id;
        Menu::create($data);
        //auth('restaurant')->user()->menus()->create($data);

        return redirect()->back()->with('success', 'Menu item added.');
    }

    public function edit(Menu $menu)
    {
        return view('restaurant.menus.edit', [
            'menu'       => $this->ownMenu($menu),
            'categories' => Category::all(),
        ]);
    }

    public function update(Request $request, Menu $menu): RedirectResponse
    {
        $this->ownMenu($menu);

        $data = $request->validate($this->rules());
        $data['is_veg']   = $request->boolean('is_veg');
        $data['is_avail'] = $request->boolean('is_avail');

        if ($request->hasFile('img')) {
            if ($menu->img) {
                Storage::disk('public')->delete($menu->img);
            }
            $data['img'] = $request->file('img')->store('img/menus', 'public');
        }

        $menu->update($data);

        return redirect()->route('restaurant.menus.index')->with('success', 'Menu item updated.');
    }

    public function destroy(Menu $menu): RedirectResponse
    {
        $this->ownMenu($menu);

        if ($menu->img) {
            Storage::disk('public')->delete($menu->img);
        }

        $menu->delete();

        return back()->with('success', 'Menu item deleted.');
    }
}
