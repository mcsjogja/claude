<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Transaksi ' . ucfirst($type)) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('transactions.store') }}" method="POST" id="transactionForm">
                        @csrf
                        <input type="hidden" name="type" value="{{ $type }}">
                        
                        <div class="mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detail Transaksi</h3>
                            
                            <div id="productItems">
                                <div class="product-item grid grid-cols-1 md:grid-cols-5 gap-4 mb-4 p-4 border rounded-lg">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Produk</label>
                                        <select name="products[0][product_id]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 product-select" required>
                                            <option value="">Pilih Produk</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $type == 'penjualan' ? $product->selling_price : $product->purchase_price }}" data-stock="{{ $product->stock }}">
                                                    {{ $product->code }} - {{ $product->name }} (Stok: {{ $product->stock }})
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Quantity</label>
                                        <input type="number" name="products[0][quantity]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 quantity-input" min="1" required>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Harga</label>
                                        <input type="number" name="products[0][price]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 price-input" min="0" step="0.01" required>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Subtotal</label>
                                        <input type="text" class="mt-1 block w-full rounded-md border-gray-300 bg-gray-100 subtotal-display" readonly>
                                    </div>
                                    
                                    <div class="flex items-end">
                                        <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded remove-item" disabled>
                                            Hapus
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" id="addProduct" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mb-4">
                                Tambah Produk
                            </button>
                        </div>

                        <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-semibold text-gray-900">Total:</span>
                                <span id="grandTotal" class="text-xl font-bold text-gray-900">Rp 0</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <a href="{{ route('transactions.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Kembali
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Simpan Transaksi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let itemIndex = 1;

        function calculateSubtotal(item) {
            const quantity = parseFloat(item.querySelector('.quantity-input').value) || 0;
            const price = parseFloat(item.querySelector('.price-input').value) || 0;
            const subtotal = quantity * price;
            
            item.querySelector('.subtotal-display').value = 'Rp ' + subtotal.toLocaleString('id-ID');
            
            calculateGrandTotal();
        }

        function calculateGrandTotal() {
            let total = 0;
            document.querySelectorAll('.product-item').forEach(item => {
                const quantity = parseFloat(item.querySelector('.quantity-input').value) || 0;
                const price = parseFloat(item.querySelector('.price-input').value) || 0;
                total += quantity * price;
            });
            
            document.getElementById('grandTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
        }

        document.getElementById('addProduct').addEventListener('click', function() {
            const productItems = document.getElementById('productItems');
            const newItem = productItems.querySelector('.product-item').cloneNode(true);
            
            // Update names and clear values
            newItem.querySelectorAll('select, input').forEach(element => {
                if (element.name) {
                    element.name = element.name.replace('[0]', '[' + itemIndex + ']');
                }
                if (element.type !== 'hidden') {
                    element.value = '';
                }
            });
            
            // Enable remove button
            newItem.querySelector('.remove-item').disabled = false;
            
            productItems.appendChild(newItem);
            itemIndex++;
            
            // Add event listeners to new item
            addEventListeners(newItem);
        });

        function addEventListeners(item) {
            const productSelect = item.querySelector('.product-select');
            const quantityInput = item.querySelector('.quantity-input');
            const priceInput = item.querySelector('.price-input');
            const removeButton = item.querySelector('.remove-item');

            productSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    priceInput.value = selectedOption.dataset.price;
                    calculateSubtotal(item);
                }
            });

            quantityInput.addEventListener('input', function() {
                calculateSubtotal(item);
            });

            priceInput.addEventListener('input', function() {
                calculateSubtotal(item);
            });

            removeButton.addEventListener('click', function() {
                if (document.querySelectorAll('.product-item').length > 1) {
                    item.remove();
                    calculateGrandTotal();
                }
            });
        }

        // Add event listeners to initial item
        document.querySelectorAll('.product-item').forEach(item => {
            addEventListeners(item);
        });
    </script>
</x-app-layout>