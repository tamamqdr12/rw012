<?php

$route = 'map-location';
$title = 'Peta Lokasi';
$fields = [
    'name' => 'string',
    'type' => 'select_type',
    'latitude' => 'string',
    'longitude' => 'string',
    'description' => 'textarea'
];
$controllerName = 'MapLocationController';
$model = 'MapLocation';

$controllerCode = "<?php\n\nnamespace App\Http\Controllers\Admin;\n\nuse App\Http\Controllers\Controller;\nuse App\Models\\$model;\nuse Illuminate\Http\Request;\n";

$validationRules = [];
foreach ($fields as $field => $type) {
    if ($field == 'latitude' || $field == 'longitude') {
        $validationRules[] = "'$field' => 'nullable|string'";
    } else {
        $validationRules[] = "'$field' => 'required'";
    }
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

$tableRows = "<td>{{ \$item->name }}</td>\n<td>{{ \$item->type }}</td>\n<td>{{ \$item->latitude && \$item->longitude ? \$item->latitude.', '.\$item->longitude : 'Belum diset' }}</td>\n<td>{{ Str::limit(\$item->description, 30) }}</td>\n";

$indexView = "@extends('layouts.admin')\n@section('content')\n<div class='d-flex justify-content-between mb-4'>\n    <h2 class='fw-bold'>Kelola {$title}</h2>\n    <a href=\"{{ route('admin.{$route}.create') }}\" class='btn btn-primary'><i class='bi bi-plus-lg'></i> Tambah Lokasi</a>\n</div>\n<div class='card border-0 shadow-sm'>\n    <div class='card-body'>\n        <div class='table-responsive'>\n            <table class='table table-bordered table-hover align-middle'>\n                <thead class='table-light'>\n                    <tr>\n                        <th>Nama Lokasi</th>\n                        <th>Kategori</th>\n                        <th>Koordinat</th>\n                        <th>Deskripsi</th>\n                        <th width='150'>Aksi</th>\n                    </tr>\n                </thead>\n                <tbody>\n                    @forelse(\$data as \$item)\n                    <tr>\n                        $tableRows\n                        <td>\n                            <a href=\"{{ route('admin.{$route}.edit', \$item->id) }}\" class='btn btn-sm btn-warning'><i class='bi bi-pencil'></i></a>\n                            <form action=\"{{ route('admin.{$route}.destroy', \$item->id) }}\" method='POST' class='d-inline' onsubmit=\"return confirm('Yakin ingin menghapus data ini?')\">\n                                @csrf\n                                @method('DELETE')\n                                <button type='submit' class='btn btn-sm btn-danger'><i class='bi bi-trash'></i></button>\n                            </form>\n                        </td>\n                    </tr>\n                    @empty\n                    <tr><td colspan='100%' class='text-center'>Data tidak ditemukan</td></tr>\n                    @endforelse\n                </tbody>\n            </table>\n        </div>\n    </div>\n</div>\n@endsection";
file_put_contents("$viewDir/index.blade.php", $indexView);

$buildForm = function($isEdit) use ($fields, $route, $title) {
    $formRows = "";
    foreach ($fields as $field => $type) {
        $label = ucfirst(str_replace('_', ' ', $field));
        $val = $isEdit ? "old('{$field}', \$item->{$field})" : "old('{$field}')";
        
        if ($type == 'textarea') {
            $formRows .= "<div class='mb-3'><label class='form-label'>{$label}</label><textarea class='form-control' name='{$field}' rows='4' required>{{ $val }}</textarea></div>\n";
        } else if ($type == 'select_type') {
            $categories = ['Sekretariat RW', 'RT 001', 'RT 002', 'RT 003', 'Posyandu', 'Masjid/Musala', 'Sekolah', 'Fasilitas umum', 'Pos keamanan', 'UMKM', 'Lokasi penting lainnya'];
            $formRows .= "<div class='mb-3'><label class='form-label'>Kategori Lokasi</label><select class='form-select' name='{$field}' required><option value=''>Pilih Kategori</option>";
            foreach($categories as $c) {
                $sel = $isEdit ? "{{ \$item->{$field} == '$c' ? 'selected' : '' }}" : "";
                $formRows .= "<option value='$c' $sel>$c</option>";
            }
            $formRows .= "</select></div>\n";
        } else if ($field == 'latitude' || $field == 'longitude') {
            $formRows .= "<div class='mb-3'><label class='form-label'>{$label}</label><input type='text' class='form-control' name='{$field}' value=\"{{ $val }}\" placeholder=\"Boleh dikosongkan jika belum tahu, misal: -6.1852\"></div>\n";
        } else {
            $formRows .= "<div class='mb-3'><label class='form-label'>{$label}</label><input type='text' class='form-control' name='{$field}' value=\"{{ $val }}\" required></div>\n";
        }
    }
    
    $method = $isEdit ? "@method('PUT')" : "";
    $action = $isEdit ? "{{ route('admin.{$route}.update', \$item->id) }}" : "{{ route('admin.{$route}.store') }}";
    $pageTitle = $isEdit ? "Edit $title" : "Tambah $title";
    
    return "@extends('layouts.admin')\n@section('content')\n<h2 class='fw-bold mb-4'>$pageTitle</h2>\n<div class='card border-0 shadow-sm'><div class='card-body'>\n<form action=\"$action\" method='POST'>\n@csrf\n$method\n$formRows\n<a href=\"{{ route('admin.{$route}.index') }}\" class='btn btn-secondary'>Kembali</a> <button type='submit' class='btn btn-primary'>Simpan</button>\n</form>\n</div></div>\n@endsection";
};

file_put_contents("$viewDir/create.blade.php", $buildForm(false));
file_put_contents("$viewDir/edit.blade.php", $buildForm(true));

echo "Map CRUD Updated!";
