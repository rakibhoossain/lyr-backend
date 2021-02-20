<?php

namespace App\Traits;

use App\Notifications\VerifyEmail;

trait MustVerifyEmail
{
    /**
     * Determine if the user has verified their email address.
     *
     * @return bool
     */
    public function hasVerifiedEmail()
    {
        return ! is_null($this->email_verified_at);
    }

    /**
     * Mark the given user's email as verified.
     *
     * @return bool
     */
    public function markEmailAsVerified()
    {
        return $this->forceFill([
            'email_verified_at' => $this->freshTimestamp(),
        ])->save();
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    /**
     * get Otp.
     *
     * @return String
     */
    public function getOtp()
    {
        return ($this->otp)? $this->otp : null;
    }

    /**
     * set Otp.
     *
     * @return bool
     */
    public function setOtp()
    {
        $random = str_shuffle('AS32553DFGZWX0927466043161QPONM');
        $opt = substr($random,1,6);
        return $this->forceFill([
            'otp' => $opt,
        ])->save();
    }

    /**
     * Get the email address that should be used for verification.
     *
     * @return string
     */
    public function getEmailForVerification()
    {
        return $this->email;
    }
}
