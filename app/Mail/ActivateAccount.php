<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\URL;

class ActivateAccount extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    private $fromCustomName;

    /**
     * Create a new message instance.
     *
     * @param User $user
     * @param null $from
     */
    public function __construct(User $user, $fromCustomName = null)
    {
        $this->user = $user;
        $this->fromCustomName = $fromCustomName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->fromCustomName) {
            $this->from(env('MAIL_FROM_ADDRESS'), $this->fromCustomName);
        }
        $logoUrl = URL::to('/api/logo');
        $activationUrl = URL::to('/user/activate/'.$this->user->token);
        /// wip
        $positionMapper = [
            'admin' => [
                'name' => 'Administrator',
                'specialization_field_1' => 'Specialization Field 1',
                'specialization_field_2' => 'Specialization Field 2',
                'checkbox' => 'Knows how to admin'
            ],
            'tester' => [
                'name' => 'Tester',
                'specialization_field_1' => 'Testing Systems',
                'specialization_field_2' => 'Reporting Systems',
                'checkbox' => 'Knows Selenium'
            ],
            'developer' => [
                'name' => 'Developer',
                'specialization_field_1' => 'IDE Environment',
                'specialization_field_2' => 'Programming Languages',
                'checkbox' => 'Knows MySql'
            ],
            'project_manager' => [
                'name' => 'Project Manager',
                'specialization_field_1' => 'Methodologies for Project Management',
                'specialization_field_2' => 'Reporting Systems',
                'checkbox' => 'Knows Scrum'
            ],

        ];
        return $this
            ->view('wip')
            ->with([
                'positionMapper' => $positionMapper,
                'activationUrl' => $activationUrl,
                'logoUrl' => $logoUrl
            ]);
    }
}
