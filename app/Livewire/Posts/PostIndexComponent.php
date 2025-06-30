<?php

declare(strict_types=1);

namespace App\Livewire\Posts;

use App\Models\Post;
use App\Traits\PaginationTrait;
use App\Traits\PostTrait;
use App\Traits\SessionTimezoneTrait;
use App\Traits\SubsiteTrait;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

final class PostIndexComponent extends Component
{
    use PaginationTrait;
    use PostTrait;
    use SessionTimezoneTrait;
    use SubsiteTrait;
    use WithPagination;

    protected const string ASCENDING = 'asc';
    protected const string DESCENDING = 'desc';
    protected const array COLUMNS = [
        'posts.id',
        'posts.title',
        'posts.slug',
        'posts.body',
        'posts.created_at',
        'posts.deleted_at',
        'subsites.subdomain',
        'subsites.id AS subsite_id',
        'subsites.name AS subsite',
        'users.id AS user_id',
        'users.username',
    ];

    protected const int PER_PAGE = 20;

    public int $page = 1;
    public string $orderBy = 'created_at';
    public string $sortDirection = self::DESCENDING;
    public string $subdomain;
    public mixed $days;
    public string|null $searchColumn = null;
    public string|null $searchTerm = null;

    public function boot(): void
    {
        $this->subdomain = $this->getSubdomain();
    }

    public function render(): View
    {
        $posts = $this->getPosts();

        return view('livewire.posts.post-index-component', [
            'posts' => $posts,
            'displayTimezone' => $this->getDisplayTimezone(),
        ]);
    }

    public function query(): Builder
    {
        // This is just a placeholder to satisfy the PaginationTrait
        // The actual functionality is in getPosts() method
        return Post::query();
    }

    private function getPosts(): CursorPaginator
    {
        $dateQueries = [
            DB::raw("DATE_FORMAT(CONVERT_TZ(posts.created_at, 'UTC', " . DB::connection()->getPdo()->quote($this->getDisplayTimezone()) . "), '%m-%d') as month_day"),
            DB::raw('COUNT(*) as total_posts'),
        ];

        $columns = array_merge(self::COLUMNS, $dateQueries);

        return Post::select($columns)
        ->join(table: 'users', first: 'posts.user_id', operator: '=', second: 'users.id')
        ->join(table: 'subsites', first: 'posts.subsite_id', operator: '=', second: 'subsites.id')
        ->where(column: 'subsites.subdomain', operator: '=', value: $this->subdomain)
        ->with([
            'comments',
            //            'bookmarks',
            //            'favorites',
            //            'flags',
            'user',
        ])
        ->groupBy('month_day', 'id', 'title', 'created_at')
        ->orderBy(column: 'posts.created_at', direction: self::DESCENDING)
        ->cursorPaginate(perPage: self::PER_PAGE);
    }
}
