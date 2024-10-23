<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product') }}
            <a href="{{ route('product.index') }}"
               class="text-white float-end bg-gray-500 hover:bg-gray-700 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                {{ __('Back To Product List') }}
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="table table-compact w-full border">
                            <thead>
                            <tr>
                                <th class="bg-gray-200 border">{{ __('Product Heading') }}</th>
                                <th class="bg-gray-200 border">{{ __('Product Data') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td class="bg-white px-4 py-2 border">
                                    {{ __('Product Name') }}
                                </td>
                                <td class="bg-white px-4 py-2 border">
                                    {{ $product->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-white px-4 py-2 border">
                                    {{ __('Product Name Slug') }}
                                </td>
                                <td class="bg-white px-4 py-2 border">
                                    {{ $product->slug }}
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-white px-4 py-2 border">
                                    {{ __('Product Old Price') }}
                                </td>
                                <td class="bg-white px-4 py-2 border">
                                    {{ $product->old_price }} taka
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-white px-4 py-2 border">
                                    {{ __('Product New Price') }}
                                </td>
                                <td class="bg-white px-4 py-2 border">
                                    {{ $product->new_price }} taka
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-white px-4 py-2 border">
                                    {{ __('Product Category') }}
                                </td>
                                <td class="bg-white px-4 py-2 border">
                                    {{ $product->category->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-white px-4 py-2 border">
                                    {{ __('Product Subcategory') }}
                                </td>
                                <td class="bg-white px-4 py-2 border">
                                    {{ $product->subCategory->name }}
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-white px-4 py-2 border">
                                    {{ __('Product Description') }}
                                </td>
                                <td class="bg-white px-4 py-2 border">
                                    {{ $product->description }}
                                </td>
                            </tr>
                            <tr>
                                <td class="bg-white px-4 py-2 border">
                                    {{ __('Product Image') }}
                                </td>
                                <td class="bg-white px-4 py-2 border">
                                    <img src="{{ asset('storage/products/'.$product->image) }}" alt="{{ $product->name }}" class="w-40 h-40">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
