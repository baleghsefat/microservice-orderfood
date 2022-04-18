<?php

if (!function_exists('userServiceRouter')) {
    /**
     * @param string $url URL.
     * @return string
     */
    function userServiceRouter(string $url): string
    {
        return config('microservices.user_service_url') . '/' . $url;
    }
}
