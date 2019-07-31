<?php

namespace App\Validators;


class RegexRuleCommon
{
    const REGEX_SLUG = "/^[a-z0-9]+(?:-[a-z0-9]+)*$/i";
    const REGEX_URL = "/^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._\+~#=]{2,256}\.[a-z]{2,6}\b([-a-zA-Z0-9@:%_\+.~#?&//=]*)/g";
}