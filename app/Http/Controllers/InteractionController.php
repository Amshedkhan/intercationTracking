<?php

namespace App\Http\Controllers;

use App\Models\Interaction;
use Illuminate\Http\Request;

class InteractionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $interaction = auth()->user()->interactions;
       return response()->json([
        'status' => 200,
        'data' => $interaction,
    ]);
    }
    public function getInteractionStatistics()
    {
        $statistics = Interaction::where('user_id',auth()->user()->id)->groupBy('label')->select('label', \DB::raw('count(*) as count'))->get();
        return response()->json(['statistics' => $statistics]);
    }


    public function searchInteractionStatistics($start_date, $end_date){
        

        $statistics = Interaction::whereBetween('created_at', [$start_date, $end_date])
        ->groupBy('label')
        ->select('label', \DB::raw('count(*) as count'))
        ->get();

       return response()->json(['statistics' => $statistics]);
   }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'label' => 'required',
            'type' => 'required',
        ]);
        $obj = $request->all();
        $obj['user_id'] = auth()->user()->id;
        Interaction::updateOrCreate(
            ['id' => $request->interaction_id],
            $obj
        );
        return response()->json([
            'status' => 200,
            'message' => 'Record added or Updated successfully!',
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Interaction $interaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Interaction $interaction)
    {
       return response()->json([
        'status' => 200,
        'data' => $interaction,
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Interaction $interaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Interaction $interaction)
    {
        //
    }
}
