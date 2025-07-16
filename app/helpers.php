<?php


if (!function_exists('convert_number')) {
    function convert_number($number)
    {
        if (($number < 0) || ($number > 999999999))
        {
            throw new Exception("Number is out of range");
        }
        $giga = floor($number / 1000000);
        // Millions (giga)
        $number -= $giga * 1000000;
        $kilo = floor($number / 1000);
        // Thousands (kilo)
        $number -= $kilo * 1000;
        $hecto = floor($number / 100);
        // Hundreds (hecto)
        $number -= $hecto * 100;
        $deca = floor($number / 10);
        // Tens (deca)
        $n = $number % 10;
        // Ones
        $result = "";
        if ($giga)
        {
            $result .= convert_number($giga) .  "Million";
        }
        if ($kilo)
        {
            $result .= (empty($result) ? "" : " ") .convert_number($kilo) . " Thousand";
        }
        if ($hecto)
        {
            $result .= (empty($result) ? "" : " ") .convert_number($hecto) . " Hundred";
        }
        $ones = array("", "One", "Two", "Three", "Four", "Five", "Six", "Seven", "Eight", "Nine", "Ten", "Eleven", "Twelve", "Thirteen", "Fourteen", "Fifteen", "Sixteen", "Seventeen", "Eightteen", "Nineteen");
        $tens = array("", "", "Twenty", "Thirty", "Fourty", "Fifty", "Sixty", "Seventy", "Eigthy", "Ninety");
        if ($deca || $n) {
            if (!empty($result))
            {
                $result .= " and ";
            }
            if ($deca < 2)
            {
                $result .= $ones[$deca * 10 + $n];
            } else {
                $result .= $tens[$deca];
                if ($n)
                {
                    $result .= "-" . $ones[$n];
                }
            }
        }
        if (empty($result))
        {
            $result = "zero";
        }
        return $result;
    }
}

if (!function_exists('static_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param string $path
     * @param bool|null $secure
     * @return string
     */
    function static_asset($path, $secure = null)
    {
        return app('url')->asset('public/' . $path, $secure);
    }
}

if (!function_exists('mask_email')) {
    function mask_email($email) {
        $parts = explode("@", $email);
        $name = $parts[0];
        $domain = $parts[1];

        $name_length = strlen($name);
        $masked_name = substr($name, 0, 2) . str_repeat('*', $name_length - 4) . substr($name, -2);

        return $masked_name . '@' . $domain;
    }
}

if (!function_exists('updateEnv'))
{
    function updateEnv(array $data)
    {
        $path = base_path('.env');

        if (file_exists($path)) {
            $env = file_get_contents($path);

            foreach ($data as $key => $value) {
                $key = strtoupper($key);
                $value = '"' . $value . '"';

                if (preg_match("/^{$key}=/m", $env)) {
                    $env = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $env);
                } else {
                    $env .= "\n{$key}={$value}";
                }
            }

            file_put_contents($path, $env);
        }
    }
}

if (!function_exists('discounted_price')) {
    function discounted_price($product)
    {
        $newPrice = $product->sell_price;

        // Check if the current date is within the discount period
        if ($product->discount > 0) {
            if ($product->discount_type == 2) {
                $newPrice = $product->sell_price - ($product->sell_price * ($product->discount / 100));
            } else {
                $newPrice = $product->sell_price - $product->discount;
            }
        }

        return $newPrice;
    }
}
if (!function_exists('discounted_active')) {
    function discounted_active($product)
    {
        if ($product->is_variant == 1) {
            // Check if any variant has a discount greater than 0
            foreach ($product->variants as $variant) {
                if ($variant->discount > 0) {
                    return true;
                }
            }
            return false;
        }

        // If not a variant product, check the main product discount
        return $product->discount > 0;
    }
}


