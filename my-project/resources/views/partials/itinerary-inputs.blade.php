@foreach ($tour->itineraries as $index => $itinerary)

{{------------ Single Itinerary -------------}}
<div class="row row-cols-1 row-cols-lg-4 itinerary-container border rounded-3 py-1 mb-4 mx-auto position-relative">
    {{-- Day --}}
    <div class="col input-container">
        <div class="position-relative">
            <input id="day-{{$index}}" type="text"
                class="form-control text-light position-relative @error('itineraries.'.$index.'.day') is-invalid @enderror"
                name="itineraries[{{$index}}][day]"
                value="{{ old('itineraries.'.$index.'.day', $itinerary->day ?? '') }}" required autocomplete="off"
                autofocus>
            <label for="day-{{$index}}">{{
                __('static.day')}} *
            </label>
            {{-- Day Error --}}
            @error('itineraries.'.$index.'.day')
            @include('partials.input-validation-error-msg')
            @enderror
            {{-- Input instructions --}}
            @include('partials.input-instruction', ['instructionMessages' =>
            __('input-instruction.name') ])
        </div>
    </div>

    {{-- Start Time --}}
    <div class="col input-container">
        <div class="position-relative">
            <input id="start-time-{{$index}}" type="time"
                class="form-control custom-time text-light position-relative @error('itineraries.'.$index.'.start_at') is-invalid @enderror"
                name="itineraries[{{$index}}][start_at]" value="{{ old('itineraries.'.$index.'.start_at',
                App\Helpers\DateTimeHelper::formatTime($itinerary->start_at) ?? '') }}" required autocomplete="off"
                autofocus>
            <label for="start-time-{{$index}}">{{
                __('itineraries.start_time')}} *
            </label>
            {{-- Start time Error --}}
            @error('itineraries.'.$index.'.start_at')
            @include('partials.input-validation-error-msg')
            @enderror
        </div>
    </div>

    {{-- Lunch Time --}}
    <div class="col input-container">
        <div class="position-relative">
            <input id="lunch-time-{{$index}}" type="time"
                class="form-control custom-time text-light position-relative @error('itineraries.'.$index.'.lunch_time') is-invalid @enderror"
                name="itineraries[{{$index}}][lunch_time]" value="{{ old('itineraries.'.$index.'.lunch_time',
                App\Helpers\DateTimeHelper::formatTime($itinerary->lunch_time) ?? '') }}" required autocomplete="off"
                autofocus>
            <label for="lunch-time-{{$index}}">
                {{__('itineraries.lunch_time')}} *
            </label>
            {{-- Lunch time Error --}}
            @error('itineraries.'.$index.'.lunch_time')
            @include('partials.input-validation-error-msg')
            @enderror
        </div>
    </div>

    {{-- End Time --}}
    <div class="col input-container">
        <div class="position-relative">
            <input id="end-time-{{$index}}" type="time"
                class="form-control custom-time text-light position-relative @error('itineraries.'.$index.'.end_at') is-invalid @enderror"
                name="itineraries[{{$index}}][end_at]" value="{{ old('itineraries.'.$index.'.end_at', App\Helpers\DateTimeHelper::formatTime($itinerary->end_at) ??
            '') }}" required autocomplete="off" autofocus>
            <label for="end-time-{{$index}}">{{
                __('itineraries.end_time')}} *
            </label>
            {{-- end time Error --}}
            @error('itineraries.'.$index.'.end_at')
            @include('partials.input-validation-error-msg')
            @enderror
        </div>
    </div>

    {{-- Activities --}}
    <div class="col col-lg-12 input-container">
        <div class="position-relative">
            <textarea id="activities-{{$index}}" name="itineraries[{{$index}}][activities]"
                class="form-control @error('itineraries.'.$index.'.activities') is-invalid @enderror" rows="2"
                maxlength="500" required autocomplete="off"
                autofocus>{{ old("itineraries.$index.activities", $itinerary->activities ?? '') }}</textarea>
            <label for="activities-{{$index}}">
                {{__('static.activities')}} *
            </label>
            {{-- activities Error --}}
            @error('itineraries.'.$index.'.activities')
            @include('partials.input-validation-error-msg')
            @enderror
            {{-- Input instructions --}}
            @include('partials.input-instruction', ['instructionMessages' =>
            __('input-instruction.description') ])
        </div>
    </div>

    {{-- Delete Itinerary --}}
    <div class="w-auto p-0 position-absolute top-0 end-0 translate-middle">
        <button class="btn-sm bg-danger rounded-5" onclick="removeItinerary(this)">
            <i class="bi bi-trash3 text-light"></i>
        </button>
    </div>
</div>
{{-- ------- End Single Itinerary ------- --}}

@endforeach
