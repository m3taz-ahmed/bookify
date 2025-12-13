<x-filament-panels::page>
    <div>
        <div class="space-y-6">
            <!-- Summary table -->
            <x-filament::card class="activity-log-card" style="padding: 0px !important;">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 activity-log-card-title">@lang('filament.Activity Log Summary')</h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left divide-y divide-gray-200 dark:divide-gray-700 activity-log-table">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider activity-log-th">
                                    @lang('filament.Log Name')
                                </th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider activity-log-th">
                                    @lang('filament.Description')
                                </th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider activity-log-th">
                                    @lang('filament.Subject Type')
                                </th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider activity-log-th">
                                    @lang('filament.Subject ID')
                                </th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider activity-log-th">
                                    @lang('filament.User')
                                </th>
                                <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider activity-log-th">
                                    @lang('filament.Created At')
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                            <tr class="activity-log-tr">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white activity-log-td">
                                    {{ $activity->log_name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white activity-log-td">
                                    {{ $activity->description ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white activity-log-td">
                                    {{ $activity->subject_type ? class_basename($activity->subject_type) : 'N/A' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white activity-log-td">
                                    {{ $activity->subject_id ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white activity-log-td">
                                    <div>
                                        <div>{{ $activity->causer?->name ?? __('filament.Unknown') }}</div>
                                        @if($activity->causer?->email)
                                            <div class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                                {{ $activity->causer->email }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900 dark:text-white activity-log-td">
                                    <div>
                                        <div>{{ $activity->created_at?->format('M j, Y g:i A') ?? 'N/A' }}</div>
                                        @if($activity->updated_at && $activity->updated_at != $activity->created_at)
                                            <div class="text-gray-500 dark:text-gray-400 text-xs mt-1">
                                                @lang('filament.Updated At'): {{ $activity->updated_at->format('M j, Y g:i A') }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </x-filament::card>

            <!-- Changes table -->
            <x-filament::card class="activity-log-card">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 activity-log-card-title">@lang('filament.Changes')</h3>
                
                @php
                    $properties = $activity->properties;
                    $attributes = [];
                    $old = [];
                    
                    // Handle different possible data structures
                    if ($properties instanceof \Illuminate\Support\Collection) {
                        if ($properties->offsetExists('attributes')) $attributes = (array) $properties['attributes'];
                        if ($properties->offsetExists('old')) $old = (array) $properties['old'];
                    } else if (is_object($properties)) {
                        if (isset($properties->attributes)) $attributes = (array) $properties->attributes;
                        if (isset($properties->old)) $old = (array) $properties->old;
                    } else if (is_array($properties)) {
                        if (isset($properties['attributes'])) $attributes = (array) $properties['attributes'];
                        if (isset($properties['old'])) $old = (array) $properties['old'];
                    }
                    
                    // Define fields to exclude from changes display
                    $excludedFields = ['updated_at'];
                @endphp
                
                @if(!empty($attributes) || !empty($old))
                    <div class="overflow-x-auto">
                        <table class="w-full text-left divide-y divide-gray-200 dark:divide-gray-700 activity-log-table">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                                <tr>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider activity-log-th">
                                        @lang('filament.Change')
                                    </th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider activity-log-th">
                                        @lang('filament.From')
                                    </th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider activity-log-th">
                                        @lang('filament.To')
                                    </th>
                                    <th class="px-4 py-3 text-sm font-semibold text-gray-900 dark:text-white uppercase tracking-wider activity-log-th">
                                        @lang('filament.Time')
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($attributes as $key => $newValue)
                                    @php
                                        // Skip excluded fields
                                        if (in_array($key, $excludedFields)) {
                                            continue;
                                        }
                                        
                                        $oldValue = $old[$key] ?? null;
                                        $hasChanged = $oldValue !== null && $oldValue != $newValue;
                                    @endphp
                                    
                                    @if($hasChanged)
                                        <tr class="activity-log-tr">
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white activity-log-td">
                                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 activity-log-td">
                                                @if(is_array($oldValue) || is_object($oldValue))
                                                    <pre class="text-red-600 dark:text-red-400 line-through activity-log-pre">{{ json_encode($oldValue, JSON_PRETTY_PRINT) }}</pre>
                                                @else
                                                    <span class="text-red-600 dark:text-red-400 line-through activity-log-span">
                                                        {!! formatActivityLogValue($oldValue, $key) !!}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 activity-log-td">
                                                @if(is_array($newValue) || is_object($newValue))
                                                    <pre class="text-green-600 dark:text-green-400 font-medium activity-log-pre">{{ json_encode($newValue, JSON_PRETTY_PRINT) }}</pre>
                                                @else
                                                    <span class="text-green-600 dark:text-green-400 font-medium activity-log-span">
                                                        {!! formatActivityLogValue($newValue, $key) !!}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 activity-log-td">
                                                {{ $activity->created_at?->format('M j, Y g:i A') ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    @elseif($oldValue === null)
                                        <tr class="activity-log-tr">
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white activity-log-td">
                                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 activity-log-td">
                                                <span class="italic text-gray-400 dark:text-gray-500 activity-log-span">@lang('filament.Not Set')</span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 activity-log-td">
                                                @if(is_array($newValue) || is_object($newValue))
                                                    <pre class="text-blue-600 dark:text-blue-400 font-medium activity-log-pre">{{ json_encode($newValue, JSON_PRETTY_PRINT) }}</pre>
                                                @else
                                                    <span class="text-blue-600 dark:text-blue-400 font-medium activity-log-span">
                                                        {!! formatActivityLogValue($newValue, $key) !!}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 activity-log-td">
                                                {{ $activity->created_at?->format('M j, Y g:i A') ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                                
                                @foreach($old as $key => $oldValue)
                                    @php
                                        // Skip excluded fields
                                        if (in_array($key, $excludedFields)) {
                                            continue;
                                        }
                                    @endphp
                                    
                                    @if(!array_key_exists($key, $attributes))
                                        <tr class="activity-log-tr">
                                            <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white activity-log-td">
                                                {{ ucfirst(str_replace('_', ' ', $key)) }}
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 activity-log-td">
                                                @if(is_array($oldValue) || is_object($oldValue))
                                                    <pre class="text-red-600 dark:text-red-400 line-through activity-log-pre">{{ json_encode($oldValue, JSON_PRETTY_PRINT) }}</pre>
                                                @else
                                                    <span class="text-red-600 dark:text-red-400 line-through activity-log-span">
                                                        {!! formatActivityLogValue($oldValue, $key) !!}
                                                    </span>
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 activity-log-td">
                                                <span class="italic text-gray-400 dark:text-gray-500 activity-log-span">@lang('filament.Removed')</span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400 activity-log-td">
                                                {{ $activity->created_at?->format('M j, Y g:i A') ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-8">
                        <x-filament::icon
                            icon="heroicon-o-information-circle"
                            class="mx-auto h-12 w-12 text-gray-400 dark:text-gray-500"
                        />
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">@lang('filament.No changes recorded')</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                            @lang('filament.This activity log entry does not contain any property changes.')
                        </p>
                    </div>
                @endif
            </x-filament::card>

            @if($activity->event)
                <x-filament::card class="activity-log-card">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2 activity-log-card-title">@lang('filament.Event')</h3>
                    <p class="text-gray-700 dark:text-gray-300 activity-log-card-content">
                        {{ $activity->event }}
                    </p>
                </x-filament::card>
            @endif
        </div>

        <!-- Inline Styles -->
        <style>
            /* Card styles */
            .activity-log-card {
                border-radius: 0.5rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
                padding: 1.5rem;
                background-color: #ffffff;
                border: 1px solid #e5e7eb;
                margin-bottom: 20px;
            }
            
            .dark .activity-log-card {
                background-color: #1f2937;
                border-color: #374151;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.2), 0 1px 2px 0 rgba(0, 0, 0, 0.1);
            }
            
            .activity-log-card-title {
                font-size: 1.125rem;
                font-weight: 600;
                margin-bottom: 0.5rem;
            }
            
            .activity-log-card-content {
                font-size: 1rem;
                line-height: 1.5;
            }
            
            .activity-log-card-subcontent {
                font-size: 0.875rem;
                line-height: 1.5;
            }
            
            /* Table styles */
            .activity-log-table {
                width: 100%;
                text-align: left;
                border-collapse: collapse;
            }
            
            .activity-log-th {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 0.05em;
                background-color: #f9fafb;
                border-bottom: 1px solid #e5e7eb;
            }
            
            .dark .activity-log-th {
                background-color: #1f2937;
                border-color: #374151;
                color: #ffffff;
            }
            
            .activity-log-tr {
                border-bottom: 1px solid #e5e7eb;
            }
            
            .dark .activity-log-tr {
                border-color: #374151;
            }
            
            .activity-log-td {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
                white-space: nowrap;
            }
            
            .dark .activity-log-td {
                color: #d1d5db;
            }
            
            /* Status badge styles */
            .activity-log-status-badge {
                display: inline-block;
                padding: 0.25rem 0.5rem;
                border-radius: 9999px;
                font-size: 0.75rem;
                font-weight: 500;
                line-height: 1;
            }
            
            .activity-log-status-pending {
                background-color: #fef3c7;
                color: #92400e;
            }
            
            .dark .activity-log-status-pending {
                background-color: #78350f;
                color: #fef3c7;
            }
            
            .activity-log-status-confirmed {
                background-color: #d1fae5;
                color: #065f46;
            }
            
            .dark .activity-log-status-confirmed {
                background-color: #065f46;
                color: #d1fae5;
            }
            
            .activity-log-status-cancelled {
                background-color: #fee2e2;
                color: #991b1b;
            }
            
            .dark .activity-log-status-cancelled {
                background-color: #7f1d1d;
                color: #fee2e2;
            }
            
            .activity-log-status-completed {
                background-color: #dbeafe;
                color: #1e40af;
            }
            
            .dark .activity-log-status-completed {
                background-color: #1e3a8a;
                color: #dbeafe;
            }
            
            .activity-log-payment-paid {
                background-color: #d1fae5;
                color: #065f46;
            }
            
            .dark .activity-log-payment-paid {
                background-color: #065f46;
                color: #d1fae5;
            }
            
            .activity-log-payment-refunded {
                background-color: #f3e8ff;
                color: #6b21a8;
            }
            
            .dark .activity-log-payment-refunded {
                background-color: #5b21b6;
                color: #f3e8ff;
            }
            
            .activity-log-payment-pending {
                background-color: #fef3c7;
                color: #92400e;
            }
            
            .dark .activity-log-payment-pending {
                background-color: #78350f;
                color: #fef3c7;
            }
            
            .activity-log-boolean-true {
                background-color: #d1fae5;
                color: #065f46;
            }
            
            .dark .activity-log-boolean-true {
                background-color: #065f46;
                color: #d1fae5;
            }
            
            .activity-log-boolean-false {
                background-color: #fee2e2;
                color: #991b1b;
            }
            
            .dark .activity-log-boolean-false {
                background-color: #7f1d1d;
                color: #fee2e2;
            }
            
            /* Preformatted text */
            .activity-log-pre {
                overflow: auto;
                max-width: 24rem;
                font-size: 0.75rem;
                line-height: 1rem;
                margin: 0;
                padding: 0.5rem;
                border-radius: 0.25rem;
                background-color: #f9fafb;
            }
            
            .dark .activity-log-pre {
                background-color: #111827;
                color: #d1d5db;
            }
            
            /* Span elements */
            .activity-log-span {
                font-size: 0.875rem;
                line-height: 1.25rem;
            }
            
            /* No changes message */
            .text-center {
                text-align: center;
            }
            
            .py-8 {
                padding-top: 2rem;
                padding-bottom: 2rem;
            }
            
            .mt-2 {
                margin-top: 0.5rem;
            }
            
            .mt-1 {
                margin-top: 0.25rem;
            }
            
            .text-sm {
                font-size: 0.875rem;
            }
            
            .font-medium {
                font-weight: 500;
            }
            
            .text-xs {
                font-size: 0.75rem;
            }
        </style>

        <!-- Inline Scripts -->
        <script>
            // Helper function for capitalizing first letter
            function ucfirst(string) {
                return string.charAt(0).toUpperCase() + string.slice(1);
            }
        </script>
    </div>
</x-filament-panels::page>