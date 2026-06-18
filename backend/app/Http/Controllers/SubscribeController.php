<?php

namespace App\Http\Controllers;

use App\Models\Contect;
use App\Models\Project;
use App\Models\Subscribe;
use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function subscribe(Request $request)
    {
        $email = $request->input('email');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['message' => 'Invalid email address'], 400);
        }

        $emailExists = Subscribe::where('email', $email)->exists();

        if ($emailExists) {
            return response()->json(['message' => 'Email already subscribed'], 400);
        }

        Subscribe::create(['email' => $email]);

        return response()->json(['message' => 'Subscription successful'], 200);
    }
    public function getSubscribers()
    {
        $subscribers = Subscribe::all();
        return response()->json(['subscribers' => $subscribers]);
    }
     public function getcontacts()
    {
        $contact =  Contect::all();
        $Subscriber = Subscribe::all();
        $project = Project::all();
        return response()->json(['contacts' => $contact, 'subscribers' => $Subscriber, 'project' => $project]);
    }
    public function deleteSubscriber( $id)
    {
        $subscriber = Subscribe::findOrFail($id);

        if (!$subscriber) {
            return response()->json(['message' => 'Subscriber not found'], 404);
        }

        $subscriber->delete();

        return response()->json(['message' => 'Subscriber deleted successfully'], 200);
    }
public function deletecontact( $id)
    {
        $contact = Contect::findOrFail($id);

        if (!$contact) {
            return response()->json(['message' => 'Contact not found'], 404);
        }

        $contact->delete();

        return response()->json(['message' => 'Contact deleted successfully'], 200);
    }

}
