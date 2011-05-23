<?php
//package Spaghetti.core
class Validation {
    public static function alphanumeric($value) {
        return (bool) preg_match('/^[\p{Ll}\p{Lm}\p{Lo}\p{Lt}\p{Lu}\p{Nd}]+$/mu', $value);
    }

    public static function between($value, $min, $max) {
        if(!is_numeric($value)) {
            $value = strlen($value);
        }

        return filter_var($value, FILTER_VALIDATE_INT, array(
            'options' => array(
                'min_range' => $min,
                'max_range' => $max,
            )
        )) !== false;
    }

    public static function blank($value) {
        return !preg_match('/[^\s]/', $value);
    }

    public static function boolean($value) {
        $boolean = array(0, 1, '0', '1', true, false);

        return in_array($value, $boolean, true);
    }

    public static function creditCard($value) {
        return preg_match('/^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|6011[0-9]{12}|3(?:0[0-5]|[68][0-9])[0-9]{11}|3[47][0-9]{13})$/', $value);
    }

    public static function comparison($value1, $operator, $value2) {
        switch($operator) {
            case '>':
            case 'greater':
                return $value1 > $value2;
            case '<':
            case 'less':
                return $value1 < $value2;
            case '>=':
            case 'greaterorequal':
                return $value1 >= $value2;
            case '<=':
            case 'lessorequal':
                return $value1 <= $value2;
            case '==':
            case 'equal':
                return $value1 == $value2;
            case '!=':
            case 'notequal':
                return $value1 != $value2;
        }

        return false;
    }

    public function regex($value, $regex) {
        return preg_match($regex, $value);
    }

    public static function date($value) {
        $regex = '%^(?:(?:31(/|-|\\.)(?:0?[13578]|1[02]))\\1|(?:(?:29|30)(/|-|\\.)(?:0?[1,3-9]|1[0-2])\\2))(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$|^(?:29(/|-|\\.)0?2\\3(?:(?:(?:1[6-9]|[2-9]\\d)?(?:0[48]|[2468][048]|[13579][26])|(?:(?:16|[2468][048]|[3579][26])00))))$|^(?:0?[1-9]|1\\d|2[0-8])(/|-|\\.)(?:(?:0?[1-9])|(?:1[0-2]))\\4(?:(?:1[6-9]|[2-9]\\d)?\\d{2})$%';

        return (bool) preg_match($regex, $value);
    }

    public static function decimal($value, $places = null) {
        if(is_null($places)) {
            $regex = '/^[+-]?[\d]+\.[\d]+([eE][+-]?[\d]+)?$/';
        }
        else {
            $regex = '/^[+-]?[\d]+\.[\d]{' . $places . '}$/';
        }

        return (bool) preg_match($regex, $value);
    }

    public static function email($value) {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function equal($value, $compare) {
        return $value === $compare;
    }

    public static function ip($value) {
        return filter_var($value, FILTER_VALIDATE_IP) !== false;
    }

    public static function minLength($value, $length) {
        $value_length = strlen($value);

        return $value_length >= $length;
    }

    public static function maxLength($value, $length) {
        $value_length = strlen($value);

        return $value_length <= $length;
    }

    public static function multiple($values, $list, $min = null, $max = null) {
        $values = array_filter($values);

        if(empty($values)) {
            return false;
        }
        else if(!is_null($min) && count($values) < $min) {
            return false;
        }
        else if(!is_null($max) && count($values) > $max) {
            return false;
        }
        else {
            foreach(array_keys($values) as $value) {
                if(!in_array($value, $list)) {
                    return false;
                }
            }
        }

        return true;
    }

    public static function inList($value, $list) {
        return in_array($value, $list);
    }

    public static function numeric($value) {
        return is_numeric($value);
    }

    public static function notEmpty($value) {
        return (bool) preg_match('/[^\s]+/m', $value);
    }

    public static function range($value, $lower = null, $upper = null) {
        if(is_numeric($value)) {
            if(!is_null($lower) || !is_null($upper)) {
                $check_lower = $check_upper = true;
                if(!is_null($lower)) {
                    $check_lower = $value > $lower;
                }
                if(!is_null($upper)) {
                    $check_upper = $value < $upper;
                }
            }
            else {
                return is_finite($value);
            }

            return $check_lower && $check_upper;
        }

        return false;
    }

    public static function time($value) {
        $regex = '/^([01]\d|2[0-3])(:[0-5]\d){1,2}$'
               . '|^(0?[1-9]|1[0-2])(:[0-5]\d){1,2}\s?[AaPp]m$/';

        return (bool) preg_match($regex, $value);
    }

    public static function url($value) {
        return filter_var($value, FILTER_VALIDATE_URL) !== false;
    }
}