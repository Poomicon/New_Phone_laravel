import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Link, Head } from '@inertiajs/react';

export default function Index({ auth, products }) {
    return (
        <AuthenticatedLayout>
            <Head title="Products" />
            <div className="max-w-7xl mx-auto p-4 sm:p-6 lg:p-8">
                <h1 className="text-2xl font-bold mb-6 text-center"> New Phone Shop</h1>
                <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    {products.map((product) => (
                        <div
                            key={product.id}
                            className="border rounded-lg shadow-sm p-4 bg-white"
                        >
                            <img
                                src={product.image}
                                alt={product.name}
                                className="w-full h-30 object-cover rounded-md"
                            />
                            <div className="center-content">
                                <h2 className="mt-4 text-lg font-semibold">{product.name}</h2>
                                <p className="text-yellow-500 mt-2">฿{product.price}</p>
                                <Link
                                    href={`/products/${product.id}`}
                                    className="mt-4 inline-block text-indigo-500 hover:text-indigo-700 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" 
                                >
                                    View Details 
                                </Link>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
