<?php

$models = [
    'RwProfile' => [
        'route' => 'rw-profile',
        'title' => 'Profil RW',
        'fields' => ['name' => 'string', 'village' => 'string', 'district' => 'string', 'city' => 'string']
    ],
    'Rt' => [
        'route' => 'rt',
        'title' => 'Data RT',
        'fields' => ['name' => 'string']
    ],
    'OrganizationalMember' => [
        'route' => 'pengurus',
        'title' => 'Pengurus',
        'fields' => ['name' => 'string', 'role' => 'string', 'rt_id' => 'select_rt']
    ],
    'ResidentsStatistic' => [
        'route' => 'data-warga',
        'title' => 'Data Warga',
        'fields' => ['rt_id' => 'select_rt', 'male_count' => 'number', 'female_count' => 'number', 'total_count' => 'number']
    ],
    'MapLocation' => [
        'route' => 'map-location',
        'title' => 'Map Location',
        'fields' => ['type' => 'string', 'latitude' => 'string', 'longitude' => 'string', 'description' => 'textarea']
    ],
    'DailyReport' => [
        'route' => 'daily-report',
        'title' => 'Daily Report',
        'fields' => ['title' => 'string', 'date' => 'date', 'description' => 'textarea']
    ],
    'Announcement' => [
        'route' => 'pengumuman',
        'title' => 'Pengumuman',
        'fields' => ['title' => 'string', 'is_active' => 'boolean', 'content' => 'textarea']
    ],
    'Event' => [
        'route' => 'kegiatan',
        'title' => 'Kegiatan',
        'fields' => ['title' => 'string', 'event_date' => 'datetime-local', 'location' => 'string', 'description' => 'textarea']
    ],
    'Gallery' => [
        'route' => 'galeri',
        'title' => 'Galeri',
        'fields' => ['title' => 'string', 'image_path' => 'string', 'description' => 'textarea']
    ],
    'Aspiration' => [
        'route' => 'aspirasi',
        'title' => 'Aspirasi',
        'fields' => ['sender_name' => 'string', 'status' => 'select_status', 'message' => 'textarea']
    ],
    'Contact' => [
        'route' => 'kontak',
        'title' => 'Kontak',
        'fields' => ['name' => 'string', 'phone_number' => 'string']
    ],
];

$routes = "\n// Admin CRUD Routes\n";

if (!is_dir(__DIR__.'/app/Http/Controllers/Admin')) {
    mkdir(__DIR__.'/app/Http/Controllers/Admin', 0777, true);
}

