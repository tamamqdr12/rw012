<?php

$controllers = [
    'DailyReport' => [
        'route' => 'daily-report',
        'title' => 'Daily Report',
        'fields' => [
            'title' => 'string', 
            'date' => 'date', 
            'category' => 'select_category',
            'description' => 'textarea',
            'writer_name' => 'string',
            'photo_path' => 'file',
            'is_published' => 'boolean'
        ]
    ],
    'Announcement' => [
        'route' => 'pengumuman',
        'title' => 'Pengumuman',
        'fields' => [
            'title' => 'string', 
            'publish_date' => 'datetime-local',
            'content' => 'textarea',
            'photo_path' => 'file',
            'is_pinned' => 'boolean',
            'is_active' => 'boolean'
        ]
    ],
    'Event' => [
        'route' => 'kegiatan',
        'title' => 'Kegiatan',
        'fields' => [
            'title' => 'string', 
            'event_date' => 'date', 
            'event_time' => 'time',
            'location' => 'string', 
            'organizer' => 'string',
            'description' => 'textarea',
            'photo_path' => 'file',
            'status' => 'select_status'
        ]
    ]
];

foreach ($controllers as $model => $config) {
    $route = $config['route'];
    $title = $config['title'];
    $fields = $config['fields'];
    $controllerName = $model . 'Controller';

    // 1. Controller
    $controllerCode = "<?php\n\nnamespace App\Http\Controllers\Admin;\n\nuse App\Http\Controllers\Controller;\nuse App\Models\\$model;\nuse Illuminate\Http\Request;\nuse Illuminate\Support\Facades\Storage;\n";
    
    $validationRules = [];
    foreach ($fields as $field => $type) {
        if ($type == 'boolean') $validationRules[] = "'$field' => 'nullable|boolean'";
        else if ($type == 'file') $validationRules[] = "'$field' => 'nullable|image|max:2048'";
        else if ($type == 'select_category' || $type == 'select_status' || $type == 'textarea' || $type == 'string' || $type == 'date' || $type == 'time' || $type == 'datetime-local') $validationRules[] = "'$field' => 'required'";
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
        return view('admin.{$route}.create');
    }

    public function store(Request \$request)
    {
        \$data = \$request->validate([
            $validationStr
        ]);

";
    foreach ($fields as $field => $type) {
        if ($type == 'boolean') {
            $controllerCode .= "        \$data['$field'] = \$request->has('$field');\n";
        }
        if ($type == 'file') {
            $controllerCode .= "        if (\$request->hasFile('$field')) {\n            \$data['$field'] = \$request->file('$field')->store('uploads', 'public');\n        }\n";
        }
    }
    
    $controllerCode .= "
        {$model}::create(\$data);
        return redirect()->route('admin.{$route}.index')->with('success', 'Data berhasil ditambahkan');
    }

    public function edit(\$id)
    {
        \$item = {$model}::findOrFail(\$id);
        return view('admin.{$route}.edit', compact('item'));
    }

    public function update(Request \$request, \$id)
    {
        \$data = \$request->validate([
            $validationStr
        ]);
        
        \$item = {$model}::findOrFail(\$id);

";
    foreach ($fields as $field => $type) {
        if ($type == 'boolean') {
            $controllerCode .= "        \$data['$field'] = \$request->has('$field');\n";
        }
        if ($type == 'file') {
            $controllerCode .= "        if (\$request->hasFile('$field')) {\n            if (\$item->$field && Storage::disk('public')->exists(\$item->$field)) { Storage::disk('public')->delete(\$item->$field); }\n            \$data['$field'] = \$request->file('$field')->store('uploads', 'public');\n        }\n";
        }
    }

    $controllerCode .= "
        \$item->update(\$data);
        return redirect()->route('admin.{$route}.index')->with('success', 'Data berhasil diperbarui');
    }

    public function destroy(\$id)
    {
        \$item = {$model}::findOrFail(\$id);
";
    foreach ($fields as $field => $type) {
        if ($type == 'file') {
            $controllerCode .= "        if (\$item->$field && Storage::disk('public')->exists(\$item->$field)) { Storage::disk('public')->delete(\$item->$field); }\n";
        }
    }
    $controllerCode .= "        \$item->delete();
        return redirect()->route('admin.{$route}.index')->with('success', 'Data berhasil dihapus');
    }
}
";
    file_put_contents(__DIR__ . "/app/Http/Controllers/Admin/{$controllerName}.php", $controllerCode);

    // 2. Views
    $viewDir = __DIR__ . "/resources/views/admin/{$route}";
    
    // Index
    $tableHeaders = "";
    $tableRows = "";
    foreach (array_keys($fields) as $field) {
        if($field == 'description' || $field == 'content') continue;
        $label = ucfirst(str_replace('_', ' ', $field));
        $tableHeaders .= "<th>{$label}</th>\n";
        
        if ($fields[$field] == 'boolean') {
            $tableRows .= "<td>{{ \$item->{$field} ? 'Ya' : 'Tidak' }}</td>\n";
        } else if ($fields[$field] == 'file') {
            $tableRows .= "<td>@if(\$item->{$field}) <img src=\"{{ asset('storage/'.\$item->{$field}) }}\" height=\"50\"> @else - @endif</td>\n";
        } else {
            $tableRows .= "<td>{{ Str::limit(\$item->{$field}, 30) }}</td>\n";
        }
    }
    $indexView = "@extends('layouts.admin')\n@section('content')\n<div class='d-flex justify-content-between mb-4'>\n    <h2 class='fw-bold'>Kelola {$title}</h2>\n    <a href=\"{{ route('admin.{$route}.create') }}\" class='btn btn-primary'><i class='bi bi-plus-lg'></i> Tambah Data</a>\n</div>\n<div class='card border-0 shadow-sm'>\n    <div class='card-body'>\n        <div class='table-responsive'>\n            <table class='table table-bordered table-hover align-middle'>\n                <thead class='table-light'>\n                    <tr>\n                        $tableHeaders\n                        <th width='150'>Aksi</th>\n                    </tr>\n                </thead>\n                <tbody>\n                    @forelse(\$data as \$item)\n                    <tr>\n                        $tableRows\n                        <td>\n                            <a href=\"{{ route('admin.{$route}.edit', \$item->id) }}\" class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>\n                            <form action=\"{{ route('admin.{$route}.destroy', \$item->id) }}\" method='POST' class='d-inline' onsubmit=\"return confirm('Yakin ingin menghapus data ini?')\">\n                                @csrf\n                                @method('DELETE')\n                                <button type='submit' class='btn btn-sm btn-danger'><i class='bi bi-trash'></i></button>\n                            </form>\n                        </td>\n                    </tr>\n                    @empty\n                    <tr><td colspan='100%' class='text-center'>Data tidak ditemukan</td></tr>\n                    @endforelse\n                </tbody>\n            </table>\n        </div>\n    </div>\n</div>\n@endsection";
    file_put_contents("$viewDir/index.blade.php", $indexView);

    // Form helper
    $buildForm = function($isEdit) use ($fields, $route, $title) {
        $formRows = "";
        foreach ($fields as $field => $type) {
            $label = ucfirst(str_replace('_', ' ', $field));
            $val = $isEdit ? "old('{$field}', \$item->{$field})" : "old('{$field}')";
            
            if ($type == 'textarea') {
                $formRows .= "<div class='mb-3'><label class='form-label'>{$label}</label><textarea class='form-control' name='{$field}' rows='4' required>{{ $val }}</textarea></div>\n";
            } else if ($type == 'boolean') {
                $checked = $isEdit ? "{{ \$item->{$field} ? 'checked' : '' }}" : "";
                $formRows .= "<div class='mb-3 form-check'><input type='checkbox' class='form-check-input' name='{$field}' value='1' $checked id='{$field}'><label class='form-check-label' for='{$field}'>Aktif/Tandai</label></div>\n";
            } else if ($type == 'file') {
                $formRows .= "<div class='mb-3'><label class='form-label'>{$label}</label><input type='file' class='form-control' name='{$field}'>\n";
                if ($isEdit) $formRows .= "@if(\$item->$field) <div class='mt-2'><img src=\"{{ asset('storage/'.\$item->$field) }}\" height='100'></div> @endif\n";
                $formRows .= "</div>\n";
            } else if ($type == 'select_category') {
                $categories = ['Kebersihan', 'Keamanan', 'Sosial', 'Lingkungan', 'Kesehatan', 'Infrastruktur', 'Kegiatan warga', 'Lainnya'];
                $formRows .= "<div class='mb-3'><label class='form-label'>Kategori</label><select class='form-select' name='{$field}' required><option value=''>Pilih Kategori</option>";
                foreach($categories as $c) {
                    $sel = $isEdit ? "{{ \$item->{$field} == '$c' ? 'selected' : '' }}" : "";
                    $formRows .= "<option value='$c' $sel>$c</option>";
                }
                $formRows .= "</select></div>\n";
            } else if ($type == 'select_status') {
                $statuses = ['Akan Datang', 'Berlangsung', 'Selesai'];
                $formRows .= "<div class='mb-3'><label class='form-label'>Status</label><select class='form-select' name='{$field}' required>";
                foreach($statuses as $c) {
                    $sel = $isEdit ? "{{ \$item->{$field} == '$c' ? 'selected' : '' }}" : "";
                    $formRows .= "<option value='$c' $sel>$c</option>";
                }
                $formRows .= "</select></div>\n";
            } else {
                $inputType = $type == 'date' ? 'date' : ($type == 'datetime-local' ? 'datetime-local' : ($type == 'time' ? 'time' : 'text'));
                $formRows .= "<div class='mb-3'><label class='form-label'>{$label}</label><input type='{$inputType}' class='form-control' name='{$field}' value=\"{{ $val }}\" required></div>\n";
            }
        }
        $method = $isEdit ? "@method('PUT')" : "";
        $action = $isEdit ? "{{ route('admin.{$route}.update', \$item->id) }}" : "{{ route('admin.{$route}.store') }}";
        $pageTitle = $isEdit ? "Edit $title" : "Tambah $title";
        return "@extends('layouts.admin')\n@section('content')\n<h2 class='fw-bold mb-4'>$pageTitle</h2>\n<div class='card border-0 shadow-sm'><div class='card-body'>\n<form action=\"$action\" method='POST' enctype='multipart/form-data'>\n@csrf\n$method\n$formRows\n<a href=\"{{ route('admin.{$route}.index') }}\" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>\n</form>\n</div></div>\n@endsection";
    };

    file_put_contents("$viewDir/create.blade.php", $buildForm(false));
    file_put_contents("$viewDir/edit.blade.php", $buildForm(true));
}
echo "Features Updated!";
