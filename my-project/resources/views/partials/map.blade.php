@vite(['resources/sass/components/map.scss'])
{{-- MAP --}}
<div class="d-flex justify-content-center p-3">
    @foreach ($tour->destinations as $destination)
    <div class="destination" data-lat="{{ $destination->latitude }}" data-lng="{{ $destination->longitude }}"
        data-name="{{$destination->name}}" data-description="{{$destination->description}}">
    </div>
    @endforeach
    <div id="map"></div>
</div>
{{-- <a href="https://www.google.com/maps?q={{ $latitude }},{{ $longitude }}" target="_blank"
    class="nav-link text-secondary">
    Show on Map
</a> --}}

<script src="https://maps.googleapis.com/maps/api/js?key={{ $apiKey }}&callback=initMap" async defer></script>
<script src="{{ asset('js/tour-map.js') }}"></script>
