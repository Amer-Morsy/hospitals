<?php


namespace App\Repository\Dashboard_Ray_Employee;


use App\Models\Ray;
use App\Tarits\UploadTrait;

class InvoicesRepository implements \App\Interfaces\Dashboard_Ray_Employee\InvoicesRepositoryInterface
{
    use UploadTrait;

    public function index()
    {
        $invoices = Ray::all();
        return view('Dashboard.dashboard_RayEmployee.invoices.index',compact('invoices'));
    }

    public function edit($id)
    {
        $invoice = Ray::findorFail($id);
        return view('Dashboard.dashboard_RayEmployee.invoices.add_diagnosis',compact('invoice'));
    }

    public function update($request, $id)
    {
        $invoice = Ray::findorFail($id);

        $invoice->update([
            'employee_id'=> auth()->user()->id,
            'description_employee'=> $request->description_employee,
            'case'=> 1,
        ]);

        //Upload img
        $this->verifyAndStoreImage($request,'photo','Rays','upload_image',auth()->user()->id,'App\Models\Ray');

        session()->flash('edit');
        return redirect()->route('invoices_ray_employee.index');

    }

}
