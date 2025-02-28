@php
$fullStars = floor($rating); // Number of full stars
$halfStar = (round($rating - $fullStars, 1)) >= 0.40 ? true : false; // Check for half stars
$emptyStars = 5 - $fullStars - ($halfStar ? 1 : 0); // Empty stars
@endphp
<span>
    @for ($i = 0; $i < $fullStars; $i++) <i class="bi bi-star-fill text-warning"></i>
        @endfor

        @if ($halfStar)
        <i class="bi bi-star-half text-warning"></i>
        @endif

        @for ($i = 0; $i < $emptyStars; $i++) <i class="bi bi-star text-secondary"></i>
            @endfor
</span>
<span class="text-secondary">
    ({{$rating}})
</span>
