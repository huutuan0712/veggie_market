<?php

if (!function_exists('getStatusColor')) {
    function getStatusColor($status)
    {
        return match($status){
        'pending'    => 'bg-yellow-100 text-yellow-800',
            'confirmed'  => 'bg-blue-100 text-blue-800',
            'processing' => 'bg-purple-100 text-purple-800',
            'shipping'   => 'bg-indigo-100 text-indigo-800',
            'delivered'  => 'bg-green-100 text-green-800',
            'cancelled'  => 'bg-red-100 text-red-800',
            default      => 'bg-gray-100 text-gray-800',
        };
    }
}

if (!function_exists('getStatusText')) {
    function getStatusText($status)
    {
        return match($status){
        'pending'    => 'Chờ xử lý',
            'confirmed'  => 'Đã xác nhận',
            'processing' => 'Đang xử lý',
            'shipping'   => 'Đang giao',
            'delivered'  => 'Đã giao',
            'cancelled'  => 'Đã hủy',
            default      => 'Không xác định',
        };
    }
}

if (!function_exists('getStatusIcon')) {
    function getStatusIcon($status)
    {
        return match($status){
        'pending'    => '<svg class="w-4 h-4 text-yellow-500"><circle cx="10" cy="10" r="8"/></svg>',
            'confirmed'  => '<svg class="w-4 h-4 text-blue-500"><circle cx="10" cy="10" r="8"/></svg>',
            'processing' => '<svg class="w-4 h-4 text-purple-500"><circle cx="10" cy="10" r="8"/></svg>',
            'shipping'   => '<svg class="w-4 h-4 text-indigo-500"><circle cx="10" cy="10" r="8"/></svg>',
            'delivered'  => '<svg class="w-4 h-4 text-green-500"><circle cx="10" cy="10" r="8"/></svg>',
            'cancelled'  => '<svg class="w-4 h-4 text-red-500"><line x1="5" y1="5" x2="15" y2="15" stroke="red" /><line x1="15" y1="5" x2="5" y2="15" stroke="red" /></svg>',
            default      => '',
        };
    }
}
