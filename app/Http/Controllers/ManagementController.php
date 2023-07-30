<?php

namespace App\Http\Controllers;


use App\Http\Middleware\HandleInertiaRequests;
use App\Models\Department;
use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Str;
use Excel;

class ManagementController extends Controller
{
    public function departments()
    {
        return Inertia::render('Department/Departments', [
            'departments' => Department::withCount("employees")->get(),
            "message" => session("message") ?? ""
        ]);
    }



    public function create_department()
    {
        return Inertia::render("Department/Create-Department");
    }

    public function store_department(Request $request)
    {
        $request->validate([
            "name" => "required|unique:departments,name,except,id"
        ]);
        $cat = Department::create([
            "name" => $request->name,
            "uuid" => Str::uuid()
        ]);
        return redirect()->route("departments")->with("message", $cat->name . " department created successfully");
    }

    public function edit_department($uuid)
    {
        return Inertia::render('Department/Edit-Department', [
            'department' => Department::where("uuid", $uuid)->first(),
        ]);
    }

    public function update_department(Request $request, $uuid)
    {
        $request->validate([
            "name" => "required|unique:departments,name,except,id"
        ]);
        $cat = Department::where("uuid", $uuid)->first();
        $cat->name = $request->name;
        $cat->save();
        return redirect()->route("departments")->with("message", $cat->name . " department updated successfully");
    }

    public function delete_department($uuid)
    {
        $cat = Department::where("uuid", $uuid)->first();
        $cat->delete();
        return redirect()->route("departments")->with("message", $cat->name . " department deleted successfully");
    }

    public function employees()
    {
        return Inertia::render('Dashboard', [
            'employees' => Employee::with("department")->get(),
            'message' => session("message")
        ]);
    }

    public function search($searchKey) {
        return Inertia::render('Dashboard', [
            'employees' => Employee::where('name', 'like', "%$searchKey%")->get()
        ]);
    }

    public function create_employee()
    {
        return Inertia::render("Create-Employee", [
            "departments" => Department::latest()->get()
        ]);
    }

    public function store_employee(Request $request)
    {

        $request->validate([
            "name" => "required|unique:employees,name,except,id",
            "email" => "sometimes|unique:employees,email,except,id",
            "phone" => "sometimes|unique:employees,phone,except,id",
            "address" => "sometimes|unique:employees,address,except,id",
            "department" => "required|exists:departments,id",
        ]);

        $fileName = null;

        // Process image
        if ($request->hasFile('pic') && $request->file('pic')->isValid()) {
            $fileName = time() . '.' . $request->pic->extension();
            $request->pic->move(public_path('images/product_pics'), $fileName);
        }

        $Employee = Employee::create([
            "user_id" => auth()->id(),
            "uuid" => Str::uuid(),
            "name" => $request->name,
            "email" => $request->email,
            "phone" => $request->phone,
            "address" => $request->address,
            "department_id" => $request->department,
            "pic" => $fileName,
        ]);



        return redirect()->route("employees")->with("message", $Employee->name . " Employee created successfully");
    }

    public function toggle(Employee $employee) {
        $employee->enabled = !$employee->enabled;
        $employee->save();
        return back();
    }

    public function edit_employee($uuid)
    {
        return Inertia::render('Edit-Employee', [
            'employee' => Employee::where("uuid", $uuid)->first(),
            'departments' => Department::latest()->get(),
        ]);
    }

    public function update_employee(Request $request, $uuid)
    {
        $data = Employee::where("uuid", $uuid)->first();
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->department_id = $request->department;
        $data->save();

        return redirect()->route("employees")->with("message", $data->name . " Employee updated successfully");
    }

    public function delete_employee($uuid)
    {
        $data = Employee::where("uuid", $uuid)->first();
        $data->delete();
        return redirect()->route("employees")->with("message", $data->name . " Employee deleted successfully");
    }

    public function pdf() {
        $employees = Employee::all();
        $pdf = PDF::loadView('pdf.employee', compact('employees'));

        return $pdf->stream();
    }

    public function email(Employee $employee) {
        $employees = Employee::all();
        $pdf = PDF::loadView('pdf.employee', compact('employees'));

        $filename = 'statements/' . $employee->last_name . "_" . $employee->id . ".pdf";
        $pdf->save($filename);

        Mail::send('email.soa', ['employee'=>$employee], function($message) use ($employee, $filename){
            $message->to($employee->email);
            $message->subject('Statement of Account');
            $message->attach($filename);
        });

        return back();
      }


}
