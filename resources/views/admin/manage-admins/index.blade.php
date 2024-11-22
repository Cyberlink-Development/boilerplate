@extends('admin.common.master')
@section('page_sub_title')
~ Admins List
@endsection
@section('sub-content')
    <div>
        <div class="rounded overflow-hidden shadow bg-white w-full mb-[1rem]">
            <div class="px-6 py-2 border-b border-light-grey flex justify-between">
                <div class="font-bold text-xl">Manage Admins</div>
                @can('admins_create')
                    <div>
                        <a href="{{route('manage-admins.create')}}" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-xs px-4 py-2 mb-2">Create</a>
                    </div>
                @endcan
            </div>
        </div>

        <div class=" flex justify-center mx-auto">
            <div class="flex flex-col w-full">
                <div class="w-full">
                    <div class="border-b border-gray-200 shadow">
                        <table class="divide-y divide-green-400 w-full cursor-default">
                            <!-- <thead class="bg-gray-50"> -->
                            <thead class="bg-[#8795a1] text-white">
                                <tr class="text-left">
                                    <th class="px-6 py-2 text-normal text-white">
                                        #
                                    </th>
                                    <th class="px-6 py-2 text-normal text-white">
                                        Name
                                    </th>
                                    <th class="px-6 py-2 text-normal text-white">
                                        Email
                                    </th>
                                    <th class="px-6 py-2 text-normal text-white">
                                        Role
                                    </th>
                                    <th class="px-6 py-2 text-normal text-white">
                                        Created_at
                                    </th>
                                    @can('admins_edit')
                                        <th class="px-6 py-2 text-normal text-white">
                                            Edit
                                        </th>
                                    @endcan
                                    @can('admins_delete')
                                        <th class="px-6 py-2 text-normal text-white">
                                            Delete
                                        </th>
                                    @endcan
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                @php
                                    $c = 1;
                                @endphp
                                @foreach($data as $row)
                                    @if(compare_roles_hierarchy_with_admins($row))
                                        <tr class="whitespace-nowrap text-start">
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{$c++}}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    @can('admins_show')
                                                        <a href="{{route('manage-admins.show',$row->id)}}" class="hover:underline">{{name_deformat($row->name)}}</a>
                                                    @else
                                                        {{name_deformat($row->name)}}
                                                    @endcan
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{$row->email}}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{get_admin_role($row->id) ? get_admin_role($row->id) : '-'}}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{$row->created_at->format('Y-m-d')}}
                                            </td>
                                            @can('admins_edit')
                                                <td class="px-6 py-4">
                                                    {!! $row->id == 1 ? '-' : 
                                                        '<a href="' . route('manage-admins.edit', $row->id) . '">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-400" fill="none"
                                                                viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                            </svg>
                                                        </a>'
                                                    !!}
                                                </td>
                                            @endcan
                                            @can('admins_delete')
                                                <td class="px-6 py-4">
                                                    {!! $row->id == 1 ? '-' :
                                                        '<form action="' . route('manage-admins.destroy', $row->id) . '" method="POST" style="display:inline;">
                                                            ' . csrf_field() . '
                                                            ' . method_field('DELETE') . '
                                                            <button type="button" style="border:none; background:none;" onclick="confirmDelete(this)">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5  4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                </svg>
                                                            </button>
                                                        </form>'
                                                    !!}
                                                </td>
                                            @endcan
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('sub-script')
    <script>
        function confirmDelete(button) {
            Swal.fire({
                title: "Are you sure?",
                text: "Once deleted, you will not be able to recover this data!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>
@endsection