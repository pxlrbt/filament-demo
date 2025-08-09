<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use LemonSqueezy\Laravel\Billable;

class ThemeConfiguration extends Model
{
    use Billable;

    protected $fillable = [
        'purchase_token',
        'configuration',
        'license_type',
        'email',
        'payment_status',
        'lemon_squeezy_order_id',
        'name', // Required for Billable trait
    ];

    protected $casts = [
        'configuration' => 'array',
    ];

    // Billable trait requirements
    public function billingEmail(): string
    {
        return $this->email;
    }

    public function billingName(): ?string
    {
        return $this->name ?? $this->email;
    }

    public function generateThemeCode(): string
    {
        $config = $this->configuration;

        // Generate CSS based on configuration
        $css = "/* Filament Studio Generated Theme */\n\n";

        // Add CSS variables for colors if they exist
        if (isset($config['colors'])) {
            $css .= ":root {\n";
            foreach ($config['colors'] as $key => $value) {
                $css .= "    --{$key}: {$value};\n";
            }
            $css .= "}\n\n";
        }

        // Add typography styles if they exist
        if (isset($config['typography'])) {
            foreach ($config['typography'] as $element => $styles) {
                $css .= ".{$element} {\n";
                foreach ($styles as $property => $value) {
                    $css .= "    {$property}: {$value};\n";
                }
                $css .= "}\n\n";
            }
        }

        return $css;
    }
}
