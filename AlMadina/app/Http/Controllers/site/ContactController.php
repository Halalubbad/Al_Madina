<?php

namespace App\Http\Controllers\site;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Setting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller
{
    //
    public function contact()
    {
        // $contact = contact
        $settings = Setting::all();
        return view('al_madina.contactUs.contact_us', compact('settings'));
    }

    public function sendMessage(Request $request)
    {
        $validator = validator($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'comment' => 'required',
            'type' => 'required||in:complaint,enquiry',
        ]);
        if (!$validator->fails()) {
            $contact = new Contact();
            $contact->name = $request->input('name');
            $contact->email = $request->input('email');
            $contact->phone = $request->input('phone');
            $contact->comment = $request->input('comment');
            $contact->type = $request->input('type');

            $isSaved = $contact->save();
            return response()->json([
                'message' => $isSaved ? 'Message Sent Successfully' : 'Message Sent Failed!'
            ], $isSaved ? Response::HTTP_CREATED : Response::HTTP_BAD_REQUEST);
        } else {
            return response()->json(
                ['message' => $validator->getMessageBag()->first()],
                Response::HTTP_BAD_REQUEST,
            );
        }
    }
}
