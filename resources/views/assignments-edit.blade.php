@if (session('ok'))
  <div class="alert"
       style="background:#e6ffed;border:1px solid #b4f8c8;padding:10px;border-radius:8px;color:#1a7f37;margin-bottom:10px;">
    {{ session('ok') }}
  </div>
@endif

@if ($errors->any())
  <div class="alert"
       style="background:#fdecec;border:1px solid #f5c2c7;padding:10px;border-radius:8px;color:#b02a37;margin-bottom:10px;">
    <ul style="margin:0">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  </div>
@endif
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>تعديل الواجب</title>

  <link rel="icon" href="{{ asset('assets/images/logo2-removebg-preview.png') }}" type="image/x-icon">
  <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"/>
  <link rel="stylesheet" href="{{ asset('assets/css/navbar.css') }}">

  <style>
    :root{ --primary:#2a67f3; --ink:#0f2f72; --muted:#6b7280; --bg:#f3f9ff; --card:#fff; --border:#d7e2ff; --danger:#b91c1c; --soft:#f0f6ff; }
    *{box-sizing:border-box}
    body{font-family:'Cairo',sans-serif;background:var(--bg);margin:0}
    .page{max-width:1100px;margin:0 auto;padding:24px}
    .topbar{display:flex;gap:10px;align-items:center;margin-bottom:12px}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:.75rem 1.15rem;border-radius:12px;font-weight:800;text-decoration:none;border:1px solid transparent;cursor:pointer;transition:.15s ease}
    .btn-primary{background:var(--primary);color:#fff}
    .btn-primary:hover{filter:brightness(0.95);transform:translateY(-1px)}
    .btn-secondary{background:#fff;color:var(--ink);border-color:var(--border)}
    .btn-secondary:hover{background:#f8fbff}
    .btn-danger{background:#fff;color:var(--danger);border-color:#f3c2c4}
    .btn-danger:hover{background:#fff5f5}
    .header{display:flex;align-items:center;justify-content:space-between;margin:8px 0 18px}
    .header h1{margin:0;color:#193b8a;font-weight:900}
    .card{background:var(--card);border:1px solid var(--border);border-radius:16px;box-shadow:0 6px 30px rgba(28,61,140,.06);padding:20px}
    .grid{display:grid;grid-template-columns:1fr 1fr;gap:18px}
    .full{grid-column:1 / -1}
    label{font-weight:800;color:var(--ink)}
    input[type="text"],input[type="number"],input[type="datetime-local"],select,textarea{width:100%;border:1px solid var(--border);border-radius:12px;background:#f7fbff;padding:.8rem 1rem;font-size:1rem;outline:none}
    textarea{min-height:150px;resize:vertical}
    .muted{color:var(--muted);font-size:.92rem}
    .attachments{display:flex;flex-direction:column;gap:10px}
    .att{display:flex;justify-content:space-between;align-items:center;gap:10px;background:var(--soft);border:1px solid var(--border);border-radius:12px;padding:.6rem .8rem}
    .att a{text-decoration:none;color:#1d4ed8;font-weight:800;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
    .row-actions{display:flex;gap:10px;align-items:center}
    .alert{border-radius:12px;padding:.9rem 1rem;margin-bottom:14px}
    .alert-success{background:#ecfdf5;color:#065f46;border:1px solid #a7f3d0}
    .alert-error{background:#fef2f2;color:#991b1b;border:1px solid #fecaca}
    @media (max-width:900px){ .grid{grid-template-columns:1fr} }
  </style>
</head>
<body>
<div class="page">

  <div class="topbar">
    <a class="btn btn-secondary" href="{{ route('assignments.show', $assignment->id) }}"><i class="fa fa-arrow-right"></i> الرجوع للتفاصيل</a>
    <a class="btn btn-secondary" href="{{ route('assignments.index') }}"><i class="fa fa-rectangle-list"></i> الرجوع للقائمة</a>
  </div>

  <div class="header"><h1>تعديل الواجب</h1></div>

  @if(session('success'))
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> {{ session('success') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-error">
      <strong>تحقّق من الحقول التالية:</strong>
      <ul style="margin:8px 0 0 0; padding-inline-start:20px;">
        @foreach($errors->all() as $e) <li>{{ $e }}</li> @endforeach
      </ul>
    </div>
  @endif

  {{-- فورم التعديل الأساسي --}}
  <div class="card">
    <form id="edit-form" method="POST" action="{{ route('assignments.update', $assignment->id) }}" enctype="multipart/form-data">
      @csrf @method('PUT')

      <div class="grid">
        {{-- الدرس --}}
        <div>
          <label for="lesson_id">الدرس</label>
          <select id="lesson_id" name="lesson_id" required>
            @foreach($lessons as $l)
              <option value="{{ $l->id }}" @selected(old('lesson_id',$assignment->lesson_id)==$l->id)>{{ $l->title }}</option>
            @endforeach
          </select>
          @error('lesson_id') <div class="muted">{{ $message }}</div> @enderror
        </div>

        {{-- العنوان --}}
        <div>
          <label for="title">عنوان الواجب</label>
          <input type="text" id="title" name="title" value="{{ old('title', $assignment->title) }}" required>
          @error('title') <div class="muted">{{ $message }}</div> @enderror
        </div>

        {{-- تاريخ التسليم --}}
        <div>
          <label for="due_at">تاريخ التسليم</label>
          <input type="datetime-local" id="due_at" name="due_at"
                 value="{{ old('due_at', optional($assignment->due_at)->format('Y-m-d\TH:i')) }}">
          @error('due_at') <div class="muted">{{ $message }}</div> @enderror
        </div>

        {{-- الدرجة القصوى --}}
        <div>
          <label for="weight">الدرجة القصوى (اختياري)</label>
          <input type="number" id="weight" name="weight" min="0" max="100" step="1"
                 value="{{ old('weight', $assignment->weight) }}" placeholder="0 - 100">
          @error('weight') <div class="muted">{{ $message }}</div> @enderror
        </div>

        {{-- الوصف --}}
        <div class="full">
          <label for="body">وصف الواجب / التعليمات</label>
          <textarea id="body" name="body" placeholder="اكتبي نص الواجب والتعليمات للطلاب">{{ old('body', $assignment->body) }}</textarea>
          @error('body') <div class="muted">{{ $message }}</div> @enderror
        </div>

        {{-- المرفقات الحالية --}}
        <div class="full">
          <label>المرفقات الحالية</label>
          @if($assignment->attachments->isEmpty())
            <div class="muted">لا توجد مرفقات.</div>
          @else
            <div class="attachments">
              @foreach($assignment->attachments as $att)
                <div class="att">
                  <a href="{{ \Illuminate\Support\Facades\Storage::disk('public')->url($att->path) }}" target="_blank" rel="noopener">
                    <i class="fa fa-paperclip"></i> {{ $att->original_name }}
                  </a>
                  <div class="row-actions">
                    <span class="muted">{{ number_format(($att->size ?? 0)/1024,0) }} KB</span>
                    {{-- زر يرسل فورم حذف مستقل غير متداخل --}}
                    <button type="submit" form="del-att-{{ $att->id }}" class="btn btn-danger">
                      <i class="fa fa-trash"></i> حذف
                    </button>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>

        {{-- مرفقات جديدة --}}
        <div class="full">
          <label for="new_files">إضافة مرفقات جديدة (اختياري)</label>
          <input type="file" id="new_files" name="new_files[]" multiple>
          <div class="muted">يمكن رفع أكثر من ملف (PDF, DOCX, صور...). الحد الأقصى 20MB لكل ملف.</div>
          @error('new_files') <div class="muted">{{ $message }}</div> @enderror
          @error('new_files.*') <div class="muted">{{ $message }}</div> @enderror
        </div>
      </div>

      <div style="display:flex;gap:10px;align-items:center;margin-top:16px">
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> حفظ التعديلات</button>
        <a href="{{ route('assignments.show', $assignment->id) }}" class="btn btn-secondary"><i class="fa fa-xmark"></i> إلغاء</a>
      </div>
    </form>
  </div>

  {{-- فورمات حذف المرفقات (خارج فورم التعديل حتى لا يحدث تعشيش) --}}
  @if($assignment->attachments->isNotEmpty())
    @foreach($assignment->attachments as $att)
      <form id="del-att-{{ $att->id }}" action="{{ route('assignments.attachments.destroy', [$assignment->id, $att->id]) }}"
            method="POST" onsubmit="return confirm('حذف هذا المرفق؟');" style="display:none">
        @csrf @method('DELETE')
      </form>
    @endforeach
  @endif

</div>
</body>
</html>
