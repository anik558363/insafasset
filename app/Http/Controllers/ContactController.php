<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Http\Requests\ContactRequest;

class ContactController extends Controller
{
    public function index()
    {
        return view('contact');
    }

    public function store(ContactRequest $request)
    {
        ContactMessage::create($request->validated());

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => __('messages.contact.success_ajax')]);
        }

        return back()->with('success', __('messages.contact.success'));
    }
}
