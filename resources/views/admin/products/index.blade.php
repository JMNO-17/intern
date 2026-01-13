@extends('layouts.admin')
@section('content')
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="bg-white shadow-xs ring-1 ring-gray-900/5 sm:rounded-xl my-4 md:my-8">
            <div class="px-4 py-6 sm:p-8">
                <div class="sm:flex sm:items-center">
                    <div class="sm:flex-auto">
                        <div class="text-base font-semibold text-gray-900">
                            {{ __('labels.product.title') }}
                        </div>
                        <p class="mt-2 text-sm text-gray-700">{{ __('labels.product.description') }}</p>
                    </div>
                    @can('product_create')
                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <a href="{{ route('admin.products.create') }}"
                            class="block rounded-md custom-bg px-3 py-2 text-center text-sm font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            {{ __('global.add') }}
                            {{ __('labels.product.title_singular') }}

                            </a>
                        </div>
                    @endcan
                </div>
                <div class="mt-8 overflow-x-auto">
                    @foreach (['success', 'error'] as $msgType)
                        @if ($message = Session::get($msgType))
                            @include('admin.common.success-error-message', [
                                'type' => $msgType,
                                'message' => $message,
                            ])
                        @endif
                    @endforeach
                    <table id="product-table" class="min-w-full divide-gray-200 border border-gray-200 rounded-lg text-sm text-left text-gray-700">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('global.no') }}</th>
                                <th scope="col" class="px-6 py-3 font-semibold">
                                    Category ( {{ __('labels.category.fields.name') }} )
                                </th>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('labels.product.fields.name') }}</th>
                                {{-- <th scope="col" class="px-6 py-3 font-semibold">{{ __('labels.product.fields.slug') }}</th> --}}
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('labels.product.fields.price') }}</th>
                                <th scope="col" class="px-6 py-3 font-semibold">{{ __('labels.product.fields.status') }}</th>

                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">{{ __('global.action') }}</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                            @foreach ($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $loop->iteration ?? '' }}
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    @if($product->category)
                                        {{ $product->category->name ?? '' }}
                                        @if(optional($product->category->menu)->name)
                                            ({{ $product->category->menu->name }})
                                        @endif
                                    @endif
                                </td>
                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $product->name ?? '' }}
                                </td>

                                {{-- <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $product->slug ?? '' }}
                                </td> --}}

                                <td class="px-6 py-4 font-medium text-gray-900">
                                    {{ $product->price ?? '' }}
                                </td>

                                <td class="px-6 py-4">
                                        @include('admin.common.change-status',[
                                            'id' => $product->id,
                                            'status' => $product->status == true ? 'checked' : '',
                                            'url' => route('admin.change.product.status')
                                        ])
                                </td>


                                <td class="px-6 py-4 flex items-center justify-end gap-2">
                                    @can('product_access')
                                            <a href="{{ route('admin.products.show', $product) }}" class="custom-color">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                        @endcan
                                    @can('product_edit')
                                       <a href="{{ route('admin.products.edit', $product) }}" class="custom-color">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                    @endcan
                                    @can('product_delete')
                                            <x-admin.delete-popup :id="$product->id" :action="route('admin.products.destroy', $product->id)" :isDestroy="true">
                                                <button type="submit"
                                                    class="text-gray-600 hover:text-red-600 px-2 cursor-pointer" title="Delete">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </x-admin.delete-popup>
                                    @endcan
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @parent
    <script>
        if (document.getElementById("product-table") && typeof simpleDatatables.DataTable !== 'undefined') {
            const dataTable = new simpleDatatables.DataTable("#product-table", {
                searchable: true,
                sortable: true,
                perPage: 10,
                perPageSelect: [10, 20, 30, 50, 100],
            });
        }

         document.querySelectorAll(".deleteForm").forEach(form => {
            form.addEventListener("submit", function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure you want to delete?",
                    text: "If you delete this, it will be gone forever.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#FF0000",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.submit(); // Submit the current form directly
                    }
                });
            });
        });

    </script>

@endsection
