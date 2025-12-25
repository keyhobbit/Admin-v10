<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Blog;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BlogCrudTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create an admin user for authentication
        $this->admin = Admin::factory()->create([
            'email' => 'test@admin.com',
            'password' => bcrypt('password123'),
        ]);
    }

    /**
     * Test admin can view blogs list
     */
    public function test_admin_can_view_blogs_list(): void
    {
        // Create some blogs
        Blog::factory()->count(3)->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.blogs.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.blogs.index');
        $response->assertViewHas('blogs');
    }

    /**
     * Test admin can view create blog form
     */
    public function test_admin_can_view_create_blog_form(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.blogs.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.blogs.create');
        $response->assertSee('Create New Blog');
    }

    /**
     * Test admin can create a new blog
     */
    public function test_admin_can_create_blog(): void
    {
        $blogData = [
            'title' => 'Test Blog Post',
            'excerpt' => 'This is a test excerpt for the blog post.',
            'content' => '<p>This is the <strong>main content</strong> of the test blog post.</p>',
            'image' => 'https://example.com/image.jpg',
            'category' => 'Guides',
            'status' => 'published',
        ];

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.blogs.store'), $blogData);

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success', 'Blog created successfully!');

        $this->assertDatabaseHas('blogs', [
            'title' => 'Test Blog Post',
            'excerpt' => 'This is a test excerpt for the blog post.',
            'category' => 'Guides',
            'author' => $this->admin->name,
            'status' => 'published',
        ]);

        // Check slug was generated
        $blog = Blog::where('title', 'Test Blog Post')->first();
        $this->assertNotNull($blog->slug);
        $this->assertEquals('test-blog-post', $blog->slug);
    }

    /**
     * Test blog creation generates unique slug
     */
    public function test_blog_creation_generates_unique_slug(): void
    {
        // Create first blog
        Blog::factory()->create([
            'title' => 'Same Title',
            'slug' => 'same-title',
        ]);

        // Create second blog with same title
        $blogData = [
            'title' => 'Same Title',
            'excerpt' => 'Different excerpt',
            'content' => '<p>Different content</p>',
            'category' => 'Guides',
            'status' => 'draft',
        ];

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.blogs.store'), $blogData);

        $response->assertRedirect(route('admin.blogs.index'));

        // Check second blog has unique slug
        $secondBlog = Blog::where('title', 'Same Title')
            ->where('slug', '!=', 'same-title')
            ->first();
        
        $this->assertNotNull($secondBlog);
        $this->assertStringStartsWith('same-title-', $secondBlog->slug);
    }

    /**
     * Test blog creation validation
     */
    public function test_blog_creation_requires_all_fields(): void
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.blogs.store'), []);

        $response->assertSessionHasErrors(['title', 'excerpt', 'content', 'category', 'status']);
    }

    /**
     * Test admin can view edit blog form
     */
    public function test_admin_can_view_edit_blog_form(): void
    {
        $blog = Blog::factory()->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.blogs.edit', $blog));

        $response->assertStatus(200);
        $response->assertViewIs('admin.blogs.edit');
        $response->assertViewHas('blog', $blog);
        $response->assertSee($blog->title);
    }

    /**
     * Test admin can update a blog
     */
    public function test_admin_can_update_blog(): void
    {
        $blog = Blog::factory()->create([
            'title' => 'Original Title',
            'status' => 'draft',
        ]);

        $updatedData = [
            'title' => 'Updated Title',
            'excerpt' => 'Updated excerpt',
            'content' => '<p>Updated content</p>',
            'image' => 'https://example.com/updated.jpg',
            'category' => 'Updates',
            'author' => 'Updated Author',
            'status' => 'published',
        ];

        $response = $this->actingAs($this->admin, 'admin')
            ->put(route('admin.blogs.update', $blog), $updatedData);

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success', 'Blog updated successfully!');

        $blog->refresh();
        $this->assertEquals('Updated Title', $blog->title);
        $this->assertEquals('published', $blog->status);
        $this->assertNotNull($blog->published_at);
    }

    /**
     * Test updating blog regenerates slug if title changes
     */
    public function test_updating_blog_regenerates_slug_on_title_change(): void
    {
        $blog = Blog::factory()->create([
            'title' => 'Original Title',
            'slug' => 'original-title',
        ]);

        $updatedData = [
            'title' => 'New Title',
            'excerpt' => $blog->excerpt,
            'content' => $blog->content,
            'category' => $blog->category,
            'author' => $blog->author,
            'status' => $blog->status,
        ];

        $response = $this->actingAs($this->admin, 'admin')
            ->put(route('admin.blogs.update', $blog), $updatedData);

        $response->assertRedirect(route('admin.blogs.index'));

        $blog->refresh();
        $this->assertEquals('new-title', $blog->slug);
    }

    /**
     * Test admin can delete a blog
     */
    public function test_admin_can_delete_blog(): void
    {
        $blog = Blog::factory()->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->delete(route('admin.blogs.destroy', $blog));

        $response->assertRedirect(route('admin.blogs.index'));
        $response->assertSessionHas('success', 'Blog deleted successfully!');

        $this->assertDatabaseMissing('blogs', [
            'id' => $blog->id,
        ]);
    }

    /**
     * Test blogs can be filtered by status
     */
    public function test_blogs_can_be_filtered_by_status(): void
    {
        Blog::factory()->create(['status' => 'published']);
        Blog::factory()->create(['status' => 'published']);
        Blog::factory()->create(['status' => 'draft']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.blogs.index', ['status' => 'published']));

        $response->assertStatus(200);
        $blogs = $response->viewData('blogs');
        $this->assertEquals(2, $blogs->total());
    }

    /**
     * Test blogs can be filtered by category
     */
    public function test_blogs_can_be_filtered_by_category(): void
    {
        Blog::factory()->create(['category' => 'Guides']);
        Blog::factory()->create(['category' => 'Guides']);
        Blog::factory()->create(['category' => 'Updates']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.blogs.index', ['category' => 'Guides']));

        $response->assertStatus(200);
        $blogs = $response->viewData('blogs');
        $this->assertEquals(2, $blogs->total());
    }

    /**
     * Test blogs can be searched
     */
    public function test_blogs_can_be_searched(): void
    {
        Blog::factory()->create(['title' => 'Laravel Tutorial']);
        Blog::factory()->create(['title' => 'PHP Best Practices']);
        Blog::factory()->create(['title' => 'JavaScript Guide']);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.blogs.index', ['search' => 'Laravel']));

        $response->assertStatus(200);
        $blogs = $response->viewData('blogs');
        $this->assertEquals(1, $blogs->total());
        $this->assertEquals('Laravel Tutorial', $blogs->first()->title);
    }

    /**
     * Test guests cannot access admin blog pages
     */
    public function test_guests_cannot_access_admin_blog_pages(): void
    {
        $blog = Blog::factory()->create();

        // Index
        $this->get(route('admin.blogs.index'))
            ->assertRedirect();

        // Create
        $this->get(route('admin.blogs.create'))
            ->assertRedirect();

        // Store
        $this->post(route('admin.blogs.store'), [])
            ->assertRedirect();

        // Edit
        $this->get(route('admin.blogs.edit', $blog))
            ->assertRedirect();

        // Update
        $this->put(route('admin.blogs.update', $blog), [])
            ->assertRedirect();

        // Delete
        $this->delete(route('admin.blogs.destroy', $blog))
            ->assertRedirect();
    }

    /**
     * Test published blogs appear on frontend
     */
    public function test_published_blogs_appear_on_frontend(): void
    {
        $publishedBlog = Blog::factory()->create([
            'status' => 'published',
            'title' => 'Published Blog',
        ]);

        $draftBlog = Blog::factory()->create([
            'status' => 'draft',
            'title' => 'Draft Blog',
        ]);

        $response = $this->get(route('blogs'));

        $response->assertStatus(200);
        $response->assertSee('Published Blog');
        $response->assertDontSee('Draft Blog');
    }

    /**
     * Test blog detail page shows published blog
     */
    public function test_blog_detail_page_shows_published_blog(): void
    {
        $blog = Blog::factory()->create([
            'status' => 'published',
            'title' => 'Test Blog',
            'slug' => 'test-blog',
            'content' => '<p>Test content</p>',
        ]);

        $response = $this->get(route('blogs.show', $blog->slug));

        $response->assertStatus(200);
        $response->assertSee('Test Blog');
        $response->assertSee('Test content', false); // false = don't escape HTML
    }

    /**
     * Test draft blogs are not accessible on frontend
     */
    public function test_draft_blogs_not_accessible_on_frontend(): void
    {
        $blog = Blog::factory()->create([
            'status' => 'draft',
            'slug' => 'draft-blog',
        ]);

        $response = $this->get(route('blogs.show', $blog->slug));

        $response->assertStatus(404);
    }
}