foreach ($models as $model => $config) {
    $route = $config['route'];
    $title = $config['title'];
    $fields = $config['fields'];
    $controllerName = $model . 'Controller';

    $routes .= "Route::resource('admin/{$route}', App\Http\Controllers\Admin\\{$controllerName}::class, ['as' => 'admin']);\n";

    // 1. Controller
    $controllerCode = "<?php\n\nnamespace App\Http\Controllers\Admin;\n\nuse App\Http\Controllers\Controller;\nuse App\Models\\$model;\nuse Illuminate\Http\Request;\n";
    if (in_array('select_rt', array_values($fields))) {
        $controllerCode .= "use App\Models\Rt;\n";
    }
    
    $validationRules = [];
    foreach ($fields as $field => $type) {
        if ($type == 'boolean') $validationRules[] = "'$field' => 'boolean'";
        else if ($type == 'select_rt') $validationRules[] = "'$field' => 'nullable|exists:rts,id'";
        else $validationRules[] = "'$field' => 'required'";
    }
    $validationStr = implode(",\n            ", $validationRules);

    $controllerCode .= "
class {$controllerName} extends Controller
{
    public function index()
    {
        \$data = $model::latest()->get();
        return view('admin.{$route}.index', compact('data'));
    }

    public function create()
    {
";
    if (in_array('select_rt', array_values($fields))) {
        $controllerCode .= "        \$rts = Rt::all();\n        return view('admin.{$route}.create', compact('rts'));\n";
    } else {
        $controllerCode .= "        return view('admin.{$route}.create');\n";
    }
    
    $controllerCode .= "    }

    public function store(Request \$request)
    {
        \$data = \$request->validate([
            $validationStr
        ]);
";
    if (isset($fields['is_active'])) {
        $controllerCode .= "        \$data['is_active'] = \$request->has('is_active');\n";
    }
    $controllerCode .= "
        {$model}::create(\$data);
        return redirect()->route('admin.{$route}.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(\$id)
    {
        \$item = {$model}::findOrFail(\$id);
";
    if (in_array('select_rt', array_values($fields))) {
        $controllerCode .= "        \$rts = Rt::all();\n        return view('admin.{$route}.edit', compact('item', 'rts'));\n";
    } else {
        $controllerCode .= "        return view('admin.{$route}.edit', compact('item'));\n";
    }
    $controllerCode .= "    }

    public function update(Request \$request, \$id)
    {
        \$data = \$request->validate([
            $validationStr
        ]);
";
    if (isset($fields['is_active'])) {
        $controllerCode .= "        \$data['is_active'] = \$request->has('is_active');\n";
    }
    $controllerCode .= "
        \$item = {$model}::findOrFail(\$id);
        \$item->update(\$data);
        return redirect()->route('admin.{$route}.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(\$id)
    {
        \$item = {$model}::findOrFail(\$id);
        \$item->delete();
        return redirect()->route('admin.{$route}.index')->with('success', 'Data berhasil dihapus');
    }
}
";
    file_put_contents(__DIR__ . "/app/Http/Controllers/Admin/{$controllerName}.php", $controllerCode);

    // 2. Views
    $viewDir = __DIR__ . "/resources/views/admin/{$route}";
    if (!is_dir($viewDir)) mkdir($viewDir, 0777, true);

    // Index
    $tableHeaders = "";
    $tableRows = "";
    foreach (array_keys($fields) as $field) {
        $label = ucfirst(str_replace('_', ' ', $field));
        $tableHeaders .= "<th>{$label}</th>\n";
        if ($fields[$field] == 'select_rt') {
            $tableRows .= "<td>{{ \$item->rt ? \$item->rt->name : '-' }}</td>\n";
        } else if ($fields[$field] == 'boolean') {
            $tableRows .= "<td>{{ \$item->{$field} ? 'Ya' : 'Tidak' }}</td>\n";
        } else {
            $tableRows .= "<td>{{ Str::limit(\$item->{$field}, 50) }}</td>\n";
        }
    }
    $indexView = "@extends('layouts.admin')

@section('content')
<div class='d-flex justify-content-between mb-4'>
    <h2 class='fw-bold'>Kelola {$title}</h2>
    <a href=\"{{ route('admin.{$route}.create') }}\" class='btn btn-primary'><i class='bi bi-plus-lg'></i> Tambah Data</a>
</div>
<div class='card border-0 shadow-sm'>
    <div class='card-body'>
        <div class='table-responsive'>
            <table class='table table-bordered table-hover align-middle'>
                <thead class='table-light'>
                    <tr>
                        $tableHeaders
                        <th width='150'>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse(\$data as \$item)
                    <tr>
                        $tableRows
                        <td>
                            <a href=\"{{ route('admin.{$route}.edit', \$item->id) }}\" class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>
                            <form action=\"{{ route('admin.{$route}.destroy', \$item->id) }}\" method='POST' class='d-inline' onsubmit=\"return confirm('Yakin ingin menghapus data ini?')\">
                                @csrf
                                @method('DELETE')
                                <button type='submit' class='btn btn-sm btn-danger'><i class='bi bi-trash'></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan='100%' class='text-center'>Data tidak ditemukan</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection";
    file_put_contents("$viewDir/index.blade.php", $indexView);

    // Form builder helper
    $buildForm = function($isEdit) use ($fields, $route, $title) {
        $formRows = "";
        foreach ($fields as $field => $type) {
            $label = ucfirst(str_replace('_', ' ', $field));
            $val = $isEdit ? "old('{$field}', \$item->{$field})" : "old('{$field}')";
            
            if ($type == 'textarea') {
                $formRows .= "<div class='mb-3'><label class='form-label'>{$label}</label><textarea class='form-control' name='{$field}' rows='4' required>{{ $val }}</textarea></div>\n";
            } else if ($type == 'boolean') {
                $checked = $isEdit ? "{{ \$item->{$field} ? 'checked' : '' }}" : "";
                $formRows .= "<div class='mb-3 form-check'><input type='checkbox' class='form-check-input' name='{$field}' value='1' $checked id='{$field}'><label class='form-check-label' for='{$field}'>Aktif/Publish</label></div>\n";
            } else if ($type == 'select_rt') {
                $formRows .= "<div class='mb-3'><label class='form-label'>Pilih RT</label><select class='form-select' name='{$field}'><option value=''>-- Bukan Pengurus RT (Pilih jika RW/Lainnya) --</option>@foreach(\$rts as \$rt)<option value='{{ \$rt->id }}' " . ($isEdit ? "{{ \$item->{$field} == \$rt->id ? 'selected' : '' }}" : "") . ">{{ \$rt->name }}</option>@endforeach</select></div>\n";
            } else if ($type == 'select_status') {
                $formRows .= "<div class='mb-3'><label class='form-label'>Status</label><select class='form-select' name='{$field}' required><option value='pending' " . ($isEdit ? "{{ \$item->{$field} == 'pending' ? 'selected' : '' }}" : "") . ">Pending</option><option value='resolved' " . ($isEdit ? "{{ \$item->{$field} == 'resolved' ? 'selected' : '' }}" : "") . ">Resolved</option></select></div>\n";
            } else {
                $inputType = $type == 'date' ? 'date' : ($type == 'datetime-local' ? 'datetime-local' : ($type == 'number' ? 'number' : 'text'));
                $formRows .= "<div class='mb-3'><label class='form-label'>{$label}</label><input type='{$inputType}' class='form-control' name='{$field}' value=\"{{ $val }}\" required></div>\n";
            }
        }
        $method = $isEdit ? "@method('PUT')" : "";
        $action = $isEdit ? "{{ route('admin.{$route}.update', \$item->id) }}" : "{{ route('admin.{$route}.store') }}";
        $pageTitle = $isEdit ? "Edit $title" : "Tambah $title";
        return "@extends('layouts.admin')\n@section('content')\n<h2 class='fw-bold mb-4'>$pageTitle</h2>\n<div class='card border-0 shadow-sm'><div class='card-body'>\n<form action=\"$action\" method='POST'>\n@csrf\n$method\n$formRows\n<a href=\"{{ route('admin.{$route}.index') }}\" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>\n</form>\n</div></div>\n@endsection";
    };

    file_put_contents("$viewDir/create.blade.php", $buildForm(false));
    file_put_contents("$viewDir/edit.blade.php", $buildForm(true));
}

// Write Routes
$webphp = file_get_contents(__DIR__ . '/routes/web.php');
$webphp = str_replace("Route::middleware('auth')->group(function () {", "Route::middleware('auth')->group(function () {\n" . $routes, $webphp);
file_put_contents(__DIR__ . '/routes/web.php', $webphp);

echo "CRUD Generated Successfully!\n";
