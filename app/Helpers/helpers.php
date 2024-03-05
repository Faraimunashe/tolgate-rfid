<?php

use App\Models\Type;
use App\Models\User;
use App\Models\Vehicle;
use Twilio\Rest\Client;
function get_tolclass($class_id)
{
    $class = Type::find($class_id);
    if(is_null($class)){
        return 'Not Specified';
    }

    return $class->description;
}

function get_vehicle_regnum($vehicle_id)
{
    $vehicle = Vehicle::find($vehicle_id);
    if(is_null($vehicle)){
        return 'Null';
    }

    return $vehicle->regnum;
}

function send_sms($phone, $message)
{
    try{
        $sid = getenv("TWILIO_AUTH_SID");
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);

        $client = new Client($sid, $token);
        $client->messages->create($phone, [
            'from' => getenv("TWILIO_WHATSAPP_FROM"),
            'body' => $message
        ]);

    }catch(\Exception $e){
        return $e->getMessage();
    }
}

function get_user_phone($user_id)
{
    $user = User::find($user_id);
    if(is_null($user)){
        return '+263783540959';
    }

    return $user->phone;
}
