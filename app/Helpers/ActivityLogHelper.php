<?php

if (!function_exists('formatActivityLogValue')) {
    /**
     * Format activity log values for display
     *
     * @param mixed $value
     * @param string $key
     * @return string
     */
    function formatActivityLogValue($value, $key = '')
    {
        if (is_bool($value)) {
            return $value ? 'Yes' : 'No';
        }
        
        // Format status values
        if (in_array(strtolower($key), ['status', 'payment_status'])) {
            $status = strtolower($value);
            switch ($status) {
                case 'pending':
                    return '<span class="activity-log-status-badge activity-log-status-pending">Pending</span>';
                case 'confirmed':
                    return '<span class="activity-log-status-badge activity-log-status-confirmed">Confirmed</span>';
                case 'cancelled':
                    return '<span class="activity-log-status-badge activity-log-status-cancelled">Cancelled</span>';
                case 'completed':
                    return '<span class="activity-log-status-badge activity-log-status-completed">Completed</span>';
                case 'paid':
                    return '<span class="activity-log-status-badge activity-log-payment-paid">Paid</span>';
                case 'refunded':
                    return '<span class="activity-log-status-badge activity-log-payment-refunded">Refunded</span>';
                default:
                    return ucfirst($value);
            }
        }
        
        // Format boolean values
        if (in_array(strtolower($key), ['is_paid', 'is_active'])) {
            if ($value == 1 || strtolower($value) === 'true') {
                return '<span class="activity-log-status-badge activity-log-boolean-true">Yes</span>';
            } else {
                return '<span class="activity-log-status-badge activity-log-boolean-false">No</span>';
            }
        }
        
        // Format datetime values
        if (is_string($value) && strlen($value) > 19 && strpos($value, 'T') !== false) {
            try {
                $date = \Carbon\Carbon::parse($value);
                return $date->format('M j, Y g:i A');
            } catch (Exception $e) {
                return e($value);
            }
        }
        
        return is_array($value) || is_object($value) ? json_encode($value, JSON_PRETTY_PRINT) : e($value);
    }
}