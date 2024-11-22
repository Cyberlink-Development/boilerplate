@extends('admin.common.master')
@section('page_sub_title')
    ~ Site Settings
@endsection
@section('sub-content')
    <div>
        <div class="rounded overflow-hidden shadow bg-white w-full mb-[1rem]">
            <div class="px-6 py-2 border-b border-light-grey flex justify-between">
                <div class="font-bold text-xl">Site Settings</div>
            </div>
        </div>
        <div>
            <form action="{{route('site-settings.store')}}" method="post" enctype="multipart/form-data">
                @csrf
                @if($data->id ?? false)
                    <input type="hidden" name="id" value="{{ $data->id }}">
                @endif
                <div class="grid md:grid-cols-3 gap-[1rem] md:gap-[2rem]">
                    <div class="h-fit md:col-span-2 shadow px-[3rem] py-[1.5rem] bg-[#66666622] space-y-[1.5rem]">
                        <div class="grid lg:grid-cols-12">
                            <label for="site_name" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Site Name:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="text" name="site_name" value="{{ $data->site_name ?? '' }}" id="site_name" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full" autofocus>
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="email_primary" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Email Primary:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="email" name="email_primary" value="{{ $data->email_primary ?? '' }}" id="email_primary" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full">
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="email_secondary" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Email Secondary:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="email" name="email_secondary" value="{{ $data->email_secondary ?? '' }}" id="email_secondary" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full">
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="phone" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Phone:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="text" name="phone" id="phone" value="{{ $data->phone ?? '' }}" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full">
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="facebook_link" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Facebook Link:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="url" name="facebook_link" id="facebook_link" value="{{ $data->facebook_link ?? '' }}" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full">
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="linkedin_link" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Linkedin Link:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="url" name="linkedin_link" id="linkedin_link" value="{{ $data->linkedin_link ?? '' }}"  class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full">
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="youtube_link" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Youtube Link:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="url" name="youtube_link" id="youtube_link" value="{{ $data->youtube_link ?? '' }}" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full">
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="twitter_link" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Twitter Link:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="url" name="twitter_link" id="twitter_link" value="{{ $data->twitter_link ?? '' }}" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full">
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="instagram__link" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Instagram Link:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="url" name="instagram__link" id="instagram__link" value="{{ $data->instagram__link ?? '' }}" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full">
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="google_map" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Google Map:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="url" name="google_map" id="google_map" value="{{ $data->google_map ?? '' }}" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full">
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="welcome_title" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Welcome Text:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="text" name="welcome_title" id="welcome_title" value="{{ $data->welcome_title ?? '' }}" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full">
                            </div>
                        </div>
                        <div class="grid lg:grid-cols-12">
                            <label for="copyright_text" class="lg:col-span-2 text-gray-900 pt-[.5rem] mb-0 lg:text-right">Copyright Text:</label>
                            <div class="lg:col-span-1"></div>
                            <div class="lg:col-span-9">
                                <input type="text" name="copyright_text" id="copyright_text" value="{{ $data->copyright_text ?? '' }}" class="h-[39px] px-[9px] py-[12px] text-[13px] text-[#555555] border border-[#eeeeee] w-full">
                            </div>
                        </div>
                    </div>
                    <div class="h-fit md:col-span-1 shadow bg-[#66666622] px-[3rem] py-[1.5rem] space-y-[1.5rem]">
                        <div class="bg-white p-[.5rem] flex">
                            <button type="submit" class="ml-auto focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-xs px-4 py-2">Submit</button>
                        </div>
                        <div class="bg-white p-[.5rem] flex flex-col gap-[.4rem]">
                            <div class="flex flex-col gap-[.4rem]">
                                <label for="logo" class="lg:col-span-2 text-[#222] bg-[#66666622] mb-0 text-left">Logo:</label>
                                <input type="file" name="logo" id="logo" class="bg-[#66666622]">
                            </div>
                            @if(!empty($data->logo))
                                <div class="flex" id="siteLogoImage">
                                    <img src="{{asset('template-assets/images/' . $data->logo )}}" width="150" class="mr-[.4rem]" alt="{{ $data->name}}"/>
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
                let setting_id = $(this).attr('data-id')
                let url = "{{ route('delete-logo', 'id') }}"
                url = url.replace('id', setting_id);
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
                            $('#siteLogoImage').remove();
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