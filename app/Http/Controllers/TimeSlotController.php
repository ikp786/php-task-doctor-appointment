<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimeSlotRequest;
use App\Models\TimeSlot;
use Illuminate\Http\Request;

class TimeSlotController extends Controller
{
    function create(){      
        return view('time_slot_view');
    }

    public function store(StoreTimeSlotRequest $request)
    {        
        $check_same_date = TimeSlot::where(['doctor_id' => $request->doctor_id,'slot_date' => $request->slot_date])->count();
        if($check_same_date > 0)
        return redirect()->back()->with('failed','Sorry! this date already added slot.');   

        $input  = $request->validated();
        $insert = TimeSlot::create($input);
        return redirect()->route('time_slot.create')->with('success','New Slot Created.');   
    }
}
