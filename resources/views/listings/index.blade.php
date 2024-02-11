<x-layout>
@include("/partials/_hero")
@include('/partials/_search')
    <div class="lg:grid lg:grid-cols-2 gap-4 space-y-4 md:space-y-0 mx-4">
        @foreach ($Listings as $Listing)
        <!-- Item 1 -->
            <x-listing-card :Listing="$Listing" />
        @endforeach
    </div>

    <div class="mt-4 p-6">
        {{$Listings->links()}}
    </div>
</x-layout>
