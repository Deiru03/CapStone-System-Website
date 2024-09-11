class ChecklistSent extends Mailable
{
    public $checklist;

    public function __construct($checklist)
    {
        $this->checklist = $checklist;
    }

    public function build()
    {
        return $this->view('emails.checklist-sent')
                    ->with(['checklist' => $this->checklist]);
    }
}