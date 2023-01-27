<section class="w-[220px]">
    <div class="carousel__header py-2 text-center">
        <h3 class="carousel__heading text-2xl font-mono	">
            {{ __('user.top-uploaders-count') }}
        </h3>
    </div>
    <div class="panel-body w-[220px]">
        <ul>
            @foreach ($uploaders as $key => $uploader)
                <li>
                    <x-home.row :uploader="$uploader" :key="$loop"/>
                </li>
            @endforeach
        </ul>
    </div>
</section>
