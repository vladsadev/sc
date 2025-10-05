@if(session('success'))
    <div class="toast toast-top">
        <div role="alert" class="alert container mx-auto mt-2 alert-success animate-fade-out">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-gray-100">{{session('success')}}</span>
        </div>
    </div>

@elseif(session('fail'))
    <div class="toast toast-top">
        <div role="alert" class="alert alert-error container mx-auto mt-2  animate-fade-out">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 shrink-0 stroke-current" fill="none" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-gray-100">{{session('fail')}}</span>
        </div>
    </div>

@endif
