<?php

namespace App;

use App\Activity;

trait Activityable
{

    protected static function bootActivityable()
    {
        if (!auth()->check()) {
            return;
        }

        foreach (self::getEventsToReact() as $event) {
            static::$event(function ($model) use ($event) {
                $model->activities()->create([
                    'user_id' => auth()->user()->id,
                    'type' => $model->getActivityType($event),
                ]);
            });
        }

        static::deleting(function ($model) {
            $model->activities()->delete();
        });
    }

    protected static function getEventsToReact()
    {
        return ['created'];
    }

    public function activities()
    {
        return $this->morphMany(Activity::class, 'subject');
    }

    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return  $event . '_' . $type;
    }
}
