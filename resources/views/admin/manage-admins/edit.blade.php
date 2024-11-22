@extends('admin.common.master')
@section('page_sub_title')
    ~ Edit Admin
@endsection
@section('sub-content')
    <div>
        <div class="rounded overflow-hidden shadow bg-white w-full mb-[1rem]">
            <div class="px-6 py-2 border-b border-light-grey flex justify-between">
                <div class="font-bold text-xl">Edit Admin</div>
                <div>
                    <a href="{{route('manage-admins.index')}}" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-xs px-4 py-2 mb-2">Back</a>
                </div>
            </div>
        </div>
        <div>
            <form action="{{route('manage-admins.update', $data->id)}}" method="post" enctype="multipart/form-data">
                @method('patch')
                @csrf
                <div class="grid md:grid-cols-3 gap-[1rem] md:gap-[2rem]">
                    <div class="md:col-span-2 shadow px-[3rem] py-[1.5rem] bg-[#66666622] space-y-[1.5rem]">
                        <div class="grid lg:grid-cols-12">
                            <label for="admin_name" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Name:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="text" name="admin_name" value="{{name_deformat($data->name)}}" id="admin_name" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full" required autofocus>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="email" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Email:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="email" name="admin_email" value="{{$data->email}}" id="email" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full" required>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="phone" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Phone:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="text" name="phone" id="phone" value="{{$data->phone}}" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full" required>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="pin" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Pin:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="number" name="pin" value="{{$data->pin}}" id="pin" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full" required>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="password" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Password:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="password" name="password" id="password" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full">
                            </div>
                        </div>
                    </div>
                    <div class="md:col-span-1 shadow bg-[#66666622] px-[3rem] py-[1.5rem] space-y-[1.5rem]">
                        <div class="bg-white p-[.5rem] flex">
                            <button type="submit" class="ml-auto focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-xs px-4 py-2">Submit</button>
                        </div>
                        <div class="bg-white p-[.5rem] flex flex-col gap-[.2rem]">
                            <label for="image" class="lg:col-span-2 text-[#222] bg-[#66666622] mb-0 text-left">Role:</label>
                            <select name="role" id="role" required>
                                <option value="">Choose a role</option>
                                @foreach($roleData as $row)
                                    @if(compare_roles_hierarchy_with_roles($row))
                                        <option value="{{$row->id}}" {{get_admin_role($data->id) == name_deformat($row->name) ? 'selected' : ''}}>{{name_deformat($row->name)}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="bg-white p-[.5rem] flex flex-col gap-[.4rem]">
                            <div class="flex flex-col gap-[.4rem]">
                                <label for="image" class="lg:col-span-2 text-[#222] bg-[#66666622] mb-0 text-left">Profile Image:</label>
                                <input type="file" name="image" id="image" class="bg-[#66666622]">
                            </div>
                            @if($data->image)
                                <div class="flex" id="adminProfileImage">
                                    <img src="{{asset('admin/images/profile/' . $data->image )}}" width="150" class="mr-[.4rem]" alt="{{ $data->name}}"/>
                                    <span class="remove-btn d-btn" data-id="{{ $data->id }}" onclick="">X</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('sub-css')
    <style>
        .remove-btn{
        cursor: pointer;
        height: max-content;
        padding: .5rem;
        background-color: #dfdfdf;
        border-radius: 50%;
        line-height: .5rem;
    }
    </style>
@endsection
@section('sub-script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.remove-btn', function() {
                let admin_id = $(this).attr('data-id')
                let url = "{{ route('delete-admin-image', 'id') }}"
                url = url.replace('id', admin_id);
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
                    $.ajax({
                        method: 'get',
                        url: url,
                        success: function(res) {
                            ajax_response(res);
                            $('#adminProfileImage').remove();
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }
                    })
                    }
                });
            })
        })
    </script>
@endsection