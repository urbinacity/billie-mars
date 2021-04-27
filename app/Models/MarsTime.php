<?php

namespace App\Models;

class MarsTime
{
    // Difference between TAI and UTC. This value should be
    // updated each time the IERS announces a leap second.
    const TAI_OFFSET = 37;
    const TT_UTC_DIFFERENCE = 32.184;

    const JD_AT_UNIX_EPOCH = 2440587.5;
    const JD_AT_J2000_EPOCH = 2451545.0;
    const JULIAN_RATIO = 1.027491252;
    const DAY_IN_MILLIS = 8.64E7;
    const DAY_IN_SECONDS = 8.64E4;

    public $datetime;

    /**
     * Obtain Martian Coordinated Time (MTC).
     *
     * @return string
     */
    public function __construct($datetime = null)
    {
        $this->datetime = new \DateTime($datetime);
    }

    public static function h_to_hms($hour) {
        $x = $hour * 3600;
        $hh = floor($x / 3600);
        if ($hh < 10) {
            $hh = "0" . $hh;
        }
        $y = $x % 3600;
        $mm = floor($y / 60);
        if ($mm < 10) {
            $mm = "0" . $mm;
        }
        $ss = round($y % 60);
        if ($ss < 10) {
            $ss = "0" . $ss;
        }
        return "{$hh}:{$mm}:{$ss}";
    }

    private function get_UTC_milliseconds()
    {
        $unix_stamp = $this->datetime->getTimestamp();
        $milliseconds = substr($this->datetime->format('u'), 0, 3);

        return (int) "{$unix_stamp}{$milliseconds}";
    }

    /**
     * Obtain Mars Sol Date (MSD).
     *
     * @return string
     */
    public function msd()
    {
        $millis = $this->get_UTC_milliseconds();

        $jd_ut = self::JD_AT_UNIX_EPOCH + ($millis / self::DAY_IN_MILLIS);
        $jd_tt = $jd_ut + (self::TAI_OFFSET + self::TT_UTC_DIFFERENCE) / self::DAY_IN_SECONDS;
        $j2000 = $jd_tt - self::JD_AT_J2000_EPOCH;

        return ((($j2000 - 4.5) / self::JULIAN_RATIO) + 44796.0 - 0.00096);
    }

    /**
     * Obtain Martian Coordinated Time (MTC).
     *
     * @return string
     */
    public function mtc()
    {
        return fmod(24 * $this->msd(), 24);
    }
}