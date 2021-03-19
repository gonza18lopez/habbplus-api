<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Resources\AllArticlesResource;
use App\Http\Resources\AllCategoriesResource;
use App\Http\Resources\CategoryResource;
use App\Http\Requests\Category\CreateRequest;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
	/**
	 * Create the controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth:sanctum')->except([ 'index', 'show' ]);
		
		$this->authorizeResource(Category::class, 'category');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return response()->json(
			AllCategoriesResource::collection(
				Category::all()
			)
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Category\CreateRequest  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateRequest $request)
	{
		$category = Category::create($request->validated());

		return response()->json(
			new CategoryResource($category), 201
		);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function show(Category $category)
	{
		return AllArticlesResource::collection(
			$category->articles()->with('user')->with('category')->with('comments')->orderBy('id', 'desc')->paginate(10)
		);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Category $category)
	{
		$request->validate([
			'name' => 'sometimes|required|min:4',
			'prefix' => 'sometimes|required|min:2',
			'color' => 'sometimes|required'
		]);

		$category->fill($request->all());
		$category->save();

		return response()->json(
			new CategoryResource($category)
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Category  $category
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Category $category)
	{
		$category->delete();

		return response()->noContent();
	}
}
