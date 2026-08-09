<?php

namespace App\Console\Commands;

use App\Models\PropertyImage;
use App\Models\Testimonial;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MigrateImagesToUploads extends Command
{
    /**
     * Usage: php artisan images:migrate-to-uploads
     */
    protected $signature = 'images:migrate-to-uploads {--dry-run : Show what would change without copying files or touching the database}';

    protected $description = 'Copy property & testimonial images from storage/app/public into public/uploads (symlink-free, cPanel safe) and update their disk references.';

    public function handle(): int
    {
        $dry = (bool) $this->option('dry-run');
        $this->info($dry ? 'Running in DRY-RUN mode — no changes will be made.' : 'Migrating images to public/uploads ...');

        $moved = 0;
        $skipped = 0;

        // ── Property images ───────────────────────────────────────────────
        foreach (PropertyImage::all() as $img) {
            if (!$img->image_path) {
                continue;
            }

            $target = public_path('uploads/' . $img->image_path);

            // Already in uploads — just make sure the disk column is correct.
            if (File::exists($target)) {
                if ($img->disk !== 'uploads' && !$dry) {
                    $img->update(['disk' => 'uploads']);
                }
                $skipped++;
                continue;
            }

            $source = $this->locateSource($img->image_path);
            if (!$source) {
                $this->warn("  [property #{$img->id}] source not found for: {$img->image_path}");
                $skipped++;
                continue;
            }

            if (!$dry) {
                File::ensureDirectoryExists(dirname($target));
                File::copy($source, $target);
                $img->update(['disk' => 'uploads']);
            }
            $this->line("  [property #{$img->id}] {$img->image_path}");
            $moved++;
        }

        // ── Testimonial images ────────────────────────────────────────────
        foreach (Testimonial::whereNotNull('image')->get() as $t) {
            $target = public_path('uploads/' . $t->image);
            if (File::exists($target)) {
                $skipped++;
                continue;
            }
            $source = $this->locateSource($t->image);
            if (!$source) {
                $this->warn("  [testimonial #{$t->id}] source not found for: {$t->image}");
                $skipped++;
                continue;
            }
            if (!$dry) {
                File::ensureDirectoryExists(dirname($target));
                File::copy($source, $target);
            }
            $this->line("  [testimonial #{$t->id}] {$t->image}");
            $moved++;
        }

        $this->newLine();
        $this->info("Done. Copied: {$moved}, skipped/already-present: {$skipped}.");

        return self::SUCCESS;
    }

    /**
     * Find the physical source of a stored relative path, checking the
     * storage public dir and the symlink location.
     */
    private function locateSource(string $relativePath): ?string
    {
        $candidates = [
            storage_path('app/public/' . $relativePath),
            public_path('storage/' . $relativePath),
        ];

        foreach ($candidates as $path) {
            if (File::exists($path)) {
                return $path;
            }
        }

        return null;
    }
}
