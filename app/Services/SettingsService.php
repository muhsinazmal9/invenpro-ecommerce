<?php

namespace App\Services;

use App\Http\Requests\UpdateAuthenticationSettingsRequest;
use App\Http\Requests\UpdateBusinessSettingsRequest;
use App\Http\Requests\UpdateChargesRequest;
use App\Http\Requests\UpdateColorSettingsRequest;
use App\Http\Requests\UpdateEmailTemplateRequest;
use App\Http\Requests\UpdateExternalApiRequest;
use App\Http\Requests\UpdateLogoSettingsRequest;
use App\Http\Requests\UpdateOrderSettingsRequest;
use App\Http\Requests\UpdateSiteSettingsRequest;
use App\Http\Requests\UpdateSmtpSettingsRequest;
use App\Http\Requests\UpdateStockSettingsRequest;
use App\Http\Requests\UpdateStripeSettingsRequest;
use App\Models\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class SettingsService
{
    public function updateLogoSettings(UpdateLogoSettingsRequest $request): JsonResponse
    {
        if (!checkUserPermission(Settings::LOGO_SETTINGS)) {
            return error(__('app.permission_denied'));
        }

        try {

            if ($request->hasFile('primary_logo')) {
                $this->uploadFile($request->file('primary_logo'), Settings::PRIMARY_LOGO);
            }
            if ($request->hasFile('secondary_logo')) {
                $this->uploadFile($request->file('secondary_logo'), Settings::SECONDARY_LOGO);
            }

            if ($request->hasFile('favicon')) {
                $this->uploadFile($request->file('favicon'), Settings::FAVICON);
            }

            return success(__('app.logo_settings_updated_successfully'));
        } catch (\Exception $e) {
            logError('Error updating logo settings', $e);

            return error(__('app.error_updating_logo_settings'));
        }
    }

    public function updateAuthenticationSettings(UpdateAuthenticationSettingsRequest $request): JsonResponse
    {
        if (!checkUserPermission(Settings::AUTHENTICATION_SETTING)) {
            return error(__('app.permission_denied'));
        }

        try {

            $setting = $request->except(['_token', '_method', 'default_avatar']);

            foreach ($setting as $key => $value) {
                $setting = Settings::where('key', $key)->first();

                if (!$setting) {
                    $setting = new Settings();
                    $setting->key = $key;
                }
                $setting->value = $value;
                $setting->save();
            }

            if ($request->hasFile('default_avatar')) {
                $this->uploadFile($request->file('default_avatar'), Settings::DEFAULT_AVATAR);
            }

            Artisan::call('cache:clear');

            return success(__('app.authentication_settings_updated_successfully'));
        } catch (\Exception $e) {
            logError('Error updating authentication settings', $e);

            return error(__('app.error_updating_authentication_settings'));
        }
    }

    protected function uploadFile($file, $name): void
    {

        $oldFile = public_path(getSetting($name));

        if (file_exists($oldFile)) {
            unlink($oldFile);
        }

        $fileName = Str::slug(getSetting(Settings::SITE_TITLE)) . "-{$name}-" . time() . '.' . $file->getClientOriginalExtension();
        $localLocation = Settings::IMAGE_DIRECTORY . $fileName;
        $path = public_path($localLocation);

        saveImage($file, $path, 'png');

        $siteSettings = Settings::where('key', $name)->first();

        if (!$siteSettings) {
            $siteSettings = new Settings();
            $siteSettings->key = $name;
        }

        $siteSettings->value = $localLocation;
        $siteSettings->save();
    }

    public function updateQuery(
        UpdateBusinessSettingsRequest
        |UpdateSiteSettingsRequest
        |UpdateStripeSettingsRequest
        |UpdateSmtpSettingsRequest
        |UpdateStockSettingsRequest
        |UpdateOrderSettingsRequest
        |UpdateColorSettingsRequest
        |UpdateEmailTemplateRequest
        |UpdateExternalApiRequest
        |UpdateChargesRequest $request
    ): JsonResponse {

        try {
            $setting = $request->except(['_token', '_method']);

            $setting['stripe_status'] = (bool) $request->stripe_status;

            foreach ($setting as $key => $value) {
                $setting = Settings::where('key', $key)->first();

                if (!$setting) {
                    $setting = new Settings();
                    $setting->key = $key;
                }
                $setting->value = $value;
                $setting->save();

            }

            Artisan::call('cache:clear');

            return success(__('app.settings_updated_successfully'));
        } catch (\Exception $e) {
            logError('Error updating  settings', $e);

            return error(__('app.error_updating_settings'));
        }
    }



    public function updatePaymentGatewaySettings()
    {

    }
}
