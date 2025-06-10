<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use App\Jobs\UpdateSmtpEnvJob;
use App\Services\SettingsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\UpdateChargesRequest;
use App\Http\Requests\UpdateExternalApiRequest;
use App\Http\Requests\UpdateLogoSettingsRequest;
use App\Http\Requests\UpdateSiteSettingsRequest;
use App\Http\Requests\UpdateSmtpSettingsRequest;
use App\Http\Requests\UpdateColorSettingsRequest;
use App\Http\Requests\UpdateEmailTemplateRequest;
use App\Http\Requests\UpdateOrderSettingsRequest;
use App\Http\Requests\UpdateStockSettingsRequest;
use App\Http\Requests\UpdateStripeSettingsRequest;
use App\Http\Requests\UpdateBusinessSettingsRequest;
use App\Http\Requests\UpdateAuthenticationSettingsRequest;

class SettingsController extends Controller
{
    public function __construct(private SettingsService $settingsService)
    {
        $this->middleware('can:'.Settings::SITE_SETTINGS)->only(['siteSettings', 'UpdateSiteSettingsRequest']);
        $this->middleware('can:'.Settings::BUSINESS_SETTINGS)->only(['businessSettings', 'updateBusinessSettings']);
        $this->middleware('can:'.Settings::LOGO_SETTINGS)->only(['logoSettings', 'updateLogoSettings']);
        $this->middleware('can:'.Settings::STRIPE_SETTINGS)->only(['stripeSettings', 'updateStripeSettings']);
        $this->middleware('can:'.Settings::EMAIL_TEMPLATE)->only(['emailTemplate', 'updateEmailTemplate']);
        $this->middleware('can:'.Settings::SMTP_SETTINGS)->only(['smtpSettings', 'updateSmtpSettings']);
        $this->middleware('can:'.Settings::CHARGES_SETTINGS)->only(['chargesSettings', 'updateChargesSettings']);
        $this->middleware('can:'.Settings::STOCK_SETTINGS)->only(['stockSettings', 'updateStockSettings']);
        $this->middleware('can:'.Settings::ORDER_SETTING)->only(['orderSettings', 'updateOrderSettings']);
        $this->middleware('can:'.Settings::COLOR_SETTING)->only(['colorSettings', 'updateColorSettings']);
        $this->middleware('can:'.Settings::AUTHENTICATION_SETTING)->only(['authenticationSettings', 'updateAuthenticationSettings']);
    }

    public function siteSettings(): View
    {
        $phoneCodes = collect(json_decode(file_get_contents(base_path('json/phone_codes.json'))));
        $currencies = collect(json_decode(file_get_contents(base_path('json/currencies.json'))));
        $timezones = collect(json_decode(file_get_contents(base_path('json/timezones.json'))));

        return view('backend.settings.site_settings', compact('phoneCodes', 'currencies', 'timezones'));
    }

    public function UpdateSiteSettingsRequest(UpdateSiteSettingsRequest $request): RedirectResponse
    {

        $siteSettings = $this->settingsService->updateQuery($request);

        if ($siteSettings->getData()->success) {
            return back()->with('success', __('app.site_settings_updated_successfully'));
        }

        return back()->with('error', __('app.error_updating_site_settings'));
    }

    public function businessSettings(): View
    {
        $countries_json = file_get_contents(base_path().'/json/countries.json');

        // $states_json = file_get_contents(base_path().'/json/states.json');
        // $cities_json = file_get_contents(base_path().'/json/cities.json');
        return view('backend.settings.business_setting', compact('countries_json'));
    }

    public function updateBusinessSettings(UpdateBusinessSettingsRequest $request): RedirectResponse
    {

        $businessSettings = $this->settingsService->updateQuery($request);

        if ($businessSettings->getData()->success) {
            return back()->with('success', __('app.business_settings_updated_successfully'));
        }

        return back()->with('error', __('app.error_updating_business_settings'));
    }

    public function getStates(int $country_id)
    {
        if ($country_id) {
            $states = collect(json_decode(file_get_contents(base_path('json/states.json'))))->where('country_id', $country_id)->pluck('name', 'id')->toArray();

            return success(data: $states);
        } else {
            return error();
        }
    }

    public function getCities(int $state_id)
    {
        if ($state_id) {
            $cities = collect(json_decode(file_get_contents(base_path('json/cities.json'))))->where('state_id', $state_id)->pluck('name', 'id')->toArray();

            return success(data: $cities);
        } else {
            return error();
        }
    }

    public function logoSettings(): View
    {
        return view('backend.settings.logo_settings');
    }

