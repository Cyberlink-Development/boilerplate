@extends('admin.common.master')
@section('page_sub_title')
    ~ Roles Details
@endsection
@section('sub-content')
<div>
        <div class="rounded overflow-hidden shadow bg-white w-full mb-[1rem]">
            <div class="px-6 py-2 border-b border-light-grey flex justify-between">
                <div class="font-bold text-xl">Role Details</div>
            </div>
        </div>

        <div class="flex justify-center mx-auto">
            <div class="w-full flex flex-col space-y-[2rem]">
                @if(compare_roles_hierarchy_with_roles($data))
                    <div class="bg-[#66666622] px-6 py-2 border-b border-gray-200 shadow flex flex-col space-y-[1rem]">
                        <h1 class="font-bold text-lg">{{name_deformat($data->name)}}</h1>
                        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-[1rem]">
                            @foreach ($permissions as $permission)  
                                @if(compare_roles_permission_with_permission($permission))
                                    <div class="flex items-center mb-4">
                                        <input id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600 {{ $data->name == 'super_admin' ? '!text-[#666666]' : '' }}" {{$data->hasPermissionTo($permission->name) ? 'checked' : ''}} {{$data->name == 'super_admin' ? 'disabled' : ''}} onclick="permissionUpdate('{{ $data->id }}-{{ $permission->id }}')">
                                        
                                        <label for="default-checkbox" class="ms-2 text-sm font-medium text-gray-900 font-bold dark:text-gray-300 break-all {{$data->name == 'super_admin' ? '!text-[#666666]' : ''}}">{{($permission->name)}}</label>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@section('sub-css')

@endsection
@section('sub-script')
    <script>
        function permissionUpdate(permissionId){
            let url = "{{ route('permissionUpdate', 'id') }}";
            url = url.replace('id', permissionId);
            console.log(url);
            $.ajax({
                method: 'get',
                url: url,
                success:function(res){
                    ajax_response(res);
                }
            });
        }
    </script>
@endsection