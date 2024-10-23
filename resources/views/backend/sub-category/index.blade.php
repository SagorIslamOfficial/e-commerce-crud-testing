<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Category') }}
            <a href="{{ route('subcategory.create') }}"
               class="text-white float-end bg-gray-500 hover:bg-gray-700 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center">
                {{ __('Create New SubCategory') }}
            </a>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="bg-green-100 mb-5 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Well done!</strong>
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <table class="table-auto w-full mb-5">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">#</th>
                                <th class="px-4 py-2">SubCategory Name</th>
                                <th class="px-4 py-2">Slug</th>
                                <th class="px-4 py-2">Category (Main)</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($subcategories->isEmpty())
                                <tr class="text-center">
                                    <td colspan="5" class="border px-4 py-2">No Category Found</td>
                                </tr>
                            @else
                                @foreach ($subcategories as $key => $subcategory)
                                    <tr class="text-center">
                                        <td class="border px-4 py-2">{{ $key + 1 }}</td>
                                        <td class="border px-4 py-2">{{ $subcategory->name }}</td>
                                        <td class="border px-4 py-2">{{ $subcategory->slug }}</td>
                                        <td class="border px-4 py-2">{{ $subcategory->category->name }}</td>
                                        <td class="border px-4 py-2">
                                            <a href="{{ route('subcategory.edit', $subcategory->id) }}"
                                               class="text-blue-500 hover:text-blue-700 hover:underline mr-2">
                                                {{ __('Edit') }}
                                            </a>
                                            <button type="button"
                                                    class="text-red-500 hover:text-red-700 hover:underline"
                                                    onclick="confirmDelete('{{ $subcategory->name }}', '{{ route('subcategory.destroy', $subcategory->id) }}')">
                                                {{ __('Delete') }}
                                            </button>

                                            <script>
                                            <!-- I used AI to generate this code -->
                                                function confirmDelete(subCategoryName, deleteUrl) {
                                                    if (confirm(`Are you sure you want to delete the category: ${subCategoryName}?`)) {

                                                        var form = document.createElement('form');
                                                        form.method = 'POST';
                                                        form.action = deleteUrl;

                                                        var csrfToken = document.createElement('input');
                                                        csrfToken.type = 'hidden';
                                                        csrfToken.name = '_token';
                                                        csrfToken.value = '{{ csrf_token() }}';
                                                        form.appendChild(csrfToken);

                                                        var methodField = document.createElement('input');
                                                        methodField.type = 'hidden';
                                                        methodField.name = '_method';
                                                        methodField.value = 'DELETE';
                                                        form.appendChild(methodField);

                                                        document.body.appendChild(form);
                                                        form.submit();
                                                    }
                                                }
                                            </script>

                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    {{ $subcategories->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
