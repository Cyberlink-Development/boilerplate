@extends('admin.common.master')
@section('page_sub_title')
    ~ Edit Role
@endsection
@section('sub-content')
    <div>
        <div class="rounded overflow-hidden shadow bg-white w-full mb-[1rem]">
            <div class="px-6 py-2 border-b border-light-grey flex justify-between">
                <div class="font-bold text-xl">Edit Role</div>
                <div>
                    <a href="{{route('roles.index')}}" class="focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-xs px-4 py-2 mb-2">Back</a>
                </div>
            </div>
        </div>
        <div>
            <form action="{{route('roles.update', $data->id)}}" method="post">
                @method('patch')
                @csrf
                <div class="grid md:grid-cols-3 gap-[1rem] md:gap-[2rem]">
                    <div class="h-fit md:col-span-2 shadow px-[3rem] py-[1.5rem] bg-[#66666622] space-y-[1.5rem]">
                        <div class="grid lg:grid-cols-12">
                            <label for="role_name" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 text-right">Name:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="text" name="role_name" value="{{name_deformat($data->name)}}" id="role_name" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full" required autofocus>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="hierarchy" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 text-right">Role Hierarchy:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="number" name="hierarchy" value="{{$data->hierarchy}}" id="hierarchy" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full" required>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="guard_name" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 text-right">Guard Name:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="text" name="guard_name" value="admin" id="guard_name" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full" readonly required>
                            </div>
                        </div>
                    </div>
                    <div class="h-fit md:col-span-1 shadow bg-[#66666622] px-[3rem] py-[1.5rem] space-y-[1.5rem]">
                        <div class="bg-white p-[.5rem] flex">
                            <button type="submit" class="ml-auto focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-xs px-4 py-2">Submit</button>
                        </div>  
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection