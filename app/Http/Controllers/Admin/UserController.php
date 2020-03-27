<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Studio;
use App\User;
use Gate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $users = User::all(['id', 'name', 'email', 'created_at', 'updated_at', 'permissions']);

        return view('admin.pages.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.pages.users.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return View
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $studios = Studio::all();

        return view('admin.pages.users.edit', compact('user', 'studios'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     *
     * @return RedirectResponse
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $user = User::find($id);

        $permissions = $request->get('studioID');
        $mailings = $request->get('mailingStudioID');
        if ($request->get('role')) {
            $permissions[] = $request->get('role');
        }

        $user->name = $request->get('name');
        $user->permissions = $permissions;
        $user->mailings = $mailings;
        $user->save();

        return redirect('/admin/users')->with('success', 'Пользователь обновлен!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        if (Gate::allows('deletingCurrentUser', $id)) {
            User::destroy($id);
            return response()->json([
                'success' => 'Пользователь удален!',
            ]);
        }

        return response()->json([
            'error' => 'Нельзя удалить текущего пользователя!',
        ]);
    }
}