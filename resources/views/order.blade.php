<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-4">รายการสั่งซื้อทั้งหมด</h1>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white p-4 rounded shadow">
            <table id="ordersTable" class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">ชื่อลูกค้า</th>
                        <th class="px-4 py-2 text-left">เบอร์โทร</th>
                        <th class="px-4 py-2 text-left">วันที่</th>
                        <th class="px-4 py-2 text-left">สลิป</th>
                        <th class="px-4 py-2 text-left">ดูรายละเอียด</th>
                        <th class="px-4 py-2 text-left">ลบ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $index => $order)
                        <tr>
                            <td class="px-4 py-2">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $order->customer_name }}</td>
                            <td class="px-4 py-2">{{ $order->phone }}</td>
                            <td class="px-4 py-2">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2">
                                @if ($order->payment_slip_path)
                                    <a href="{{ asset('storage/' . $order->payment_slip_path) }}" target="_blank">
                                        <img src="{{ asset('storage/' . $order->payment_slip_path) }}" alt="slip" class="h-16 rounded shadow">
                                    </a>
                                @else
                                    ไม่มี
                                @endif
                            </td>
                            <td class="px-4 py-2">
                               @php
                                    $items = json_decode($order->cart_data, true);
                                @endphp

                                @if (is_array($items))
                                    <ul class="text-sm list-disc list-inside">
                                        @foreach ($items as $item)
                                            <li>{{ $item['name'] }} × {{ $item['quantity'] }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <span class="text-red-500 text-sm">ไม่สามารถโหลดสินค้าในคำสั่งซื้อนี้ได้</span>
                                @endif

                            </td>
                            <td>
                                <form action="{{ route('orders.delete', $order->id) }}" method="POST" onsubmit="return confirm('คุณแน่ใจว่าต้องการลบคำสั่งซื้อนี้หรือไม่?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                        ลบ
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- DataTables --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function () {
            $('#ordersTable').DataTable({
                language: {
                    search: "ค้นหา:",
                    lengthMenu: "แสดง _MENU_ รายการ",
                    info: "แสดง _START_ ถึง _END_ จากทั้งหมด _TOTAL_ รายการ",
                    paginate: {
                        previous: "ก่อนหน้า",
                        next: "ถัดไป"
                    }
                }
            });
        });
    </script>
</x-app-layout>
