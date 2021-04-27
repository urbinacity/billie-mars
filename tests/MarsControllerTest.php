<?php

use App\Models\MarsTime;
use Illuminate\Http\Response;

class MarsControllerTest extends TestCase
{
    public $endpoint = '/mars';

    /**
     * Testing /mars endpoint.
     */
    public function testMarsEndpoint()
    {
        $this->get($this->endpoint);
        $this->response
            ->assertStatus(Response::HTTP_OK)
            ->assertJsonStructure([
                'mars_sol_date',
                'mars_coordinated_time',
            ]
        );
    }

    /**
     * Testing /mars endpoint with UTC argument.
     */
    public function testMarsEndpointWithValidArguments()
    {
        $datetime = "2021-04-27T05:15:16Z";
        $instance = new MarsTime($datetime);
        $this->get($this->endpoint . '?utc=' . $datetime);

        $this->response
            ->assertStatus(Response::HTTP_OK)
            ->assertExactJson([
                'mars_sol_date' => $instance->msd(),
                'mars_coordinated_time' => $instance->h_to_hms($instance->mtc()),
            ]
        );
    }

    /**
     * Testing /mars endpoint with invalid UTC argument.
     */
    public function testMarsEndpointInvalidArguments()
    {
        $datetime = "04-27T";
        $this->get($this->endpoint . '?utc=' . $datetime);

        $this->response->assertStatus(Response::HTTP_BAD_REQUEST);
    }
}
