{{--
    This partial view renders a single environment field for the Persian Gulf theme.
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
    $commonInputClasses = 'mt-1 block w-full py-2.5 px-4 text-sm rounded-lg shadow-sm transition-colors duration-150 ease-in-out';
    $normalBorderClasses = 'border-gray-300 dark:border-slate-600';
    $errorBorderClasses = 'border-red-500 dark:border-red-400 ring-1 ring-red-500 dark:ring-red-400';
    $focusClasses = 'focus:border-teal-500 dark:focus:border-teal-400 focus:ring-2 focus:ring-teal-500/50 dark:focus:ring-teal-400/50 focus:outline-none';
    $textAndBgClasses = 'bg-white dark:bg-slate-700 text-gray-800 dark:text-gray-200 placeholder-gray-400 dark:placeholder-gray-500';
@endphp

<div class="col-span-1">
    <label for="{{ $fieldId }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
        {{ isset($field['label_key']) ? __($field['label_key']) : $key }}
        @if($isRequired)
            <span class="text-red-500 dark:text-red-400">*</span>
        @endif
    </label>

    @if($field['type'] === 'select' && isset($field['options']) && is_array($field['options']))
        <select name="{{ $key }}" id="{{ $fieldId }}"
                class="{{ $commonInputClasses }} {{ $textAndBgClasses }} @error($key) {{ $errorBorderClasses }} @else {{ $normalBorderClasses }} @enderror {{ $focusClasses }}">
            @foreach($field['options'] as $optionValue => $optionLabelKey)
                <option value="{{ $optionValue }}" {{ (string)$currentValue === (string)$optionValue ? 'selected' : '' }}>
                    {{ __($optionLabelKey) }}
                </option>
            @endforeach
        </select>

    @elseif($field['type'] === 'textarea')
        <textarea name="{{ $key }}" id="{{ $fieldId }}" rows="3"
                  class="{{ $commonInputClasses }} {{ $textAndBgClasses }} @error($key) {{ $errorBorderClasses }} @else {{ $normalBorderClasses }} @enderror {{ $focusClasses }}"
                  placeholder="{{ isset($field['placeholder_key']) ? __($field['placeholder_key']) : '' }}">{{ $currentValue }}</textarea>

    @else {{-- Default to text, password, or number input type --}}
        <input type="{{ $field['type'] === 'password' ? 'password' : ($field['type'] === 'number' ? 'number' : 'text') }}"
               name="{{ $key }}" id="{{ $fieldId }}" value="{{ $currentValue }}"
               class="{{ $commonInputClasses }} {{ $textAndBgClasses }} @error($key) {{ $errorBorderClasses }} @else {{ $normalBorderClasses }} @enderror {{ $focusClasses }}"
               placeholder="{{ isset($field['placeholder_key']) ? __($field['placeholder_key']) : '' }}">
    @endif

    @if(isset($field['help_key']) && !empty($field['help_key']))
        <p class="mt-1.5 text-xs text-gray-500 dark:text-gray-400">{{ __($field['help_key']) }}</p>
    @endif

    @error($key)
        <p class="mt-1.5 text-xs text-red-600 dark:text-red-400">{{ $message }}</p>
    @enderror
</div>
