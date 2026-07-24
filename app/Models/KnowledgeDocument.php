<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KnowledgeDocument extends Model
{
    use HasFactory;

    protected $table = 'ai_knowledge_documents';

    protected $fillable = [
        'title',
        'original_filename',
        'pdf_path',
        'markdown',
        'page_count',
        'status',
        'error_message',
        'is_published',
        'uploaded_by',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];
}
