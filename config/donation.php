<?php

return [
    "enabled" => env("DONATIONS_ENABLED", false),
    "ad_hoc_donations_enabled" => env("AD_HOC_DONATIONS_ENABLED", false),
    "btc_enabled" => env("DONATIONS_BTC_ENABLED", false),
    "btc_address" => env("DONATIONS_BTC_PUBLIC_ADDRESS", 'N/A'),
];
