@props(['job'])
<x-panel class="flex gap-3">
    <!-- Image -->
    <div class="bg-black rounded-xl">
{{--        <x-employer-logo :width="100"/>--}}
    </div>

    <div class="flex-1 flex flex-col py-2 px-4">
{{--        <a class="text-sm text-gray-400">{{$job->employer->name}}</a>--}}
        <a class="text-sm text-gray-400">ok</a>
        <h3 class="mt-2 font-bold text-xl group-hover:text-blue-900 transition-colors duration-300">Tit</h3>
{{--        <p class="mt-auto text-xs">{{$job->location}} - From {{$job->salary}}</p>--}}
        <p class="mt-auto text-xs">Ubicacion </p>
    </div>

    <!-- schedule and Tags -->
    <div class="flex flex-col justify-between items-end">
        <div>
{{--            <x-tag class="bg-black">{{$job->schedule}}</x-tag>--}}
            <x-tag>{{rand(3,8)}}h</x-tag>
        </div>
        <div>
{{--            @foreach($job->tags as $tag)--}}
{{--                <x-tag :$tag/>--}}
{{--            @endforeach--}}
            <x-tag>Backend</x-tag>
            <x-tag>Frontend</x-tag>
            <x-tag>Web stack</x-tag>
        </div>
    </div>
</x-panel>
