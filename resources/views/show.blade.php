<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 bg-white rounded shadow">
        <div>
            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-64 object-contain mb-4">
        </div>
        <h1 class="text-3xl font-bold mb-2">{{ $product->name }}</h1>
        <p class="text-xl text-indigo-600 mb-4">{{ number_format($product->price, 2) }} บาท</p>
        <p class="text-gray-700">{{ $product->description }}</p>
        {{-- แสดงจำนวนสินค้าคงเหลือ --}}
        <p class="text-gray-600 mb-2">มีสินค้าในสต็อก: <span id="productAmount">{{ $product->Amount }}</span> ชิ้น</p>

        {{-- ส่วนเพิ่ม-ลดจำนวน --}}
        <div class="flex items-center space-x-4 my-6">
            <button type="button" id="decreaseBtn" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">-</button>
            <span id="quantityDisplay" class="text-xl font-semibold">1</span>
            <button type="button" id="increaseBtn" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">+</button>
        </div>

        {{-- ฟอร์มเพิ่มลงตะกร้า --}}
        <form action="{{ route('cart.add', $product->id) }}" method="POST" id="addToCartForm">
            @csrf
            <input type="hidden" name="quantity" id="quantityInput" value="1">
            <button type="submit" class="mt-4 px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
                เพิ่มลงตะกร้า
            </button>
        </form>
    </div>

    {{-- JS สำหรับควบคุมปุ่ม --}}
    <script>
        const decreaseBtn = document.getElementById('decreaseBtn');
        const increaseBtn = document.getElementById('increaseBtn');
        const quantityDisplay = document.getElementById('quantityDisplay');
        const quantityInput = document.getElementById('quantityInput');
        const productAmount = parseInt(document.getElementById('productAmount').innerText.trim(), 10);
        console.log("Amount:", productAmount)
        let quantity = 1;

        
        /* increaseBtn.addEventListener('click', () => {
            quantity++;
            updateQuantity();
        });

        decreaseBtn.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                updateQuantity();
            }
        }); */
        increaseBtn.addEventListener('click', () => {
            if (quantity < productAmount) {
                quantity++;
                updateQuantity();
            } else {
                alert("จำนวนเกินจากสต็อกที่มี!");
            }
        });

        decreaseBtn.addEventListener('click', () => {
            if (quantity > 1) {
                quantity--;
                updateQuantity();
            }
        });
        function updateQuantity() {
            quantityDisplay.textContent = quantity;
            quantityInput.value = quantity;
        }
    </script>
</x-app-layout>
