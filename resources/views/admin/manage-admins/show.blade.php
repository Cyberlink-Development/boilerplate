@extends('admin.common.master')
@section('page_sub_title')
    ~ Admin Details
@endsection
@section('sub-content')
    <div>
        <div class="rounded overflow-hidden shadow bg-white w-full mb-[1rem]">
            <div class="px-6 py-2 border-b border-light-grey flex justify-between">
                <div class="font-bold text-xl">{{name_deformat($data->name)}} ~ Details</div>
            </div>
        </div>

        <div class=" space-y-[1.5rem]">
            <div class="bg-[#66666622] px-6 pt-2 pb-1.5 border-b border-gray-200 shadow flex flex-row justify-between items-center">
                <div class="flex flex-col space-y-[1rem]">
                    <div>
                        <span class="font-bold">Name :</span> {{name_deformat($data->name)}}
                    </div>
                    <div>
                        <span class="font-bold">Email :</span> {{$data->email}}
                    </div>
                    <div>
                        <span class="font-bold">Email Verified At :</span> {{$data->email_verified_at->format('Y-m-d')}}
                    </div>
                    @if($data->phone)
                        <div>
                            <span class="font-bold">Phone :</span> {{$data->phone}}
                        </div>
                    @endif
                    <div>
                        <span class="font-bold">Role :</span> {{name_deformat($data->roles->first()->name)}}
                    </div>
                </div>
                <div>
                    <img src="{{$data->image ? asset('/admin/images/profile/'.$data->image) : asset('/admin/images/default/default-profile.png')}}" alt="" class="h-[10rem] w-auto">
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
                                            Role
                                        </th>
                                        <th class="px-6 py-2 text-normal text-white">
                                            Gurd Name
                                        </th>
                                        <th class="px-6 py-2 text-normal text-white">
                                            Created_at
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-300">
                                    @php
                                        $c = 1;
                                    @endphp
                                    <tr class="whitespace-nowrap text-start">
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{$c++}}
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                {{name_deformat($role->name)}}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ucfirst($role->guard_name)}}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{$role->created_at->format('Y-m-d')}}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
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
                                            Permissions
                                        </th>
                                        <th class="px-6 py-2 text-normal text-white">
                                            Gurd Name
                                        </th>
                                        <th class="px-6 py-2 text-normal text-white">
                                            Created_at
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-300">
                                    @php
                                        $c = 1;
                                    @endphp
                                    @foreach($permissions as $row)
                                            <tr class="whitespace-nowrap text-start">
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    {{$c++}}
                                                </td>
                                                <td class="px-6 py-4">
                                                    <div class="text-sm text-gray-900">
                                                        {{name_deformat($row->name)}}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    {{ucfirst($row->guard_name)}}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    {{$row->created_at->format('Y-m-d')}}
                                                </td>
                                            </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection