<?php

namespace Modules\DeliveryTime\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DeliveryTimeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
                // handle creates
            case 'post':
            case 'POST':
                $r = [];
                if (isset($this->days_status) && !empty($this->days_status)) {
                    $workTimesRoles = $this->workTimesValidation($this->days_status, $this->is_full_day, $this->availability);
                    $r = array_merge($r, $workTimesRoles);
                }
                return $r;

                //handle updates
            case 'put':
            case 'PUT':
                $r = [];
                if (isset($this->days_status) && !empty($this->days_status)) {
                    $workTimesRoles = $this->workTimesValidation($this->days_status, $this->is_full_day, $this->availability);
                    $r = array_merge($r, $workTimesRoles);
                }
                return $r;
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
        if (isset($this->days_status) && !empty($this->days_status)) {
            $workTimesRoles = $this->workTimesValidationMessages($this->days_status, $this->is_full_day, $this->availability);
            $v = array_merge($v, $workTimesRoles);
        }
        return $v;
    }

    private function workTimesValidation($days_status, $is_full_day, $availability)
    {
        $roles = [];
        foreach ($days_status as $k => $dayCode) {
            if (array_key_exists($dayCode, $is_full_day)) {
                if ($is_full_day[$dayCode] == '0') {

                    if ($this->arrayContainsDuplicate($availability['time_from'][$dayCode]) && $this->arrayContainsDuplicate($availability['time_to'][$dayCode])) {
                        $roles['availability.duplicated_time.' . $dayCode] = 'required';
                    }
                    foreach ($availability['time_from'][$dayCode] as $key => $time) {

                        if (empty($availability['time_to'][$dayCode][$key]) || empty($time)) {
                            $roles['availability.time.' . $dayCode . '.' . $key] = 'required';
                        }

                        if (strtotime($availability['time_to'][$dayCode][$key]) < strtotime($time)) {
                            $roles['availability.time.' . $dayCode . '.' . $key] = 'required';
                        }
                    }
                }
            }
        }

        return $roles;
    }

    private function workTimesValidationMessages($days_status, $is_full_day, $availability)
    {
        $v = [];
        foreach ($days_status as $k => $dayCode) {
            if (array_key_exists($dayCode, $is_full_day)) {
                if ($is_full_day[$dayCode] == '0') {

                    $duplicatedMsg = __('apps::dashboard.availabilities.form.day');
                    $duplicatedMsg .= ' " ' . __('apps::dashboard.availabilities.days.' . $dayCode) . ' " ';
                    $duplicatedMsg .= __('apps::dashboard.availabilities.form.contain_duplicated_values');
                    $v['availability.duplicated_time.' . $dayCode . '.required'] = $duplicatedMsg;

                    foreach ($availability['time_from'][$dayCode] as $key => $time) {

                        if (empty($availability['time_to'][$dayCode][$key]) || empty($time)) {
                            $requiredMsg = __('apps::dashboard.availabilities.form.enter_time');
                            $requiredMsg .= ' " ' . $time . ' " ';
                            $requiredMsg .= __('apps::dashboard.availabilities.form.for_day');
                            $requiredMsg .= ' " ' . __('apps::dashboard.availabilities.days.' . $dayCode) . ' " ';

                            $v['availability.time.' . $dayCode . '.' . $key . '.required'] = $requiredMsg;
                        }

                        if (strtotime($availability['time_to'][$dayCode][$key]) < strtotime($time)) {
                            $requiredMsg = __('apps::dashboard.availabilities.form.time');
                            $requiredMsg .= ' " ' . $time . ' " ';
                            $requiredMsg .= __('apps::dashboard.availabilities.form.for_day');
                            $requiredMsg .= ' " ' . __('apps::dashboard.availabilities.days.' . $dayCode) . ' " ';
                            $requiredMsg .= " " . __('apps::dashboard.availabilities.form.greater_than') . " ";
                            $requiredMsg .= " " . __('apps::dashboard.availabilities.form.time') . " ";
                            $requiredMsg .= ' " ' . $availability['time_to'][$dayCode][$key] . ' " ';

                            $v['availability.time.' . $dayCode . '.' . $key . '.required'] = $requiredMsg;
                        }
                    }
                }
            }
        }
        return $v;
    }

    public function arrayContainsDuplicate($array)
    {
        return count($array) != count(array_unique($array));
    }
}
