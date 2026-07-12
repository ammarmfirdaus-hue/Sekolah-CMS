<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\DocumentationEvent;
use App\Models\DocumentationMedia;
use App\Models\User;
use Database\Seeders\AdminUserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AdminDocumentationMediaTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(AdminUserSeeder::class);
        $this->admin = User::query()->where('email', 'admin@pkbmalfalah.test')->firstOrFail();
    }

    public function test_admin_can_upload_multiple_photos(): void
    {
        Storage::fake('public');

        $event = DocumentationEvent::factory()->create();

        $photo1 = UploadedFile::fake()->create('photo1.jpg', 1000, 'image/jpeg');
        $photo2 = UploadedFile::fake()->create('photo2.jpg', 1000, 'image/jpeg');

        $this->actingAs($this->admin)
            ->post(route('admin.documentation-events.media.store', $event), [
                'photos' => [$photo1, $photo2],
                'caption' => 'Test caption',
            ])
            ->assertRedirect(route('admin.documentation-events.edit', $event))
            ->assertSessionHas('status');

        $this->assertDatabaseCount('documentation_media', 2);

        $media = $event->media()->orderBy('sort_order')->get();
        $this->assertCount(2, $media);
        $this->assertEquals('Test caption', $media[0]->caption);
        $this->assertEquals('Test caption', $media[1]->caption);

        Storage::disk('public')->assertExists($media[0]->path);
        Storage::disk('public')->assertExists($media[1]->path);
    }

    public function test_first_uploaded_photo_becomes_featured_if_no_featured_exists(): void
    {
        Storage::fake('public');

        $event = DocumentationEvent::factory()->create();

        $photo1 = UploadedFile::fake()->create('photo1.jpg', 1000, 'image/jpeg');
        $photo2 = UploadedFile::fake()->create('photo2.jpg', 1000, 'image/jpeg');

        $this->actingAs($this->admin)
            ->post(route('admin.documentation-events.media.store', $event), [
                'photos' => [$photo1, $photo2],
            ]);

        $media = $event->media()->orderBy('sort_order')->get();
        $this->assertTrue($media[0]->is_featured);
        $this->assertFalse($media[1]->is_featured);
    }

    public function test_uploaded_photo_is_not_featured_if_featured_already_exists(): void
    {
        Storage::fake('public');

        $event = DocumentationEvent::factory()->create();
        $existingMedia = DocumentationMedia::factory()->for($event)->create(['is_featured' => true, 'sort_order' => 1]);

        $this->assertDatabaseHas('documentation_media', [
            'id' => $existingMedia->id,
            'is_featured' => true,
        ]);

        $photo = UploadedFile::fake()->create('new-photo.jpg', 1000, 'image/jpeg');

        $this->actingAs($this->admin)
            ->post(route('admin.documentation-events.media.store', $event), [
                'photos' => [$photo],
            ]);

        $this->assertEquals(2, $event->media()->count());

        $newMedia = $event->media()->orderByDesc('id')->first();
        $this->assertFalse($newMedia->is_featured);

        $this->assertDatabaseHas('documentation_media', [
            'id' => $existingMedia->id,
            'is_featured' => true,
        ]);
    }

    public function test_admin_can_update_media_caption(): void
    {
        $event = DocumentationEvent::factory()->create();
        $media = DocumentationMedia::factory()->for($event)->create(['caption' => 'Old caption']);

        $this->actingAs($this->admin)
            ->patch(route('admin.documentation-events.media.update', [$event, $media]), [
                'caption' => 'New caption',
            ])
            ->assertRedirect(route('admin.documentation-events.edit', $event));

        $this->assertDatabaseHas('documentation_media', [
            'id' => $media->id,
            'caption' => 'New caption',
        ]);
    }

    public function test_admin_can_set_media_as_featured(): void
    {
        $event = DocumentationEvent::factory()->create();
        $media1 = DocumentationMedia::factory()->for($event)->create(['is_featured' => true, 'sort_order' => 1]);
        $media2 = DocumentationMedia::factory()->for($event)->create(['is_featured' => false, 'sort_order' => 2]);

        $this->actingAs($this->admin)
            ->patch(route('admin.documentation-events.media.set-featured', [$event, $media2]))
            ->assertRedirect(route('admin.documentation-events.edit', $event));

        $this->assertDatabaseHas('documentation_media', [
            'id' => $media1->id,
            'is_featured' => false,
        ]);

        $this->assertDatabaseHas('documentation_media', [
            'id' => $media2->id,
            'is_featured' => true,
        ]);
    }

    public function test_admin_can_delete_media(): void
    {
        Storage::fake('public');

        $event = DocumentationEvent::factory()->create();
        $path = 'documentation/events/1/test.jpg';
        Storage::disk('public')->put($path, 'fake-content');
        $media = DocumentationMedia::factory()->for($event)->create(['path' => $path, 'is_featured' => false]);

        $this->actingAs($this->admin)
            ->delete(route('admin.documentation-events.media.destroy', [$event, $media]))
            ->assertRedirect(route('admin.documentation-events.edit', $event));

        $this->assertDatabaseMissing('documentation_media', ['id' => $media->id]);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_deleting_featured_media_assigns_next_media_as_featured(): void
    {
        Storage::fake('public');

        $event = DocumentationEvent::factory()->create();
        $media1 = DocumentationMedia::factory()->for($event)->create(['is_featured' => true, 'sort_order' => 1]);
        $media2 = DocumentationMedia::factory()->for($event)->create(['is_featured' => false, 'sort_order' => 2]);

        $this->actingAs($this->admin)
            ->delete(route('admin.documentation-events.media.destroy', [$event, $media1]));

        $this->assertDatabaseHas('documentation_media', [
            'id' => $media2->id,
            'is_featured' => true,
        ]);
    }

    public function test_deleting_event_removes_all_media_files(): void
    {
        Storage::fake('public');

        $event = DocumentationEvent::factory()->create();
        $path1 = 'documentation/events/1/photo1.jpg';
        $path2 = 'documentation/events/1/photo2.jpg';

        Storage::disk('public')->put($path1, 'fake-content-1');
        Storage::disk('public')->put($path2, 'fake-content-2');

        DocumentationMedia::factory()->for($event)->create(['path' => $path1]);
        DocumentationMedia::factory()->for($event)->create(['path' => $path2]);

        $this->actingAs($this->admin)
            ->delete(route('admin.documentation-events.destroy', $event))
            ->assertRedirect(route('admin.documentation-events.index'));

        Storage::disk('public')->assertMissing($path1);
        Storage::disk('public')->assertMissing($path2);
    }

    public function test_cannot_manipulate_media_from_different_event(): void
    {
        $event1 = DocumentationEvent::factory()->create();
        $event2 = DocumentationEvent::factory()->create();
        $media = DocumentationMedia::factory()->for($event2)->create();

        $this->actingAs($this->admin)
            ->patch(route('admin.documentation-events.media.update', [$event1, $media]), ['caption' => 'Test'])
            ->assertNotFound();

        $this->actingAs($this->admin)
            ->patch(route('admin.documentation-events.media.set-featured', [$event1, $media]))
            ->assertNotFound();

        $this->actingAs($this->admin)
            ->delete(route('admin.documentation-events.media.destroy', [$event1, $media]))
            ->assertNotFound();
    }

    public function test_validation_rejects_non_image_files(): void
    {
        $event = DocumentationEvent::factory()->create();
        $file = UploadedFile::fake()->create('document.pdf', 1000);

        $this->actingAs($this->admin)
            ->post(route('admin.documentation-events.media.store', $event), [
                'photos' => [$file],
            ])
            ->assertSessionHasErrors('photos.0');
    }

    public function test_validation_rejects_oversized_files(): void
    {
        $event = DocumentationEvent::factory()->create();
        $file = UploadedFile::fake()->create('huge.jpg', 5000, 'image/jpeg');

        $this->actingAs($this->admin)
            ->post(route('admin.documentation-events.media.store', $event), [
                'photos' => [$file],
            ])
            ->assertSessionHasErrors('photos.0');
    }

    public function test_validation_rejects_more_than_10_files(): void
    {
        $event = DocumentationEvent::factory()->create();
        $photos = [];

        for ($i = 0; $i < 11; $i++) {
            $photos[] = UploadedFile::fake()->create("photo{$i}.jpg", 1000, 'image/jpeg');
        }

        $this->actingAs($this->admin)
            ->post(route('admin.documentation-events.media.store', $event), [
                'photos' => $photos,
            ])
            ->assertSessionHasErrors('photos');
    }

    public function test_non_admin_cannot_manage_media(): void
    {
        $teacher = User::factory()->create(['role' => UserRole::TEACHER]);
        $event = DocumentationEvent::factory()->create();

        $this->actingAs($teacher)
            ->post(route('admin.documentation-events.media.store', $event), [])
            ->assertForbidden();
    }
}
