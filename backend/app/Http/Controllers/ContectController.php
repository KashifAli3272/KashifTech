<?php

namespace App\Http\Controllers;

use App\Mail\ContactReplyMail;
use App\Mail\NewContactNotification;
use Illuminate\Support\Facades\Mail;
use App\Models\Contect;
use Illuminate\Http\Request;

class ContectController extends Controller
{
    public function contect(Request $request)
    {
        $name = $request->input('name');
        $email = $request->input('email');
        $message = $request->input('message');
        $phone = $request->input('phone');
        $company = $request->input('company');
        $service = $request->input('service');
        $budget = $request->input('budget');

        if (
            empty($name) ||
            empty($email) ||
            empty($message) ||
            empty($phone) ||
            empty($company) ||
            empty($service) ||
            empty($budget)
        ) {
            return response()->json([
                'message' => 'All fields are required'
            ], 400);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'message' => 'Invalid email address'
            ], 400);
        }

        // Save to database
        Contect::create([
            'name' => $name,
            'email' => $email,
            'message' => $message,
            'phone' => $phone,
            'company' => $company,
            'service' => $service,
            'budget' => $budget
        ]);


       Mail::to($email)
    ->queue(new ContactReplyMail($name));

Mail::to('kashifali1512003@gmail.com')
    ->queue(
        new NewContactNotification([
            'name' => $name,
            'email' => $email,
            'phone' => $phone,
            'company' => $company,
            'service' => $service,
            'budget' => $budget,
            'message' => $message,
        ])
    );

        return response()->json([
            'message' => 'Contact form submitted successfully'
        ], 200);
    }
}
