<?php

use App\Models\MarsTime;

class MarsTimeTest extends TestCase
{
    /**
     * Testing MarsTime class with datetime: 2000-01-06
     */
    public function testMarsJ2000EpochTime()
    {
        $datetime = '2000-01-06T00:00:00Z';
        $instance = new MarsTime($datetime);

        $data = [
            'mars_sol_date' => floor(44795.9998),
            'mars_coordinated_time' => '23:59:44',
        ];
        $this->assertEquals(
            $data['mars_sol_date'], floor($instance->msd())
        );
        $this->assertEquals(
            $data['mars_coordinated_time'], $instance->h_to_hms($instance->mtc())
        );
    }
    /**
     * Testing MarsTime class with datetime: 1970-01-01
     */
    public function testMarsUnixEpochTime()
    {
        $datetime = '1970-01-01T00:00:00Z';
        $instance = new MarsTime($datetime);

        $data = [
            'mars_sol_date' => floor(34127.29584),
            'mars_coordinated_time' => '07:06:01',
        ];
        $this->assertEquals(
            $data['mars_sol_date'], floor($instance->msd())
        );
        $this->assertEquals(
            $data['mars_coordinated_time'], $instance->h_to_hms($instance->mtc())
        );
    }
}
