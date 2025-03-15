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
      return  $this->Doctors->store($request);
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(Request $request)
    {
        return $this->Doctors->destroy($request);
    }
}
