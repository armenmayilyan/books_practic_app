<?php


namespace App\Contracts;


interface ResetPasswordInterface
{
public function createPassword(array $data);
}
