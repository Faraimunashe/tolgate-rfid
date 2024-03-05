<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Paynowlog;
use App\Models\Transaction;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::orderBy("created_at","desc")->paginate(10);

        return view('user.transactions', [
            'transactions'=> $transactions
        ]);
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
        $request->validate([
            'amount' => ['required', 'numeric', 'min:5'],
            'phone' => ['required', 'digits:10', 'starts_with:07'],
            'vehicle_id' => ['required', 'integer']
        ]);

        $wallet = "ecocash";

        //get all data ready
        $email = "jimmymotofire@gmail.com";
        $phone = $request->phone;
        $amount = $request->amount;

        $vehicle = Vehicle::find($request->vehicle_id);
        if(is_null($vehicle))
        {
            return redirect()->back()->with("error","Vehicle not found!");
        }

        /*determine type of wallet*/
        if (strpos($phone, '071') === 0) {
            $wallet = "onemoney";
        }

        $paynow = new \Paynow\Payments\Paynow(
            "11336",
            "1f4b3900-70ee-4e4c-9df9-4a44490833b6",
            route('transactions.store'),
            route('transactions.store'),
        );

        // Create Payments
        $invoice_name = "ZinaraTolgate" . time();
        $payment = $paynow->createPayment($invoice_name, $email);

        $payment->add("Zinara Tolgate", $amount);

        $response = $paynow->sendMobile($payment, $phone, $wallet);
        //dd($response);
        // Check transaction success
        if ($response->success()) {

            $timeout = 9;
            $count = 0;

            while (true) {
                sleep(3);
                // Get the status of the transaction
                // Get transaction poll URL
                $pollUrl = $response->pollUrl();
                $status = $paynow->pollTransaction($pollUrl);


                //Check if paid
                if ($status->paid()) {
                    // Yay! Transaction was paid for
                    // You can update transaction status here
                    // Then route to a payment successful
                    $info = $status->data();

                    $paynowdb = new Paynowlog();
                    $paynowdb->reference = $info['reference'];
                    $paynowdb->paynow_reference = $info['paynowreference'];
                    $paynowdb->amount = $info['amount'];
                    $paynowdb->status = $info['status'];
                    $paynowdb->poll_url = $info['pollurl'];
                    $paynowdb->hash = $info['hash'];
                    $paynowdb->save();

                    //transaction update
                    $trans = new Transaction();
                    $trans->vehicle_id = $request->vehicle_id;
                    $trans->description = time().'DEPOSIT';
                    $trans->type = "deposit";
                    $trans->method = "paynow";
                    $trans->amount = $info['amount'];
                    $trans->status = 'successful';
                    $trans->save();

                    $vehicle->balance = $vehicle->balance + $info['amount'];
                    $vehicle->save();

                    return redirect()->back()->with('success', 'Succesfully paid license fee');
                }


                $count++;
                if ($count > $timeout) {
                    $info = $status->data();

                    $paynowdb = new Paynowlog();
                    $paynowdb->reference = $info['reference'];
                    $paynowdb->paynow_reference = $info['paynowreference'];
                    $paynowdb->amount = $info['amount'];
                    $paynowdb->status = $info['status'];
                    $paynowdb->poll_url = $info['pollurl'];
                    $paynowdb->hash = $info['hash'];
                    $paynowdb->save();

                    $trans_status = 2;
                    if($info['status'] != 'sent')
                    {
                        $trans_status = 0;
                    }
                    //transaction update
                    $trans = new Transaction();
                    $trans->vehicle_id = $request->vehicle_id;
                    $trans->description = time().'DEPOSIT';
                    $trans->type = "deposit";
                    $trans->method = "paynow";
                    $trans->amount = $info['amount'];
                    $trans->status = 'failed';
                    $trans->save();

                    return redirect()->back()->with('error', 'Taking too long wait a moment and refresh');
                } //endif
            } //endwhile
        } //endif

        //total fail
        return redirect()->back()->with('error', 'Cannot perform transaction at the moment');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
