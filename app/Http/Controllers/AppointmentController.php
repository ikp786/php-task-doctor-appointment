<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\TimeSlot;
use Illuminate\Http\Request;
use Validator;


class AppointmentController extends Controller
{

    function createAppointment(Request $request){
        $doctors  = TimeSlot::GroupBy('doctor_id')->pluck('doctor_id','doctor_id');
        return view('appointment_view',['doctors' => $doctors]);
    }

    function bookAppointment(Request $request){

        if($request->ajax()){
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name'            => 'required',
                    'email'           => 'required',
                    'contact_number'  => 'required',
                    'doctor_id'       => 'required',
                    'start_time'      => 'required',
                    'slot_date'      => 'required',
                ]
            );


                 if ($validator->passes()) {


            $timeslot_data = TimeSlot::
            where("doctor_id",request()->doctor_id)
            ->whereDate('slot_date', date('Y-m-d',strtotime(request()->slot_date)))
            ->first();
//dd($timeslot_data);
                $checkIn1 = strtotime($timeslot_data->start_time);
                 $checkOut = strtotime($timeslot_data->end_time);

                if($checkOut < $checkIn1){
                    $checkOut = strtotime('+1 day', $checkOut);
                }

            $difference = round(abs($checkOut - $checkIn1) / 3600, 2);
            $difference = ($difference * 60) / $timeslot_data->slot;

            $appointment = new Appointment();
            $appointment->fill($request->all());
            //$appointment->start_ime = $request->start_ime.":00";

            $appointment->time_slot = $difference;
            $appointment->slot_date = date('Y-m-d',strtotime(request()->slot_date));
            $appointment->user_id = 1;
            $appointment->save();

                return response()->json(['status' => true, 'data' => []]);
            }
                return response()->json(['error' => $validator->errors()->all()]);
            } catch (\Throwable $e) {
                return response()->json(['error' => [$e->getMessage().' On line '.$e->getLine()]]);
            }
        }
    }

    function getSlot(Request $request){
        if($request->ajax()){
            $timeslot_data = TimeSlot::where("doctor_id",request()->doctor_id)
                ->whereDate('slot_date', date('Y-m-d',strtotime(request()->date)))
                ->first();
            if(empty($timeslot_data)){
                return response()->json(['status' => false, 'data' => '']);
            }

        $checkIn1 = strtotime($timeslot_data->start_time);
        $checkOut = strtotime($timeslot_data->end_time);

        if($checkOut < $checkIn1){
            $checkOut = strtotime('+1 day', $checkOut);
            }

        $start_time = [];
        $checkOutTime = [];
        $difference = round(abs($checkOut - $checkIn1) / 3600, 2);
        $difference = ($difference * 60) / $timeslot_data->slot;
        // AVAILBLE CHECKIN TIME
        $new_time = 0;
        $j = 1;
        for ($i = 0; $i <  $difference; $i++) {
            if($i != 0){
            $checkInT2 = date('H:i', strtotime($timeslot_data->start_time . '+' . $timeslot_data->slot * $j . ' minute'));
            }else{
            $checkInT2 = date('H:i', strtotime($timeslot_data->start_time));
            }
            $start_time[] = ($checkInT2);
            $j++;
        }
        $html_content = '';
        foreach($start_time as $key => $val){

            $check_appointment = Appointment::where('doctor_id',$request->doctor_id)
            ->whereDate('slot_date', date('Y-m-d',strtotime(request()->date)))
            ->whereTime('start_time',$val)
            ->count();
            if($check_appointment == 0){
        $html_content .= '
            <button type="button" class="border-0 mb-1 btn btn-sm bg-success">'.$val.'</button>';
            }else{
            $html_content .= '
          <button type="button" class="border-0 mb-1 btn btn-sm bg-danger">'.$val.'</button>';
            }
        }
        return response()->json(['status' => true, 'data' => $html_content]);

        }
    }
}
