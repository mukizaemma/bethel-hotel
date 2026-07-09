<?php

namespace App\Livewire\Public;

use App\Models\Blog;
use App\Services\PublicWebsiteData;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.frontbase')]
class BlogPostPage extends Component
{
    public string $slug;

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        Blog::where('slug', $slug)->firstOrFail()->increment('views');
    }

    public function render()
    {
        return view('frontend.blog', PublicWebsiteData::blogPost($this->slug));
    }
}
