import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';//สำหรับหน้าที่ต้องการการยืนยันตัวตน.
import Chirp from '@/Components/Chirp';
import InputError from '@/Components/InputError';//สำหรับแสดงข้อความ error.
import PrimaryButton from '@/Components/PrimaryButton';//ปุ่มหลักของฟอร์ม.
import { useForm, Head } from '@inertiajs/react';//useForm: จัดการฟอร์มและข้อมูล,Head: ตั้งค่าหัวข้อ (title) ของหน้า.
 
export default function Index({ auth, chirps }) {    
    const { data, setData, post, processing, reset, errors } = useForm({
      message: '',
    });
 
    const submit = (e) => {//หยุดการทำงานปกติของฟอร์ม 
        e.preventDefault();
        post(route('chirps.store'), { onSuccess: () => reset() })//ส่งข้อมูลในpostไปที่ chirscontroller.store
    };
 
    return (
        // ครอบทุกอย่างในหน้าด้วย Layout สำหรับผู้ใช้ที่ล็อกอินแล้ว
        <AuthenticatedLayout>
            <Head title="Chirps" />
 
            <div className="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
                <form onSubmit={submit}>
                    <textarea   //รับข้อความจากผู้ใช้ (ผูกกับ data.message)เมื่อข้อความเปลี่ยน จะเรียก setData เพื่ออัปเดตค่าใน data.
                        value={data.message}
                        placeholder="What's on your mind?"
                        className="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                        onChange={e => setData('message', e.target.value)}
                    ></textarea>
                    <InputError message={errors.message} className="mt-2" />
                    <PrimaryButton className="mt-4" disabled={processing}>Chirp</PrimaryButton>
                </form>
                <div className="mt-6 bg-white shadow-sm rounded-lg divide-y">
                    {chirps.map(chirp =>
                        <Chirp key={chirp.id} chirp={chirp} />
                    )}
                </div>
            </div>
        </AuthenticatedLayout>
    ); 
}