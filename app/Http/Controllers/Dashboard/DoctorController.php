<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Interfaces\Doctors\DoctorRepositoryInterface;
use App\Models\Doctor;
use Illuminate\Http\Request;
use PhpParser\Comment\Doc;

class DoctorController extends Controller
{
    private $Doctors;

    public function __construct(DoctorRepositoryInterface $Doctors)
    {
        $this->Doctors = $Doctors;
    }

    public function index()
    {
        return $this->Doctors->index();
    }

    public function create()
    {
        return $this->Doctors->create();
    }

    public function store(Request $request)
    {
        return $this->Doctors->store($request);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        return $this->Doctors->edit($id);
    }

    public function update(Request $request)
    {
        return $this->Doctors->update($request);
    }

    public function update_password(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ]);

        return $this->Doctors->update_password($request);
    }

    public function update_status(Request $request)
    {
        $request->validate( [
            'status' => 'required|in:0,1',
        ]);
        return $this->Doctors->update_status($request);

    }

    public function destroy(Request $request)
    {
        return $this->Doctors->destroy($request);
    }
}
