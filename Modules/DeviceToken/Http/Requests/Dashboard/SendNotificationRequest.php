<?php

namespace Modules\DeviceToken\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SendNotificationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    protected $maxLength = 200;

    public function rules()
    {
        switch ($this->getMethod()) {
            // handle creates
            case 'post':
            case 'POST':

                return [
                    'title.*' => 'required|max:' . $this->maxLength,
                    'description.*' => 'required|max:' . $this->maxLength,
                ];
        }
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        $v = [];
        foreach (config('laravellocalization.supportedLocales') as $key => $value) {
            $v["title." . $key . ".required"] = __('devicetoken::dashboard.devicetokens.validation.title.required') . ' - ' . $value['native'] . '';
            $v["title." . $key . ".max"] = __('devicetoken::dashboard.devicetokens.validation.title.max') . ' - ' . $value['native'] . ' : ' . $this->maxLength;
            $v["description." . $key . ".required"] = __('devicetoken::dashboard.devicetokens.validation.description.required') . ' - ' . $value['native'] . '';
            $v["description." . $key . ".max"] = __('devicetoken::dashboard.devicetokens.validation.description.max') . ' - ' . $value['native'] . ' : ' . $this->maxLength;
        }
        return $v;
    }
}
