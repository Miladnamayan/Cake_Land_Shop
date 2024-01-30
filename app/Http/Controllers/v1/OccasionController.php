<?php

namespace App\Http\Controllers\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\OccasionsRequest;
use App\Http\Resources\v1\OccasionResource;
use App\Models\Occasion;
use Illuminate\Http\Request;

class OccasionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $pageCount = request()->get('page_count') ?? 4;
        // $query = Occasion::query();
        // if(request()->has('search')){
        //     $search = request()->get('search');
        //     $query->where('title', 'like', "%$search%");
        // }
        // $orderBy = request()->get('order_by') ?? 'created_at';
        // $orderDir = request()->get('order_dir') ?? 'desc';
        // $query->orderBy($orderBy, $orderDir);

        $occasion=Occasion::paginate($pageCount);
        return  OccasionResource::collection($occasion);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(OccasionsRequest $request){
        $occasion=Occasion::create([
            'name' => $request['name'],
            'display_name' => $request['display_name'],
        ]);
        return new OccasionResource($occasion);
    }


    /**
     * Display the specified resource.
     */
    public function show(Occasion $occasion)
    {
        return new OccasionResource($occasion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Occasion $occasion)
    {
        $occasion->update([
            'name' => $request['name'],
            'display_name' => $request['display_name'],
        ]);
        return new OccasionResource($occasion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Occasion $occasion)
    {
        $occasion->delete();
        return new OccasionResource($occasion);
    }


    public function Products(Occasion $occasion)
    {
        return new OccasionResource($occasion->load('products'));
    }

}
