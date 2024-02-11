@props(['Listing'])

<x-card>
<div class="flex">
        <img
            class="hidden w-48 mr-6 md:block"
            src="{{asset($Listing->image)}}"
            alt=""
        />
        <div>
            <h3 class="text-2xl">
                <a href="<?php echo route('Listings.show',["Listing" => $Listing->id]) ?>">{{$Listing->title}}</a>
            </h3>
            <div class="text-xl font-bold mb-4">{{$Listing->company}}</div>
            <x-listing-tags :tags="$Listing->tags"/>
            <div class="text-lg mt-4">
                <i class="fa-solid fa-location-dot"></i> {{$Listing->location}}
            </div>
        </div>
    </div>

</x-card>
