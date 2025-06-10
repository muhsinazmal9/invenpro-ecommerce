<?php

use App\Models\Order;
use App\Models\Settings;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

/**
 * Validate with validator Make
 */
function validateData(array $rules)
{
    return Validator::make(request()->all(), $rules);
}

function saveImage($image, $location, $extension = 'webp')
{
    $path = explode('/', $location);
    array_pop($path);

    $imageDirectory = implode('/', $path).'/';

    makeDirectory($imageDirectory);

    if ($extension === 'webp') {
        Image::make($image)->encode('webp', 90)->save($location);
    } else {
        Image::make($image)->save($location);
    }
}

function makeDirectory($location)
{
    if (! file_exists($location)) {
        mkdir($location, 0777, true);
    }
}
function deleteImage($image)
{
    deleteFile($image);
}
function deleteFile($location)
{
    File::exists($location) && File::delete($location);
}

function generateSlug($title)
{
    return Str::slug($title);
}

if (! function_exists('generateUsername')) {

    function generateUsername($fname, $lname)
    {
        $username = Str::slug($fname.' '.$lname);

        // check username availability
        $i = 1;
        while (User::where('username', $username)->exists()) {
            $username = Str::slug($fname.' '.$lname).'-'.$i;
            $i++;
        }

        return $username;
    }
}

if (! function_exists('logError')) {
    function logError(string $message, Exception|Throwable $e)
    {
        info(
            $message,
            [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]
        );
    }
}

if (! function_exists('deleteMessage')) {
    function deleteMessage(string $modelName): string
    {
        return $modelName.' '. 'Deleted Successfully';
    }
}

if (! function_exists('updateMessage')) {
    function updateMessage(string $modelName): string
    {
        return $modelName.' '. 'Updated Successfully';
    }
}
if (! function_exists('createMessage')) {
    function createMessage(string $modelName): string
    {
        return $modelName.' '. 'Created Successfully';
    }
}

if (! function_exists('checkUserPermission')) {
    function checkUserPermission(string $permission_name): bool
    {
        return auth()->user()->can($permission_name);
    }
}

if (! function_exists('getSetting')) {
    function getSetting(string $key): ?string
    {
        return Settings::where('key', $key)->first()?->value;
    }
}
if (! function_exists('getPlaceholderImage')) {
    function getPlaceholderImage(string $width, string $height, ?string $text = null): ?string
    {
        return "https://fakeimg.pl/{$width}x{$height}/?text={$text}&font=bebas";
    }
}

if (! function_exists('getTotalCancelRequestCount')) {
    function getTotalCancelRequestCount(): int
    {
        return DB::table('orders')->where('is_cancel_request', Order::CANCEL_REQUEST['requested'])->count();
    }
}

if (! function_exists('getCancelRequestStatus')) {

    function getCancelRequestStatus($status): string
    {
        $newStatus = match ($status) {
            0 => 'No Request',
            1 => 'Requested',
            2 => 'Approved',
            3 => 'Rejected',
            default => 'Unknown',
        };

        return $newStatus;
    }
}

if (! function_exists('getOrderStatusColor')) {

    function getOrderStatusColor(string $status): string
    {
        $statusColor = 'success';

        match ($status) {
            Order::ORDER_STATUS['placed'] => $statusColor = 'primary',
            Order::ORDER_STATUS['approved'] => $statusColor = 'info',
            Order::ORDER_STATUS['shipped'] => $statusColor = 'warning',
            Order::ORDER_STATUS['delivered'] => $statusColor = 'success',
            Order::ORDER_STATUS['cancelled'] => $statusColor = 'danger',
        };

        return $statusColor;
    }
}
if (! function_exists('getPaymentStatusColor')) {

    function getPaymentStatusColor(string $status): string
    {
        $statusColor = 'danger';

        match ($status) {
            Order::PAYMENT_STATUS['paid'] => $statusColor = 'success',
            Order::PAYMENT_STATUS['pending'] => $statusColor = 'primary',
            Order::PAYMENT_STATUS['failed'] => $statusColor = 'danger',
        };

        return $statusColor;
    }
}
if (! function_exists('getCancelRequestStatusColor')) {

    function getCancelRequestStatusColor($status): string
    {
        $statusColor = 'info';

        match ($status) {
            0 => $statusColor = 'info',
            1 => $statusColor = 'warning',
            2 => $statusColor = 'success',
            3 => $statusColor = 'danger',
        };

        return $statusColor;
    }
}
if (! function_exists('getTransactionStatusColor')) {

    function getTransactionStatusColor($status): string
    {
        $statusColor = 'info';

        match ($status) {
            1 => $statusColor = 'primary',
            2 => $statusColor = 'danger',
            3 => $statusColor = 'success',
            4 => $statusColor = 'danger',
        };

        return $statusColor;
    }
}
if (! function_exists('getTransactionStatus')) {

    function getTransactionStatus($statusCode): string
    {
        $status = Transaction::FAILED;

        match ($statusCode) {
            1 => $status = Transaction::PENDING,
            2 => $status = Transaction::FAILED,
            3 => $status = Transaction::SUCCESS,
            4 => $status = Transaction::CANCEL,
        };

        return $status;
    }
}

if (! function_exists('numberToWords')) {
    function numberToWord(int $number): string
    {
        $hyphen      = '-';
        $conjunction = ' and ';
        $separator   = ', ';
        $negative    = 'negative ';
        $decimal     = ' point ';
        $dictionary  = [
            0                   => 'zero',
            1                   => 'one',
            2                   => 'two',
            3                   => 'three',
            4                   => 'four',
            5                   => 'five',
            6                   => 'six',
            7                   => 'seven',
            8                   => 'eight',
            9                   => 'nine',
            10                  => 'ten',
            11                  => 'eleven',
            12                  => 'twelve',
            13                  => 'thirteen',
            14                  => 'fourteen',
            15                  => 'fifteen',
            16                  => 'sixteen',
            17                  => 'seventeen',
            18                  => 'eighteen',
            19                  => 'nineteen',
            20                  => 'twenty',
            30                  => 'thirty',
            40                  => 'forty',
            50                  => 'fifty',
            60                  => 'sixty',
            70                  => 'seventy',
            80                  => 'eighty',
            90                  => 'ninety',
            100                 => 'hundred',
            1000                => 'thousand',
            1000000             => 'million',
            1000000000          => 'billion',
            1000000000000       => 'trillion',
            1000000000000000    => 'quadrillion',
            1000000000000000000 => 'quintillion'
        ];
    
        if (!is_numeric($number)) {
            return false;
        }
    
        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'numberToWord only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }
    
        if ($number < 0) {
            return $negative . numberToWord(abs($number));
        }
    
        $string = $fraction = null;
    
        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }
    
        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens   = ((int) ($number / 10)) * 10;
                $units  = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds  = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . numberToWord($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = numberToWord($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= numberToWord($remainder);
                }
                break;
        }
    
        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = [];
            foreach (str_split((string) $fraction) as $digit) {
                $words[] = $dictionary[$digit];
            }
            $string .= implode(' ', $words);
        }
    
        return $string;
    }
}    
