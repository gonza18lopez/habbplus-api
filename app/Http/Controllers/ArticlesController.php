<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Http\Resources\AllArticlesResource;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ArticlesController extends Controller
{
	/**
	 * Create the controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('auth:sanctum')->except([ 'index', 'show' ]);
		
		$this->authorizeResource(Article::class, 'article');
	}
	
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return AllArticlesResource::collection(
			Article::with('user')->with('category')->with('comments')->orderBy('id', 'desc')->paginate(10)
		);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		$request->validate([
			'title' => 'required|min:4',
			'description' => 'required|min:50',
			'body' => 'required',
			'image' => 'required|image',
			'category' => 'required|exists:categories,id'
		]);

		$path = $request->file('image')->store('thumbnails', 'public');

		$article = $request->user()->articles()->create([
			'title' => $request->title,
			'description' => $request->description,
			'body' => $request->body,
			'image' => "storage/$path",
			'category_id' => $request->category
		]);

		if ($request->user()->can('moderate articles'))
			$article->markApproved();
		else
			$article->markPending();

		return response()->json(new AllArticlesResource($article), 201);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Article  $article
	 * @return \Illuminate\Http\Response
	 */
	public function show(Article $article)
	{
		return response()->json(
			new ArticleResource(
				$article
			)
		);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Article  $article
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Article $article)
	{
		$request->validate([
			'title' => 'sometimes|required|min:4',
			'description' => 'sometimes|required|min:50',
			'body' => 'sometimes|required|min:50',
			'image' => 'sometimes|required|image',
			'category' => 'sometimes|required|exists:categories,id'
		]);

		$article->fill($request->all());
		$article->save();

		return response()->json(
			new AllArticlesResource(
				$article
			)
		);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Article  $article
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Article $article)
	{
		$article->delete();

		return response()->json([
			'deleted' => true
		]);
	}
}
