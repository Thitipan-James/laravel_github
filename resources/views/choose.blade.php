<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Store') }}
        </h2>
        {{-- Filter Form --}}
        <form method="GET" action="{{ route('choose') }}" class="mb-4">
            <label for="game" class="mr-2 dark:text-white">เลือกเกม:</label>
            <select name="game" id="game" class="p-2 border rounded">
                <option value="">-- ทั้งหมด --</option>
                <option value="Genshin" {{ request('game') == 'Genshin' ? 'selected' : '' }}>Genshin</option>
                <option value="Starrail" {{ request('game') == 'Starrail' ? 'selected' : '' }}>Starrail</option>
                <option value="WutheringWave" {{ request('game') == 'WutheringWave' ? 'selected' : '' }}>WutheringWave</option>
            </select>
            <button type="submit" class="ml-2 px-4 py-2 bg-blue-500 text-white rounded">กรอง</button>
        </form>
    </x-slot>
    <div class="py-12">
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 p-4">
    @if ($products->isEmpty())
        {{-- Display this message if no products are found --}}
        <div class="col-span-full text-center py-10 text-gray-600 dark:text-gray-400">
            <p>ยังไม่มีสินค้าในขณะนี้</p>
            <p>เพิ่มสินค้าใหม่ได้เลย!</p>
        </div>
    @else
        {{-- Loop through each product if products exist --}}
        @foreach ($products as $product)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden transition-transform duration-300 hover:scale-105 hover:shadow-xl">
                <img src="{{$product->image}}" alt="{{ $product->name }}" class="w-full h-48 object-cover object-center">
                <div class="p-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ $product->name }}</h3>
                    <p class="text-2xl font-bold text-indigo-600 dark:text-indigo-400 mb-3">{{ number_format($product->price, 2) }} บาท</p>
                    <p class="text-gray-700 dark:text-gray-300 text-sm line-clamp-3 mb-4">{{ $product->description }}</p>

                    {{-- Optional: Add a button or link --}}
                    <div class="mt-4">
                        @if($product->Amount === 0)
                            <div class="text-xl font-bold text-red-600 dark:text-red-400 mb-3">ของหมด</div>
                        @else
                            <a href="{{ route('products.show', $product->id) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                            ดูรายละเอียด
                        </a>
                        @endif
                        
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
    </div>

</x-app-layout>

<script>
    /* const modal = document.getElementById('productModal');
    document.getElementById('new_product').addEventListener('click', () => modal.classList.remove('hidden'));
    function closeModal() {
        modal.classList.add('hidden');
    } */
</script>
