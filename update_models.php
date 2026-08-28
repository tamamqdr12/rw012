<?php
$modelsDir = __DIR__ . '/app/Models';
$files = glob($modelsDir . '/*.php');
foreach ($files as $file) {
    if (basename($file) === 'User.php') continue;
    $content = file_get_contents($file);
    if (strpos($content, 'protected $guarded') === false) {
        $content = str_replace('use HasFactory;', "use HasFactory;\n\n    protected \$guarded = ['id'];", $content);
    }
    
    if (basename($file) === 'Rt.php' && strpos($content, 'organizationalMembers') === false) {
        $content = str_replace('}', "
    public function organizationalMembers()
    {
        return \$this->hasMany(OrganizationalMember::class);
    }

    public function residentsStatistic()
    {
        return \$this->hasOne(ResidentsStatistic::class);
    }
}", $content);
    }

    if (basename($file) === 'OrganizationalMember.php' && strpos($content, 'public function rt') === false) {
        $content = str_replace('}', "
    public function rt()
    {
        return \$this->belongsTo(Rt::class);
    }
}", $content);
    }

    if (basename($file) === 'ResidentsStatistic.php' && strpos($content, 'public function rt') === false) {
        $content = str_replace('}', "
    public function rt()
    {
        return \$this->belongsTo(Rt::class);
    }
}", $content);
    }

    if (basename($file) === 'DailyReport.php' && strpos($content, 'public function author') === false) {
        $content = str_replace('}', "
    public function author()
    {
        return \$this->belongsTo(User::class, 'author_id');
    }
}", $content);
    }

    file_put_contents($file, $content);
}
echo "Models updated successfully.";
