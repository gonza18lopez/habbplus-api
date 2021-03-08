<?php

namespace App\Http\Controllers;

use App\Models\Animation;
use App\Http\Resources\AllAnimationsResource;
use Illuminate\Http\Request;

class AnimationsController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return response()->json(
			AllAnimationsResource::collection(
				Animation::byDate()
			)
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
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Models\Animation  $animation
	 * @return \Illuminate\Http\Response
	 */
	public function show(Animation $animation)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Models\Animation  $animation
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, Animation $animation)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Models\Animation  $animation
	 * @return \Illuminate\Http\Response
	 */
	public function destroy(Animation $animation)
	{
		//
	}
}
