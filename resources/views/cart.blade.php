<x-app-layout>
    <div class="max-w-5xl mx-auto p-6 bg-slate-100">
        <h1 class="text-3xl font-bold mb-6">ตะกร้าสินค้า</h1>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if (empty($cart))
            <p>ตะกร้าของคุณว่างเปล่า</p>
        @else
            <div class="space-y-4">
                @php $total = 0; @endphp

                @foreach ($cart as $item)
                    @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp

                    <div class="flex items-center bg-white rounded shadow p-4">
                        <img src="{{ $item['image'] }}" class="w-24 h-24 object-cover rounded mr-4">
                        <div class="flex-1">
                            <h2 class="text-xl font-semibold">{{ $item['name'] }}</h2>
                            <p>จำนวน: {{ $item['quantity'] }}</p>
                            <p class="text-indigo-600 font-bold">ราคา: {{ number_format($subtotal, 2) }} บาท</p>
                        </div>
                        <form action="{{ route('cart.remove', $item['id']) }}" method="POST">
                            @csrf
                            <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                ลบ
                            </button>
                        </form>
                    </div>
                @endforeach

                <div class="text-right mt-6">
                    <h3 class="text-2xl font-bold">รวมทั้งหมด: {{ number_format($total, 2) }} บาท</h3>
                </div>
            </div>
            <div class="mt-10 bg-white p-6 rounded shadow">
                <h2 class="text-xl font-bold mb-4">ยืนยันการสั่งซื้อ</h2>
                <form action="{{ route('checkout.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="block font-semibold">ชื่อ-นามสกุล</label>
                        <input type="text" name="customer_name" required class="border rounded px-3 py-2 w-full">
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold">เบอร์โทร</label>
                        <input type="text" name="phone" required class="border rounded px-3 py-2 w-full">
                    </div>
                    <div class="mb-4">
                        <label for="payment_slip" class="block text-gray-700 font-semibold mb-2">แนบสลิปการโอนเงิน:</label>
                        <input type="file" name="payment_slip" id="payment_slip" accept="image/*"
                            class="border rounded w-full px-3 py-2" required>
                    </div>
                    {{-- ส่วนแสดง preview --}}
                    <div id="previewContainer" class="mb-4 hidden">
                        <p class="text-gray-600 mb-2">ตัวอย่างสลิปที่เลือก:</p>
                        <img id="previewImage" src="#" alt="Preview" class="max-w-xs rounded border">
                    </div>
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700">
                        ยืนยันการชำระเงิน
                    </button>
                </form>
            </div>
        @endif
    </div>
</x-app-layout>
<script>
    const paymentSlipInput = document.getElementById('payment_slip');
    const previewContainer = document.getElementById('previewContainer');
    const previewImage = document.getElementById('previewImage');

    if (paymentSlipInput) {
        paymentSlipInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();

                reader.onload = function (e) {
                    if (previewImage && previewContainer) {
                        previewImage.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                }

                reader.readAsDataURL(file);
            } else {
                if (previewContainer) {
                    previewContainer.classList.add('hidden');
                }
            }
        });
    }

</script>
