<?php

class Validate {
    private $passed = false,
            $errors = [];

    /**
    Parameters:
    $source - array
    $arrayOfRules - array

    Description: Проверка переданных данных $source на соответствие переданным правилам $arrayOfRules

    Return value: $this
     **/
    public function check($source, $arrayOfRules = []) {
        foreach($arrayOfRules as $item => $rules) {
            foreach ($rules as $rule => $rule_value) {

                $value = $source[$item];

                if ($rule == 'required' && empty($value)) {
                    $this->addError("{$item} является обязательным!");
                } else if (!empty($value)) {
                    switch ($rule) {
                        case 'min':
                            if (strlen($value) < $rule_value) {
                                $this->addError("{$item} должен состоять минимум из {$rule_value} символов.");
                            }
                        break;
                        case 'max':
                            if (strlen($value) > $rule_value) {
                                $this->addError("{$item} должен состоять максимум из {$rule_value} символов.");
                            }
                        break;
                        case 'matches':
                            if ($value != $source[$rule_value]) {
                                $this->addError("{$rule_value} должен совпадать с {$item}");
                            }
                        break;
                        case 'email':
                            if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                                $this->addError("{$item} не является электронной почтой.");
                            }
                        break;
                    }
                }
            }
        }

        if (empty($this->errors)) {
            $this->passed = true;
        }

        return $this;
    }

    /**
    Parameters:
    $error - string

    Description: Запись возникших ошибок в процессе валидации

    Return value: null
     **/
    private function addError($error) {
        $this->errors[] = $error;
    }

    /**
    Parameters:

    Description: Получение возникших ошибок в процессе валидации

    Return value: array
     **/
    public function errors() {
        return $this->errors;
    }

    /**
    Parameters:

    Description: Получение результатов валидации - true либо false

    Return value: boolean
     **/
    public function passed() {
        return $this->passed;
    }
}