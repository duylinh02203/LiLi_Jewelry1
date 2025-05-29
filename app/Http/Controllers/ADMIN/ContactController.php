<?php

namespace App\Http\Controllers\ADMIN;
use App\Http\Controllers\Controller;
use App\Http\Requests\ADMIN\CreateContactRequest;
use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class ContactController extends Controller
{
    public function index(){
        $contacts=Contact::paginate(5);
        return view('admin.contacts.contact',compact('contacts'));
    }

    public function create(CreateContactRequest $request){
        if (!session()->has('userData')) {
            return redirect()->route('auth.login')->with('error', 'Bạn cần đăng nhập để đánh giá sản phẩm.');
        }
        try{
            $data = $request->all();
            Contact::create($data);
            return redirect()->route('admin.contact.success');
        }
        catch(\Exception $e){
            return redirect()->route('contact')->with('error','Thêm liên hệ thất bại');
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
                return redirect()->route('admin.contact.index')->with('error', 'Không tìm thấy liên hệ.');
            }
            $contactDelete->delete();
            DB::commit();
            return redirect()->route('admin.contact.index')->with('success', 'Xóa liên hệ thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.contact.index')->with('error', 'Không tìm thấy liên hệ.');
        }
    }

    public function searchContact(Request $request){
        $search = $request->input('search');
        $contacts = Contact::where('first_name', 'like', "%$search%")
            ->orWhere('last_name', 'like', "%$search%")
            ->orWhere('email', 'like', "%$search%")
            ->orWhere('phone', 'like', "%$search%")
            ->get();
        return view('admin.contacts.contact', compact('contacts'));
    }

    public function detail($id){
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.detail', compact('contact'));
    }
}
