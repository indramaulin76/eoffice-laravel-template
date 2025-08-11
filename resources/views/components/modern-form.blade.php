<!-- Modern Form Component -->
<div class="modern-form bg-white rounded-lg shadow-sm border border-gray-200">
    <!-- Form Header -->
    @if(isset($title) || isset($subtitle))
    <div class="px-6 py-4 border-b border-gray-200">
        @if(isset($title))
        <h3 class="text-lg font-semibold text-gray-900">{{ $title }}</h3>
        @endif
        @if(isset($subtitle))
        <p class="mt-1 text-sm text-gray-600">{{ $subtitle }}</p>
        @endif
    </div>
    @endif

    <!-- Form Body -->
    <div class="px-6 py-4">
        <form {{ $attributes->merge(['class' => 'space-y-6']) }}>
            @csrf
            {{ $slot }}
            
            <!-- Form Actions -->
            @if(isset($actions))
            <div class="flex items-center justify-end space-x-3 pt-6 border-t border-gray-200">
                {!! $actions !!}
            </div>
            @endif
        </form>
    </div>
</div>

<!-- Form Field Component -->
@php
if (!function_exists('renderFormField')) {
    function renderFormField($type, $name, $label, $options = []) {
        $value = old($name) ?? ($options['value'] ?? '');
        $required = $options['required'] ?? false;
        $placeholder = $options['placeholder'] ?? '';
        $class = 'form-input block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500';
        
        $html = '<div class="form-group">';
        $html .= '<label for="' . $name . '" class="block text-sm font-medium text-gray-700 mb-2">';
        $html .= $label;
        if ($required) $html .= ' <span class="text-red-500">*</span>';
        $html .= '</label>';
        
        switch ($type) {
            case 'text':
            case 'email':
            case 'password':
            case 'number':
            case 'date':
            case 'time':
            case 'datetime-local':
                $html .= '<input type="' . $type . '" name="' . $name . '" id="' . $name . '" value="' . htmlspecialchars($value) . '" placeholder="' . $placeholder . '" class="' . $class . '"' . ($required ? ' required' : '') . '>';
                break;
                
            case 'textarea':
                $rows = $options['rows'] ?? 3;
                $html .= '<textarea name="' . $name . '" id="' . $name . '" rows="' . $rows . '" placeholder="' . $placeholder . '" class="' . $class . '"' . ($required ? ' required' : '') . '>' . htmlspecialchars($value) . '</textarea>';
                break;
                
            case 'select':
                $selectOptions = $options['options'] ?? [];
                $html .= '<select name="' . $name . '" id="' . $name . '" class="' . $class . '"' . ($required ? ' required' : '') . '>';
                $html .= '<option value="">Pilih ' . $label . '</option>';
                foreach ($selectOptions as $optValue => $optLabel) {
                    $selected = $value == $optValue ? ' selected' : '';
                    $html .= '<option value="' . $optValue . '"' . $selected . '>' . $optLabel . '</option>';
                }
                $html .= '</select>';
                break;
                
            case 'file':
                $accept = $options['accept'] ?? '';
                $html .= '<input type="file" name="' . $name . '" id="' . $name . '" accept="' . $accept . '" class="' . $class . '"' . ($required ? ' required' : '') . '>';
                break;
        }
        
        // Error message
        $html .= '<div class="text-red-600 text-sm mt-1" id="error-' . $name . '"></div>';
        $html .= '</div>';
        
        return $html;
    }
}
@endphp
