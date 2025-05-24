{{--
    This partial view renders a single environment field.
    It expects the following variables:
    - $key: The .env key (e.g., 'APP_NAME')
    - $field: An array containing field details:
        - 'label_key': (string) The translation key for the display label.
        - 'type': (string) Input type ('text', 'password', 'select', 'textarea', 'number').
        - 'rules': (string, optional) Laravel validation rules.
        - 'default': (mixed, optional) Default value for the field.
        - 'options': (array, optional) Key-value pairs for 'select' type, where values are translation keys.
        - 'help_key': (string, optional) The translation key for a short help text.
        - 'placeholder_key': (string, optional) The translation key for the placeholder text.
    - $currentEnvValues: An array of current .env values, keyed by the .env key.
--}}

@php
    $fieldId = 'env_'.strtolower(str_replace('.', '_', $key));
    $currentValue = old($key, $currentEnvValues[$key] ?? ($field['default'] ?? ''));
    $isRequired = isset($field['rules']) && str_contains($field['rules'], 'required');
@endphp

<div class="col-span-1">
    <label for="{{ $fieldId }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{-- Translate the label --}}
        {{ isset($field['label_key']) ? __($field['label_key']) : $key }}
        @if($isRequired)
            <span class="text-red-500">*</span>
        @endif
    </label>

    @if($field['type'] === 'select' && isset($field['options']) && is_array($field['options']))
        <select name="{{ $key }}" id="{{ $fieldId }}"
                class="mt-1 block w-full py-2 px-3 border @error($key) border-red-500 @else border-gray-300 @enderror bg-white rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm">
            @foreach($field['options'] as $optionValue => $optionLabelKey)
                <option value="{{ $optionValue }}" {{ $currentValue == $optionValue ? 'selected' : '' }}>
                    {{-- Translate the option label --}}
                    {{ __($optionLabelKey) }}
                </option>
            @endforeach
        </select>

    @elseif($field['type'] === 'textarea')
        <textarea name="{{ $key }}" id="{{ $fieldId }}" rows="3"
                  class="mt-1 block w-full py-2 px-3 border @error($key) border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm placeholder-gray-400"
                  placeholder="{{ isset($field['placeholder_key']) ? __($field['placeholder_key']) : '' }}">{{ $currentValue }}</textarea>

    @else {{-- Default to text or password input type --}}
        <input type="{{ $field['type'] === 'password' ? 'password' : ($field['type'] === 'number' ? 'number' : 'text') }}"
               name="{{ $key }}" id="{{ $fieldId }}" value="{{ $currentValue }}"
               class="mt-1 block w-full py-2 px-3 border @error($key) border-red-500 @else border-gray-300 @enderror rounded-md shadow-sm focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm placeholder-gray-400"
               placeholder="{{ isset($field['placeholder_key']) ? __($field['placeholder_key']) : '' }}">
    @endif

    @if(isset($field['help_key']) && !empty($field['help_key']))
        {{-- Translate the help text --}}
        <p class="mt-1 text-xs text-gray-500">{{ __($field['help_key']) }}</p>
    @endif

    @error($key)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p> {{-- Laravel's validation messages are usually already translatable --}}
    @enderror
</div>
