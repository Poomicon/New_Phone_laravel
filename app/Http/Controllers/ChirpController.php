<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Inertia\Response;
class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response 
    {
        return Inertia::render('Chirps/Index', [
            'chirps' => Chirp::with('user:id,name')->latest()->get(), //เพื่อดึงข้อมูล Chirp ทั้งหมดจากฐานข้อมูล
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse //รับ Request จากผู้ใช้เพื่อสร้าง Chirp ใหม่
    {
        $validated = $request->validate([  
            'message' => 'required|string|max:255', //Validate ข้อมูลใหม่ต้องไม่ว่างและไม่เกิน 255 ตัวอักษร
        ]);
 
        $request->user()->chirps()->create($validated); //สร้างข้อความใหม่โดยเชื่อมโยงกับuser
 
        return redirect(route('chirps.index'));//หลังจากสร้างเสร็จจะไปที่หน้า chirps.index
    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        Gate::authorize('update', $chirp); //เพื่อตรวจสอบว่า User ปัจจุบันมีสิทธิ์ในการอัปเดต Chirp นี้หรือไม่ โดยอิงตาม Policy ที่กำหนดไว้สำหรับ "update"

        $validated = $request->validate([
            'message' => 'required|string|max:255', //Validate ข้อมูลใหม่ต้องไม่ว่างและไม่เกิน 255 ตัวอักษร
        ]);
 
        $chirp->update($validated); //อัปเดต Chirp ผ่าน 
 
        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chirp $chirp): RedirectResponse //ใช้สำหรับลบ Chirp
    {
        Gate::authorize('delete', $chirp); //ตรวจสอบสิทธิ์ก่อนลบ
 
        $chirp->delete(); //มีสิทธิ์จะลบข้อความ
 
        return redirect(route('chirps.index'));
    }
}
