<?php

namespace App\Console\Commands;

use App\Note;
use App\Notifications\DailyNotesNotification;
use App\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;

class DailyEmailCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:email';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $tags = Tag::all();
        $notes = [];
        foreach ($tags as $tag) {
            $note = Note::with('tags')->whereHas('tags', function($q) use ($tag) {
                return $q->where('id', $tag->id);
            })->whereNotIn('id', array_keys($notes))->first();

            if ($note) {
                $notes[$note->id] = $note;
            }
        }

        Notification::route('mail', 'povilask007@gmail.com')
            ->notify(new DailyNotesNotification($notes));
    }
}
