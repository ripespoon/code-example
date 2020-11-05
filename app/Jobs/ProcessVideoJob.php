<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Aws\ElasticTranscoder\ElasticTranscoderClient;
use DB;

class ProcessVideoJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $video;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($video)
    {
        $this->video = $video;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client = ElasticTranscoderClient::factory(array(
            'region'  => 'eu-west-1',
            'version' => '2012-09-25' // TODO:: Update this to a newer version
        ));

        $videoPath = $this->video->video_path;

        $results = $client->createJob([
            'PipelineId' => '1603298049691-sgqym3', // PipelineId is specific per project
            'Input' => [
                'Key' => $videoPath,
            ],
            'Output' => [
                'Key' => 'output/' . $this->video->id,
                'SegmentDuration' => '10',
                'PresetId' => '1351620000001-200030', // This preset is specific to a segmented streamable file type
            ]
        ]);

        /**
         * FYI:
         * Once the job has completed processing an AWS Notification will be sent
         * to confirm job completion, then the new video URL will be updated against the resource.
         */
    }
}
