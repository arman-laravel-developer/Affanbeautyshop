<?php

namespace App\Http\Controllers;

use App\Models\ContactForm;
use Illuminate\Http\Request;

class ContactFormController extends Controller
{
    public function submit(Request $request)
    {
        $contactForm = new ContactForm();
        $contactForm->name = $request->name;
        $contactForm->email = $request->email;
        $contactForm->subject = $request->subject;
        $contactForm->message = $request->message;
        $contactForm->phone = $request->phone;
        $contactForm->save();

        return redirect()->back()->with('success', 'Your query has been submitted successfully');
    }

}
