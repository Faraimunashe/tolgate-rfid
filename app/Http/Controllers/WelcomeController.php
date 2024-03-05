<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Type;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function tol(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string']
        ]);

        try{



            $vehicle = Vehicle::where('code', $request->code)->first();
            if(is_null($vehicle)){
                return redirect()->back()->with('error','This license plate is not registered');
            }
            $tolfee = Type::find($vehicle->type_id);
            if(is_null($tolfee)){
                return redirect()->back()->with('error','This vehicle is not associated with a tolfee');
            }

            if($vehicle->balance >= $tolfee->amount){
                $trans = new Transaction();
                $trans->vehicle_id = $vehicle->id;
                $trans->description = time().'TOLFEE';
                $trans->type = "tolfee";
                $trans->method = "tolgate";
                $trans->amount = $tolfee->amount;
                $trans->status = 'successful';
                $trans->save();

                $vehicle->balance = $vehicle->balance - $tolfee->amount;
                $vehicle->save();

                $phone = get_user_phone($vehicle->user_id);
                $message = 'Tolfee of amount $'.$tolfee->amount.' was paid successfully for vehicle '.$vehicle->regnum.'('.$vehicle->make.' '.$vehicle->model.'). Remaining balance: $'.$vehicle->balance;
                send_sms($phone, $message);
                return redirect()->back()->with('success','Tolfee paid successfully');
            }else{
                return redirect()->back()->with('error','You have insufficient balance please topup');
            }
        }catch(\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }
}
