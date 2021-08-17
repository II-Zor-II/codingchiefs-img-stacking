@extends('layout')
@section('title', env('APP_NAME'))

@push('styles')
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
@endpush

@section('body')
    <div id="app">
        <div class="container">
            <albums></albums>
            <upload-image-form></upload-image-form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ mix('js/manifest.js') }}"></script>
    <script src="{{ mix('js/vendor.js') }}"></script>
    <script src="{{ mix('js/app.js') }}"></script>
@endpush
<script>
    import Albums from "../js/components/Albums";
    export default {
        components: {Albums}
    }
</script>
