<?php

declare(strict_types=1);

namespace App\Http\Controllers\Posts;

use App\Dtos\PostDto;
use App\Enums\PostStateEnum;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Models\Post;
use App\Repositories\PostRepositoryInterface;
use App\Services\LdJsonService;
use App\Services\PostService;
use App\Traits\PostTrait;
use App\Traits\SessionTimezoneTrait;
use App\Traits\SubsiteTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

final class PostController extends BaseController
{
    use PostTrait;
    use SessionTimezoneTrait;
    use SubsiteTrait;

    protected int $subsiteId;

    public function __construct(
        protected LdJsonService $ldJsonService,
        protected PostRepositoryInterface $postRepository,
        protected PostService $postService,
    ) {
        $this->subsiteId = $this->getSubsiteId();

        parent::__construct();
    }

    public function index(): View
    {
        return view('posts.index', [
            'title' => trans('Posts'),
            'showSecondaryNavigation' => true,
        ]);
    }

    public function show(Post $post, ?string $slug = null): View|RedirectResponse
    {
        // Check if the post belongs to the correct subsite
        $subdomain = $this->getSubdomain() === 'www' ? 'metafilter' : $this->getSubdomain();
        $postSubdomain = $post->subsite->subdomain === 'www' ? 'metafilter' : $post->subsite->subdomain;

        // Redirect if subdomain or slug is incorrect
        if ($subdomain !== $postSubdomain || $slug !== $post->slug) {
            return redirect()->route($this->getShowPostRouteName($postSubdomain), [
                'post' => $post,
                'slug' => $post->slug,
            ], 301);
        }

        $relatedPosts = $this->postRepository->getRelatedPosts($post);

        return view('posts.show', [
            'title' => $post->title,
            'post' => $post,
            'user' => $post->user(),
            'next' => $post->next(),
            'previous' => $post->previous(),
            'canonicalUrl' => $this->getCanonicalUrl($post),
            'displayTimezone' => $this->getDisplayTimezone(),
            'relatedPosts' => $relatedPosts,
            'subdomain' => $subdomain,
            'useLivewire' => true,
            'useWysiwyg' => true,
            'showSecondaryNavigation' => true,
        ]);
    }

    public function create(): View
    {
        return view('posts.create', [
            'routeName' => $this->getStorePostRouteName(),
            'title' => $this->getNewPostText(),
            'useWysiwyg' => true,
        ]);
    }

    public function store(StorePostRequest $request): void
    {
        if (isset(auth()->user()->id)) {

            $dto = new PostDto(
                title: $request->validated('title'),
                body: $request->validated('body'),
                more_inside: $request->input('more_inside'),
                tags: $request->input('tags'),
                user_id: auth()->user()->id,
                subsite_id: $this->subsiteId,
                state: PostStateEnum::Published->value,
                published_at: now()->toDateTimeString(),
                is_published: true,
            );

            $this->postService->store($dto);
        }
    }

    public function edit(Post $post): View
    {
        return view('posts.edit', [
            'title' => $this->getEditPostText(),
            'post' => $post,
            'useWysiwyg' => true,
        ]);
    }

    public function update(UpdatePostRequest $request, Post $post): void
    {
        $this->postService->update($post->id, $request->validated());
    }

    public function delete(Post $post): void
    {
        $this->postService->delete($post->id);
    }
}
