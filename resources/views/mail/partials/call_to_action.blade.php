{{-- <div style="margin:10px auto;max-width:600px;">
    <table width="100%" cellspacing="0" role="presentation">
        <tr>
            <td align="center">
                <table role="presentation" cellpadding="0" cellspacing="0" border="0"
                    style="border-collapse:collapse;border:1px solid #cccccc;">
                    <tbody>
                        <tr>
                            <td>
                                @switch(true)
                                    @case(getSetting('phone_1'))
                                        <a href="tel:{{ getSetting('phone_1') }}" target="_blank"
                                            style="padding: 10px 20px; font-family: sans-serif; font-size: 14px; line-height: 24px; color: #ffffff; text-decoration: none; background-color: #365cf5; border-radius: 5px;">
                                            Call Us
                                        </a>
                                    @break

                                    @case(getSetting('phone_2'))
                                        <a href="tel:{{ getSetting('phone_2') }}" target="_blank"
                                            style="padding: 10px 20px; font-family: sans-serif; font-size: 14px; line-height: 24px; color: #ffffff; text-decoration: none; background-color: #365cf5; border-radius: 5px;">
                                            Call Us
                                        </a>
                                    @break

                                    @case(getSetting('phone_3'))
                                        <a href="tel:{{ getSetting('phone_1') }}" target="_blank"
                                            style="padding: 10px 20px; font-family: sans-serif; font-size: 14px; line-height: 24px; color: #ffffff; text-decoration: none; background-color: #365cf5; border-radius: 5px;">
                                            Call Us
                                        </a>
                                    @break

                                    @default
                                        <a href="{{ url('/') }}" target="_blank"
                                            style="padding: 10px 20px; font-family: sans-serif; font-size: 14px; line-height: 24px; color: #ffffff; text-decoration: none; background-color: #365cf5; border-radius: 5px;">
                                            Call Us
                                        </a>
                                @endswitch

                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </table>
</div> --}}


<div style="margin:10px auto;max-width:600px;">
    <table border="0" cellpadding="0" cellspacing="0" role="presentation"
        style="border-collapse:separate;width:100%;line-height:100%;">
        <tr>
            <td align="center" bgcolor="#F45E43" role="presentation" class="btn-hover"
                style="border:none;border-radius:3px;cursor:auto;mso-padding-alt:10px 25px;background:#365cf5;"
                valign="middle">

                @php
                    $phone = '';
                    if (!empty(getSetting('phone_1'))) {
                        $phone = getSetting('phone_1');
                    } elseif (!empty(getSetting('phone_2'))) {
                        $phone = getSetting('phone_2');
                    } elseif (!empty(getSetting('phone_3'))) {
                        $phone = getSetting('phone_3');
                    }
                @endphp

                <a href="tel:{{ $phone }}" target="_blank"
                    style="display:inline-block;color:white;font-family:Helvetica;font-size:13px;font-weight:normal;line-height:120%;margin:0;text-decoration:none;text-transform:none;padding:10px 25px;mso-padding-alt:0px;border-radius:3px;">
                    CALL US
                </a>
            </td>
        </tr>
    </table>
</div>
