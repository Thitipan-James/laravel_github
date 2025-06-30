<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 bg-slate-50">
        <h1 class="text-2xl font-bold mb-6">รายการสินค้า</h1>
        <div>
            <button id="new_product" class="bg-green-400 rounded-lg p-1 hover:bg-green-200">new product</button>
        </div>
        <!-- Modal -->
        <div id="productModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <!-- This element is to trick the browser into centering the modal contents. -->
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                    <form method="POST" id="productForm" enctype="multipart/form-data">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <div class="sm:flex sm:items-start">
                                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                        New Product
                                    </h3>
                                    <div class="mt-2">
                                        <div class="mb-4">
                                            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                                            <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="price" class="block text-gray-700 text-sm font-bold mb-2">Price:</label>
                                            <input type="number" name="price" id="price" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                                            <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required></textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label for="Amount" class="block text-gray-700 text-sm font-bold mb-2">Amount:</label>
                                            <input type="number" name="Amount" id="Amount" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="image" class="block text-gray-700 text-sm font-bold mb-2">Image:</label>
                                            <input type="file" name="image" id="image" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                                Create
                            </button>
                            <button type="button" onclick="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    
        <table id="productsTable" class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="py-2 px-4 border">#</th>
                    <th class="py-2 px-4 border">ชื่อสินค้า</th>
                    <th class="py-2 px-4 border">ราคา</th>
                    <th class="py-2 px-4 border">คงเหลือ</th>
                    <th class="py-2 px-4 border">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($products as $index => $product)
                    <tr>
                        <td class="py-2 px-4 border">{{ $index + 1 }}</td>
                        <td class="py-2 px-4 border">{{ $product->name }}</td>
                        <td class="py-2 px-4 border">{{ number_format($product->price, 2) }} บาท</td>
                        <td class="py-2 px-4 border">{{ $product->Amount }}</td>
                        <td class="py-2 px-4 border">
                            <button 
                                class="edit-btn bg-yellow-400 rounded-lg p-1 hover:bg-yellow-300"
                                data-id="{{ $product->id }}"
                                data-name="{{ $product->name }}"
                                data-price="{{ $product->price }}"
                                data-description="{{ $product->description }}"
                                data-amount="{{ $product->Amount }}"
                            >
                                แก้ไข
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    
    <script>
        $(document).ready(function () {
            $('#productsTable').DataTable({
                language: {
                    search: "ค้นหา:",
                    lengthMenu: "แสดง _MENU_ รายการต่อหน้า",
                    info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    paginate: {
                        previous: "ก่อนหน้า",
                        next: "ถัดไป"
                    }
                }
            });
        });

        const modal = document.getElementById('productModal');
        const form = document.getElementById('productForm');
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';

        // ปุ่ม "เพิ่มสินค้า"
        document.getElementById('new_product').addEventListener('click', () => {
            form.action = "{{ route('products.store') }}"; // route สำหรับ POST
            form.reset(); // ล้างค่าเก่า
            if (form.contains(methodInput)) form.removeChild(methodInput); // ลบ _method ถ้ามี
            modal.classList.remove('hidden');
        });

        // ปุ่ม "แก้ไขสินค้า"
        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.dataset.id;

                // กำหนด action สำหรับ update
                form.action = `/products/${id}`;
                methodInput.value = 'PUT';
                form.appendChild(methodInput);

                // กำหนดค่าฟิลด์ต่าง ๆ
                document.getElementById('name').value = button.dataset.name;
                document.getElementById('price').value = button.dataset.price;
                document.getElementById('description').value = button.dataset.description;
                document.getElementById('Amount').value = button.dataset.amount;

                modal.classList.remove('hidden');
            });
        });


        function closeModal() {
            modal.classList.add('hidden');
        }
    </script>
</x-app-layout>
