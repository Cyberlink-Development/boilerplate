@extends('admin.common.master')
@section('page_sub_title')
    ~ Permission Details
@endsection
@section('sub-content')
    <div>
        <div class="rounded overflow-hidden shadow bg-white w-full mb-[1rem]">
            <div class="px-6 py-2 border-b border-light-grey flex justify-between">
                <div class="font-bold text-xl">{{name_deformat($data->name)}} ~ Details</div>
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
                                        Roles
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-300">
                                @php
                                    $c = 1;
                                @endphp
                                @foreach($roles as $row)
                                    @if(get_permissions_roles($row))
                                        <tr class="whitespace-nowrap text-start">
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{$c++}}
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    {{name_deformat($row->name)}}
                                                </div>
                                            </td>
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