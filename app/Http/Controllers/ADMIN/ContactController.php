<?php

namespace App\Http\Controllers\ADMIN;
use App\Http\Controllers\Controller;
use App\Http\Requests\ADMIN\CreateContactRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index(){
        $contacts=Contact::all();
        return view('admin.contacts.contact',compact('contacts'));
    }

    public function create(CreateContactRequest $request){
        try{
            $data = $request->all();
            Contact::create($data);
            return redirect()->route('admin.contact.success');
        }
        catch(\Exception $e){
            return redirect()->route('contact')->with('error','Failed to create contact');
        }
        
    }
    public function success(){
        return view('cms.contact.contact_success');
    }

    public function remove($id){
        DB::beginTransaction();
        try {
            $contactDelete = Contact::find($id);
            if (!$contactDelete) {
                return redirect()->route('admin.contact.index')->with('error', 'Contact not found.');
            }
            $contactDelete->delete();
            DB::commit();
            return redirect()->route('admin.contact.index')->with('success', 'Contact deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.contact.index')->with('error', 'Contact not found.');
        }
    }

}
