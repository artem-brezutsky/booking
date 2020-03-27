<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Studio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\Factory;
use Illuminate\View\View;
use Illuminate\Support\Str;
use App\Http\Requests\StoreStudioRequest;


class StudioController extends Controller
{
    /**
     * Display a listing of the resource.
     * Отображение всего нужного содержимого
     *
     * @return View|Factory
     */
    public function index()
    {
        $studios = Studio::all();

        return view('admin.pages.studios.index', compact('studios'));
    }

    /**
     * Show the form for creating a new resource.
     * Отображение формы для отправки данных в БД
     *
     * @return View|Factory
     */
    public function create()
    {
        return view('admin.pages.studios.create');
    }

    /**
     * Store a newly created resource in storage.
     * Хранилище для подготовки запроса
     *
     * @param StoreStudioRequest $request
     * @return View|Factory
     */
    public function store(StoreStudioRequest $request)
    {
        $studio = new Studio([
            'name'        => $request->get('studio-name'),
            'description' => $request->get('description'),
            'slug'        => Str::slug($request->get('slug')),
        ]);

        $studio->save();
        return redirect('/admin/studios')->with('success', 'Комната добавлена!');
    }

    /**
     * Display the specified resource.
     * Отображенеи специфического ресурса
     *
     * @param Studio $studio
     * @return void
     */
    public function show(Studio $studio): void
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * Отображение формы для обновления специфического ресурса
     *
     * @param int $id
     * @return View|Factory
     */
    public function edit(int $id)
    {
        $studio = Studio::find($id);

        return view('admin.pages.studios.edit', compact('studio'));
    }

    /**
     * Update the specified resource in storage.
     * Обновление специфического ресурса из хранилищя
     *
     * @param StoreStudioRequest $request
     * @param int $studio_id
     * @return RedirectResponse
     */
    public function update(StoreStudioRequest $request, int $studio_id): RedirectResponse
    {
        $studio = Studio::find($studio_id);
        $studio->name = $request->get('studio-name');
        $studio->description = $request->get('description');
        $studio->slug = Str::slug($request->get('slug'));
        $studio->save();

        return redirect('/admin/studios')->with('success', 'Комната обновлена!');
    }

    /**
     * Remove the specified resource from storage.
     * Удаление специфического ресурса из хранилищя
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $studioModel = new Studio;
        $studioModel->deleteStudioEvents($id);
        Studio::destroy($id);

        return response()->json([
            'success' => 'Комната удалена!',
        ]);
    }
}
