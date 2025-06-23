<div class="col-md-12">
    <label for="delivery_date"
        class="mb-2"><strong>Expected Delivery Date
            <span class="text-danger">*</span></strong></label>
    <x-input-select :type="'text'" :value="old('delivery_date')" :name="'delivery_date'"
        :id="'delivery_date'">
        <option value="">Select Delivery Date</option>
        @foreach ($deliverySchedules as $key => $date)
            <option value="{{ $date?->format('Y-m-d') }}">
                {{ $date?->format('l d-m-Y') }}</option>
        @endforeach
    </x-input-select>
</div>



@push('css')
<style>
    .select2 {
  width: 100%!important; /* overrides computed width, 100px in your demo */
}
</style>
@endpush

@push('script')
    <script>
        $('#delivery_date').select2({
            placeholder: "Select Delivery Date"
        });
    </script>
@endpush
