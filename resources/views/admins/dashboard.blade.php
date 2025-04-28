@extends('admins.layouts.master')

@section('title', 'Dashboard')

@section('content')

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <i class="fas fa-chart-line text-red-500 text-3xl mr-4"></i>
                        <div>
                            <h2 class="text-2xl font-bold">250k</h2>
                            <p class="text-gray-500">Sales</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <i class="fas fa-smile text-blue-500 text-3xl mr-4"></i>
                        <div>
                            <h2 class="text-2xl font-bold">24m</h2>
                            <p class="text-gray-500">Customers</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <i class="fas fa-box text-yellow-500 text-3xl mr-4"></i>
                        <div>
                            <h2 class="text-2xl font-bold">15k</h2>
                            <p class="text-gray-500">Products</p>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <div class="flex items-center">
                        <i class="fas fa-lock text-green-500 text-3xl mr-4"></i>
                        <div>
                            <h2 class="text-2xl font-bold">180m</h2>
                            <p class="text-gray-500">Revenue</p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Charts -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow-md col-span-2">
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h3 class="text-lg font-bold">Overall Sales</h3>
                            <p class="text-gray-500">12 Millions</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Overall Earnings</h3>
                            <p class="text-gray-500">78 Millions</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">Overall Revenue</h3>
                            <p class="text-gray-500">60 Millions</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">New Customers</h3>
                            <p class="text-gray-500">23k</p>
                        </div>
                    </div>
                    <div class="flex justify-between items-center mb-4">
                        <button class="bg-green-500 text-white px-4 py-2 rounded-lg">Today</button>
                        <button class="text-gray-500 px-4 py-2">Yesterday</button>
                        <button class="text-gray-500 px-4 py-2">7 days</button>
                        <button class="text-gray-500 px-4 py-2">15 days</button>
                        <button class="text-gray-500 px-4 py-2">30 days</button>
                    </div>
                    <img src="https://storage.googleapis.com/a1aa/image/Ul7s8sI7jXqcdwArDVpCF5-BId2Dq07YwT39_qT7ogo.jpg" alt="Sales and Revenue Chart" class="w-full" width="600" height="300">
                </div>
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-bold mb-4">Sales</h3>
                    <img src="https://storage.googleapis.com/a1aa/image/aXzgiezQ1KeMrSILZTfaqLFUndKumaPUZLLhl7mgFoQ.jpg" alt="Sales Bar Chart" class="w-full mb-4" width="200" height="200">
                    <h2 class="text-4xl font-bold">2100</h2>
                    <p class="text-gray-500">12% higher than last month.</p>
                </div>
            </div>
            <!-- Orders -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-bold mb-4">Orders</h3>
                <table class="w-full text-left">
                    <thead>
                        <tr>
                            <th class="py-2">Customer</th>
                            <th class="py-2">Product</th>
                            <th class="py-2">User ID</th>
                            <th class="py-2">Ordered Placed</th>
                            <th class="py-2">Amount</th>
                            <th class="py-2">Payment Status</th>
                            <th class="py-2">Order Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="py-2 flex items-center">
                                <img src="https://storage.googleapis.com/a1aa/image/3ePAiEn9bnXLMjhkArdD_ztD2Km747hGKADIFxOn_PQ.jpg" alt="Customer Avatar" class="h-10 w-10 rounded-full mr-2">
                                Ellie Collins
                            </td>
                            <td class="py-2">
                                <img src="https://storage.googleapis.com/a1aa/image/i1-fiXwoyZYJohl2N--LkBPyk9He1OjOmtn2HgKUidk.jpg" alt="Ginger Snacks" class="h-10 w-10 rounded-full mr-2">
                                Ginger Snacks
                            </td>
                            <td class="py-2">Arise827</td>
                            <td class="py-2">12/12/2021</td>
                            <td class="py-2">$18.00</td>
                            <td class="py-2 text-green-500">Paid</td>
                            <td class="py-2">
                                <span class="bg-green-100 text-green-500 px-2 py-1 rounded-lg">Delivered</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 flex items-center">
                                <img src="https://storage.googleapis.com/a1aa/image/3ePAiEn9bnXLMjhkArdD_ztD2Km747hGKADIFxOn_PQ.jpg" alt="Customer Avatar" class="h-10 w-10 rounded-full mr-2">
                                Sophie Nguyen
                            </td>
                            <td class="py-2">
                                <img src="https://storage.googleapis.com/a1aa/image/qbUcPzsp8CvcIanaU17J1tce75cZVqYPN1UtC4X9468.jpg" alt="Guava Sorbet" class="h-10 w-10 rounded-full mr-2">
                                Guava Sorbet
                            </td>
                            <td class="py-2">Arise253</td>
                            <td class="py-2">18/12/2021</td>
                            <td class="py-2">$32.00</td>
                            <td class="py-2 text-red-500">Failed</td>
                            <td class="py-2">
                                <span class="bg-red-100 text-red-500 px-2 py-1 rounded-lg">Cancelled</span>
                            </td>
                        </tr>
                        <tr>
                            <td class="py-2 flex items-center">
                                <img src="https://storage.googleapis.com/a1aa/image/3ePAiEn9bnXLMjhkArdD_ztD2Km747hGKADIFxOn_PQ.jpg" alt="Customer Avatar" class="h-10 w-10 rounded-full mr-2">
                                Darcy Ryan
                            </td>
                            <td class="py-2">
                                <img src="https://storage.googleapis.com/a1aa/image/nnT1wAV4j3ikYRGJOqXm5z9TRCNzXJss2-HDrpX-HT0.jpg" alt="Gooseberry Surprise" class="h-10 w-10 rounded-full mr-2">
                                Gooseberry Surprise
                            </td>
                            <td class="py-2">Arise878</td>
                            <td class="py-2">22/12/2021</td>
                            <td class="py-2">$19.00</td>
                            <td class="py-2 text-blue-500">Awaiting</td>
                            <td class="py-2">
                                <span class="bg-blue-100 text-blue-500 px-2 py-1 rounded-lg">Processing</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

@endsection