    public function updateLogoSettings(UpdateLogoSettingsRequest $request): RedirectResponse
    {
        $logoSettings = $this->settingsService->updateLogoSettings($request);

        if ($logoSettings->getData()->success) {
            return back()->with('success', __('app.logo_settings_updated_successfully'));
        }

        return back()->with('error', __('app.error_updating_logo_settings'));
    }

    public function stripeSettings(): View
    {
        return view('backend.settings.payment_gateway.stripe');
    }

    public function updateStripeSettings(UpdateStripeSettingsRequest $request): RedirectResponse
    {
        $stripeSettings = $this->settingsService->updateQuery($request);

        if ($stripeSettings->getData()->success) {
            return back()->with('success', __('app.stripe_settings_updated_successfully'));
        }

        return back()->with('error', __('app.error_updating_stripe_settings'));
    }

    public function smtpSettings(): View
    {
        return view('backend.settings.smtp_settings');
    }

    public function updateSmtpSettings(UpdateSmtpSettingsRequest $request): RedirectResponse
    {
        $smtpSettings = $this->settingsService->updateQuery($request);

        if ($smtpSettings->getData()->success) {

            try {
                UpdateSmtpEnvJob::dispatch($request->all());

            } catch (\Exception $e) {
                logError('SMTP Settings Error', $e);

                return back()->with('error', __('app.updated_to_database_but_could_not_update_env_file'));
            }

            return back()->with('success', __('app.smtp_settings_updated_successfully'));
        }

        return back()->with('error', __('app.error_updating_smtp_settings'));
    }

    public function chargesSettings(): View
    {
        return view('backend.settings.charges_settings');
    }

    public function updateChargesSettings(UpdateChargesRequest $request): RedirectResponse
    {
        $chargesSettings = $this->settingsService->updateQuery($request);

        if ($chargesSettings->getData()->success) {
            return back()->with('success', __('app.charges_settings_updated_successfully'));
        }

        return back()->with('error', __('app.error_updating_charges_settings'));
    }

    public function stockSettings(): View
    {
        return view('backend.settings.stock_settings');
    }

    public function updateStockSettings(UpdateStockSettingsRequest $request): RedirectResponse
    {
        $stockSettings = $this->settingsService->updateQuery($request);

        if ($stockSettings->getData()->success) {
            return back()->with('success', __('app.stock_settings_updated_successfully'));
        }

        return back()->with('error', __('app.error_updating_stock_settings'));
    }

    public function orderSettings(): view
    {
        return view('backend.settings.order_settings');
    }

    public function updateOrderSettings(UpdateOrderSettingsRequest $request): RedirectResponse
    {

        $orderSettings = $this->settingsService->updateQuery($request);

        if ($orderSettings->getData()->success) {
            return back()->with('success', __('app.order_settings_updated_successfully'));
        }

        return back()->with('error', __('app.error_updating_order_settings'));
    }

    public function colorSettings(): View
    {
        return view('backend.settings.color_setting');
    }

    public function updateColorSettings(UpdateColorSettingsRequest $request): RedirectResponse
    {
        $colorSettings = $this->settingsService->updateQuery($request);

        if ($colorSettings->getData()->success) {
            return back()->with('success', __('app.color_settings_updated_successfully'));
        }

        return back()->with('error', __('app.error_updating_color_settings'));
    }

    public function authenticationSettings(): View
    {
        return view('backend.settings.authentication_setting');
    }

    public function updateAuthenticationSettings(UpdateAuthenticationSettingsRequest $request): RedirectResponse
    {
        $authenticationSettings = $this->settingsService->updateAuthenticationSettings($request);

        if ($authenticationSettings->getData()->success) {
            return back()->with('success', __('app.authentication_settings_updated_successfully'));
        }

        return back()->with('error', __('app.error_updating_authentication_settings'));

    }

    public function emailTemplate(): View
    {
        return view('backend.settings.email_template.email');
    }

    public function updateEmailTemplate(UpdateEmailTemplateRequest $request): RedirectResponse
    {
        $emailTemplate = $this->settingsService->updateQuery($request);

        if ($emailTemplate->getData()->success) {
            return back()->with('success', __('app.email_template_updated_successfully'));
        }

        return back()->with('error', __('app.error_updating__'));
    }

    public function externalApi(): View
    {
        return view('backend.settings.external_api_keys_settings');
    }

    public function updateExternalApi(UpdateExternalApiRequest $request): RedirectResponse
    {
        $externalApi = $this->settingsService->updateQuery($request);

        if ($externalApi->getData()->success) {
            return back()->with('success', __('app.external_api_keys_updated_successfully'));
        }

        return back()->with('error', __('app.error_updating_external_api_keys'));
    }
}
