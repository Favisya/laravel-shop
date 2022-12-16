<?php

namespace App\Models;

trait Translateable
{
    public function __($originalName)
    {
        $locale = Session::getItem('locale');

        if ($locale === 'en') {
            $fieldName = $originalName . '_en';
        } else {
            $fieldName = $originalName;
        }

        if ($locale === 'en' && (is_null($this->$fieldName) || empty($this->$fieldName))) {
            return $this->$originalName;
        }

        return $this->$fieldName;
    }
}
