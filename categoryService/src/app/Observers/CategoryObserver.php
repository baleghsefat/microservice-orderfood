<?php

namespace App\Observers;

use App\Jobs\PublishGlobalJob;
use App\Models\Category;

class CategoryObserver
{
    public bool $afterCommit = true;

    /**
     * @param Category $category Category.
     * @return void
     */
    public function created(Category $category): void
    {
        $this->publishGlobally($category, 'create');
    }

    /**
     * @param Category $category Category.
     * @return void
     */
    public function deleted(Category $category): void
    {
        $this->publishGlobally($category, 'delete');
    }

    /**
     * @param Category $category Category.
     * @param string $event Event.
     * @return void
     */
    private function publishGlobally(Category $category, string $event): void
    {
        $data = $category->toArray();
        $data['event'] = $event;

        dispatch(new PublishGlobalJob($data));
    }
}
