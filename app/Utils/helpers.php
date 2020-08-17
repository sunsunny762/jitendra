<?php

if (!function_exists('getPasswordPolicy')) {
    /**
     * Get password minimum length and password regexp on basis of password strength
     *
     * @param array $passwordValidationRule
     * @return array
    */
    function getPasswordPolicy($passwordValidationRule)
    {
        if (count($passwordValidationRule)== 0) {
            $passwordValidationRule = [];
        }
        $min = 6;
        $passwordValidationRule[] = 'min:'.$min;
        $passwordStrength = 'medium';
        $passwordValidationRule[] = 'regex:/^[A-Za-z0-9!"#.@_~$%^*:|-]*$/';
        $passwordValidationRule[] = 'regex:/[a-z]/';
        $passwordValidationRule[] = 'regex:/[A-Z]/';
        $passwordValidationRule[] = 'regex:/[0-9]/';
        return array('passwordValidationRule'=> $passwordValidationRule,'passwordMinLength'=>$min,'passwordStrength'=>$passwordStrength);
    }
}





