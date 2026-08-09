<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    private array $groups = [
        'website' => ['icon' => 'bi-globe',           'label' => 'Website Info'],
        'company' => ['icon' => 'bi-building',         'label' => 'Company / Contact'],
        'social'  => ['icon' => 'bi-share',            'label' => 'Social Media'],
        'home'    => ['icon' => 'bi-house-heart',      'label' => 'Home Page'],
        'about'   => ['icon' => 'bi-info-circle',      'label' => 'About Page'],
        'contact' => ['icon' => 'bi-envelope-heart',   'label' => 'Contact Page'],
        'seo'     => ['icon' => 'bi-search-heart',     'label' => 'SEO Settings'],
    ];

    public function index(Request $request)
    {
        $activeGroup = $request->get('group', 'website');
        if (!array_key_exists($activeGroup, $this->groups)) {
            $activeGroup = 'website';
        }

        $settings = Setting::where('group', $activeGroup)->orderBy('key')->get()->keyBy('key');

        return view('admin.settings.index', [
            'groups'      => $this->groups,
            'activeGroup' => $activeGroup,
            'settings'    => $settings,
        ]);
    }

    public function update(Request $request)
    {
        $group = $request->input('group', 'website');
        $data  = $request->except(['_token', '_method', 'group']);

        $existingKeys = Setting::where('group', $group)->pluck('type', 'key');

        foreach ($data as $key => $value) {
            $type = $existingKeys[$key] ?? 'text';

            if ($type === 'image' && $request->hasFile($key)) {
                $file = $request->file($key);
                $filename = $key . '_' . time() . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/settings'), $filename);
                $value = 'uploads/settings/' . $filename;
            } elseif ($type === 'image') {
                // Keep existing value if no new file uploaded
                $value = Setting::get($key, '');
            }

            Setting::set($key, $value ?? '', $group, $type, Setting::where('key', $key)->value('label'));
        }

        Setting::clearCache();

        return redirect()->route('admin.settings.index', ['group' => $group])
            ->with('success', 'Settings saved successfully.');
    }
}
